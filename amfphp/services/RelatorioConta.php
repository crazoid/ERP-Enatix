<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<title>Untitled Document</title>
<style type='text/css'>
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 1.3em;
}
</style>
</head>

<body onload="window.print();">

<table width='100%' border='0' cellspacing='10' cellpadding='20'>

<?php
if($_GET['nota']!=""){
	require_once "Conexao_Contas.php";
	$con = new Conexao_Contas();
	$c = $con->getConexao();
	$nota = explode(",",$_GET['nota']);
	foreach($nota as $key=>$valor){
		$sql = "SELECT FIRST 1 n.nota,n.fornecedor,n.localizador,n.grupo,n.historico,n.observacao,f.nome_fantasia as fornecedor_desc,
			l.descricao as localizador_desc,g.descricao as grupo_desc, n.data_criacao as data, t.data_vencto as data_vencto, t.parcela, t.valor
			FROM CTS_NOTAS N,CTS_FORNECEDORES F,CTS_LOCALIZADORES L, CTS_GRUPOS G, CTS_NOTA T 
			WHERE n.fornecedor=f.id and n.localizador=l.id and n.grupo=g.id and n.nota=t.nota and n.nota='$valor' ORDER BY t.data_vencto DESC";
		$query = ibase_query($c, $sql);
		$row= ibase_fetch_assoc($query);
		$row['DATA_VENCTO'] = explode("-",$row['DATA_VENCTO']);
		$row['DATA_VENCTO'] = $row['DATA_VENCTO'][2]."/".$row['DATA_VENCTO'][1]."/".$row['DATA_VENCTO'][0];
		$vencto           = $row['DATA_VENCTO'];
		$nf               = $row['NOTA'];
		$parc             = $row['PARCELA'];
		$fornecedor       = $row['FORNECEDOR'];
		$fornecedor_desc  = $row['FORNECEDOR_DESC'];
		$valor            = $row['VALOR'];
		$localizador_desc = $row['LOCALIZADOR_DESC'];
		
		echo "  <tr>
		<td colspan='2' align='center'><strong>".$vencto."</strong></td>
	  </tr>
	  <tr>
		<td><strong>N.F:</strong> ".$nf."</td>
		<td><strong>PARC:</strong> ".$parc."</td>
	  </tr>
	  <tr>
		<td colspan='2'><p>".$fornecedor." - ".$fornecedor_desc."</p></td>
	  </tr>
	  <tr>
		<td colspan='2'><strong>R$:</strong> ".$valor."</td>
	  </tr>
	  <tr>
		<td colspan='2' align='center'>".$localizador_desc."</td>
	  </tr>";
	}
}
?>
</table>
</body>
</html>