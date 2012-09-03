<?php

require_once "Conexao.php";

class InsumoTipoService
{	
	function InsumoTipoService(){ }

	function listar($texto){
		$padrao = "^([0-9][0-9][0-9][0-9])-([0-9][0-9][0-9][0-9])$";
		if($texto==""){ $s = "SELECT * FROM AGA_INSUMOS_TIPOS ORDER BY ID ASC"; }
		else if(ereg($padrao,$texto)){
			$intervalo = explode("-",$texto);
			$s = "SELECT * FROM AGA_INSUMOS_TIPOS WHERE ID BETWEEN '$intervalo[0]' AND '$intervalo[1]' ORDER BY ID ASC";
		}
		else if(is_numeric($texto)){
			$s = "SELECT * FROM AGA_INSUMOS_TIPOS WHERE ID='$texto' ORDER BY ID ASC";
		} 
		else {
			$s = "SELECT * FROM AGA_INSUMOS_TIPOS WHERE DESCRICAO LIKE '%$texto%' ORDER BY ID ASC";
		}
		$r = fetch_assoc($s);
		return $r;
	}
	function cadastrar($obj){
		$obj[ID] = str_replace("'", "''", $obj[ID]);
		$obj[DESCRICAO] = str_replace("'", "''", $obj[DESCRICAO]);
		executa("INSERT INTO AGA_INSUMOS_TIPOS VALUES (
				'$obj[ID]',
				'$obj[DESCRICAO]',
				'$obj[DECI]')
				");
	}

	function editar($obj){
		$obj[ID] = str_replace("'", "''", $obj[ID]);
		$obj[DESCRICAO] = str_replace("'", "''", $obj[DESCRICAO]);
		executa("UPDATE AGA_INSUMOS_TIPOS SET 
				ID='$obj[ID2]', 
				DESCRICAO='$obj[DESCRICAO]',
				DECI='$obj[DECI]'
				WHERE ID='$obj[ID]'
				");

		executa("UPDATE AGA_INSUMOS SET TIPO='$obj[ID2]' WHERE TIPO='$obj[ID]'");
		
		if($obj[DECI]=='S') {
			executa("UPDATE AGA_INSUMOS SET DECI='S' WHERE TIPO=".$obj['ID2']);
			executa("UPDATE AGA_INSUMOS_TIPOS SET DECI='S' WHERE ID=".$obj['ID2']);
		} else {
			executa("UPDATE AGA_INSUMOS SET DECI='N' WHERE TIPO=".$obj['ID2']);
			executa("UPDATE AGA_INSUMOS_TIPOS SET DECI='N' WHERE ID=".$obj['ID2']);
		}

	}

	function excluir($id){
		executa("DELETE FROM AGA_INSUMOS_TIPOS WHERE ID='$id'");
	}
	
	function marcar($item){
		$s = "SELECT DECI FROM AGA_INSUMOS WHERE ID=".$item['ID'];
		if($item[DECI]=='S') {
			executa("UPDATE AGA_INSUMOS SET DECI='S' WHERE TIPO=".$item['ID']);
			executa("UPDATE AGA_INSUMOS_TIPOS SET DECI='S' WHERE ID=".$item['ID']);
		} else {
			executa("UPDATE AGA_INSUMOS SET DECI='N' WHERE TIPO=".$item['ID']);
			executa("UPDATE AGA_INSUMOS_TIPOS SET DECI='N' WHERE ID=".$item['ID']);
		}
	}
}

?>