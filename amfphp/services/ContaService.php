<?php

require_once "Conexao.php";
require_once "Funcoes.php";

class ContaService
{	
	function ContaService(){  }
	
	function listar($texto,$data_inicial,$data_final){
		$padrao = "^([0-9][0-9])/([0-9][0-9])/([0-9][0-9][0-9][0-9])$";
		$select = "SELECT n.nota,
							 n.fornecedor,
							 n.localizador,
							 n.grupo,
							 n.historico,
							 n.observacao,
							 n.data_lancto,
							 f.nome_fantasia as fornecedor_desc,
							 l.descricao as localizador_desc,
							 g.descricao as grupo_desc, 
							 n.data_nota, 
							 t.data_vencto as data_vencto, 
							 t.valor ";
		$from = "FROM CTS_NOTAS N,
							 CTS_FORNECEDORES F,
							 CTS_LOCALIZADORES L,
							 CTS_GRUPOS G, 
							 CTS_NOTA T ";
		$where = "WHERE n.fornecedor=f.id and 
						n.localizador=l.id and 
						n.grupo=g.id and 
						n.nota=t.nota and n.fornecedor=t.fornecedor";
		$orderby = " ORDER BY t.data_vencto ASC";
		if($data_inicial==""){
			if($texto=="") { 
				$s = $select.$from.$where.$orderby;
			} else if(ereg($padrao,$texto)) {
				$data = explode("/",$texto);
				$data = $data[2]."-".$data[1]."-".$data[0];
				$s = $select.$from.$where." and t.data_vencto='$data' ".$orderby;
			} else {
				$s = $select.$from.$where." and f.nome_fantasia LIKE '%$texto%'".$orderby;
			}
			
		} else {
			$data_inicial = explode("/",$data_inicial);
			$data_inicial = $data_inicial[2]."-".$data_inicial[1]."-".$data_inicial[0];
			$data_final = explode("/",$data_final);
			$data_final = $data_final[2]."-".$data_final[1]."-".$data_final[0];
			if($texto==""){ 
				$s = $select.$from.$where." and t.data_vencto BETWEEN '$data_inicial' AND '$data_final' ".$orderby;
			} else if(ereg($padrao,$texto)) {
				$data = explode("/",$texto);
				$data = $data[2]."-".$data[1]."-".$data[0];
				$s = $select.$from.$where." and t.data_vencto='$data' and t.data_vencto BETWEEN '$data_inicial' AND '$data_final' ".$orderby;
			} else {
				$s = $select.$from.$where." and t.data_vencto BETWEEN '$data_inicial' AND '$data_final' ".$orderby;
			}	
		}
		$r = fetch_assoc($s);
		foreach($r as $k=>$f){
			if($texto!=""){
				$passou = false;
				if(eregi($texto,$f['NOTA'])) $passou = true;
				if(eregi($texto,$f['RAZAO'])) $passou = true;
				if(eregi($texto,$f['FORNECEDOR_DESC'])) $passou = true;
				if(eregi($texto,$f['LOCALIZADOR_DESC'])) $passou = true;
				if(eregi($texto,$f['GRUPO_DESC'])) $passou = true;
				if($passou){
					$d = explode("-",$f['DATA_NOTA']);
					$r[$k]['DATA_NOTA_SEMANA'] = diasemana($d);
					$r[$k]['DATA_NOTA'] = $d[2]."/".$d[1]."/".$d[0];
					$r[$k]['VALOR'] = str_replace(",",".",$f['VALOR']);
					
					$d = explode("-",$f['DATA_VENCTO']);
					$r[$k]['DATA_VENCTO_SEMANA'] = diasemana($d);
					$r[$k]['DATA_VENCTO'] = $d[2]."/".$d[1]."/".$d[0];
					
					$d = explode("-",$f['DATA_LANCTO']);
					$r[$k]['DATA_LANCTO'] = $d[2]."/".$d[1]."/".$d[0];
					$r[$k]['LOCALIZADOR'] = $f['LOCALIZADOR'] == "" ? '0' : $f['LOCALIZADOR'];
				} else { unset($r[$k]); }				
			} else {
				$d = explode("-",$f['DATA_NOTA']);
				$r[$k]['DATA_NOTA_SEMANA'] = diasemana($d);
				$r[$k]['DATA_NOTA'] = $d[2]."/".$d[1]."/".$d[0];
				$r[$k]['VALOR'] = str_replace(",",".",$f['VALOR']);
				
				$d = explode("-",$f['DATA_VENCTO']);
				$r[$k]['DATA_VENCTO_SEMANA'] = diasemana($d);
				$r[$k]['DATA_VENCTO'] = $d[2]."/".$d[1]."/".$d[0];
				
				$d = explode("-",$f['DATA_LANCTO']);
				$r[$k]['DATA_LANCTO'] = $d[2]."/".$d[1]."/".$d[0];
				$r[$k]['LOCALIZADOR'] = $f['LOCALIZADOR'] == "" ? '0' : $f['LOCALIZADOR'];
			}
		}
		$r = array_merge($r);
		return $r;
	}
	
