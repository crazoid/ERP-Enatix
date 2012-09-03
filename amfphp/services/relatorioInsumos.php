<?php

	require_once "Conexao.php";
	
	header('MIME-Version: 1.0');
	header('Content-Type: text/html; charset=iso-8859-1');
	
	$lote = $_GET['lote'];
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
	//$relatorio .= "    <th colspan='2' scope='col'>.</th>";
	$relatorio .= "   </tr>";
	$relatorio .= "   <tr>";
	$relatorio .= "     <th colspan='2'>RELAT&Oacute;RIO DE CUSTO DE PRODU&Ccedil;&Atilde;O </th>";
	$relatorio .= "   </tr>";
	$relatorio .= "   <tr>";
	//$relatorio .= "     <td width='500' align='left'><strong>LOTE:</strong> ".$l[ID]." - ".$l[DESCRICAO]."</td>";
		$relatorio .= "     <td width='500' align='left'><strong>LOTE:</strong> ".$l[DESCRICAO]."</td>";
	$relatorio .= "     <td width='500' align='right'><strong>DATA:</strong> ".date('d/m/Y')."</td>";
	$relatorio .= "   </tr>";
	$relatorio .= " </table>";
	$relatorio .= " <br>";
	$relatorio .= " <table>";
	$r = fetch_assoc("SELECT * from AGA_MARCACAO WHERE LOTE='$lote'");
	$insumoMP = array();
	$insumoMO = array();
	foreach($r as $k=>$l){
		$escola = $l[ESCOLA];
		$artigo = $l[ARTIGO];
		$tamanhos = array("02"=>$l[DOIS],"04"=>$l[QUATRO],"06"=>$l[SEIS],"08"=>$l[OITO],"10"=>$l[DEZ],"12"=>$l[DOZE],"14"=>$l[QUATORZE],"16"=>$l[DEZESSEIS],"P"=>$l[P],"M"=>$l[M],"G"=>$l[G],"XG"=>$l[XG]);
		foreach($tamanhos as $key=>$qtde){
			if($qtde!=0){
				$r2 = fetch_assoc("SELECT P.ID AS PRODUTO, 
								          P.ESCOLA, 
										  P.ARTIGO, 
										  P.INSUMO AS PINSUMO, 
										  P.TAMANHO, 
										  P.QTDE, 
										  I.ID AS INSUMO, 
										  I.DESCRICAO, 
										  I.TIPO, 
										  I.DATA,
										  I.DECI,
										  IT.DESCRICAO AS TIPO_DESC,
										  I.PRECO, 
										  I.PRAZO 
									FROM AGA_PRODUTOS P, 
									     AGA_INSUMOS I,
										 AGA_INSUMOS_TIPOS IT
									WHERE P.ESCOLA='$escola' AND 
										  P.ARTIGO='$artigo' AND 
										  P.TAMANHO='$key' AND 
										  I.TIPO=IT.ID AND 
										  P.INSUMO=I.ID");
				foreach($r2 as $k2=>$i){
					$i[QTDE] = str_replace(",", ".", $i[QTDE]);
					if($i[TIPO]<3){
						$mostra = false;
						foreach($tp as $s=>$t){
							if($t==$i[TIPO]) $mostra=true;
						}
						if($mostra){
							$insumoMP[$i[TIPO_DESC]][$i[DESCRICAO]]['ID'] = $i[INSUMO];
							$insumoMP[$i[TIPO_DESC]][$i[DESCRICAO]]['DESCRICAO'] = $i[DESCRICAO];
							$insumoMP[$i[TIPO_DESC]][$i[DESCRICAO]]['PRECO'] = $i[PRECO];
							$insumoMP[$i[TIPO_DESC]][$i[DESCRICAO]]['TIPO'] = $i[TIPO];
							$insumoMP[$i[TIPO_DESC]][$i[DESCRICAO]]['DECIMAL'] = $i[DECI];
							(double)$insumoMP[$i[TIPO_DESC]][$i[DESCRICAO]]['QTDE'] += (double)$i[QTDE] * $qtde;
						}
					} else {
						$mostra=false;
						foreach($tp as $s=>$t){
							if($t==$i[TIPO]) $mostra=true;
						}
						if($mostra){
							$insumoMO[$i[TIPO_DESC]][$i[DESCRICAO]]['ID'] = $i[INSUMO];
							$insumoMO[$i[TIPO_DESC]][$i[DESCRICAO]]['DESCRICAO'] = $i[DESCRICAO];
							$insumoMO[$i[TIPO_DESC]][$i[DESCRICAO]]['PRECO'] = $i[PRECO];
							$insumoMO[$i[TIPO_DESC]][$i[DESCRICAO]]['TIPO'] = $i[TIPO];
							$insumoMO[$i[TIPO_DESC]][$i[DESCRICAO]]['QTDE'] += $qtde;
							$insumoMO[$i[TIPO_DESC]][$i[DESCRICAO]]['DECIMAL'] = $i[DECI];
							(double)$insumoMO[$i[TIPO_DESC]][$i[DESCRICAO]]['QTDE'] += (double)$i[QTDE] * $qtde;
						}
					}
				}
			}
		}
	}
	//$relatorio .= " <table class='tabela'>";
	//$relatorio .= "   <tr>";
	//$relatorio .= "     <th width='450'>MAT&Eacute;RIA PRIMA</th>";
	//$relatorio .= "     <th width='70'>QTD.TOT.</th>";
	//$relatorio .= "     <th width='70'>CST.UN.</th>";
	//$relatorio .= "     <th width='70'>CST.PAR.</th>";
	//$relatorio .= "   </tr>";
	ksort($insumoMP);
	ksort($insumoMO);
	
	foreach($insumoMP as $a=>$tipo){
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
			$insumon = $i['ID'];
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
			$relatorio .= "  <td align='left'> - <a href='relatorioInsumosEscolas.php?lote=".$lote."&insumo=".$insumon."' target='_blank'>".$insumo."</a></td>";
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
			$insumon = $i['ID'];
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
			$relatorio .= "  <td align='left'> - <a href='relatorioInsumosEscolas.php?lote=".$lote."&insumo=".$insumon."' target='_blank'>".$insumo."</a></td>";
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
	$relatorio .= "</table>";
	$relatorio .= "</body>";
	$relatorio .= "</html>";
	echo $relatorio;

?>