<?php

require_once "Conexao.php";

class FornecedorService
{	
	function FornecedorService(){ }

	function listar($texto){
		$padrao = "^([0-9][0-9][0-9][0-9])-([0-9][0-9][0-9][0-9])$";
		if($texto==""){ $s = "SELECT * FROM CTS_FORNECEDORES ORDER BY ID ASC"; }
		else if(ereg($padrao,$texto)){
			$intervalo = explode("-",$texto);
			$s = "SELECT * FROM CTS_FORNECEDORES WHERE ID BETWEEN '$intervalo[0]' AND '$intervalo[1]' ORDER BY ID ASC";
		}
		else if(is_numeric($texto)){
			$s = "SELECT * FROM CTS_FORNECEDORES WHERE ID='$texto' ORDER BY ID ASC";
		} 
		else {
			$s = "SELECT * FROM CTS_FORNECEDORES WHERE RAZAO || ' ' || NOME_FANTASIA || ' ' || CONTATO || ' ' || REPRESENTANTE LIKE '%$texto%' ORDER BY ID ASC";
		}
		$r = fetch_assoc($s);
		foreach($r as $k=>$f){
			if($f['RAZAO']=="") $r[$k]['RAZAO'] = $r[$k]['NOME_FANTASIA'];
			if($f['DATA_CAD']==NULL) $r[$k]['DATA_CAD'] = date("Y-m-d");
			$r[$k]['MENSAL'] = $r[$k]['MENSAL']=="S"? true : false;
		}
		return $r;
	}
	
	function marcar($codigo){
		$s = "SELECT MENSAL FROM CTS_FORNECEDORES WHERE ID=".$codigo;
		$r = fetch_assoc_simples($s);
		$g = $r[MENSAL]=="S"? "UPDATE CTS_FORNECEDORES SET MENSAL='N' WHERE ID=".$codigo : "UPDATE CTS_FORNECEDORES SET MENSAL='S' WHERE ID=".$codigo;
		executa($g);
	}
	
	function cadastrar($obj){
		$data = date("Y-m-d");
		$obj[RAZAO] = str_replace("'", "''", $obj[RAZAO]);
		$obj[NOME_FANTASIA] = str_replace("'", "''", $obj[NOME_FANTASIA]);
		executa("INSERT INTO CTS_FORNECEDORES VALUES (
				'$obj[CODIGO]',
				'$obj[RAZAO]',
				'$obj[NOME_FANTASIA]',
				'$obj[CNPJ]',
				'$obj[IE]',
				'$data',
				'$obj[ENDERECO]',
				'$obj[BAIRRO]',
				'$obj[MUNICIPIO]',
				'$obj[UF]',
				'$obj[CEP]',
				'$obj[FONE]',
				'$obj[FAX]',
				'$obj[CONTATO]',
				'$obj[REPRESENTANTE]',
				'$obj[FONE_REPRES]',
				'$obj[MENSAL]',
				'$obj[EMAIL]',
				'$obj[SITE]')
				");
	}

	function editar($obj){
		$obj[RAZAO] = str_replace("'", "''", $obj[RAZAO]);
		$obj[NOME_FANTASIA] = str_replace("'", "''", $obj[NOME_FANTASIA]);
		$obj[MUNICIPIO] = str_replace("'", "''", $obj[MUNICIPIO]);
		if($obj[DATA_CAD]!=""){
			$obj[DATA_CAD] = explode("/",$obj[DATA_CAD]);
			$obj[DATA_CAD] = $obj[DATA_CAD][2]."-".$obj[DATA_CAD][1]."-".$obj[DATA_CAD][0];
			$data = $obj[DATA_CAD];
		} else {
			$data = date("Y-m-d");
		}
		executa("UPDATE CTS_FORNECEDORES SET 
				ID='$obj[CODIGO2]', 
				RAZAO='$obj[RAZAO]', 
				NOME_FANTASIA='$obj[NOME_FANTASIA]', 
				CNPJ='$obj[CNPJ]', 
				IE='$obj[IE]', 
				DATA_CAD='$data', 
				ENDERECO='$obj[ENDERECO]', 
				BAIRRO='$obj[BAIRRO]',
				MUNICIPIO='$obj[MUNICIPIO]', 
				UF='$obj[UF]', 
				CEP='$obj[CEP]', 
				FONE='$obj[FONE]', 
				FAX='$obj[FAX]', 
				CONTATO='$obj[CONTATO]', 
				REPRESENTANTE='$obj[REPRESENTANTE]', 
				FONE_REPRES='$obj[FONE_REPRES]',
				MENSAL='$obj[MENSAL]',
				EMAIL='$obj[EMAIL]',
				SITE='$obj[SITE]'
				WHERE ID='$obj[CODIGO]'
				");
				executa("UPDATE CTS_NOTAS SET FORNECEDOR='$obj[CODIGO2]' WHERE FORNECEDOR='$obj[CODIGO]'");
	}

	function excluir($codigo){
		executa("DELETE FROM CTS_FORNECEDORES WHERE ID='$codigo'");
		$r = fetch_assoc("SELECT * FROM CTS_NOTAS WHERE FORNECEDOR='$codigo'");
		foreach($r as $k=>$v){
			executa("DELETE FROM CTS_NOTA WHERE NOTA='$v[NOTA]'");
		}
		executa("DELETE FROM CTS_NOTAS WHERE FORNECEDOR='$codigo'");
	}
}

?>