<?php

require_once "ConexaoCRD.php";
$s = "SELECT CC.COD_CLIENTE, CC.NOME, CC.FONE1, CC.FONE2, CC.ENDERECO, CV.FATURA, CVP.NUM_PARCELA, CV.DT_COMPRA, CVP.DT_PAGTO-CVP.DT_VENCTO AS ATRASO FROM CRD_CLIENTES CC, CRD_VENDAS CV, CRD_VENDAS_PARCELAS CVP WHERE CC.COD_CLIENTE=CV.COD_CLIENTE AND CC.COD_CLIENTE=CV.COD_CLIENTE AND CV.COD_VENDA=CVP.COD_VENDA AND CVP.DT_PAGTO-CVP.DT_VENCTO<=15 AND CV.DT_COMPRA<='2011-07-01' AND CV.DT_COMPRA BETWEEN '2010-02-01' AND '2011-07-01' ORDER BY CC.COD_CLIENTE ASC";
$r = fetch_assoc($s);
$re = array();
foreach($r as $k=>$f){
	if($f['COD_CLIENTE'] == $re['COD_CLIENTE']){
		if($re[$f['COD_CLIENTE']]['DT_COMPRA']<$f['DT_COMPRA']) $re[$f['COD_CLIENTE']] = $f;
	} else {
		$re[$f['COD_CLIENTE']] = $f;
	}
}

$arquivo = fopen("arquivo.txt", "w");

foreach($re as $k=>$f){
	$s = "SELECT COUNT(*) FROM CRD_VENDAS WHERE DT_COMPRA BETWEEN '2011-07-01' AND '2012-07-04' AND COD_CLIENTE='".$f['COD_CLIENTE']."'";
	$r = fetch_assoc_simples($s);
	$d = explode("-",$f['DT_COMPRA']);
	$data = $d[2]."/".$d[1]."/".$d[0];
	if($r['COUNT']==0) fwrite($arquivo,$f['COD_CLIENTE']." $ ".$f['NOME']." $ ".$f['FONE1']." $ ".$f['FONE2']." $ ".$f['ENDERECO']." $ ".$f['FATURA']."/".$f['NUM_PARCELA']." $ ".$data." $ ".$f['ATRASO']."\r\n");
}
fclose($arquivo);
?>