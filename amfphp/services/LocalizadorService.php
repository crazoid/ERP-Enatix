<?php

require_once "Conexao.php";

class LocalizadorService
{	
	function LocalizadorService(){ }

	function listar($texto){
		$padrao = "^([0-9][0-9][0-9][0-9])-([0-9][0-9][0-9][0-9])$";
		if($texto==""){ $s = "SELECT ID,DESCRICAO FROM CTS_LOCALIZADORES ORDER BY ID ASC"; }
		else if(ereg($padrao,$texto)){
			$intervalo = explode("-",$texto);
			$s = "SELECT * FROM CTS_LOCALIZADORES WHERE ID BETWEEN '$intervalo[0]' AND '$intervalo[1]' ORDER BY ID ASC";
		}
		else if(is_numeric($texto)){
			$s = "SELECT * FROM CTS_LOCALIZADORES WHERE ID='$texto' ORDER BY ID ASC";
		} 
		else {
			$s = "SELECT * FROM CTS_LOCALIZADORES WHERE DESCRICAO LIKE '%$texto%' ORDER BY ID ASC";
		}
		$r = fetch_assoc($s);
		return $r;
	}
	function cadastrar($obj){
		$obj[ID] = str_replace("'", "''", $obj[ID]);
		$obj[DESCRICAO] = str_replace("'", "''", $obj[DESCRICAO]);
		executa("INSERT INTO CTS_LOCALIZADORES VALUES (
				'$obj[ID]',
				'$obj[DESCRICAO]')
				");
	}

	function editar($obj){
		$obj[ID] = str_replace("'", "''", $obj[ID]);
		$obj[DESCRICAO] = str_replace("'", "''", $obj[DESCRICAO]);
		executa("UPDATE CTS_LOCALIZADORES SET 
				ID='$obj[ID2]', 
				DESCRICAO='$obj[DESCRICAO]'
				WHERE ID='$obj[ID]'
				");
		executa("UPDATE CTS_NOTAS SET LOCALIZADOR='$obj[ID2]' WHERE LOCALIZADOR='$obj[ID]'");
	}

	function excluir($id){
		executa("DELETE FROM CTS_LOCALIZADORES WHERE ID='$id'");
		$r = fetch_assoc("SELECT * FROM CTS_NOTAS WHERE LOCALIZADOR='$id'");
		foreach($r as $k=>$v){
			executa("DELETE FROM CTS_NOTA WHERE NOTA='$v[NOTA]'");
		}
		executa("DELETE FROM CTS_NOTAS WHERE LOCALIZADOR='$id'");
	}
}

?>