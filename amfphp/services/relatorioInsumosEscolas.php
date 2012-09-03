<?php

	require_once "Conexao.php";
	
	header('MIME-Version: 1.0');
	header('Content-Type: text/html; charset=iso-8859-1');
	
	$lote = $_GET['lote'];
	$insumo = $_GET['insumo'];
	$l=fetch_assoc_simples("SELECT ID,DESCRICAO FROM AGA_LOTES WHERE ID='$lote'");
	$tp = $_GET['tipos'];
	$tp = explode(",",$tp);
	$relatorio = " <!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'";
	$relatorio .= " 'http://www.w3.org/TR/html4/loose.dtd'>";
	$relatorio .= " <html>";
	$relatorio .= " <head>";
	$relatorio .= " <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>";
	$relatorio .= "<style type='text/css' media='all'>";
    $relatorio .= "body{";
    $relatorio .= "	font-family:Verdana, Arial, Helvetica, sans-serif;";
    $relatorio .= "	font-size:small;";
    $relatorio .= "}";
    $relatorio .= "table.tabela {";
    $relatorio .= "	border-width: 2px;";
    $relatorio .= "	border-spacing: 2px;";
    $relatorio .= "	border-style: none;";
    $relatorio .= "	border-color: black;";
    $relatorio .= "	border-collapse: collapse;";
    $relatorio .= "	background-color: white;";
    $relatorio .= "	width: 1000px;";
    $relatorio .= "	text-align: center;";
    $relatorio .= "}";
    $relatorio .= "table.tabela th {";
    $relatorio .= "	border-width: 1px;";
    $relatorio .= "	padding: 2px;";
    $relatorio .= "	border-style: solid;";
    $relatorio .= "	border-color: gray;";
    $relatorio .= "	background-color: white;";
    $relatorio .= "}";
    $relatorio .= "table.tabela td {";
    $relatorio .= "	border-width: 1px;";
    $relatorio .= "	padding: 2px;";
    $relatorio .= "	border-style: solid;";
    $relatorio .= "	border-color: gray;";
    $relatorio .= "	background-color: white;";
    $relatorio .= "}";
    $relatorio .= "</style>";
	$relatorio .= " <title>BONSUCESSO - RELAT&Oacute;RIO DE CUSTO DE PRODU&Ccedil;&Atilde;O</title>";
	$relatorio .= " </head>";
	$relatorio .= " ";
	$relatorio .= " <body>";
	$relatorio .= " <table class='tabela'>";
	$relatorio .= "   <tr>";
	$relatorio .= "    <th colspan='2' scope='col'><img src='/amfphp/services/bonsucesso.jpg' width='502' height='107'></th>";
	$relatorio .= "   </tr>";
	$relatorio .= "   <tr>";
	$relatorio .= "     <th colspan='2'>RELAT&Oacute;RIO DE CUSTO DE PRODU&Ccedil;&Atilde;O </th>";
	$relatorio .= "   </tr>";
	$relatorio .= "   <tr>";
	$relatorio .= "     <td width='500' align='left'><strong>LOTE:</strong> ".$l[DESCRICAO]."</td>";
	$relatorio .= "     <td width='500' align='right'><strong>DATA:</strong> ".date('d/m/Y')."</td>";
	$relatorio .= "   </tr>";
	$relatorio .= "   <tr>";
	$relatorio .= "     <td width='500' colspan='2' align='left'><strong>INSUMO:</strong> ".$insumo."</td>";
	$relatorio .= "   </tr>";
	$relatorio .= " </table>";
	$relatorio .= " <br>";
	$r = fetch_assoc("SELECT AG.*, 
							 AP.*, 
							 AI.* 
					  FROM AGA_MARCACAO AG, 
					       AGA_PRODUTOS AP, 
						   AGA_INSUMOS AI 
					  WHERE AG.LOTE='$lote' AND 
						    AG.ESCOLA=AP.ESCOLA AND 
							AG.ARTIGO=AP.ARTIGO AND 
							AP.INSUMO='$insumo' AND
							AI.ID=AP.INSUMO");
	$quantidades = array();
	$escolas = array();
	foreach($r as $k=>$i){
		$quantidades['02'] = $i['DOIS'];
		$quantidades['04'] = $i['QUATRO'];
		$quantidades['06'] = $i['SEIS'];
		$quantidades['08'] = $i['OITO'];
		$quantidades['10'] = $i['DEZ'];
		$quantidades['12'] = $i['DOZE'];
		$quantidades['14'] = $i['QUATORZE'];
		$quantidades['16'] = $i['DEZESSEIS'];
		$quantidades['P'] = $i['P'];
		$quantidades['G'] = $i['M'];
		$quantidades['G'] = $i['G'];
		$quantidades['XG'] = $i['XG'];
		
		if($i[TAMANHO]=='02') $escolas[$i[ESCOLA]][$i[ARTIGO]]['02'] = $i[QTDE];
		if($i[TAMANHO]=='04') $escolas[$i[ESCOLA]][$i[ARTIGO]]['04'] = $i[QTDE];
		if($i[TAMANHO]=='06') $escolas[$i[ESCOLA]][$i[ARTIGO]]['06'] = $i[QTDE];
		if($i[TAMANHO]=='08') $escolas[$i[ESCOLA]][$i[ARTIGO]]['08'] = $i[QTDE];
		if($i[TAMANHO]=='10') $escolas[$i[ESCOLA]][$i[ARTIGO]]['10'] = $i[QTDE];
		if($i[TAMANHO]=='12') $escolas[$i[ESCOLA]][$i[ARTIGO]]['12'] = $i[QTDE];
		if($i[TAMANHO]=='14') $escolas[$i[ESCOLA]][$i[ARTIGO]]['14'] = $i[QTDE];
		if($i[TAMANHO]=='16') $escolas[$i[ESCOLA]][$i[ARTIGO]]['16'] = $i[QTDE];
		if($i[TAMANHO]=='P') $escolas[$i[ESCOLA]][$i[ARTIGO]]['P'] = $i[QTDE];
		if($i[TAMANHO]=='M') $escolas[$i[ESCOLA]][$i[ARTIGO]]['M'] = $i[QTDE];
		if($i[TAMANHO]=='G') $escolas[$i[ESCOLA]][$i[ARTIGO]]['G'] = $i[QTDE];
		if($i[TAMANHO]=='XG') $escolas[$i[ESCOLA]][$i[ARTIGO]]['XG'] = $i[QTDE];
	}
	$relatorio .= " <table class='tabela'>";
	$relatorio .= "   <tr>";
	$relatorio .= "     <th colspan='2' align='center'>QUANTIDADES</th>";
	$relatorio .= "     <td width='45'>".$quantidades['02']."</th>";
	$relatorio .= "     <td width='45'>".$quantidades['04']."</th>";
	$relatorio .= "     <td width='45'>".$quantidades['06']."</th>";
	$relatorio .= "     <td width='45'>".$quantidades['08']."</th>";
	$relatorio .= "     <td width='45'>".$quantidades['10']."</th>";
	$relatorio .= "     <td width='45'>".$quantidades['12']."</th>";
	$relatorio .= "     <td width='45'>".$quantidades['14']."</th>";
	$relatorio .= "     <td width='45'>".$quantidades['16']."</th>";
	$relatorio .= "     <td width='45'>".$quantidades['P']."</th>";
	$relatorio .= "     <td width='45'>".$quantidades['M']."</th>";
	$relatorio .= "     <td width='45'>".$quantidades['G']."</th>";
	$relatorio .= "     <td width='45'>".$quantidades['XG']."</th>";
	$relatorio .= "   </tr></table>";
	$relatorio .= "<BR/>";
	foreach($escolas as $escola){
		$relatorio .= " <table class='tabela'>";
		$relatorio .= "   <tr>";
		$relatorio .= "     <th align='left'>ESCOLA</th>";
		$relatorio .= "     <th align='left'>ARTIGO</th>";
		$relatorio .= "     <th width='45'>02</th>";
		$relatorio .= "     <th width='45'>04</th>";
		$relatorio .= "     <th width='45'>06</th>";
		$relatorio .= "     <th width='45'>08</th>";
		$relatorio .= "     <th width='45'>10</th>";
		$relatorio .= "     <th width='45'>12</th>";
		$relatorio .= "     <th width='45'>14</th>";
		$relatorio .= "     <th width='45'>16</th>";
		$relatorio .= "     <th width='45'>P</th>";
		$relatorio .= "     <th width='45'>M</th>";
		$relatorio .= "     <th width='45'>G</th>";
		$relatorio .= "     <th width='45'>XG</th>";
		$relatorio .= "   </tr>";
		foreach($escola as $k=>$artigo){
			$relatorio .= "<tr>";
			$relatorio .= "  <td align='left'>".$escola."</td>";
			$relatorio .= "  <td align='right'>".$artigo."</td>";
			$relatorio .= "  <td align='right'>".$artigo['02']."</td>";
			$relatorio .= "  <td align='right'>".$artigo['04']."</td>";
			$relatorio .= "  <td align='right'>".$artigo['06']."</td>";
			$relatorio .= "  <td align='right'>".$artigo['08']."</td>";
			$relatorio .= "  <td align='right'>".$artigo['10']."</td>";
			$relatorio .= "  <td align='right'>".$artigo['12']."</td>";
			$relatorio .= "  <td align='right'>".$artigo['14']."</td>";
			$relatorio .= "  <td align='right'>".$artigo['16']."</td>";
			$relatorio .= "  <td align='right'>".$artigo['P']."</td>";
			$relatorio .= "  <td align='right'>".$artigo['M']."</td>";
			$relatorio .= "  <td align='right'>".$artigo['G']."</td>";
			$relatorio .= "  <td align='right'>".$artigo['XG']."</td>";
			$relatorio .= "</tr>";
			(double)$dois = (double)$artigo['02'] * (double)$quantidades['02'];
			(double)$quatro = (double)$artigo['04'] * (double)$quantidades['04'];
			(double)$seis = (double)$artigo['06'] * (double)$quantidades['06'];
			(double)$oito = (double)$artigo['08'] * (double)$quantidades['08'];
			(double)$dez = (double)$artigo['10'] * (double)$quantidades['10'];
			(double)$doze = (double)$artigo['12'] * (double)$quantidades['12'];
			(double)$quatorze = (double)$artigo['14'] * (double)$quantidades['14'];
			(double)$dezesseis = (double)$artigo['16'] * (double)$quantidades['16'];
			(double)$p = (double)$artigo['P'] * (double)$quantidades['P'];
			(double)$m = (double)$artigo['M'] * (double)$quantidades['M'];
			(double)$g = (double)$artigo['G'] * (double)$quantidades['G'];
			(double)$xg = (double)$artigo['XG'] * (double)$quantidades['XG'];
			$relatorio .= "<tr>";
			$relatorio .= "  <th colspan='2' align='right'>TOTAL</td>";
			$relatorio .= "  <td align='right'>".$dois."</td>";
			$relatorio .= "  <td align='right'>".$quatro."</td>";
			$relatorio .= "  <td align='right'>".$seis."</td>";
			$relatorio .= "  <td align='right'>".$oito."</td>";
			$relatorio .= "  <td align='right'>".$dez."</td>";
			$relatorio .= "  <td align='right'>".$doze."</td>";
			$relatorio .= "  <td align='right'>".$quatorze."</td>";
			$relatorio .= "  <td align='right'>".$dezesseis."</td>";
			$relatorio .= "  <td align='right'>".$p."</td>";
			$relatorio .= "  <td align='right'>".$m."</td>";
			$relatorio .= "  <td align='right'>".$g."</td>";
			$relatorio .= "  <td align='right'>".$xg."</td>";
			$relatorio .= "</tr>";
		}
		$relatorio .= "</table><BR/>";
	}
	/*
		$qtde = $i[QTDE];
		$qtde = explode(".",$qtde);
		if(strlen($qtde[1])>1) {
			$tmp = str_pad($qtde[1], 3, "0", STR_PAD_RIGHT);
			$qtde = $qtde[0].".".$tmp;
		} else $qtde = $qtde[0];
		if($i['DECIMAL']=='S') $qtde = str_pad($qtde, 7, "0", STR_PAD_LEFT);

		$relatorio .= "<tr>";
		$relatorio .= "  <td align='left'> - ".$insumo."</td>";
		$relatorio .= "  <td align='right'>".$qtde."</td>";
		$relatorio .= "  <td align='right'>".$cstun."</td>";
		$relatorio .= "  <td align='right'>".$vF."</td>";
		$relatorio .= "</tr>";
		}
		$subtotal =  number_format($subtotal, 2, ',', '.');
		$relatorio .= "<tr>";
		$relatorio .= "  <th colspan='3' align='right'>SUBTOTAL:</td>";
		$relatorio .= "  <th align='right'>".$subtotal."</td>";
		$relatorio .= "</tr>";
		$relatorio .= " </table>";
	}
	//$relatorio .= "   <tr>";
	//$relatorio .= "     <th>M&Atilde;O DE OBRA </th>";
	//$relatorio .= "     <th>QTD.TOT.</th>";
	//$relatorio .= "     <th>CST.UN.</th>";
	//$relatorio .= "     <th>CST.PAR.</th>";
	//$relatorio .= "   </tr>";
	foreach($insumoMO as $a=>$tipo){
		$relatorio .= "<BR/><table class='tabela'>";
		$relatorio .= "   <tr>";
		$relatorio .= "     <th width='450' align='left'>".$a."</th>";
		$relatorio .= "     <th width='70'>QTDE</th>";
		$relatorio .= "     <th width='70'>CSTUND (R$)</th>";
		$relatorio .= "     <th width='70'>CSTPAR (R$)</th>";
		$relatorio .= "   </tr>";
		ksort($tipo);
		$subtotal = 0;
		foreach($tipo as $k=>$i){
			$insumo = $i['DESCRICAO'];
			$qtde = $i[QTDE];
			$cstun = number_format((double)$i[PRECO], 2, ',', '.');
			$valor = ($i[QTDE] * (double)$i[PRECO]);
			$total += $valor;
			$subtotal += $valor;
			$vF =  number_format($valor, 2, ',', '.');
			$qtde = explode(".",$qtde);
			if(strlen($qtde[1])>1) {
				$tmp = str_pad($qtde[1], 3, "0", STR_PAD_RIGHT);
				$qtde = $qtde[0].".".$tmp;
			} else $qtde = $qtde[0];
			if($i['DECIMAL']=='S') $qtde = str_pad($qtde, 7, "0", STR_PAD_LEFT);
			$relatorio .= "<tr>";
			$relatorio .= "  <td align='left'> - ".$insumo."</td>";
			$relatorio .= "  <td align='right'>".$qtde."</td>";
			$relatorio .= "  <td align='right'>".$cstun."</td>";
			$relatorio .= "  <td align='right'>".$vF."</td>";
			$relatorio .= "</tr>";
		}
		$subtotal =  number_format($subtotal, 2, ',', '.');
		$relatorio .= "<tr>";
		$relatorio .= "  <th colspan='3' align='right'>SUBTOTAL:</td>";
		$relatorio .= "  <th align='right'>".$subtotal."</td>";
		$relatorio .= "</tr>";
		$relatorio .= " </table>";
	}
	$vT =  number_format($total, 2, ',', '.');
	$vT == '0,00' ? $vT = "---" : $vT = "R$ ".$vT;
	$relatorio .= "<BR/><table class='tabela'>";
	$relatorio .= "  <tr>";
	$relatorio .= "    <td colspan='2' align='right'><strong>CUSTO FABRICA&Ccedil;&Atilde;O:</strong> </td>";
	$relatorio .= "    <td colspan='2' align='center'><strong>".$vT."</strong></td>";
	$relatorio .= "  </tr>";
	*/
	$relatorio .= "</table>";
	$relatorio .= "</body>";
	$relatorio .= "</html>";
	echo $relatorio;

?>