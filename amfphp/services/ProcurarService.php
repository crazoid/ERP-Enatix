<?php

require_once "Funcoes.php"
require_once "Object.php";
require_once "Conexao.php";

class ProcurarService extends Conexao
{
	var $c;
	
    function ProcurarService(){ $this->c = parent::getConexao(); }
	
	function fornecedor($texto){
		$r = array();
		$padrao = "^([0-9][0-9][0-9][0-9])-([0-9][0-9][0-9][0-9])$";
		if(ereg($padrao,$texto)){
			$intervalo = explode("-",$texto);
			$sql = "SELECT * FROM CTS_FORNECEDORES WHERE ID BETWEEN '$intervalo[0]' AND '$intervalo[1]' ORDER BY ID ASC";
			$query = ibase_query($this->c, $sql);	
		}
		else if(is_numeric($texto)){
			$sql = "SELECT * FROM CTS_FORNECEDORES WHERE ID='$texto' ORDER BY ID ASC";
			$query = ibase_query($this->c, $sql);
		} 
		else {
			$sql = "SELECT * FROM CTS_FORNECEDORES WHERE RAZAO || ' ' || NOME_FANTASIA || ' ' || CONTATO || ' ' || REPRESENTANTE LIKE '%$texto%' ORDER BY ID ASC";
			$query = ibase_query($this->c, $sql);
		}
		while($row= ibase_fetch_assoc($query)){
			$o = new Object();
			$o->load($row);
			if($o->get('DATA_CAD')==NULL) $o->set('DATA_CAD',date('Y-m-d'));
			$d = explode("-",$o->get('DATA_CAD'));
			$o->set('DATA_CAD', $d[2]."/".$d[1]."/".$d[0]);
			$r[] = $o->get_all();
		}
		return $r;
	}
}