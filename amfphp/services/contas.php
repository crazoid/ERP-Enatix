<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<title>BONSUCESSO - RELATÓRIO DE CONTAS À PAGAR</title>
<style type='text/css'>
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 1.3em;
}
</style>
</head>

<body onload="window.print();">

<table width='100%' border='0' cellspacing='0' cellpadding='20'>

<?php
if($_GET['nota']!=""){
	require_once "Conexao.php";
	require_once "Funcoes.php";
	$nota = explode(",",$_GET['nota']);
	foreach($nota as $key=>$valor){
		$tmp = explode(";",$valor);
		$nota = $tmp[0];
		$data = $tmp[1];
		$data = explode("/",$data);
		$data = $data[2]."-".$data[1]."-".$data[0];
		$fornecedor = $tmp[2];
		$s = "SELECT FIRST 1 
				n.nota,
				n.fornecedor,
				n.localizador,
				n.grupo,
				n.historico,
				n.observacao,
				f.nome_fantasia as fornecedor_desc,
				l.descricao as localizador_desc,
				g.descricao as grupo_desc,
				n.data_nota as data,
				t.data_vencto as data_vencto,
				t.parcela,
				t.valor
			FROM CTS_NOTAS N,
				 CTS_FORNECEDORES F,
				 CTS_LOCALIZADORES L,
				 CTS_GRUPOS G,
				 CTS_NOTA T 
			WHERE n.fornecedor=f.id and 
				  n.localizador=l.id and 
				  n.grupo=g.id and 
				  n.nota=t.nota and 
				  n.nota='$nota' and 
				  t.data_vencto='$data' and
				  n.fornecedor='$fornecedor'
			ORDER BY t.data_vencto DESC";
		$row = fetch_assoc_simples($s);
		$row['DATA_VENCTO'] = explode("-",$row['DATA_VENCTO']);
		$d[0] = $row['DATA_VENCTO'][1];
		$d[1] = $row['DATA_VENCTO'][2];
		$d[2] = $row['DATA_VENCTO'][0];
		$dia = diasemana($d);
		$row['DATA_VENCTO'] = $row['DATA_VENCTO'][2]."/".$row['DATA_VENCTO'][1]."/".$row['DATA_VENCTO'][0];
		$vencto           = $row['DATA_VENCTO']." - ".$dia;
		$nf               = $row['NOTA'];
		$parc             = $row['PARCELA'];
		$fornecedor       = $row['FORNECEDOR'];
		$fornecedor_desc  = $row['FORNECEDOR_DESC'];
		$valor            = $row['VALOR'];
		$localizador_desc = $row['LOCALIZADOR_DESC'];
		$historico = $row['HISTORICO'] != "" ? $row['HISTORICO'] : "";
		$observacao = $row['OBSERVACAO'] != "" ? $row['OBSERVACAO'] : "";
		
		$html = "  <tr>
		<td colspan='2' align='center'><strong>".$vencto."</strong></td>
	  </tr>
	  <tr>
		<td><strong>N.F:</strong> ".$nf."</td>
		<td><strong>PARC:</strong> ".$parc."</td>
	  </tr>";
		if(($historico!="") && ($observacao!="")) $html.="<tr height='180'><td colspan='2'>".$fornecedor." - ".$fornecedor_desc."<BR/>".$historico."<BR/>".$observacao."</td></tr>";
		if(($historico!="") && ($observacao=="")) $html.="<tr height='180'><td colspan='2'>".$fornecedor." - ".$fornecedor_desc."<BR/>".$historico."</td></tr>";
		if(($historico=="") && ($observacao=="")) $html.="<tr height='180'><td colspan='2'>".$fornecedor." - ".$fornecedor_desc."</td></tr>";
		if(($historico=="") && ($observacao!="")) $html.="<tr height='180'><td colspan='2'>".$fornecedor." - ".$fornecedor_desc."<BR/>".$observacao."</td></tr>";
		$html.="
	  <tr>
		<td colspan='2'><strong>R$:</strong> ".$valor."</td>
	  </tr>
	  <tr>
		<td colspan='2' align='center'>".$localizador_desc."</td>
	  </tr>";
	  echo $html;
	}
}
?>
</table>
</body>
</html>