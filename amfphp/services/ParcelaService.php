<?php

require_once "Object.php";
require_once "Conexao_Contas.php";

class ParcelaService extends Conexao_Contas
{
	var $c;
     
	function ParcelaService(){ $this->c = parent::getConexao(); }

    function listar($nota) {
		$r = array();
		$q = ibase_query($this->c, "select t.nota,t.valor,t.parcela,t.data_vencto,t.data_pagto,t.data_baixa,t.duplicata,t.fatura,t.boleto,t.fornecedor,f.id,f.nome_fantasia as fornecedor_desc from cts_nota t, cts_fornecedores f where nota='$nota' and f.id=t.fornecedor order by parcela asc");
		while($row= ibase_fetch_assoc($q)){
			$o = new Object();
			$o->load($row);
			$data = $o->get('DATA_VENCTO');
			$data = explode("-",$data);
			$o->set('DATA_VENCTO',$data[2].'/'.$data[1].'/'.$data[0]);
			$data = $o->get('DATA_BAIXA');
			if($data!=""){
				$data = explode("-",$data);
				$o->set('DATA_BAIXA',$data[2].'/'.$data[1].'/'.$data[0]);
			}
			$r[] = $o->get_all();
		}
		return $r;
    }
	
     function cadastrar($parcelas){
		foreach($parcelas as $parcela){	
			$nota = $parcela['NOTA'];
			$valor = $parcela['VALOR'];
			$parcela = $parcela['PARCELA'];
			$data_vencto = $parcela['DATA_VENCTO'];
			$fornecedor = $parcela['FORNECEDOR'];
			$data = explode("/",$data_vencto);
			$data = $data[2]."-".$data[1]."-".$data[0];
			$sql = "INSERT INTO CTS_NOTA (nota,valor,parcela,data_vencto,fornecedor) VALUES ('$nota','$valor','$parcela','$data','$fornecedor')";
			if(ibase_query($this->c, $sql)) return "Adicionado com sucesso!";
			else return "Erro!";
		}
     }
	 
     function editar($nota,$parcela,$parcela2,$data_vencto,$valor,$fornecedor){
		$data_baixa = date("Y-m-d");
	 	$data_vencto = explode("/",$data_vencto);
		$data_vencto = $data_vencto[2]."-".$data_vencto[1]."-".$data_vencto[0];
	   	$sql = "UPDATE CTS_NOTA SET PARCELA='$parcela2', DATA_VENCTO='$data_vencto', VALOR='$valor', FORNECEDOR='$fornecedor' WHERE NOTA='$nota' AND PARCELA='$parcela'";
     	if(ibase_query($this->c, $sql)) return "Atualizado com sucesso!";
     	else return "Erro!";
     }
	 
     function remover($nota,$parcela,$data_vencto){
	 	$data_vencto = explode("/",$data_vencto);
		$data_vencto = $data_vencto[2]."-".$data_vencto[1]."-".$data_vencto[0];
		$sql = "DELETE FROM CTS_NOTA WHERE NOTA='$nota' AND PARCELA='$parcela' AND DATA_VENCTO='$data_vencto'";
     	if(ibase_query($this->c, $sql)) return "Removido com sucesso!";
     	else return "Erro!";
     }
	 
     function baixar($nota,$parcela,$data_vencto){
		$data_baixa = date("Y-m-d");
	 	$data_vencto = explode("/",$data_vencto);
		$data_vencto = $data_vencto[2]."-".$data_vencto[1]."-".$data_vencto[0];
	   	$sql = "UPDATE CTS_NOTA SET DATA_BAIXA='$data_baixa' WHERE NOTA='$nota' AND PARCELA='$parcela' AND DATA_VENCTO='$data_vencto'";
     	if(ibase_query($this->c, $sql)) return "Baixado com sucesso!";
     	else return "Erro!";
     }
	 
     function desbaixar($nota,$parcela,$data_vencto){
	 	$data_vencto = explode("/",$data_vencto);
		$data_vencto = $data_vencto[2]."-".$data_vencto[1]."-".$data_vencto[0];
     	$sql = "UPDATE CTS_NOTA SET DATA_BAIXA=NULL WHERE NOTA='$nota' AND PARCELA='$parcela' AND DATA_VENCTO='$data_vencto'";
     	if(ibase_query($this->c, $sql)) return "Desbaixado com sucesso!";
     	else return "Erro!";
     }
 }

?>