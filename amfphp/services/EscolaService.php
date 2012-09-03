<?php

require_once "Conexao.php";

class EscolaService
{	
	function EscolaService(){ }

	function listar($texto){
		$padrao = "^([0-9][0-9][0-9][0-9])-([0-9][0-9][0-9][0-9])$";
		if($texto==""){ $s = "SELECT * FROM AGA_INSTITUICOES ORDER BY ID ASC"; }
		else if(ereg($padrao,$texto)){
			$intervalo = explode("-",$texto);
			$s = "SELECT * FROM AGA_INSTITUICOES WHERE ID BETWEEN '$intervalo[0]' AND '$intervalo[1]' ORDER BY ID ASC";
		}
		else if(is_numeric($texto)){
			$s = "SELECT * FROM AGA_INSTITUICOES WHERE ID='$texto' ORDER BY ID ASC";
		} 
		else {
			$s = "SELECT * FROM AGA_INSTITUICOES WHERE DESCRICAO LIKE '%$texto%' ORDER BY ID ASC";
		}
		$r = fetch_assoc($s);
		return $r;
	}
	function cadastrar($obj){
		$id = str_replace("'", "''", $obj[ID]);
		$descricao = str_replace("'", "''", $obj[DESCRICAO]);
		executa("INSERT INTO AGA_INSTITUICOES VALUES ('$id','$descricao')");
	}

	function editar($obj){
		$id = str_replace("'", "''", $obj[ID]);
		$descricao = str_replace("'", "''", $obj[DESCRICAO]);
		executa("UPDATE AGA_INSTITUICOES SET ID='$obj[ID2]', 
				DESCRICAO='$descricao'
				WHERE ID='$id'
				");
		executa("UPDATE AGA_PRODUTOS SET ESCOLA='$obj[ID2]' WHERE ESCOLA='$obj[ID]'");
		executa("UPDATE AGA_MARCACAO SET ESCOLA='$obj[ID2]' WHERE ESCOLA='$obj[ID]'");
	}

	function excluir($id){
		executa("DELETE FROM AGA_INSTITUICOES WHERE ID='$id'");
		executa("DELETE FROM AGA_PRODUTOS WHERE ESCOLA='$id'");
		executa("DELETE FROM AGA_MARCACAO WHERE ESCOLA='$id'");
	}
}

?>