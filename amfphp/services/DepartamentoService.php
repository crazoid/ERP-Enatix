<?php

require_once "Conexao.php";

class DepartamentoService
{	
	function DepartamentoService(){ }

	function listar($texto){
		$padrao = "^([0-9][0-9][0-9][0-9])-([0-9][0-9][0-9][0-9])$";
		if($texto==""){ $s = "SELECT * FROM EST_DEPARTAMENTOS ORDER BY ID ASC"; }
		else if(ereg($padrao,$texto)){
			$intervalo = explode("-",$texto);
			$s = "SELECT * FROM EST_DEPARTAMENTOS WHERE ID BETWEEN '$intervalo[0]' AND '$intervalo[1]' ORDER BY ID ASC";
		}
		else if(is_numeric($texto)){
			$s = "SELECT * FROM EST_DEPARTAMENTOS WHERE ID='$texto' ORDER BY ID ASC";
		} 
		else {
			$s = "SELECT * FROM EST_DEPARTAMENTOS WHERE DESCRICAO LIKE '%$texto%' ORDER BY ID ASC";
		}
		$r = fetch_assoc($s);
		return $r;
	}
	function cadastrar($obj){
		$obj[ID] = str_replace("'", "''", $obj[ID]);
		$obj[DESCRICAO] = str_replace("'", "''", $obj[DESCRICAO]);
		$obj[MARGEM] = str_replace("'", "''", $obj[MARGEM]);
		executa("INSERT INTO EST_DEPARTAMENTOS VALUES (
				'$obj[ID]',
				'$obj[DESCRICAO]',
				'$obj[MARGEM]')
				");
	}

	function editar($obj){
		$obj[ID] = str_replace("'", "''", $obj[ID]);
		$obj[DESCRICAO] = str_replace("'", "''", $obj[DESCRICAO]);
		$obj[MARGEM] = str_replace("'", "''", $obj[MARGEM]);
		executa("UPDATE EST_DEPARTAMENTOS SET 
				ID='$obj[ID2]', 
				DESCRICAO='$obj[DESCRICAO]',
				MARGEM='$obj[MARGEM]'
				WHERE ID='$obj[ID]'
				");
	}

	function excluir($id){
		executa("DELETE FROM EST_DEPARTAMENTOS WHERE ID='$id'");
	}
}

?>