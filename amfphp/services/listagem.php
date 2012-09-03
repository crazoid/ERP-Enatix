<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BONSUCESSO - RELATÓRIO DE CONTAS À PAGAR</title>
<style type="text/css">
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 0.8em;
}
table{
	border-collapse:collapse;
}
table, td, th {
	border:1px solid black;
}
th,td {
	background-color:#F9F9F9;
	color:#000;
	font-weight:bold;
	padding:5px;
	margin:0;
}
th  {
	background-color:#E6E6E6;
}
td {
	font-weight:normal;
}
h3 {
	font-size:14px;
	font-weight:bold;
	margin-bottom:1;
	margin-top:1;
	padding:5px;
	margin:0;
}

</style>
</head>

<!-- <body onload="window.print();"> -->
<body>
<?php
require_once "Conexao.php";
require_once "Funcoes.php";
$nota = explode(",",$_GET['nota']);
$dias = array();
$data_inicial = $_GET['data_inicial']!=""? $_GET['data_inicial'] : "01/01/1950";
$data_final = $_GET['data_final']!=""? $_GET['data_final'] : "01/01/3000";
$filtro = $_GET['filtro']!="" ? $_GET['filtro'] : "nenhum";
$texto = $_GET['texto'];
//$data_final = date("Y-m-d", strtotime("+15 days"));
?>
<table width='790' align='center'>
  <tr>
    <th scope='col'><img src='bonsucesso.jpg' width='502' height='107' /></th>
  </tr>
  <tr>
    <th><h1>RELATÓRIO DE CONTAS A PAGAR</h1></th>
  </tr>
  <tr>
    <th align="center"><h2><strong><?php if($data_inicial!="01/01/1950") echo $data_inicial?> à <?php echo $data_final; ?></strong></h2></th>
  </tr>
