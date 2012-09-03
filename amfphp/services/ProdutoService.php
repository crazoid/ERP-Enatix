<?php

require_once "Conexao.php";
require_once "Object.php";

class ProdutoService
{	
	function ProdutoService(){  }
     
     function copiar_sem_sobreescrever($obj){
		$oInstituicao = $obj[ESCOLA_ORIGEM];
		$oArtigo = $obj[ARTIGO_ORIGEM];
		$dInstituicao = $obj[ESCOLA_DESTINO];
		$dArtigo = $obj[ARTIGO_DESTINO];
		$lt = fetch_assoc_simples("SELECT COUNT(*) FROM AGA_PRODUTOS WHERE ESCOLA='$dInstituicao' AND ARTIGO='$dArtigo'");
		if($lt[COUNT]<1){
	     	$r = fetch_assoc("SELECT * FROM AGA_PRODUTOS WHERE ESCOLA='$oInstituicao' AND ARTIGO='$oArtigo'");
	     	foreach($r as $k=>$v){
				executa("INSERT INTO AGA_PRODUTOS (escola,artigo,insumo,tamanho,qtde) VALUES ('$dInstituicao','$dArtigo','$v[INSUMO]','$v[TAMANHO]','$v[QTDE]')");		
	     	}
		}
     }
	 
     function copiar($obj){
		$oInstituicao = $obj[ESCOLA_ORIGEM];
		$oArtigo = $obj[ARTIGO_ORIGEM];
		$dInstituicao = $obj[ESCOLA_DESTINO];
		$dArtigo = $obj[ARTIGO_DESTINO];
		executa("DELETE FROM AGA_PRODUTOS WHERE ESCOLA='$dInstituicao' AND ARTIGO='$dArtigo'");
    	$r = fetch_assoc("SELECT * FROM AGA_PRODUTOS WHERE ESCOLA='$oInstituicao' AND ARTIGO='$oArtigo'");
		foreach($r as $k=>$v){
			executa("INSERT INTO AGA_PRODUTOS (escola,artigo,insumo,tamanho,qtde) VALUES ('$dInstituicao','$dArtigo','$v[INSUMO]','$v[TAMANHO]','$v[QTDE]')");
		}
     }
     
