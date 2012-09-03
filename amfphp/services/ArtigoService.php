<?php

require_once "Conexao.php";

class ArtigoService
{	
	function ArtigoService(){ }

	function listar($texto){
		$padrao = "^([0-9][0-9][0-9][0-9])-([0-9][0-9][0-9][0-9])$";
		if($texto==""){ $s = "SELECT * FROM AGA_ARTIGOS ORDER BY ID ASC"; }
		else if(ereg($padrao,$texto)){
			$intervalo = explode("-",$texto);
			$s = "SELECT * FROM AGA_ARTIGOS WHERE ID BETWEEN '$intervalo[0]' AND '$intervalo[1]' ORDER BY ID ASC";
		}
		else if(is_numeric($texto)){
			$s = "SELECT * FROM AGA_ARTIGOS WHERE ID='$texto' ORDER BY ID ASC";
		} 
		else {
			$s = "SELECT * FROM AGA_ARTIGOS WHERE DESCRICAO LIKE '%$texto%' ORDER BY ID ASC";
		}
		$r = fetch_assoc($s);
		return $r;
	}
	function cadastrar($obj){
		$obj[ID] = str_replace("'", "''", $obj[ID]);
		$obj[DESCRICAO] = str_replace("'", "''", $obj[DESCRICAO]);
		executa("INSERT INTO AGA_ARTIGOS VALUES (
				'$obj[ID]',
				'$obj[DESCRICAO]')
				");
	}

	function editar($obj){
		$obj[ID] = str_replace("'", "''", $obj[ID]);
		$obj[DESCRICAO] = str_replace("'", "''", $obj[DESCRICAO]);
		executa("UPDATE AGA_ARTIGOS SET 
				ID='$obj[ID2]', 
				DESCRICAO='$obj[DESCRICAO]'
				WHERE ID='$obj[ID]'
				");
		executa("UPDATE AGA_PRODUTOS SET ARTIGO='$obj[ID2]' WHERE ARTIGO='$obj[ID]'");
		executa("UPDATE AGA_MARCACAO SET ARTIGO='$obj[ID2]' WHERE ARTIGO='$obj[ID]'");
		executa("UPDATE AGA_REGRAS SET ARTIGO='$obj[ID2]' WHERE ARTIGO='$obj[ID]'");
	}

	function excluir($id){
		executa("DELETE FROM AGA_ARTIGOS WHERE ID='$id'");
		executa("DELETE FROM AGA_PRODUTOS WHERE ARTIGO='$id'");
		executa("DELETE FROM AGA_MARCACAO WHERE ARTIGO='$id'");
		executa("DELETE FROM AGA_REGRAS WHERE ARTIGO='$id'");
	}
}

?>