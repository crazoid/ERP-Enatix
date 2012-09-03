<?php

require_once "Funcoes.php"
require_once "Object.php";
require_once "Conexao.php";

class CadastroService extends Conexao
{
	var $c;
	
    function CadastroService(){ $this->c = parent::getConexao(); }
	
     function conta($lancto,$codigo,$fornecedor,$localizador,$grupo,$data,$historico,$observacao,$parcelas){
	    $codigo = str_replace("'", "''", $codigo);
	    $historico = str_replace("'", "''", $historico);
		$observacao = str_replace("'", "''", $observacao);
		$data = explode("/",$data);
		$data = $data[2]."-".$data[1]."-".$data[0];
		$lancto = explode("/",$lancto);
		$lancto = $lancto[2]."-".$lancto[1]."-".$lancto[0];
     	$sql = "INSERT INTO CTS_NOTAS (DATA_LANCTO,NOTA,FORNECEDOR,LOCALIZADOR,GRUPO,DATA_CRIACAO,HISTORICO,OBSERVACAO) VALUES (
		'".$lancto."',
		'".$codigo."',
		'".$fornecedor."',
		'".$localizador."',
		'".$grupo."',
		'".$data."',
		'".$historico."',
		'".$observacao."'
		)";
     	ibase_query($this->c, $sql);
		foreach($parcelas as $parcela){	
			$nota = $parcela['NOTA'];
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
	 
     function localizador($id,$descricao){
     	$sql = "INSERT INTO CTS_LOCALIZADORES (id,descricao) VALUES ('$id','$descricao')";
     	if(ibase_query($this->c, $sql)) return "Cadastrado com sucesso!";
     	else return "Erro!";
     }
	 
     function artigo($id,$descricao){
     	$sql = "INSERT INTO AGA_ARTIGOS (id,descricao) VALUES ('$id','$descricao')";
     	if(ibase_query($this->c, $sql)) return "Cadastrado com sucesso!"; else return "Erro!";
     }
	 
     function fornecedor($codigo,$razao,$nome_fantasia,$cnpj,$ie,$data_cad,$endereco,$bairro,$municipio,$uf,$cep,$fone,$fax,$contato,$representante,$fone_repres){
	    $razao = str_replace("'", "''", $razao);
	    $nome_fantasia = str_replace("'", "''", $nome_fantasia);
     	$sql = "INSERT INTO CTS_FORNECEDORES (ID,RAZAO,NOME_FANTASIA,CNPJ,IE,DATA_CAD,ENDERECO,BAIRRO,MUNICIPIO,UF,CEP,FONE,FAX,CONTATO,REPRESENTANTE,FONE_REPRES) VALUES (
		'".$codigo."',
		'".$razao."',
		'".$nome_fantasia."',
		'".$cnpj."',
		'".$ie."',
		'".date("Y-m-d")."',
		'".$endereco."',
		'".$bairro."',
		'".$municipio."',
		'".$uf."',
		'".$cep."',
		'".$fone."',
		'".$fax."',
		'".$contato."',
		'".$representante."',
		'".$fone_repres."'
		)";
     	if(ibase_query($this->c, $sql)) return "Cadastrado com sucesso!";
     	else return "Erro!";
     }
	 
	 function grupo($id,$descricao,$mensal){
		$mensal = $mensal ? "S" : "N";
		$sql = "INSERT INTO CTS_GRUPOS (id,descricao,mensal) VALUES ('$id','$descricao','$mensal')";
		if(ibase_query($this->c, $sql)) return "Cadastrado com sucesso!";
		else return "Erro!";
	 }
	 
     function escola($id,$descricao){
     	$sql = "INSERT INTO AGA_INSTITUICOES(id,descricao) VALUES ('$id','$descricao')";
     	if(ibase_query($this->c, $sql)) return true;
     	else return false;
     }
	 
     function insumo($id,$descricao,$tipo,$preco,$prazo){
     	$sql = "INSERT INTO AGA_INSUMOS (id,descricao,tipo,data,preco,prazo) VALUES ('$id','$descricao','$tipo','".date('d/m/Y')."','$preco','$prazo')";
     	if(ibase_query($this->c, $sql)) return "Cadastrado com sucesso!";
     	else return "Erro!";
     }
	 
     function insumoTipo($id,$descricao){
     	$sql = "INSERT INTO AGA_INSUMOS_TIPOS (id,descricao) VALUES ('$id','$descricao')";
     	if(ibase_query($this->c, $sql)) return true;
     	else return false;
     }
}