<?php

require_once "Conexao.php";
require_once "Object.php";

class RegraService
{	
	function RegraService(){ }
	
	function listar($texto){
		$padrao = "^([0-9][0-9][0-9][0-9])-([0-9][0-9][0-9][0-9])$";
		if($texto==""){ 
			$s = "SELECT 
			R.ID,R.ARTIGO,R.INSUMO,R.DOIS,R.QUATRO,R.SEIS,R.OITO,R.DEZ,R.DOZE,R.QUATORZE,R.DEZESSEIS,R.P,R.M,R.G,R.XG,
			I.ID,I.DESCRICAO AS INSUMO_DESC,
			A.ID,A.DESCRICAO AS ARTIGO_DESC 
			FROM AGA_REGRAS R, AGA_INSUMOS I, AGA_ARTIGOS A 
			WHERE R.INSUMO=I.ID AND R.ARTIGO=A.ID ORDER BY R.ID DESC";
		}
		else if(ereg($padrao,$texto)){
			$intervalo = explode("-",$texto);
			$s = "SELECT 
			R.ID,R.ARTIGO,R.INSUMO,R.DOIS,R.QUATRO,R.SEIS,R.OITO,R.DEZ,R.DOZE,R.QUATORZE,R.DEZESSEIS,R.P,R.M,R.G,R.XG,
			I.ID,I.DESCRICAO AS INSUMO_DESC,
			A.ID,A.DESCRICAO AS ARTIGO_DESC 
			FROM AGA_REGRAS R, AGA_INSUMOS I, AGA_ARTIGOS A 
			WHERE R.INSUMO=I.ID AND R.ARTIGO=A.ID AND 
			R.ID BETWEEN '$intervalo[0]' AND '$intervalo[1]' ORDER BY R.ID DESC";
		}
		else if(is_numeric($texto)){
			$s = "SELECT 
			R.ID,R.ARTIGO,R.INSUMO,R.DOIS,R.QUATRO,R.SEIS,R.OITO,R.DEZ,R.DOZE,R.QUATORZE,R.DEZESSEIS,R.P,R.M,R.G,R.XG,
			I.ID,I.DESCRICAO AS INSUMO_DESC,
			A.ID,A.DESCRICAO AS ARTIGO_DESC 
			FROM AGA_REGRAS R, AGA_INSUMOS I, AGA_ARTIGOS A 
			WHERE R.INSUMO=I.ID AND R.ARTIGO=A.ID AND 
			R.ID='$texto' ORDER BY R.ID DESC";
		} 
		else {
			$s = "SELECT 
			R.ID,R.ARTIGO,R.INSUMO,R.DOIS,R.QUATRO,R.SEIS,R.OITO,R.DEZ,R.DOZE,R.QUATORZE,R.DEZESSEIS,R.P,R.M,R.G,R.XG,
			I.ID,I.DESCRICAO AS INSUMO_DESC,
			A.ID,A.DESCRICAO AS ARTIGO_DESC 
			FROM AGA_REGRAS R, AGA_INSUMOS I, AGA_ARTIGOS A 
			WHERE R.INSUMO=I.ID AND R.ARTIGO=A.ID ORDER BY R.ID DESC";
		}
		$r = fetch_assoc($s);
		foreach($r as $k=>$f){
			if($texto!=""){
				$passou = false;
				if(eregi($texto,$f['ARTIGO_DESC'])) $passou = true;
				if(eregi($texto,$f['INSUMO_DESC'])) $passou = true;
				if(!$passou){
					unset($r[$k]);
				}
			}
		}
		$r = array_merge($r);
		return $r;
	}
         