     function editar ($p){
		$DOIS      = $p[DOIS]=="" ?      '' : $p[DOIS];
		$QUATRO    = $p[QUATRO]=="" ?    '' : $p[QUATRO];
		$SEIS      = $p[SEIS]=="" ?      '' : $p[SEIS];
		$OITO      = $p[OITO]=="" ?      '' : $p[OITO];
		$DEZ       = $p[DEZ]=="" ?       '' : $p[DEZ];
		$DOZE      = $p[DOZE]=="" ?      '' : $p[DOZE];
		$QUATORZE  = $p[QUATORZE]=="" ?  '' : $p[QUATORZE];
		$DEZESSEIS = $p[DEZESSEIS]=="" ? '' : $p[DEZESSEIS];
		$P         = $p[P]=="" ?         '' : $p[P];
		$M         = $p[M]=="" ?         '' : $p[M];
		$G         = $p[G]=="" ?         '' : $p[G];
		$XG        = $p[XG]=="" ?        '' : $p[XG];
		$r = fetch_assoc_simples("SELECT COUNT(*) FROM AGA_PRODUTOS WHERE TAMANHO='02' AND ESCOLA='$p[ESCOLA]' AND ARTIGO='$p[ARTIGO]' AND INSUMO='$p[INSUMO]'");
		//echo "DOIS</BR>";
		//print_r($r);
		if($r[COUNT]>0) executa("UPDATE AGA_PRODUTOS SET QTDE='$DOIS' WHERE TAMANHO='02' AND ESCOLA='$p[ESCOLA]' AND ARTIGO='$p[ARTIGO]' AND INSUMO='$p[INSUMO]'");
		else executa("INSERT INTO AGA_PRODUTOS (TAMANHO,QTDE,ESCOLA,ARTIGO,INSUMO) VALUES ('02','$DOIS','$p[ESCOLA]','$p[ARTIGO]','$p[INSUMO]')");

		$r = fetch_assoc_simples("SELECT COUNT(*) FROM AGA_PRODUTOS WHERE TAMANHO='04' AND ESCOLA='$p[ESCOLA]' AND ARTIGO='$p[ARTIGO]' AND INSUMO='$p[INSUMO]'");
		//echo "QUATRO</BR>";
		//print_r($r);
		if($r[COUNT]>0) executa("UPDATE AGA_PRODUTOS SET QTDE='$QUATRO' WHERE TAMANHO='04' AND ESCOLA='$p[ESCOLA]' AND ARTIGO='$p[ARTIGO]' AND INSUMO='$p[INSUMO]'");
		else executa("INSERT INTO AGA_PRODUTOS (TAMANHO,QTDE,ESCOLA,ARTIGO,INSUMO) VALUES ('04','$QUATRO','$p[ESCOLA]','$p[ARTIGO]','$p[INSUMO]')");
		
		$r = fetch_assoc_simples("SELECT COUNT(*) FROM AGA_PRODUTOS WHERE TAMANHO='06' AND ESCOLA='$p[ESCOLA]' AND ARTIGO='$p[ARTIGO]' AND INSUMO='$p[INSUMO]'");
		//echo "SEIS</BR>";
		//print_r($r);
		if($r[COUNT]>0) executa("UPDATE AGA_PRODUTOS SET QTDE='$SEIS' WHERE TAMANHO='06' AND ESCOLA='$p[ESCOLA]' AND ARTIGO='$p[ARTIGO]' AND INSUMO='$p[INSUMO]'");
		else executa("INSERT INTO AGA_PRODUTOS (TAMANHO,QTDE,ESCOLA,ARTIGO,INSUMO) VALUES ('06','$SEIS','$p[ESCOLA]','$p[ARTIGO]','$p[INSUMO]')");

		$r = fetch_assoc_simples("SELECT COUNT(*) FROM AGA_PRODUTOS WHERE TAMANHO='08' AND ESCOLA='$p[ESCOLA]' AND ARTIGO='$p[ARTIGO]' AND INSUMO='$p[INSUMO]'");
		//echo "OITO</BR>";
		//print_r($r);
		if($r[COUNT]>0) executa("UPDATE AGA_PRODUTOS SET QTDE='$OITO' WHERE TAMANHO='08' AND ESCOLA='$p[ESCOLA]' AND ARTIGO='$p[ARTIGO]' AND INSUMO='$p[INSUMO]'");
		else executa("INSERT INTO AGA_PRODUTOS (TAMANHO,QTDE,ESCOLA,ARTIGO,INSUMO) VALUES ('08','$OITO','$p[ESCOLA]','$p[ARTIGO]','$p[INSUMO]')");

		$r = fetch_assoc_simples("SELECT COUNT(*) FROM AGA_PRODUTOS WHERE TAMANHO='10' AND ESCOLA='$p[ESCOLA]' AND ARTIGO='$p[ARTIGO]' AND INSUMO='$p[INSUMO]'");
		//echo "DEZ</BR>";
		//print_r($r);
		if($r[COUNT]>0) executa("UPDATE AGA_PRODUTOS SET QTDE='$DEZ' WHERE TAMANHO='10' AND ESCOLA='$p[ESCOLA]' AND ARTIGO='$p[ARTIGO]' AND INSUMO='$p[INSUMO]'");
		else executa("INSERT INTO AGA_PRODUTOS (TAMANHO,QTDE,ESCOLA,ARTIGO,INSUMO) VALUES ('10','$DEZ','$p[ESCOLA]','$p[ARTIGO]','$p[INSUMO]')");

		$r = fetch_assoc_simples("SELECT COUNT(*) FROM AGA_PRODUTOS WHERE TAMANHO='12' AND ESCOLA='$p[ESCOLA]' AND ARTIGO='$p[ARTIGO]' AND INSUMO='$p[INSUMO]'");
		//echo "DOZE</BR>";
		//print_r($r);
		if($r[COUNT]>0) executa("UPDATE AGA_PRODUTOS SET QTDE='$DOZE' WHERE TAMANHO='12' AND ESCOLA='$p[ESCOLA]' AND ARTIGO='$p[ARTIGO]' AND INSUMO='$p[INSUMO]'");
		else executa("INSERT INTO AGA_PRODUTOS (TAMANHO,QTDE,ESCOLA,ARTIGO,INSUMO) VALUES ('12','$DOZE','$p[ESCOLA]','$p[ARTIGO]','$p[INSUMO]')");

		$r = fetch_assoc_simples("SELECT COUNT(*) FROM AGA_PRODUTOS WHERE TAMANHO='14' AND ESCOLA='$p[ESCOLA]' AND ARTIGO='$p[ARTIGO]' AND INSUMO='$p[INSUMO]'");
		//echo "QUATORZE</BR>";
		//print_r($r);
		if($r[COUNT]>0) executa("UPDATE AGA_PRODUTOS SET QTDE='$QUATORZE' WHERE TAMANHO='14' AND ESCOLA='$p[ESCOLA]' AND ARTIGO='$p[ARTIGO]' AND INSUMO='$p[INSUMO]'");
		else executa("INSERT INTO AGA_PRODUTOS (TAMANHO,QTDE,ESCOLA,ARTIGO,INSUMO) VALUES ('14','$QUATORZE','$p[ESCOLA]','$p[ARTIGO]','$p[INSUMO]')");

		$r = fetch_assoc_simples("SELECT COUNT(*) FROM AGA_PRODUTOS WHERE TAMANHO='16' AND ESCOLA='$p[ESCOLA]' AND ARTIGO='$p[ARTIGO]' AND INSUMO='$p[INSUMO]'");
		//echo "DEZESSEIS</BR>";
		//print_r($r);
		if($r[COUNT]>0) executa("UPDATE AGA_PRODUTOS SET QTDE='$DEZESSEIS' WHERE TAMANHO='16' AND ESCOLA='$p[ESCOLA]' AND ARTIGO='$p[ARTIGO]' AND INSUMO='$p[INSUMO]'");
		else executa("INSERT INTO AGA_PRODUTOS (TAMANHO,QTDE,ESCOLA,ARTIGO,INSUMO) VALUES ('16','$DEZESSEIS','$p[ESCOLA]','$p[ARTIGO]','$p[INSUMO]')");

		$r = fetch_assoc_simples("SELECT COUNT(*) FROM AGA_PRODUTOS WHERE TAMANHO='P' AND ESCOLA='$p[ESCOLA]' AND ARTIGO='$p[ARTIGO]' AND INSUMO='$p[INSUMO]'");
		//echo "P</BR>";
		//print_r($r);
		if($r[COUNT]>0) executa("UPDATE AGA_PRODUTOS SET QTDE='$P' WHERE TAMANHO='P' AND ESCOLA='$p[ESCOLA]' AND ARTIGO='$p[ARTIGO]' AND INSUMO='$p[INSUMO]'");
		else executa("INSERT INTO AGA_PRODUTOS (TAMANHO,QTDE,ESCOLA,ARTIGO,INSUMO) VALUES ('P','$P','$p[ESCOLA]','$p[ARTIGO]','$p[INSUMO]')");

		$r = fetch_assoc_simples("SELECT COUNT(*) FROM AGA_PRODUTOS WHERE TAMANHO='M' AND ESCOLA='$p[ESCOLA]' AND ARTIGO='$p[ARTIGO]' AND INSUMO='$p[INSUMO]'");
		//echo "M</BR>";
		//print_r($r);
		if($r[COUNT]>0) executa("UPDATE AGA_PRODUTOS SET QTDE='$M' WHERE TAMANHO='M' AND ESCOLA='$p[ESCOLA]' AND ARTIGO='$p[ARTIGO]' AND INSUMO='$p[INSUMO]'");
		else executa("INSERT INTO AGA_PRODUTOS (TAMANHO,QTDE,ESCOLA,ARTIGO,INSUMO) VALUES ('M','$M','$p[ESCOLA]','$p[ARTIGO]','$p[INSUMO]')");

		$r = fetch_assoc_simples("SELECT COUNT(*) FROM AGA_PRODUTOS WHERE TAMANHO='G' AND ESCOLA='$p[ESCOLA]' AND ARTIGO='$p[ARTIGO]' AND INSUMO='$p[INSUMO]'");
		//echo "G</BR>";
		//print_r($r);
		if($r[COUNT]>0) executa("UPDATE AGA_PRODUTOS SET QTDE='$G' WHERE TAMANHO='G' AND ESCOLA='$p[ESCOLA]' AND ARTIGO='$p[ARTIGO]' AND INSUMO='$p[INSUMO]'");
		else executa("INSERT INTO AGA_PRODUTOS (TAMANHO,QTDE,ESCOLA,ARTIGO,INSUMO) VALUES ('G','$G','$p[ESCOLA]','$p[ARTIGO]','$p[INSUMO]')");

		$r = fetch_assoc_simples("SELECT COUNT(*) FROM AGA_PRODUTOS WHERE TAMANHO='XG' AND ESCOLA='$p[ESCOLA]' AND ARTIGO='$p[ARTIGO]' AND INSUMO='$p[INSUMO]'");
		//echo "XG</BR>";
		//print_r($r);
		if($r[COUNT]>0) executa("UPDATE AGA_PRODUTOS SET QTDE='$XG' WHERE TAMANHO='XG' AND ESCOLA='$p[ESCOLA]' AND ARTIGO='$p[ARTIGO]' AND INSUMO='$p[INSUMO]'");
		else executa("INSERT INTO AGA_PRODUTOS (TAMANHO,QTDE,ESCOLA,ARTIGO,INSUMO) VALUES ('XG','$XG','$p[ESCOLA]','$p[ARTIGO]','$p[INSUMO]')");
	}
     
