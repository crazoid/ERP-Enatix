<?php

	require_once "Funcoes.php";
	require_once "Conexao.php";
	
	header('MIME-Version: 1.0');
	header('Content-Type: text/html; charset=iso-8859-1');

	$lote = $_GET['lote'];

	$relatorio = "<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN'";
	$relatorio .= "'http://www.w3.org/TR/html4/loose.dtd'>";
	$relatorio .= "<html>";
	$relatorio .= "<head>";
	$relatorio .= "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>";
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
    $relatorio .= "	width: 960px;";
    $relatorio .= "	text-align: center;";
    $relatorio .= "}";
    $relatorio .= "table.tabela th {";
    $relatorio .= "	border-width: 1px;";
    $relatorio .= "	padding: 2px;";
    $relatorio .= "	border-style: solid;";
    $relatorio .= "	border-color: gray;";
    $relatorio .= "	background-color: white;";
    $relatorio .= "	-moz-border-radius: ;";
    $relatorio .= "	width: 100%;";
    $relatorio .= "}";
    $relatorio .= "table.tabela td {";
    $relatorio .= "	border-width: 1px;";
    $relatorio .= "	padding: 2px;";
    $relatorio .= "	border-style: solid;";
    $relatorio .= "	border-color: gray;";
    $relatorio .= "	background-color: white;";
    $relatorio .= "	width: 100%;";
    $relatorio .= "	-moz-border-radius: ;";
    $relatorio .= "}";
    $relatorio .= "</style>";
	$relatorio .= "<title>BONSUCESSO - PLANILHA DE CORTE</title>";
	$relatorio .= "</head>";
	
	$relatorio .= "<body>";
	$relatorio .= "<table class='tabela'>";
	$relatorio .= "  <tr>";
	$relatorio .= "    <th colspan='2' scope='col'><img src='http://10.1.1.5/amfphp/services/bonsucesso.jpg' width='502' height='107'></th>";
