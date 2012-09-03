<?php
$periodo     = "2012070120120731";
$mesAno      = "072012";
$dataInicial = "20120702";
$dataFinal   = "20120731";
$entrada     = "julho-2012.csv";
$saida       = "julho-2012.txt";

$data = array();
$reinicio = array();
$reducoes = array();
$contCanc = array();
$codPri = array();
$codUlt = array();
$vb = array();
$canc = array();
$desc = array();
$vl = array();
$gti = array();
$gtf = array();

if(($csv = fopen($entrada, "r")) !== FALSE) {
	while(($dados = fgetcsv($csv, 0, ";")) !== FALSE){
	  $data[$dados[0]] = $dados[0];
	  $reinicio[$dados[0]] = $dados[1];
      $reducoes[$dados[0]] = $dados[2];
	  $contCanc[$dados[0]] = $dados[3];
	  $codPri[$dados[0]] = $dados[4];
	  $codUlt[$dados[0]] = $dados[5];
	  $vb[$dados[0]] = $dados[6];
	  $canc[$dados[0]] = $dados[7];
	  $desc[$dados[0]] = $dados[8];
	  $vl[$dados[0]] = $dados[9];
	  $gti[$dados[0]] = $dados[10];
	  $gtf[$dados[0]] = $dados[11];
	}
	fclose($csv);
}

$saida = fopen($saida, "w");

// 10 E 11
$t =  "10774984420001342010302423    COMERCIAL DE TECIDOS PAULUK LTDA   PONTA GROSSA                  PR4232276650".$periodo."331\r\n";
$t .= "11RUA DOM PEDRO II                  00337                                     84053000FLAVIO ANTONIO PAULUK       423227665000\r\n";

// 60M, 60A, 60R
$j = 1;
$c60 = 0;
foreach($data as $i){
	$bruto = str_pad($vb[$i], 16, "0", STR_PAD_LEFT);
	$total = str_pad($gtf[$i], 16, "0", STR_PAD_LEFT);
	$branco = "";
	$branco = str_pad($branco, 37, " ", STR_PAD_LEFT);
	$t .= "60M".$data[$i]."000000047980610030260022D0".$codPri[$i]."0".$codUlt[$i]."00".$reducoes[$i]."004".$bruto.$total.$branco."\r\n";
	$c60++;
	if($desc[$i]!=""){ 
		$a = str_pad($desc[$i], 12, "0", STR_PAD_LEFT);
		$branco = "";
		$branco = str_pad($branco, 79, " ", STR_PAD_LEFT);
		$t .= "60A".$data[$i]."00000004798061003026DESC".$a.$branco."\r\n";
		$c60++;
	}
	if($vl[$i]!=""){
		$b = str_pad($vl[$i], 12, "0", STR_PAD_LEFT);
		$branco = "";
		$branco = str_pad($branco, 79, " ", STR_PAD_LEFT);
		$t .= "60A".$data[$i]."00000004798061003026I   ".$b.$branco."\r\n";
		$c60++;
	}
	if($canc[$i]!=""){
		$c = str_pad($canc[$i], 12, "0", STR_PAD_LEFT);
		$branco = "";
		$branco = str_pad($branco, 79, " ", STR_PAD_LEFT);
		$t .= "60A".$data[$i]."00000004798061003026CANC".$c.$branco."\r\n";
		$c60++;
	}
	$produto = str_pad($j, 14, "0", STR_PAD_LEFT);
	$liquido = str_pad($vl[$i], 16, "0", STR_PAD_LEFT);
	$branco = "";
	$branco = str_pad($branco, 54, " ", STR_PAD_LEFT);
	$t .= "60R".$mesAno.$produto."0000000000100".$liquido."0000000000000000I   ".$branco."\r\n";
	$c60++;
	$j++;
}

// 60R


// 75
$j = 1;
$c75 = 0;
foreach($data as $i){
	$descricao = str_pad($i, 50, " ", STR_PAD_RIGHT);
	$produto = str_pad($j, 14, "0", STR_PAD_LEFT);
	$t .= "75".$dataInicial.$dataFinal.$produto."62171000DIA".$descricao."UN    000000000000000000000000000\r\n";
	$j++;
	$c75++;
}
$c60 = str_pad($c60, 8, "0", STR_PAD_LEFT);
$c75 = str_pad($c75, 8, "0", STR_PAD_LEFT);
$c99 = ($c60 + $c75 + 3);
$c99 = str_pad($c99, 8, "0", STR_PAD_LEFT);
$t .= "90774984420001342010302423    60".$c60."75".$c75."99".$c99."                                                                 1";
fwrite($saida, $t);
fclose($saida)

?>