	 function cadastrar($p){
		foreach($p[ARTIGOS] as $artigo){
			$s = "SELECT COUNT(*) FROM AGA_PRODUTOS WHERE ESCOLA='$p[ESCOLA]' AND ARTIGO='$artigo[ID]'";
			$r = fetch_assoc($s);
			if($s[COUNT]<1)
				executa("INSERT INTO AGA_PRODUTOS (ESCOLA,ARTIGO) VALUES ('$p[ESCOLA]','$artigo[ID]')");
		}
	 }
	 
     function inserir($p){
		foreach($p[INSUMOS] as $insumo){
			$s=fetch_assoc_simples("SELECT COUNT(*) FROM AGA_REGRAS WHERE ARTIGO='$p[ARTIGO]' AND INSUMO='$insumo[ID]'");
			if($s[COUNT]<1) {
				$sql = "INSERT INTO AGA_PRODUTOS (ESCOLA,ARTIGO,INSUMO) VALUES ('$p[ESCOLA]','$p[ARTIGO]','$insumo[ID]')";
				//echo "<BR/>".$sql;
				executa($sql);
				} else {
				$r=fetch_assoc_simples("SELECT * FROM AGA_REGRAS WHERE ARTIGO='$p[ARTIGO]' and INSUMO='$insumo[ID]'");
				$DOIS = $r[DOIS];
				$QUATRO = $r[QUATRO];
				$SEIS = $r[SEIS];
				$OITO = $r[OITO];
				$DEZ = $r[DEZ];
				$DOZE = $r[DOZE];
				$QUATORZE = $r[QUATORZE];
				$DEZESSEIS = $r[DEZESSEIS];
				$rp = $r[P];
				$m = $r[M];
				$g = $r[G];
				$xg = $r[XG];
				$sql = "INSERT INTO AGA_PRODUTOS (ESCOLA,ARTIGO,INSUMO,TAMANHO,QTDE) VALUES ('$p[ESCOLA]','$p[ARTIGO]','$insumo[ID]','02','$DOIS')";
				$sql2 = "INSERT INTO AGA_PRODUTOS (ESCOLA,ARTIGO,INSUMO,TAMANHO,QTDE) VALUES ('$p[ESCOLA]','$p[ARTIGO]','$insumo[ID]','04','$QUATRO')";
				$sql3 = "INSERT INTO AGA_PRODUTOS (ESCOLA,ARTIGO,INSUMO,TAMANHO,QTDE) VALUES ('$p[ESCOLA]','$p[ARTIGO]','$insumo[ID]','06','$SEIS')";
				$sql4 = "INSERT INTO AGA_PRODUTOS (ESCOLA,ARTIGO,INSUMO,TAMANHO,QTDE) VALUES ('$p[ESCOLA]','$p[ARTIGO]','$insumo[ID]','08','$OITO')";
				$sql5 = "INSERT INTO AGA_PRODUTOS (ESCOLA,ARTIGO,INSUMO,TAMANHO,QTDE) VALUES ('$p[ESCOLA]','$p[ARTIGO]','$insumo[ID]','10','$DEZ')";
				$sql6 = "INSERT INTO AGA_PRODUTOS (ESCOLA,ARTIGO,INSUMO,TAMANHO,QTDE) VALUES ('$p[ESCOLA]','$p[ARTIGO]','$insumo[ID]','12','$DOZE')";
				$sql7 = "INSERT INTO AGA_PRODUTOS (ESCOLA,ARTIGO,INSUMO,TAMANHO,QTDE) VALUES ('$p[ESCOLA]','$p[ARTIGO]','$insumo[ID]','14','$QUATORZE')";
				$sql8 = "INSERT INTO AGA_PRODUTOS (ESCOLA,ARTIGO,INSUMO,TAMANHO,QTDE) VALUES ('$p[ESCOLA]','$p[ARTIGO]','$insumo[ID]','16','$DEZESSEIS')";
				$sql9 = "INSERT INTO AGA_PRODUTOS (ESCOLA,ARTIGO,INSUMO,TAMANHO,QTDE) VALUES ('$p[ESCOLA]','$p[ARTIGO]','$insumo[ID]','P','$rp')";
				$sql10 = "INSERT INTO AGA_PRODUTOS (ESCOLA,ARTIGO,INSUMO,TAMANHO,QTDE) VALUES ('$p[ESCOLA]','$p[ARTIGO]','$insumo[ID]','M','$m')";
				$sql11 = "INSERT INTO AGA_PRODUTOS (ESCOLA,ARTIGO,INSUMO,TAMANHO,QTDE) VALUES ('$p[ESCOLA]','$p[ARTIGO]','$insumo[ID]','G','$g')";
				$sql12 = "INSERT INTO AGA_PRODUTOS (ESCOLA,ARTIGO,INSUMO,TAMANHO,QTDE) VALUES ('$p[ESCOLA]','$p[ARTIGO]','$insumo[ID]','XG','$xg')";
				
				//echo "<BR/>".$sql;
				//echo "<BR/>".$sql2; 
				//echo "<BR/>".$sql3; 
				//echo "<BR/>".$sql4; 
				//echo "<BR/>".$sql5; 
				//echo "<BR/>".$sql6; 
				//echo "<BR/>".$sql7; 
				//echo "<BR/>".$sql8; 
				//echo "<BR/>".$sql9; 
				//echo "<BR/>".$sql10;
				//echo "<BR/>".$sql11;
				//echo "<BR/>".$sql12;
				
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
     
     function excluir($escola,$artigo,$insumo){
     	executa("DELETE FROM AGA_PRODUTOS WHERE ESCOLA='$escola' AND ARTIGO='$artigo' AND INSUMO='$insumo'");
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
	          
	function listar($escola, $artigo) {	
		$t = fetch_assoc_simples("SELECT COUNT(*) FROM AGA_PRODUTOS WHERE ESCOLA='$escola' AND ARTIGO='$artigo'");
		$r = array();
     	if($t[COUNT]>1){ 
			$l = array();
			$s = fetch_assoc("SELECT P.ID, P.ESCOLA, P.ARTIGO, P.INSUMO, P.TAMANHO, P.QTDE, I.ID AS INSUMO, I.DESCRICAO AS INSUMO_DESC, I.PRECO, I.TIPO FROM AGA_PRODUTOS P, AGA_INSUMOS I WHERE P.ESCOLA = '$escola' AND P.ARTIGO = '$artigo' AND P.INSUMO=I.ID ORDER BY I.DESCRICAO ASC");
			foreach($s as $k=>$v){
				$v[TIPO] = $v[TIPO] > 2 ? '99' : $v[TIPO];
				$v[TAMANHO] = str_replace(" ","",$v[TAMANHO]);
				$tipo = $v[TIPO];
				$insumo = $v[INSUMO];
				$tamanho = $v[TAMANHO];
				$l[$tipo][$insumo][TIPO] = $v[TIPO];
				$l[$tipo][$insumo][INSUMO] = $v[INSUMO];
				$l[$tipo][$insumo][DESCRICAO] = $v[INSUMO_DESC];
				$l[$tipo][$insumo][ESCOLA] = $v[ESCOLA];
				$l[$tipo][$insumo][ARTIGO] = $v[ARTIGO];
				$l[$tipo][$insumo][PRECO] = $v[PRECO];
				$l[$tipo][$insumo][$tamanho] = $v[QTDE];
			}
			foreach($l as $k=>$t){
				$pro = array();
				if($k==1) $pro[INSUMO] = "MALHA/RIBANA";
				if($k==2) $pro[INSUMO] = "AVIAMENTO";
				if($k==99) $pro[INSUMO] = "MAO DE OBRA";
				$pro[TIPO] = "--------";
				$pro[PRECO] = "--------";
				$pro[DOIS] = "--------";
				$pro[QUATRO] = "--------";
				$pro[SEIS] = "--------";
				$pro[OITO] = "--------";
				$pro[DEZ] = "--------";
				$pro[DOZE] = "--------";
				$pro[QUATORZE] = "--------";
				$pro[DEZESSEIS] = "--------";
				$pro[P] = "--------";
				$pro[M] = "--------";
				$pro[G] = "--------";
				$pro[XG] = "--------";
				$r[] = $pro;
				$pro = array();
				foreach($t as $kinsumo=>$v){
					$v['02'] = str_replace(",",".",$v['02']);
					$v['04'] = str_replace(",",".",$v['04']);
					$v['06'] = str_replace(",",".",$v['06']);
					$v['08'] = str_replace(",",".",$v['08']);
					$v['10'] = str_replace(",",".",$v['10']);
					$v['12'] = str_replace(",",".",$v['12']);
					$v['14'] = str_replace(",",".",$v['14']);
					$v['16'] = str_replace(",",".",$v['16']);
					$v['P'] = str_replace(",",".",$v['P']);
					$v['M'] = str_replace(",",".",$v['M']);
					$v['G'] = str_replace(",",".",$v['G']);
					$v['XG'] = str_replace(",",".",$v['XG']);
					$v['PRECO'] = str_replace(",",".",$v['PRECO']);
					$pro[INSUMO] = "- ".$v[DESCRICAO];
					$pro[INSUMO_ID] = $v[INSUMO];
					$pro[TIPO] =      $v[TIPO];
					$pro[PRECO] =     $v[PRECO];
					$pro[QTDE] =      $v[QTDE];
					$pro[ESCOLA] =    $v[ESCOLA];
					$pro[ARTIGO] =    $v[ARTIGO];
					$pro[DOIS] =      $v['02'];
					$pro[QUATRO] =    $v['04'];
					$pro[SEIS] =      $v['06'];
					$pro[OITO] =      $v['08'];
					$pro[DEZ] =       $v['10'];
					$pro[DOZE] =      $v['12'];
					$pro[QUATORZE] =  $v['14'];
					$pro[DEZESSEIS] = $v['16'];
					$pro[P] =         $v[P];
					$pro[M] =         $v[M];
					$pro[G] =         $v[G];
					$pro[XG] =        $v[XG];
					$DOIS += $v['02']!=""? (double)$v['02'] * (double)$v[PRECO] : 0;
					$QUATRO += $v['04']!=""? (double)$v['04'] * (double)$v[PRECO] : 0;
					$SEIS += $v['06']!=""? (double)$v['06'] * (double)$v[PRECO] : 0;			
					$OITO += $v['08']!=""? (double)$v['08'] * (double)$v[PRECO] : 0;
					$DEZ += $v['10']!=""? (double)$v['10'] * (double)$v[PRECO] : 0;
					$DOZE += $v['12']!=""? (double)$v['12'] * (double)$v[PRECO] : 0;
					$QUATORZE += $v['14']!=""? (double)$v['14'] * (double)$v[PRECO] : 0;
					$DEZESSEIS += $v['16']!=""? (double)$v['16'] * (double)$v[PRECO] : 0;
					$P += $v['P']!=""? (double)$v['P'] * (double)$v[PRECO] : 0;
					$M += $v['M']!=""? (double)$v['M'] * (double)$v[PRECO] : 0;
					$G += $v['G']!=""? (double)$v['G'] * (double)$v[PRECO] : 0;
					$XG += $v['XG']!=""? (double)$v['XG'] * (double)$v[PRECO] : 0;
					$r[] = $pro;
				}
			}

			$pro = array();
			$pro[INSUMO] = "*** TOTAIS ***";
			$pro[TIPO] = "TOTAIS";
		
			$DOIS = number_format($DOIS, 2, ',', '.');
			$pro[DOIS] = $DOIS == '0,00' ? "--------" : $DOIS;
			
			$QUATRO = number_format($QUATRO, 2, ',', '.');
			$pro[QUATRO] = $QUATRO == '0,00' ? "--------" : $QUATRO;
			
			$SEIS = number_format($SEIS, 2, ',', '.');
			$pro[SEIS] = $SEIS == '0,00' ? "--------" : $SEIS;
			
			$OITO = number_format($OITO, 2, ',', '.');
			$pro[OITO] = $OITO == '0,00' ? "--------" : $OITO;
			
			$DEZ = number_format($DEZ, 2, ',', '.');
			$pro[DEZ] = $DEZ == '0,00' ? "--------" : $DEZ;

			$DOZE = number_format($DOZE, 2, ',', '.');
			$pro[DOZE] = $DOZE == '0,00' ? "--------" : $DOZE;
			
			$QUATORZE = number_format($QUATORZE, 2, ',', '.');
			$pro[QUATORZE] = $QUATORZE == '0,00' ? "--------" : $QUATORZE;
			
			$DEZESSEIS = number_format($DEZESSEIS, 2, ',', '.');
			$pro[DEZESSEIS] = $DEZESSEIS == '0,00' ? "--------" : $DEZESSEIS;
			
			$P = number_format($P, 2, ',', '.');
			$pro[P] = $P == '0,00' ? "--------" : $P;
			
			$M = number_format($M, 2, ',', '.');
			$pro[M] = $M == '0,00' ? "--------" : $M;
			
			$G = number_format($G, 2, ',', '.');
			$pro[G] = $G == '0,00' ? "--------" : $G;
			
			$XG = number_format($XG, 2, ',', '.');
			$pro[XG] = $XG == '0,00' ? "--------" : $XG;

			$r[] = $pro;
		}
		return $r;
    }
}
?>