//	$relatorio .= "    <th colspan='2' scope='col'>.</th>";
	$relatorio .= "  </tr>";
	$relatorio .= "  <tr>";
	$relatorio .= "    <th colspan='2'><h2>PLANILHA DE CORTE</h2></th>";
	$relatorio .= "  </tr>";
	$relatorio .= "  <tr>";
	$r = fetch_assoc_simples("SELECT DESCRICAO FROM AGA_LOTES WHERE ID='$lote'");
	$relatorio .= "    <td align='left'><strong>LOTE:</strong> ".$lote." - ".utf8_decode($r[DESCRICAO])."</td>";
	$relatorio .= "    <td align='right'><strong>DATA:</strong> ".date("d/m/Y")."</td>";
	$relatorio .= "  </tr>";
	$relatorio .= "</table>";
 	$r = fetch_assoc("SELECT * from AGA_MARCACAO WHERE LOTE='$lote'");
 	foreach($r as $k=>$l){ //lote
		$escola = $l[ESCOLA];
		if($escola!=""){
	 		$r2 = fetch_assoc_simples("SELECT DESCRICAO FROM AGA_INSTITUICOES WHERE ID='$escola'");
			$escola_descricao = utf8_decode($r2[DESCRICAO]);
			$artigo = $l[ARTIGO];
	 		$r3 = fetch_assoc_simples("SELECT DESCRICAO FROM AGA_ARTIGOS WHERE ID='$artigo'");
			$artigo_descricao = utf8_decode($r3[DESCRICAO]);
			$sDois=$sQuatro=$sSeis=$sOito=$sDez=$sDoze=$sQuatorze=$sDezesseis=$sP=$sM=$sG=$sXG=0;
			$tamanhos = array('02c'=>0,'02q'=>0,'04c'=>0,'04q'=>0,'06c'=>0,'06q'=>0,'08c'=>0,'08q'=>0,'10c'=>0,'10q'=>0,'12c'=>0,'12q'=>0,'14c'=>0,'14q'=>0,'16c'=>0,'16q'=>0,'Pc'=>0,'Pq'=>0,'Mc'=>0,'Mq'=>0,'Gc'=>0,'Gq'=>0,'XGc'=>0,'XGq'=>0);
			$relatorio .="<BR/>-----------------------------------------------------------------------------------------------------------------------------------------";
			$relatorio .= "<br/><br/><table class='tabela'>";
			$relatorio .="  <tr>";
			$relatorio .="    <th colspan='13'><h3>".$artigo_descricao." ".$escola_descricao."</h3></th>";
			$relatorio .="  </tr>";

		$r4 = fetch_assoc("SELECT P.ID, P.ESCOLA, P.ARTIGO, P.INSUMO, P.TAMANHO, P.QTDE, I.ID AS ID_INSUMO, I.DESCRICAO AS INSUMO_DESCRICAO, I.DECI AS DECI, I.PRECO AS INSUMO_PRECO, I.TIPO FROM AGA_PRODUTOS P, AGA_INSUMOS I WHERE P.ESCOLA = '$escola' AND P.ARTIGO = '$artigo' AND P.INSUMO=I.ID ORDER BY P.ID ASC");
		foreach($r4 as $k4=>$row){
			$row[QTDE] = str_replace(",", ".", $row[QTDE]);
			if($row[TIPO]<3){
				$row[TAMANHO] = str_replace(" ","",$row[TAMANHO]);
				$objeto = $row[ID_INSUMO];
				$insumos[$objeto][ID] = $row[ID];
				$insumos[$objeto][DESCRICAO] = $row[INSUMO_DESCRICAO];
				$insumos[$objeto][DECIMAL] = $row[DECI];
				$insumos[$objeto][CSTUN] = $row[INSUMO_PRECO];
				$insumos[$objeto][ESCOLA] = $row[ESCOLA];
				$insumos[$objeto][$row[TAMANHO]]['c'] = $row[INSUMO_PRECO];
				$insumos[$objeto][$row[TAMANHO]]['q'] = $row[QTDE];
			}
			else {
				$row[TAMANHO] = str_replace(" ","",$row[TAMANHO]);
				$objeto = $row[ID_INSUMO];
				$insumosMO[$objeto][ID] = $row[ID];
				$insumosMO[$objeto][DESCRICAO] = $row[INSUMO_DESCRICAO];
				$insumosMO[$objeto][DECIMAL] = $row[DECI];
				$insumosMO[$objeto][CSTUN] = $row[INSUMO_PRECO];
				$insumosMO[$objeto][ESCOLA] = $row[ESCOLA];
				$insumosMO[$objeto][$row[TAMANHO]]['c'] = $row[INSUMO_PRECO];
				$insumosMO[$objeto][$row[TAMANHO]]['q'] = $row[QTDE];
			}
		}
		$linha = array();
		$linhaMO = array();
		foreach($insumos as $idInsumo){
			$linha[$idInsumo[DESCRICAO]]['descricao'] = $idInsumo[DESCRICAO];
			$linha[$idInsumo[DESCRICAO]]['decimal']   = $idInsumo[DECIMAL];
			$linha[$idInsumo[DESCRICAO]]['dois']      += ((double)$idInsumo['02']['q'] * (double)$l[DOIS]);
			$linha[$idInsumo[DESCRICAO]]['quatro']    += ((double)$idInsumo['04']['q'] * (double)$l[QUATRO]);
			$linha[$idInsumo[DESCRICAO]]['seis']      += ((double)$idInsumo['06']['q'] * (double)$l[SEIS]);
			$linha[$idInsumo[DESCRICAO]]['oito']      += ((double)$idInsumo['08']['q'] * (double)$l[OITO]);
			$linha[$idInsumo[DESCRICAO]]['dez']       += ((double)$idInsumo['10']['q'] * (double)$l[DEZ]);
			$linha[$idInsumo[DESCRICAO]]['doze']      += ((double)$idInsumo['12']['q'] * (double)$l[DOZE]);
			$linha[$idInsumo[DESCRICAO]]['quatorze']  += ((double)$idInsumo['14']['q'] * (double)$l[QUATORZE]);
			$linha[$idInsumo[DESCRICAO]]['dezesseis'] += ((double)$idInsumo['16']['q'] * (double)$l[DEZESSEIS]);
			$linha[$idInsumo[DESCRICAO]]['p']         += ((double)$idInsumo['P']['q'] * (double)$l[P]);
			$linha[$idInsumo[DESCRICAO]]['m']         += ((double)$idInsumo['M']['q'] * (double)$l[M]);
			$linha[$idInsumo[DESCRICAO]]['g']         += ((double)$idInsumo['G']['q'] * (double)$l[G]);
			$linha[$idInsumo[DESCRICAO]]['xg']        += ((double)$idInsumo['XG']['q'] * (double)$l[XG]);			
		}
		foreach($insumosMO as $idInsumoMO){
			$linhaMO[$idInsumoMO[DESCRICAO]]['descricao'] = $idInsumoMO[DESCRICAO];
			$linhaMO[$idInsumoMO[DESCRICAO]]['decimal']   = $idInsumoMO[DECIMAL];
			$linhaMO[$idInsumoMO[DESCRICAO]]['dois']      += ((double)$idInsumoMO['02']['q'] * (double)$l[DOIS]);
			$linhaMO[$idInsumoMO[DESCRICAO]]['quatro']    += ((double)$idInsumoMO['04']['q'] * (double)$l[QUATRO]);
			$linhaMO[$idInsumoMO[DESCRICAO]]['seis']      += ((double)$idInsumoMO['06']['q'] * (double)$l[SEIS]);
			$linhaMO[$idInsumoMO[DESCRICAO]]['oito']      += ((double)$idInsumoMO['08']['q'] * (double)$l[OITO]);
			$linhaMO[$idInsumoMO[DESCRICAO]]['dez']       += ((double)$idInsumoMO['10']['q'] * (double)$l[DEZ]);
			$linhaMO[$idInsumoMO[DESCRICAO]]['doze']      += ((double)$idInsumoMO['12']['q'] * (double)$l[DOZE]);
			$linhaMO[$idInsumoMO[DESCRICAO]]['quatorze']  += ((double)$idInsumoMO['14']['q'] * (double)$l[QUATORZE]);
			$linhaMO[$idInsumoMO[DESCRICAO]]['dezesseis'] += ((double)$idInsumoMO['16']['q'] * (double)$l[DEZESSEIS]);
			$linhaMO[$idInsumoMO[DESCRICAO]]['p']         += ((double)$idInsumoMO['P']['q'] * (double)$l[P]);
			$linhaMO[$idInsumoMO[DESCRICAO]]['m']         += ((double)$idInsumoMO['M']['q'] * (double)$l[M]);
			$linhaMO[$idInsumoMO[DESCRICAO]]['g']         += ((double)$idInsumoMO['G']['q'] * (double)$l[G]);
			$linhaMO[$idInsumoMO[DESCRICAO]]['xg']        += ((double)$idInsumoMO['XG']['q'] * (double)$l[XG]);			
		}
		$relatorio .="  <tr>";
		$relatorio .="    <th>&nbsp;</th>";
		$relatorio .="    <th>02</th>";
		$relatorio .="    <th>04</th>";
		$relatorio .="    <th>06</th>";
		$relatorio .="    <th>08</th>";
		$relatorio .="    <th>10</th>";
		$relatorio .="    <th>12</th>";
		$relatorio .="    <th>14</th>";
		$relatorio .="    <th>16</th>";
		$relatorio .="    <th>P</th>";
		$relatorio .="    <th>M</th>";
		$relatorio .="    <th>G</th>";
		$relatorio .="    <th>XG</th>";
		$relatorio .="  </tr>";
		$relatorio .="  <tr>";
		$relatorio .="    <th>INSUMO</th>";
		$relatorio .="    <th colspan='12'><strong>QUANTIDADES</strong></th>";
		$relatorio .="  </tr>";
		$relatorio .="  <tr>";
		$relatorio .="    <td>&nbsp;</td>";
		$relatorio .="    <td>".$l[DOIS]."</td>";
		$relatorio .="    <td>".$l[QUATRO]."</td>";
		$relatorio .="    <td>".$l[SEIS]."</td>";
		$relatorio .="    <td>".$l[OITO]."</td>";
		$relatorio .="    <td>".$l[DEZ]."</td>";
		$relatorio .="    <td>".$l[DOZE]."</td>";
		$relatorio .="    <td>".$l[QUATORZE]."</td>";
		$relatorio .="    <td>".$l[DEZESSEIS]."</td>";
		$relatorio .="    <td>".$l[P]."</td>";
		$relatorio .="    <td>".$l[M]."</td>";
		$relatorio .="    <td>".$l[G]."</td>";
		$relatorio .="    <td>".$l[XG]."</td>";
		$relatorio .="  </tr>";
		$relatorio .="<tr><td colspan='13' align='left'><strong>MAT&Eacute;RIA PRIMA</strong></td></tr>";

		ksort($linha);
		ksort($linhaMO);

		foreach($linha as $insumo){
			if($insumo['dois']+$insumo['quatro']+$insumo['seis']+$insumo['oito']+$insumo['dez']+$insumo['doze']+$insumo['quatorze']+$insumo['dezesseis']+$insumo['p']+$insumo['m']+$insumo['g']+$insumo['xg']>0){
				$insumo['dois']      = $insumo['decimal']=='S'? formata($insumo['dois'])      : formataInt($insumo['dois']);
				$insumo['quatro']    = $insumo['decimal']=='S'? formata($insumo['quatro'])    : formataInt($insumo['quatro']);
				$insumo['seis']      = $insumo['decimal']=='S'? formata($insumo['seis'])      : formataInt($insumo['seis']);
				$insumo['oito']      = $insumo['decimal']=='S'? formata($insumo['oito'])      : formataInt($insumo['oito']);
				$insumo['dez']       = $insumo['decimal']=='S'? formata($insumo['dez'])       : formataInt($insumo['dez']);
				$insumo['doze']      = $insumo['decimal']=='S'? formata($insumo['doze'])      : formataInt($insumo['doze']);
				$insumo['quatorze']  = $insumo['decimal']=='S'? formata($insumo['quatorze'])  : formataInt($insumo['quatorze']);
				$insumo['dezesseis'] = $insumo['decimal']=='S'? formata($insumo['dezesseis']) : formataInt($insumo['dezesseis']);
				$insumo['p']         = $insumo['decimal']=='S'? formata($insumo['p'])         : formataInt($insumo['p']);
				$insumo['m']         = $insumo['decimal']=='S'? formata($insumo['m'])         : formataInt($insumo['m']);
				$insumo['g']         = $insumo['decimal']=='S'? formata($insumo['g'])         : formataInt($insumo['g']);
				$insumo['xg']        = $insumo['decimal']=='S'? formata($insumo['xg'])        : formataInt($insumo['xg']);
				
				$relatorio .="  <tr>";
				$relatorio .="    <td align='left'>".$insumo['descricao']."</td>";
				$relatorio .="    <td>".$insumo['dois']."</td>";
				$relatorio .="    <td>".$insumo['quatro']."</td>";
				$relatorio .="    <td>".$insumo['seis']."</td>";
				$relatorio .="    <td>".$insumo['oito']."</td>";
				$relatorio .="    <td>".$insumo['dez']."</td>";
				$relatorio .="    <td>".$insumo['doze']."</td>";
				$relatorio .="    <td>".$insumo['quatorze']."</td>";
				$relatorio .="    <td>".$insumo['dezesseis']."</td>";
				$relatorio .="    <td>".$insumo['p']."</td>";
				$relatorio .="    <td>".$insumo['m']."</td>";
				$relatorio .="    <td>".$insumo['g']."</td>";
				$relatorio .="    <td>".$insumo['xg']."</td>";
				$relatorio .="  </tr>";
			}
		}
		$relatorio .="<tr><td colspan='13' align='left'><strong>M&Atilde;O DE OBRA</strong></td></tr>";
		foreach($linhaMO as $insumoMO){
			if($insumoMO['dois']+$insumoMO['quatro']+$insumoMO['seis']+$insumoMO['oito']+$insumoMO['dez']+$insumoMO['doze']+$insumoMO['quatorze']+$insumoMO['dezesseis']+$insumoMO['p']+$insumoMO['m']+$insumoMO['g']+$insumoMO['xg']>0){
				$relatorio .="  <tr>";
				$relatorio .="    <td align='left'>".$insumoMO['descricao']."</td>";
				$relatorio .="    <td>".formataInt($insumoMO['dois'])."</td>";
				$relatorio .="    <td>".formataInt($insumoMO['quatro'])."</td>";
				$relatorio .="    <td>".formataInt($insumoMO['seis'])."</td>";
				$relatorio .="    <td>".formataInt($insumoMO['oito'])."</td>";
				$relatorio .="    <td>".formataInt($insumoMO['dez'])."</td>";
				$relatorio .="    <td>".formataInt($insumoMO['doze'])."</td>";
				$relatorio .="    <td>".formataInt($insumoMO['quatorze'])."</td>";
				$relatorio .="    <td>".formataInt($insumoMO['dezesseis'])."</td>";
				$relatorio .="    <td>".formataInt($insumoMO['p'])."</td>";
				$relatorio .="    <td>".formataInt($insumoMO['m'])."</td>";
				$relatorio .="    <td>".formataInt($insumoMO['g'])."</td>";
				$relatorio .="    <td>".formataInt($insumoMO['xg'])."</td>";
				$relatorio .="  </tr>";
			}
		}
		$relatorio .="</table>";
	}
}		
	$relatorio .="</body>";
	$relatorio .="</html>";
	echo $relatorio;
?>