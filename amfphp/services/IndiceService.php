<?php

require_once "Conexao.php";
require_once "Object.php";

class IndiceService
{	
	function IndiceService(){  }
            
	 function cadastrar($p){
		$r = array();
		executa("INSERT INTO EST_INDICES (data,cst_fin,txa_def,cst_ope,v0_15,v16_30,v31_45,
		v46_60,v61_75,v76_90,v91_105,v106_120,v121_135,v136_150,v151_165,v166_180) VALUES (
				'".date('Y-m-d')."',
				'$p[CST_FIN]',
				'$p[TXA_DEF]',
				'$p[CST_OPE]',
				'$p[v0_15]',
				'$p[v16_30]',
				'$p[v31_45]',
				'$p[v46_60]',
				'$p[v61_75]',
				'$p[v76_90]',
				'$p[v91_105]',
				'$p[v106_120]',
				'$p[v121_135]',
				'$p[v136_150]',
				'$p[v151_165]',
				'$p[v166_180]')");
		$r['alerta'] = "Salvo com sucesso!";
		return $r;
	 }
	           
	function listar() {	
		$t = fetch_assoc_simples("SELECT * FROM EST_INDICES ORDER BY DATA DESC");
		return $t;
    }
}
?>