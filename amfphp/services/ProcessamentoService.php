<?php

require_once "Conexao.php";
require_once "Funcoes.php";

class ProcessamentoService
{	
	function ProcessamentoService(){  }
	
	function atualizarFornecedoresMensais(){
		$s = "SELECT * FROM CTS_NOTAS N, CTS_GRUPOS G WHERE N.GRUPO=G.ID";
		$r = fetch_assoc($s);
		$t = array();
		foreach($r as $k=>$v){
			executa("UPDATE CTS_FORNECEDORES SET MENSAL='$v[MENSAL]' WHERE ID='$v[FORNECEDOR]'");
			$t[$v[FORNECEDOR]] = $v[MENSAL];
		}
		return $t;
	}
	
}