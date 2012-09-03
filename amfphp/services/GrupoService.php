<?php

require_once "Conexao.php";

class GrupoService
{	
	function GrupoService(){ }

	function listar($texto){
		$padrao = "^([0-9][0-9][0-9][0-9])-([0-9][0-9][0-9][0-9])$";
		if($texto==""){ $s = "SELECT * FROM CTS_GRUPOS ORDER BY ID ASC"; }
		else if(ereg($padrao,$texto)){
			$intervalo = explode("-",$texto);
			$s = "SELECT * FROM CTS_GRUPOS WHERE ID BETWEEN '$intervalo[0]' AND '$intervalo[1]' ORDER BY ID ASC";
		}
		else if(is_numeric($texto)){
			$s = "SELECT * FROM CTS_GRUPOS WHERE ID='$texto' ORDER BY ID ASC";
		} 
		else {
			$s = "SELECT * FROM CTS_GRUPOS WHERE DESCRICAO LIKE '%$texto%' ORDER BY ID ASC";
		}
		$r = fetch_assoc($s);
		return $r;
	}
	function cadastrar($obj){
		$obj[ID] = str_replace("'", "''", $obj[ID]);
		$obj[DESCRICAO] = str_replace("'", "''", $obj[DESCRICAO]);
		executa("INSERT INTO CTS_GRUPOS VALUES (
				'$obj[ID]',
				'$obj[DESCRICAO]',
				'$obj[MENSAL]')
				");
	}

	function editar($obj){
		$obj[ID] = str_replace("'", "''", $obj[ID]);
		$obj[DESCRICAO] = str_replace("'", "''", $obj[DESCRICAO]);
		executa("UPDATE CTS_GRUPOS SET 
				ID='$obj[ID2]', 
				DESCRICAO='$obj[DESCRICAO]',
				MENSAL='$obj[MENSAL]'
				WHERE ID='$obj[ID]'
				");
		executa("UPDATE CTS_NOTAS SET GRUPO='$obj[ID2]' WHERE GRUPO='$obj[ID]'");
	}

	function excluir($id){
		executa("DELETE FROM CTS_GRUPOS WHERE ID='$id'");
		$r = fetch_assoc("SELECT * FROM CTS_NOTAS WHERE GRUPO='$id'");
		foreach($r as $k=>$v){
			executa("DELETE FROM CTS_NOTA WHERE NOTA='$v[NOTA]'");
		}
		executa("DELETE FROM CTS_NOTAS WHERE GRUPO='$id'");
		
	}
}

?>