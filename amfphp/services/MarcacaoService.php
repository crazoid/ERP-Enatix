<?php

require_once "Conexao.php";

class MarcacaoService
{	
	function MarcacaoService(){ }

	function listar($lote){
		$s = "SELECT M.ID, M.LOTE, M.ESCOLA, M.ARTIGO, M.DOIS, M.QUATRO, M.SEIS, M.OITO, M.DEZ,
			M.DOZE, M.QUATORZE, M.DEZESSEIS, M.P, M.M, M.G, M.XG, E.ID AS ESCOLA, E.DESCRICAO AS ESCOLA_DESC, A.ID AS ARTIGO, A.DESCRICAO AS ARTIGO_DESC, L.DESCRICAO AS LOTE_DESC FROM AGA_MARCACAO M, AGA_INSTITUICOES E, AGA_ARTIGOS A, AGA_LOTES L
			WHERE M.LOTE='$lote' AND M.ARTIGO=A.ID AND M.ESCOLA=E.ID AND L.ID='$lote' ORDER BY M.ID ASC";
		$r = fetch_assoc($s);
		foreach($r as $k=>$v){
			$r[$k]['DESCRICAO'] = $v['ARTIGO']." / ".$v['ESCOLA']." - ".$v['ARTIGO_DESC']." ".$v['ESCOLA_DESC'];
			$r[$k]['TOTAL'] = (double)$v['DOIS']+(double)$v['QUATRO']+(double)$v['SEIS']+(double)$v['OITO']+(double)$v['DEZ']+(double)$v['DOZE']+(double)$v['QUATORZE']+(double)$v['DEZESSEIS']+(double)$v['P']+(double)$v['M']+(double)$v['G']+(double)$v['XG'];
		}
		return $r;
	}
	  
     function editar($p){
		$p['DOIS']      = $p['DOIS']      ==""? "0" : $p['DOIS']      ;
		$p['QUATRO']    = $p['QUATRO']    ==""? "0" : $p['QUATRO']    ;
		$p['SEIS']      = $p['SEIS']      ==""? "0" : $p['SEIS']      ;
		$p['OITO']      = $p['OITO']      ==""? "0" : $p['OITO']      ;
		$p['DEZ']       = $p['DEZ']       ==""? "0" : $p['DEZ']       ;
		$p['DOZE']      = $p['DOZE']      ==""? "0" : $p['DOZE']      ;
		$p['QUATORZE']  = $p['QUATORZE']  ==""? "0" : $p['QUATORZE']  ;
		$p['DEZESSEIS'] = $p['DEZESSEIS'] ==""? "0" : $p['DEZESSEIS'] ;
		$p['P']         = $p['P']         ==""? "0" : $p['P']         ;
		$p['M']         = $p['M']         ==""? "0" : $p['M']         ;
		$p['G']         = $p['G']         ==""? "0" : $p['G']         ;
		$p['XG']        = $p['XG']        ==""? "0" : $p['XG']        ;
     	executa("UPDATE AGA_MARCACAO SET DOIS='$p[DOIS]', QUATRO='$p[QUATRO]', SEIS='$p[SEIS]', OITO='$p[OITO]', DEZ='$p[DEZ]', DOZE='$p[DOZE]', QUATORZE='$p[QUATORZE]', DEZESSEIS='$p[DEZESSEIS]', P='$p[P]', M='$p[M]', G='$p[G]', XG='$p[XG]' WHERE ESCOLA='$p[ESCOLA]' AND ARTIGO='$p[ARTIGO]' AND LOTE='$p[LOTE]'");
     }
	  
	function inserir($p) {
		foreach($p as $k=>$v){
			executa("INSERT INTO AGA_MARCACAO VALUES('$p[LOTE]','$p[ESCOLA]','$p[ARTIGO]','p[DOIS]','$p[QUATRO]','$p[SEIS]','$p[OITO]','$p[DEZ]','$p[DOZE]','$p[QUATORZE]','$p[DEZESSEIS]','$p[P]','$p[M]','$p[G]','$p[XG]')");
		}
    }
	
	function cadastrar($p){
		foreach($p[PRODUTOS] as $produto){
			executa("INSERT INTO AGA_MARCACAO (LOTE,ESCOLA,ARTIGO) VALUES (
					'$p[ID]',
					'$produto[ESCOLA]',
					'$produto[ARTIGO]')
					");		
		}
	}
	
	function excluir($id){
		executa("DELETE FROM AGA_MARCACAO WHERE ID='$id'");
	}
}
?>