	function inserirParcelas($obj){
		foreach($obj[PARCELAS] as $parcela){	
			$nota = $parcela['NOTA'];
			$valor = $parcela['VALOR'];
			$par = $parcela['PARCELA'];
			$data_vencto = $parcela['DATA_VENCTO'];
			$data_vencto = explode("/",$data_vencto);
			$data_vencto = $data_vencto[2]."-".$data_vencto[1]."-".$data_vencto[0];
			$fornecedor= $parcela['FORNECEDOR'];
			executa("INSERT INTO CTS_NOTA(nota,valor,parcela,data_vencto,fornecedor) VALUES ('$nota','$valor','$par','$data_vencto','$fornecedor')");
		}
	}
	
	function cadastrar($obj){
		$r = array();
		$s = fetch_assoc_simples("SELECT COUNT(*) FROM CTS_NOTAS WHERE NOTA='$obj[NOTA]' AND FORNECEDOR='$obj[FORNECEDOR]'");
		if($s[COUNT]>0){
			$obj['alerta'] = "Essa nota para esse fornecedor já foi lançada, deseja incluir somente as parcelas?";
			return $obj;
		}
		
		$d = explode("/",$obj[DATA_LANCTO]);
		$obj[DATA_LANCTO] = $d[2]."-".$d[1]."-".$d[0];
		$obj[NOTA] = str_replace("'", "''", $obj[NOTA]);
		$obj[HISTORICO] = str_replace("'", "''", $obj[HISTORICO]);
		$obj[OBSERVACAO] = str_replace("'", "''", $obj[OBSERVACAO]);
		$d = explode("/",$obj[DATA_NOTA]);
		$obj[DATA_NOTA] = $d[2]."-".$d[1]."-".$d[0];
		executa("INSERT INTO CTS_NOTAS VALUES (
				'$obj[DATA_LANCTO]',
				'$obj[NOTA]',
				'$obj[FORNECEDOR]',
				'$obj[LOCALIZADOR]',
				'$obj[GRUPO]',
				'$obj[DATA_NOTA]',
				'$obj[HISTORICO]',
				'$obj[OBSERVACAO]')
				");
		foreach($obj[PARCELAS] as $parcela){	
			$nota = $parcela['NOTA'];
			$valor = $parcela['VALOR'];
			$par = $parcela['PARCELA'];
			$data_vencto = $parcela['DATA_VENCTO'];
			$data_vencto = explode("/",$data_vencto);
			$data_vencto = $data_vencto[2]."-".$data_vencto[1]."-".$data_vencto[0];
			$fornecedor= $parcela['FORNECEDOR'];
			executa("INSERT INTO CTS_NOTA(nota,valor,parcela,data_vencto,fornecedor) VALUES ('$nota','$valor','$par','$data_vencto','$fornecedor')");
		}
		$r['alerta'] = "Cadastrado com sucesso!";
		return $r;
     }
	 
