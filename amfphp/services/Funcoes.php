<?php

function diasemana($d) {

	$dia_semana = date("w", mktime(0,0,0,$d[0],$d[1],$d[2]) );

	switch($dia_semana) {
		case "0": $dia_semana_formatado = "Domingo";             break;
		case "1": $dia_semana_formatado = "Segunda-Feira";       break;
		case "2": $dia_semana_formatado = "Ter&ccedil;a-Feira";  break;
		case "3": $dia_semana_formatado = "Quarta-Feira";        break;
		case "4": $dia_semana_formatado = "Quinta-Feira";        break;
		case "5": $dia_semana_formatado = "Sexta-Feira";         break;
		case "6": $dia_semana_formatado = "S&aacute;bado";       break;
	}

	return $dia_semana_formatado;
}

function diferenca_dias($inicial,$final){
  $inicial = strtotime($inicial); // 07/04/2003 (mm/dd/aaaa) data menor
  $final = strtotime($final);    // 07/10/2003 (mm/dd/aaaa) data maior
  
		$data_atual = date("m/d/Y");
		$d = '2009-01-07';
		$d = explode("-",$d);
		$data = $d[2]."/".$d[1]."/".$d[0];
		$o->data = $this->diferenca_dias($data_atual,$data) < 0 ? "<font color='#FF0000'>".$d[1]."/".$d[2]."/".$d[0]."</font>" : $d[1]."/".$d[2]."/".$d[0];
		$o->data = $row->DATA;

  return ($final-$inicial)/86400; //transformação do timestamp em dias 
}

 function formata($numero){
	$pos = strpos($numero, '.'); 
	if($pos === false){
		if($numero==0) $retorno = "______";
		else $retorno = strlen($numero) < 3 ? "0.".str_pad($numero, 3, "0", STR_PAD_RIGHT) : $numero;
	} else {
		$tmp = explode(".",$numero);
		$v1 = str_pad($tmp[1],3,"0", STR_PAD_RIGHT);
		$retorno = $tmp[0].".".$v1;
	}
	return $retorno;
}

 function formataInt($numero){
	$pos = strpos($numero, '.'); 
	if($pos === false){
		if($numero==0) $retorno = "______";
		else $retorno = $numero;
	} else {
		$retorno = $numero;
	}
	return $retorno;
}

function limpar(){
	$sql = "SELECT * FROM CTS_NOTAS" ;
	$query = ibase_query($this->c, $sql);
	while($row= ibase_fetch_object($query)){
		$historico = str_replace('.', '', $row->HISTORICO);
		$historico = str_replace('/', '', $historico);
		$historico = str_replace('-', '', $historico);
		$observacao = str_replace('.', '', $row->OBSERVACAO);
		$observacao = str_replace('/', '', $observacao);
		$observacao = str_replace('-', '', $observacao);
		ibase_query($this->c, "UPDATE CTS_NOTAS set HISTORICO='$historico', OBSERVACAO='$observacao' WHERE NOTA='$row->NOTA'");
	}		
}

 function excluirTudo(){
	ibase_query($this->c,"DELETE FROM CTS_NOTA");
	ibase_query($this->c, "DELETE FROM CTS_NOTAS");
	return "Excluído com sucesso!";
 }

?>