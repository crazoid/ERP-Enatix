<?php

require_once "Conexao.php";

class InsumoService
{	
	function InsumoService(){ }

	function listar($texto){
		$padrao = "^([0-9][0-9][0-9][0-9])-([0-9][0-9][0-9][0-9])$";
		if($texto==""){ $s = "SELECT * FROM AGA_INSUMOS ORDER BY ID ASC"; }
		else if(ereg($padrao,$texto)){
			$intervalo = explode("-",$texto);
			$s = "SELECT * FROM AGA_INSUMOS WHERE ID BETWEEN '$intervalo[0]' AND '$intervalo[1]' ORDER BY ID ASC";
		}
		else if(is_numeric($texto)){
			$s = "SELECT * FROM AGA_INSUMOS WHERE ID='$texto' ORDER BY ID ASC";
		} 
		else {
			$s = "SELECT * FROM AGA_INSUMOS WHERE DESCRICAO LIKE '%$texto%' ORDER BY ID ASC";
		}
		$r = fetch_assoc($s);
		foreach($r as $k=>$v){
			$r2 = fetch_assoc_simples("SELECT DESCRICAO FROM AGA_INSUMOS_TIPOS WHERE ID='$v[TIPO]'");
			$r[$k]['TIPO_DESC'] = $r2['DESCRICAO'];
			$d = explode("-",$v['DATA']);
			$r[$k]['DATA'] = $d[2]."/".$d[1]."/".$d[0];
		}
		return $r;
	}
	
	function marcar($codigo){
		$s = "SELECT DECI FROM AGA_INSUMOS WHERE ID=".$codigo;
		$r = fetch_assoc_simples($s);
		$g = $r[DECI]=="S"? "UPDATE AGA_INSUMOS SET DECI='N' WHERE ID=".$codigo : "UPDATE AGA_INSUMOS SET DECI='S' WHERE ID=".$codigo;
		executa($g);
	}

	function cadastrar($obj){
		$descricao = str_replace("'", "''", $obj[DESCRICAO]);	
		$data = explode("/",$obj[DATA]);
		$data = $data[2]."-".$data[1]."-".$data[0];
		executa("INSERT INTO AGA_INSUMOS VALUES (
				'$obj[ID]',
				'$descricao',
				'$obj[TIPO]',
				'$data',
				'$obj[PRECO]',
				'$obj[PRAZO]',
				'$obj[DECI]')
				");
	}

	function editar($obj){
		$descricao = str_replace("'", "''", $obj[DESCRICAO]);
		$data = explode("/",$obj[DATA]);
		$data = $data[2]."-".$data[1]."-".$data[0];
		executa("UPDATE AGA_INSUMOS SET
				ID='$obj[ID2]',
				DESCRICAO='$descricao',
				TIPO='$obj[TIPO]',
				DATA='$data',
				PRECO='$obj[PRECO]',
				PRAZO='$obj[PRAZO]',
				DECI='$obj[DECI]'	
				WHERE ID='$obj[ID]'
				");
	}

	function excluir($id){
		executa("DELETE FROM AGA_INSUMOS WHERE ID='$id'");
	}
}

?>