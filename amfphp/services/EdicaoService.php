<?php

require_once "Funcoes.php"
require_once "Object.php";
require_once "Conexao.php";

class EdicaoService extends Conexao
{
	var $c;
	
    function EdicaoService(){ $this->c = parent::getConexao(); }
	
     function conta($codigo,$codigo2,$fornecedor,$localizador,$grupo,$data,$historico,$observacao,$parcelas,$lancto){
	    $nota = str_replace("'", "''", $nota);
	    $historico = str_replace("'", "''", $historico);
		$observacao = str_replace("'", "''", $observacao);
		$data = explode("/",$data);
		$data = $data[2]."-".$data[1]."-".$data[0];
		$lancto = explode("/",$lancto);
		$lancto = $lancto[2]."-".$lancto[1]."-".$lancto[0];
     	$sql  = "UPDATE CTS_NOTAS set nota='".$codigo2."', fornecedor='".$fornecedor."', data_lancto='".$lancto."', localizador='".$localizador."', grupo='".$grupo."', data_atualizacao='".$data."', data_criacao='".$data."', historico='".$historico."', observacao='".$observacao."' WHERE nota='$codigo'";
		$sql1 = "DELETE FROM CTS_NOTA WHERE NOTA='$codigo'";
		ibase_query($this->c,$sql);
		ibase_query($this->c,$sql1);
		if(sizeof($parcelas)>0){
			foreach($parcelas as $parcela){	
				$nota = $codigo2;
				$valor = $parcela['VALOR'];
				$par = $parcela['PARCELA'];
				$data_vencto = $parcela['DATA_VENCTO'];
				$data_vencto = explode("/",$data_vencto);
				$data_vencto = $data_vencto[2]."-".$data_vencto[1]."-".$data_vencto[0];
				$fornecedor= $parcela['FORNECEDOR'];
				$sql = "INSERT INTO CTS_NOTA(nota,valor,parcela,data_vencto,fornecedor) VALUES ('$nota','$valor','$par','$data_vencto','$fornecedor')";
				ibase_query($this->c, $sql);
			}
		}
     }
	 
    function localizador($id,$id2,$descricao){
     	$sql = "UPDATE CTS_LOCALIZADORES set descricao='$descricao', id='$id2' WHERE ID='$id'";
     	if(ibase_query($this->c, $sql)) return "Atualizado com sucesso!";
     	else return "Erro!";
     }
	 
     function artigo($codigo,$codigo2,$descricao){
     	$sql = "UPDATE AGA_ARTIGOS set id='$codigo2', descricao='$descricao' WHERE ID='$codigo'";
		if(ibase_query($this->c, $sql)) return "Atualizado com sucesso!"; else return "Erro!";
     }
	 
     function fornecedor($codigo,$codigo2,$razao,$nome_fantasia,$cnpj,$ie,$data_cad,$endereco,$bairro,$municipio,$uf,$cep,$fone,$fax,$contato,$representante,$fone_repres){
	    $razao = str_replace("'", "''", $razao);
	    $nome_fantasia = str_replace("'", "''", $nome_fantasia);
		$municipio = str_replace("'", "''", $municipio);
		$data_cad = explode("/",$data_cad);
		$data_cad = $data_cad[2]."-".$data_cad[1]."-".$data_cad[0];
     	$sql = "UPDATE CTS_FORNECEDORES SET ID='$codigo2', RAZAO='$razao', NOME_FANTASIA='$nome_fantasia', CNPJ='$cnpj', IE='$ie', DATA_CAD='$data_cad', ENDERECO='$endereco', BAIRRO='$bairro', MUNICIPIO='$municipio', UF='$uf', CEP='$cep', FONE='$fone', FAX='$fax', CONTATO='$contato', REPRESENTANTE='$representante', FONE_REPRES='$fone_repres' WHERE ID='$codigo'";
     	ibase_query($this->c, $sql);
     }
	 
	function grupo($id,$id2,$descricao,$mensal){
		$mensal = $mensal ? "S" : "N";
     	$sql = "UPDATE CTS_GRUPOS set descricao='$descricao', id='$id2', mensal='$mensal' WHERE ID='$id'";
     	if(ibase_query($this->c, $sql)) return "Atualizado com sucesso!";
     	else return "Erro!";
    }
	
     function escola($codigo,$codigo2,$descricao){
     	$sql = "UPDATE AGA_INSTITUICOES set id='$codigo2', descricao='$descricao' WHERE ID='$codigo'";
     	if(ibase_query($this->c, $sql)) return true;
     	else return false;
     }
	 
     function insumo ($codigo,$codigo2,$descricao,$tipo,$preco,$prazo){
     	$sql = "UPDATE AGA_INSUMOS SET ID='$codigo2',
     	DESCRICAO='$descricao',
     	TIPO='$tipo',
     	DATA='".date('d/m/Y')."',
     	PRECO='$preco',
     	PRAZO='$prazo'
     	WHERE ID='$codigo'";
     	if(ibase_query($this->c, $sql)) return "Atualizado com sucesso!";
     	else return "Erro!";
     }
	 
     function insumoTipo ($codigo,$codigo2,$descricao){
     	$sql = "UPDATE AGA_INSUMOS_TIPOS set id='$codigo2', descricao='$descricao' WHERE ID='$codigo'";
     	if(ibase_query($this->c, $sql)) return true;
     	else return false;
     }
}