	function editar($obj){
		$obj[DATA_LANCTO] = explode("/",$obj[DATA_LANCTO]);
		$obj[DATA_LANCTO] = $obj[DATA_LANCTO][2]."-".$obj[DATA_LANCTO][1]."-".$obj[DATA_LANCTO][0];
		$obj[NOTA] = str_replace("'", "''", $obj[NOTA]);
		$obj[HISTORICO] = str_replace("'", "''", $obj[HISTORICO]);
		$obj[OBSERVACAO] = str_replace("'", "''", $obj[OBSERVACAO]);
		$obj[DATA_NOTA] = explode("/",$obj[DATA_NOTA]);
		$obj[DATA_NOTA] = $obj[DATA_NOTA][2]."-".$obj[DATA_NOTA][1]."-".$obj[DATA_NOTA][0];
		executa("UPDATE CTS_NOTAS SET 
				DATA_LANCTO='$obj[DATA_LANCTO]', 
				NOTA='$obj[NOTA2]', 
				FORNECEDOR='$obj[FORNECEDOR]', 
				LOCALIZADOR='$obj[LOCALIZADOR]', 
				GRUPO='$obj[GRUPO]', 
				DATA_NOTA='$obj[DATA_NOTA]', 
				HISTORICO='$obj[HISTORICO]', 
				OBSERVACAO='$obj[OBSERCACAO]' WHERE NOTA='$obj[NOTA]'
				");
		executa("DELETE FROM CTS_NOTA WHERE NOTA='$obj[NOTA]'");
		foreach($obj[PARCELAS] as $parcela){	
			$nota = $obj[NOTA2];
			$valor = $parcela['VALOR'];
			$par = $parcela['PARCELA'];
			$data_vencto = $parcela['DATA_VENCTO'];
			$data_vencto = explode("/",$data_vencto);
			$data_vencto = $data_vencto[2]."-".$data_vencto[1]."-".$data_vencto[0];
			$fornecedor= $parcela['FORNECEDOR'];
			executa("INSERT INTO CTS_NOTA(nota,valor,parcela,data_vencto,fornecedor) VALUES ('$nota','$valor','$par','$data_vencto','$fornecedor')");
		}
	}
	function excluir($nota,$fornecedor){
		executa("DELETE FROM CTS_NOTA WHERE NOTA='$nota' AND FORNECEDOR='$fornecedor'");
		executa("DELETE FROM CTS_NOTAS WHERE NOTA='$nota' AND FORNECEDOR='$fornecedor'");
	}
	
	function excluirParcela($nota,$fornecedor,$data_vencto){
		$data_vencto = explode("/",$data_vencto);
		$data_vencto = $data_vencto[2]."-".$data_vencto[1]."-".$data_vencto[0];
		$s = "SELECT COUNT(*) FROM CTS_NOTA WHERE NOTA='$nota' AND FORNECEDOR='$fornecedor'";
		$r = fetch_assoc_simples($s);
		if($r[COUNT]==1){
			executa("DELETE FROM CTS_NOTA WHERE NOTA='$nota' AND FORNECEDOR='$fornecedor' AND DATA_VENCTO='$data_vencto'");
			executa("DELETE FROM CTS_NOTAS WHERE NOTA='$nota' AND FORNECEDOR='$fornecedor'");
		} else {
			executa("DELETE FROM CTS_NOTA WHERE NOTA='$nota' AND FORNECEDOR='$fornecedor' AND DATA_VENCTO='$data_vencto'");
		}
	}
	
	function imprimirListagem2($obj){
		$r = "<HTML><HEAD>
						<style type='text/css'>
				body,td,th {
					font-family: Arial, Helvetica, sans-serif;
					font-size: 0.8em;
				}
				</style></HEAD><BODY>";
		$r .= "<TABLE WIDTH='500'>";
		$r .= "<TR><TD><span style='color:#CCC'>TESTE</span></TD></TR>";
		$r .= "<TR><TD>&nbsp;TESTE</TD></TR>";
		$r .= "<TR><TD>TESTE</TD></TR>";
		$r .= "</TABLE></BODY></HTML>";
		return $r;
	}
	
	function imprimirListagem($obj){
		$dias = array();
		$data_inicial = $obj['DATA_INICIAL']!=""? $obj['DATA_INICIAL'] : "01/01/1950";
		$data_final = $obj['DATA_FINAL']!=""? $obj['DATA_FINAL'] : "01/01/3000";
		$texto = $obj['TEXTO'];
		$impressao = "
				<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
				<html xmlns='http://www.w3.org/1999/xhtml'>
				<head>
				<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
				<title>BONSUCESSO - RELATÓRIO DE CONTAS À PAGAR</title>
				<style type='text/css'>
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
				<body>
		";
		$impressao .= "
			<table width='790' align='center'>
			  <tr>
				<th scope='col'><img src='bonsucesso.jpg' width='502' height='107' /></th>
			  </tr>
			  <tr>
				<th><h1>RELATÓRIO DE CONTAS A PAGAR</h1></th>
			  </tr>
			  <tr>
				<th align=center><h2><strong>";
				if($data_inicial!="01/01/1950") 
					$impressao .= $data_inicial." à ".$data_final;
				$impressao .= "</strong></h2></th>
				  </tr>
				</table>
				<br />";
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
					$impressao .= "<table width='790' align='center'>";
					$data[0] = $kmes;
					$data[1] = $kdia;
					$data[2] = $kano;
					$dia = diasemana($data);
					$impressao .= "<tr><th colspan='10' scope='col'><h3>".$kdia."/".$kmes."/".$kano." - ".$dia."</h3></th></tr>";
					$impressao .= "
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
							$impressao .= "<tr>
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
					$impressao .= "<tr>
							<th colspan='8' align='right'><h3>SUBTOTAL</h3></th>
							<th colspan='2' align='center'><h3>".number_format($vdia['SUBTOTAL'],2,',','.')."</h3></th>
						 </tr>";
					$impressao .= "</table><BR/>";
				}
			}
		}
	$impressao .= "<table width='790' align='center'>
			<tr>
				<th align='center'><h2>TOTAL</h2></th>
				<th align='center'><h2>".number_format($total,2,',','.')."</h2></th>
			</tr>
		</table>";
	$impressao .= "</table>
	</body>
	</html>";
	return $impressao;
	}
	
	function processar($obj){
		$de_mes = explode("/",$obj['DE_MES']);
		$de_mes = $de_mes[1]."-".$de_mes[0];
		$para_mes = explode("/",$obj['PARA_MES']);
		$parcela = explode("/",$obj['PARA_MES']);
		$para_mes = $para_mes[1]."-".$para_mes[0];
		
		$select = "SELECT n.nota,
							 n.fornecedor,
							 n.localizador,
							 n.grupo,
							 n.historico,
							 n.observacao,
							 n.data_lancto,
							 f.nome_fantasia as fornecedor_desc,
							 l.descricao as localizador_desc,
							 g.descricao as grupo_desc, 
							 n.data_nota, 
							 t.data_vencto as data_vencto, 
							 t.valor ";
		$from = "FROM CTS_NOTAS N,
							 CTS_FORNECEDORES F,
							 CTS_LOCALIZADORES L,
							 CTS_GRUPOS G, 
							 CTS_NOTA T ";
		$where = "WHERE n.fornecedor=f.id and 
						n.localizador=l.id and 
						n.grupo=g.id and 
						t.DATA_VENCTO LIKE '$de_mes%' AND t.DATA_VENCTO NOT LIKE '$para_mes%' AND F.MENSAL='S' and 
						n.nota=t.nota and n.fornecedor=t.fornecedor";
		$orderby = " ORDER BY t.data_vencto ASC";
		$s = $select.$from.$where.$orderby;		
		//$s = "SELECT N.NOTA, F.NOME_FANTASIA, N.VALOR, N.DATA_VENCTO, NS.FORNECEDOR AS CODIGO FROM CTS_NOTAS NS, CTS_NOTA N, CTS_FORNECEDORES F WHERE NS.FORNECEDOR=F.ID AND NS.NOTA=N.NOTA AND N.DATA_VENCTO LIKE '$de_mes%' AND N.DATA_VENCTO NOT LIKE '$para_mes%' AND F.MENSAL='S' ORDER BY N.DATA_VENCTO ASC";
		$r = fetch_assoc($s);
		$parcela = $parcela[0];
		foreach($r as $k=>$f){
			$d = explode("-",$f['DATA_NOTA']);
			$r[$k]['DATA_NOTA_SEMANA'] = diasemana($d);
			$r[$k]['DATA_NOTA'] = $d[2]."/".$d[1]."/".$d[0];
			$r[$k]['VALOR'] = str_replace(",",".",$f['VALOR']);
			
			$d = explode("-",$f['DATA_VENCTO']);
			$r[$k]['DATA_VENCTO_SEMANA'] = diasemana($d);
			$r[$k]['DATA_VENCTO'] = $d[2]."/".$d[1]."/".$d[0];
			
			$d = explode("-",$f['DATA_LANCTO']);
			$r[$k]['DATA_LANCTO'] = $d[2]."/".$d[1]."/".$d[0];
			$r[$k]['LOCALIZADOR'] = $f['LOCALIZADOR'] == "" ? '0' : $f['LOCALIZADOR'];

			$r[$k]['FORNECEDOR_DESC2'] = $f['FORNECEDOR']." - ".$f['FORNECEDOR_DESC'];
		}
		return $r;
	}
	
	function processando($obj){
		$de_mes = explode("/",$obj['DE_MES']);
		$de_mes = $de_mes[1]."-".$de_mes[0];
		$para_mes = explode("/",$obj['PARA_MES']);
		$parcela = explode("/",$obj['PARA_MES']);
		$para_mes = $para_mes[1]."-".$para_mes[0];
		$s = "SELECT N.NOTA, F.RAZAO, N.VALOR, N.DATA_VENCTO, NS.FORNECEDOR FROM CTS_NOTAS NS, CTS_NOTA N, CTS_FORNECEDORES F WHERE NS.FORNECEDOR=F.ID AND NS.NOTA=N.NOTA AND N.DATA_VENCTO LIKE '$de_mes%' AND N.DATA_VENCTO NOT LIKE '$para_mes%' AND F.MENSAL='S'";
		$r = fetch_assoc($s);
		$parcela = $parcela[0];
		foreach($r as $k=>$v){
			$dia = explode("-",$v[DATA_VENCTO]);
			$dia = $dia[2];
			$data_vencto = $para_mes."-".$dia;
			//$p = "SELECT FIRST 1 PARCELA FROM CTS_NOTA WHERE NOTA='$v[NOTA]' ORDER BY PARCELA DESC";
			//$pa = fetch_assoc_simples($p);
			//$parcela = $pa[PARCELA] + 1;
			executa("DELETE FROM CTS_NOTA WHERE NOTA='$v[NOTA]' AND DATA_VENCTO='$data_vencto'");
			executa("INSERT INTO CTS_NOTA (NOTA,VALOR,PARCELA,DATA_VENCTO,FORNECEDOR) VALUES ('$v[NOTA]','$v[VALOR]','$parcela','$data_vencto','$v[FORNECEDOR]')");
		}
		return $texto;
	}
 }
?>