     function editar ($p){
		$DOIS = $p[DOIS]=="" ? '0' : $p[DOIS];
		$QUATRO = $p[QUATRO]=="" ? '0' : $p[QUATRO];
		$SEIS = $p[SEIS]=="" ? '0' : $p[SEIS];
		$OITO = $p[OITO]=="" ? '0' : $p[OITO];
		$DEZ = $p[DEZ]=="" ? '0' : $p[DEZ];
		$DOZE = $p[DOZE]=="" ? '0' : $p[DOZE];
		$QUATORZE = $p[QUATORZE]=="" ? '0' : $p[QUATORZE];
		$DEZESSEIS = $p[DEZESSEIS]=="" ? '0' : $p[DEZESSEIS];
		$P = $p[P]=="" ? '0' : $p[P];
		$M = $p[M]=="" ? '0' : $p[M];
		$G = $p[G]=="" ? '0' : $p[G];
		$XG = $p[XG]=="" ? '0' : $p[XG];
		executa("UPDATE AGA_REGRAS SET DOIS='$DOIS',QUATRO='$QUATRO',SEIS='$SEIS',OITO='$OITO',DEZ='$DEZ',DOZE='$DOZE',
			QUATORZE='$QUATORZE',DEZESSEIS='$DEZESSEIS',P='$P',M='$M',G='$G',XG='$XG' WHERE ARTIGO='$p[ARTIGO]' AND INSUMO='$p[INSUMO]'");
		}
     
	function cadastrar($p){
		foreach($p[ARTIGOS] as $artigo){
			foreach($p[INSUMOS] as $insumo){
				executa("DELETE FROM AGA_REGRAS WHERE ARTIGO='$artigo[ID]' AND INSUMO='$insumo[ID]'");
				executa("INSERT INTO AGA_REGRAS (ARTIGO,INSUMO,DOIS,QUATRO,SEIS,OITO,DEZ,DOZE,QUATORZE,DEZESSEIS,P,M,G,XG) 
						VALUES ('$artigo[ID]','$insumo[ID]','$p[DOIS]','$p[QUATRO]','$p[SEIS]','$p[OITO]','$p[DEZ]',
						'$p[DOZE]','$p[QUATORZE]','$p[DEZESSEIS]','$p[P]','$p[M]','$p[G]','$p[XG]')");
			}
		}
	}
	 
    function excluir($p){
		executa("DELETE FROM AGA_REGRAS WHERE ARTIGO='$p[ARTIGO]' AND INSUMO='$p[INSUMO]'");
    }   
            
	 function inserirInsumos($escola,$artigo,$insumos){
		foreach($insumos as $insumo){
	    	$t = fecth_assoc_simples("SELECT COUNT(*) FROM AGA_PRODUTOS WHERE ESCOLA='$escola' and artigo='$artigo' and insumo='$insumo[ID]'");
	    	$DOIS=$QUATRO=$SEIS=$OITO=$DEZ=$DOZE=$QUATORZE=$DEZESSEIS=$p=$m=$g=$xg="";
		    if($t[COUNT]<1){
				$r=fetch_assoc("SELECT * FROM AGA_REGRAS WHERE ARTIGO='$artigo' and INSUMO='$insumo[ID]'");
				$DOIS = $r[DOIS];
				$QUATRO = $r[QUATRO];
				$SEIS = $r[SEIS];
				$OITO = $r[OITO];
				$DEZ = $r[DEZ];
				$DOZE = $r[DOZE];
				$QUATORZE = $r[QUATORZE];
				$DEZESSEIS = $r[DEZESSEIS];
				$p = $r[P];
				$m = $r[M];
				$g = $r[G];
				$xg = $r[XG];
				$sql = "INSERT INTO AGA_PRODUTOS (ESCOLA,ARTIGO,INSUMO,TAMANHO,QTDE) VALUES ('$escola','$artigo','$insumo[ID]','02','$DOIS')";
				$sql2 = "INSERT INTO AGA_PRODUTOS (ESCOLA,ARTIGO,INSUMO,TAMANHO,QTDE) VALUES ('$escola','$artigo','$insumo[ID]','04','$QUATRO')";
				$sql3 = "INSERT INTO AGA_PRODUTOS (ESCOLA,ARTIGO,INSUMO,TAMANHO,QTDE) VALUES ('$escola','$artigo','$insumo[ID]','06','$SEIS')";
				$sql4 = "INSERT INTO AGA_PRODUTOS (ESCOLA,ARTIGO,INSUMO,TAMANHO,QTDE) VALUES ('$escola','$artigo','$insumo[ID]','08','$OITO')";
				$sql5 = "INSERT INTO AGA_PRODUTOS (ESCOLA,ARTIGO,INSUMO,TAMANHO,QTDE) VALUES ('$escola','$artigo','$insumo[ID]','10','$DEZ')";
				$sql6 = "INSERT INTO AGA_PRODUTOS (ESCOLA,ARTIGO,INSUMO,TAMANHO,QTDE) VALUES ('$escola','$artigo','$insumo[ID]','12','$DOZE')";
				$sql7 = "INSERT INTO AGA_PRODUTOS (ESCOLA,ARTIGO,INSUMO,TAMANHO,QTDE) VALUES ('$escola','$artigo','$insumo[ID]','14','$QUATORZE')";
				$sql8 = "INSERT INTO AGA_PRODUTOS (ESCOLA,ARTIGO,INSUMO,TAMANHO,QTDE) VALUES ('$escola','$artigo','$insumo[ID]','16','$DEZESSEIS')";
				$sql9 = "INSERT INTO AGA_PRODUTOS (ESCOLA,ARTIGO,INSUMO,TAMANHO,QTDE) VALUES ('$escola','$artigo','$insumo[ID]','P','$p')";
				$sql10 = "INSERT INTO AGA_PRODUTOS (ESCOLA,ARTIGO,INSUMO,TAMANHO,QTDE) VALUES ('$escola','$artigo','$insumo[ID]','M','$m')";
				$sql11 = "INSERT INTO AGA_PRODUTOS (ESCOLA,ARTIGO,INSUMO,TAMANHO,QTDE) VALUES ('$escola','$artigo','$insumo[ID]','G','$g')";
				$sql12 = "INSERT INTO AGA_PRODUTOS (ESCOLA,ARTIGO,INSUMO,TAMANHO,QTDE) VALUES ('$escola','$artigo','$insumo[ID]','XG','$xg')";
				executa($sql);
				executa($sql2);
				executa($sql3);
				executa($sql4);
				executa($sql5);
				executa($sql6);
				executa($sql7);
				executa($sql8);
				executa($sql9);
				executa($sql10);
				executa($sql11);
				executa($sql12);
			}
	    }
	 }
}
?>