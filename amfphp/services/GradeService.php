<?php

require_once "Conexao.php";

class GradeService
{	
	function GradeService(){ }

	function listar($texto){
		$padrao = "^([0-9][0-9][0-9][0-9])-([0-9][0-9][0-9][0-9])$";
		if($texto==""){ $s = "SELECT * FROM EST_GRADES ORDER BY ID ASC"; }
		else if(ereg($padrao,$texto)){
			$intervalo = explode("-",$texto);
			$s = "SELECT * FROM EST_GRADES WHERE ID BETWEEN '$intervalo[0]' AND '$intervalo[1]' ORDER BY ID ASC";
		}
		else if(is_numeric($texto)){
			$s = "SELECT * FROM EST_GRADES WHERE ID='$texto' ORDER BY ID ASC";
		} 
		else {
			$s = "SELECT * FROM EST_GRADES WHERE DESCRICAO LIKE '%$texto%' ORDER BY ID ASC";
		}
		$r = fetch_assoc($s);
		return $r;
	}
	function cadastrar($obj){
		$obj[ID] = str_replace("'", "''", $obj[ID]);
		$obj[G1] = str_replace("'", "''", $obj[G1]);
		$obj[G2] = str_replace("'", "''", $obj[G2]);
		$obj[G3] = str_replace("'", "''", $obj[G3]);
		$obj[G4] = str_replace("'", "''", $obj[G4]);
		$obj[G5] = str_replace("'", "''", $obj[G5]);
		$obj[G6] = str_replace("'", "''", $obj[G6]);
		$obj[G7] = str_replace("'", "''", $obj[G7]);
		$obj[G8] = str_replace("'", "''", $obj[G8]);
		$obj[G9] = str_replace("'", "''", $obj[G9]);
		$obj[G10] = str_replace("'", "''", $obj[G10]);
		$obj[G11] = str_replace("'", "''", $obj[G11]);
		$obj[G12] = str_replace("'", "''", $obj[G12]);
		$obj[G13] = str_replace("'", "''", $obj[G13]);
		$obj[G14] = str_replace("'", "''", $obj[G14]);
		$obj[G15] = str_replace("'", "''", $obj[G15]);

		executa("INSERT INTO EST_GRADES VALUES (
				'$obj[ID]',
				'$obj[G1]',
				'$obj[G2]',
				'$obj[G3]',
				'$obj[G4]',
				'$obj[G5]',
				'$obj[G6]',
				'$obj[G7]',
				'$obj[G8]',
				'$obj[G9]',
				'$obj[G10]',
				'$obj[G11]',
				'$obj[G12]',
				'$obj[G13]',
				'$obj[G14]',
				'$obj[G15]')
				");
	}

	function editar($obj){
		$obj[ID] = str_replace("'", "''", $obj[ID]);
		$obj[G1] = str_replace("'", "''", $obj[G1]);
		$obj[G2] = str_replace("'", "''", $obj[G2]);
		$obj[G3] = str_replace("'", "''", $obj[G3]);
		$obj[G4] = str_replace("'", "''", $obj[G4]);
		$obj[G5] = str_replace("'", "''", $obj[G5]);
		$obj[G6] = str_replace("'", "''", $obj[G6]);
		$obj[G7] = str_replace("'", "''", $obj[G7]);
		$obj[G8] = str_replace("'", "''", $obj[G8]);
		$obj[G9] = str_replace("'", "''", $obj[G9]);
		$obj[G10] = str_replace("'", "''", $obj[G10]);
		$obj[G11] = str_replace("'", "''", $obj[G11]);
		$obj[G12] = str_replace("'", "''", $obj[G12]);
		$obj[G13] = str_replace("'", "''", $obj[G13]);
		$obj[G14] = str_replace("'", "''", $obj[G14]);
		$obj[G15] = str_replace("'", "''", $obj[G15]);
		executa("UPDATE EST_GRADES SET 
				ID='$obj[ID2]', 
				G1='$obj[G1]',
				G2='$obj[G2]',
				G3='$obj[G3]',
				G4='$obj[G4]',
				G5='$obj[G5]',
				G6='$obj[G6]',
				G7='$obj[G7]',
				G8='$obj[G8]',
				G9='$obj[G9]',
				G10='$obj[G10]',
				G11='$obj[G11]',
				G12='$obj[G12]',
				G13='$obj[G13]',
				G14='$obj[G14]',
				G15='$obj[G15]'
				WHERE ID='$obj[ID]'
				");
	}

	function excluir($id){
		executa("DELETE FROM EST_GRADES WHERE ID='$id'");
	}
}

?>