<?php

require_once "Conexao.php";

class LoteService
{	
	function LoteService(){ }

	function listar($texto){
		$padrao = "^([0-9][0-9][0-9][0-9])-([0-9][0-9][0-9][0-9])$";
		if($texto==""){ $s = "SELECT * FROM AGA_LOTES ORDER BY ID DESC"; }
		else if(ereg($padrao,$texto)){
			$intervalo = explode("-",$texto);
			$s = "SELECT * FROM AGA_LOTES WHERE ID BETWEEN '$intervalo[0]' AND '$intervalo[1]' ORDER BY ID ASC";
		}
		else if(is_numeric($texto)){
			$s = "SELECT * FROM AGA_LOTES WHERE ID='$texto' ORDER BY ID ASC";
		} 
		else {
			$s = "SELECT * FROM AGA_LOTES WHERE DESCRICAO LIKE '%$texto%' ORDER BY ID ASC";
		}
		$r = fetch_assoc($s);
		foreach($r as $k=>$f){
			$r[$k]['DESCRICAO2'] = $f['DESCRICAO'];
		}
		return $r;
	}

	function cadastrar($obj){
		$obj[DESCRICAO] = str_replace("'", "''", $obj[DESCRICAO]);
		executa("DELETE FROM AGA_LOTES WHERE ID='$obj[ID]'");
		executa("INSERT INTO AGA_LOTES VALUES (
				'$obj[ID]',
				'$obj[DESCRICAO]')
				");
		executa("DELETE FROM AGA_MARCACAO WHERE LOTE='$obj[ID]'");
		foreach($obj[PRODUTOS] as $produto){
			executa("INSERT INTO AGA_MARCACAO (LOTE,ESCOLA,ARTIGO) VALUES (
					'$obj[ID]',
					'$produto[ESCOLA]',
					'$produto[ARTIGO]')
					");		
		}
	}

	function editar($obj){
		$obj[DESCRICAO] = str_replace("'", "''", $obj[DESCRICAO]);
		executa("UPDATE AGA_LOTES SET ID='$obj[ID2]',DESCRICAO='$obj[DESCRICAO]' WHERE ID='$obj[ID]'");
		executa("UPDATE AGA_MARCACAO SET LOTE='$obj[ID2]' WHERE LOTE='$obj[ID]'");
		//executa("DELETE FROM AGA_LOTES WHERE ID='$obj[ID]'");
		//executa("INSERT INTO AGA_LOTES VALUES (
				//'$obj[ID2]',
				//'$obj[DESCRICAO]')
				//");
		//executa("DELETE FROM AGA_MARCACAO WHERE LOTE='$obj[ID]'");
		//foreach($obj[PRODUTOS] as $produto){
			//executa("INSERT INTO AGA_MARCACAO (LOTE,ESCOLA,ARTIGO) VALUES (
				//'$obj[ID2]',
				//'$produto[ESCOLA]',
				//'$produto[ARTIGO]')
			//");
		//}		
	}

	function excluir($id){
		executa("DELETE FROM AGA_LOTES WHERE ID='$id'");
		executa("DELETE FROM AGA_MARCACAO WHERE LOTE='$id'");
	}
}

?>