</table>
<br />
<?php
	$i = explode("/",$data_inicial);
	$i = $i[2]."-".$i[1]."-".$i[0];
	$f = explode("/",$data_final);
	$f = $f[2]."-".$f[1]."-".$f[0];
	$padrao = "^([0-9][0-9])/([0-9][0-9])/([0-9][0-9][0-9][0-9])$";
	if($texto==""){
		$s = "SELECT n.nota,n.fornecedor,n.localizador,n.grupo,n.historico,n.observacao,f.nome_fantasia as fornecedor_desc,
			l.descricao as localizador_desc,g.descricao as grupo_desc, n.data_nota as data, t.data_vencto as data_vencto, t.parcela, t.valor
			FROM CTS_NOTAS N,CTS_FORNECEDORES F,CTS_LOCALIZADORES L, CTS_GRUPOS G, CTS_NOTA T 
			WHERE n.fornecedor=f.id and n.localizador=l.id and n.grupo=g.id and n.nota=t.nota and t.data_vencto BETWEEN '$i' AND '$f' ORDER BY t.data_vencto ASC";
	} else if(ereg($padrao,$texto)){
		$data = explode("/",$texto);
		$data = $data[2]."-".$data[1]."-".$data[0];
		$s = "SELECT n.nota,n.fornecedor,n.localizador,n.grupo,n.historico,n.observacao,f.nome_fantasia as fornecedor_desc,
			l.descricao as localizador_desc,g.descricao as grupo_desc, n.data_nota as data, t.data_vencto as data_vencto, t.parcela, t.valor
			FROM CTS_NOTAS N,CTS_FORNECEDORES F,CTS_LOCALIZADORES L, CTS_GRUPOS G, CTS_NOTA T 
			WHERE n.fornecedor=f.id and n.localizador=l.id and n.grupo=g.id and n.nota=t.nota and t.data_vencto='$data' ORDER BY t.data_vencto ASC";
		$texto="";
	} else {
		$s = "SELECT n.nota,n.fornecedor,n.localizador,n.grupo,n.historico,n.observacao,f.nome_fantasia as fornecedor_desc,
			l.descricao as localizador_desc,g.descricao as grupo_desc, n.data_nota as data, t.data_vencto as data_vencto, t.parcela, t.valor
			FROM CTS_NOTAS N,CTS_FORNECEDORES F,CTS_LOCALIZADORES L, CTS_GRUPOS G, CTS_NOTA T 
			WHERE n.fornecedor=f.id and n.localizador=l.id and n.grupo=g.id and n.nota=t.nota ORDER BY t.data_vencto ASC";	
	}
	
	$r = fetch_assoc($s);
	foreach($r as $k=>$row){
		if($texto!=""){
			$passou = false;
			if(eregi($texto,$row['NOTA'])) $passou = true;
			if(eregi($texto,$row['RAZAO'])) $passou = true;
			if(eregi($texto,$row['FORNECEDOR_DESC'])) $passou = true;
			if(eregi($texto,$row['LOCALIZADOR_DESC'])) $passou = true;
			if(eregi($texto,$row['GRUPO_DESC'])) $passou = true;
			if($passou){
				$row['DATA_VENCTO'] = explode("-",$row['DATA_VENCTO']);
				$nota = $row['NOTA'];
				$dia = $row['DATA_VENCTO'][2];
				$mes = $row['DATA_VENCTO'][1];
				$ano = $row['DATA_VENCTO'][0];
				$row['DATA_VENCTO']   = $dia."/".$mes."/".$ano;
				$valor = $row['VALOR'];
				$valor = str_replace(',','.',$valor);
				$dias[$ano][$mes][$dia][$nota]['DATA_VENCTO'] = $row['DATA_VENCTO'];
				$dias[$ano][$mes][$dia][$nota]['NF'] = $row['NOTA'];
				$dias[$ano][$mes][$dia][$nota]['PAR'] = $row['PARCELA'];
				$dias[$ano][$mes][$dia][$nota]['FORNECEDOR'] = $row['FORNECEDOR'];
				$dias[$ano][$mes][$dia][$nota]['FORNECEDOR_DESC'] = $row['FORNECEDOR_DESC'];
				$dias[$ano][$mes][$dia][$nota]['LOCALIZADOR'] = $row['LOCALIZADOR'];
				$dias[$ano][$mes][$dia][$nota]['LOCALIZADOR_DESC'] = $row['LOCALIZADOR_DESC'];
				$dias[$ano][$mes][$dia][$nota]['GRUPO'] = $row['GRUPO'];
				$dias[$ano][$mes][$dia][$nota]['GRUPO_DESC'] = $row['GRUPO_DESC'];
				$dias[$ano][$mes][$dia][$nota]['VALOR'] = $valor;
				$dias[$ano][$mes][$dia]['SUBTOTAL'] += $valor;
			} 				
		} else {
				$row['DATA_VENCTO'] = explode("-",$row['DATA_VENCTO']);
				$nota = $row['NOTA'];
				$dia = $row['DATA_VENCTO'][2];
				$mes = $row['DATA_VENCTO'][1];
				$ano = $row['DATA_VENCTO'][0];
				$row['DATA_VENCTO']   = $dia."/".$mes."/".$ano;
				$valor = $row['VALOR'];
				$valor = str_replace(',','.',$valor);
				$dias[$ano][$mes][$dia][$nota]['DATA_VENCTO'] = $row['DATA_VENCTO'];
				$dias[$ano][$mes][$dia][$nota]['NF'] = $row['NOTA'];
				$dias[$ano][$mes][$dia][$nota]['PAR'] = $row['PARCELA'];
				$dias[$ano][$mes][$dia][$nota]['FORNECEDOR'] = $row['FORNECEDOR'];
				$dias[$ano][$mes][$dia][$nota]['FORNECEDOR_DESC'] = $row['FORNECEDOR_DESC'];
				$dias[$ano][$mes][$dia][$nota]['LOCALIZADOR'] = $row['LOCALIZADOR'];
				$dias[$ano][$mes][$dia][$nota]['LOCALIZADOR_DESC'] = $row['LOCALIZADOR_DESC'];
				$dias[$ano][$mes][$dia][$nota]['GRUPO'] = $row['GRUPO'];
				$dias[$ano][$mes][$dia][$nota]['GRUPO_DESC'] = $row['GRUPO_DESC'];
				$dias[$ano][$mes][$dia][$nota]['VALOR'] = $valor;
				$dias[$ano][$mes][$dia]['SUBTOTAL'] += $valor;
			}
		}
		array_reverse($dias);
		foreach($dias as $kano=>$vano){
			foreach($vano as $kmes=>$vmes){
				foreach($vmes as $kdia=>$vdia){
					echo "<table width='790' align='center'>";
					$data[0] = $kmes;
					$data[1] = $kdia;
					$data[2] = $kano;
					$dia = diasemana($data);
					echo "<tr><th colspan='10' scope='col'><h3>".$kdia."/".$kmes."/".$kano." - ".$dia."</h3></th></tr>";
					echo "
					<tr>
						<th width='100' scope='col'>VENCIMENTO</th>
						<th width='100' scope='col' colspan='2'>PAR / NF</th>
						<th scope='col' colspan='2'>FORNECEDOR</th>
						<th scope='col' colspan='2'>LOCALIZADOR</th>
						<th scope='col' colspan='2'>GRUPO</th>
						<th width='60' scope='col'>VALOR</th>
					</tr>";
					foreach($vdia as $knota=>$vnota){
						if($vnota['DATA_VENCTO']!=""){
							echo "<tr>
									<td align='center'>".$vnota['DATA_VENCTO']."</td>
									<td align='right'>".$vnota['PAR']."</td>
									<td align='left'>".$vnota['NF']."</td>
									<td align='right'>".$vnota['FORNECEDOR']."</td>
									<td align='left'>".substr($vnota['FORNECEDOR_DESC'],0,20)."</td>
									<td align='right'>".$vnota['LOCALIZADOR']."</td>
									<td align='left'>".substr($vnota['LOCALIZADOR_DESC'],0,10)."</td>
									<td align='right'>".$vnota['GRUPO']."</td>
									<td align='left'>".substr($vnota['GRUPO_DESC'],0,21)."</td>
									<td align='right'><strong>".number_format($vnota['VALOR'],2,',','.')."</strong></td>
								  </tr>";
						}
					}
					$total += $vdia['SUBTOTAL'];
					echo "<tr>
							<th colspan='8' align='right'><h3>SUBTOTAL</h3></th>
							<th colspan='2' align='center'><h3>".number_format($vdia['SUBTOTAL'],2,',','.')."</h3></th>
						 </tr>";
					echo "</table><BR/>";
				}
			}
		}
	echo "<table width='790' align='center'>
			<tr>
				<th align='center'><h2>TOTAL</h2></th>
				<th align='center'><h2>".number_format($total,2,',','.')."</h2></th>
			</tr>
		</table>";
?>
</table>
</body>
</html>