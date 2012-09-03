<?php

require_once "Conexao.php";

class ProdutoEstService
{	
	function ProdutoEstService(){ }

	function listar($departamento,$subdepartamento,$texto,$promocao){
		$select = "SELECT EP.*, 
						  EPP.*,
						  CF.NOME_FANTASIA AS FORNEC_DESC, 
						  ED.DESCRICAO AS DEPTO_DESC, 
						  ES.DESCRICAO AS SUBDEPTO_DESC ";
		$from = "FROM EST_PRODUTOS EP, 
					  EST_PROD_PRECOS EPP,
					  CTS_FORNECEDORES CF, 
					  EST_DEPARTAMENTOS ED, 
					  EST_PROD_QUANTIDADES EPQ, 
					  EST_GRADES EG,
					  EST_SUBDEPARTAMENTOS ES ";
		$where = "WHERE EP.FORNECEDOR=CF.ID AND
						EP.DEPTO=ED.ID AND 
						EP.GRADE=EG.ID AND
						EP.REDUZIDO=EPQ.REDUZIDO AND 
						EPP.REDUZIDO=EP.REDUZIDO AND 
						EP.DEPTO='".$departamento."' AND
						EP.SUBDEPTO=ES.ID ";
		$orderby = " ORDER BY EPP.DATA DESC, EPQ.QDATA DESC";
		$where .= $subdepartamento!=0? "AND EP.SUBDEPTO='".$subdepartamento."' " : "AND EP.SUBDEPTO>0 ";
		$padrao = "^([0-9][0-9][0-9][0-9])-([0-9][0-9][0-9][0-9])$";
		if(ereg($padrao,$texto)){
			$intervalo = explode("-",$texto);
			$where .= "AND ID BETWEEN '$intervalo[0]' AND '$intervalo[1]'";
		}
		else if(is_numeric($texto)){
			$where .= "AND EP.REDUZIDO='$texto'";
		} 
		else {
			$where .= "AND EP.DESCRICAO LIKE '%$texto%'";
		}
		if($promocao=='true') $where .= " AND EPP.PVISTA>0";
		$s = $select.$from.$where.$orderby;
		$r = fetch_assoc($s);
		foreach($r as $k=>$f){
			$r[$k]['FORNECEDOR_DESC'] = $f['FORNECEDOR']." - ".$f['FORNEC_DESC'];
		
			if($f['PVISTA']!='0'){
				$r[$k]['AVISTA_DESC'] = "P ".$f['PVISTA'];
				$r[$k]['APRAZO_DESC'] = "P ".$f['PPRAZO'];
			} else {
				$r[$k]['AVISTA_DESC'] = $f['AVISTA'];
				$r[$k]['APRAZO_DESC'] = $f['APRAZO'];
			}
			$r[$k]['AVISTA'] = $f['AVISTA'];
			$r[$k]['APRAZO'] = $f['APRAZO'];
			$r[$k]['DVISTA'] = $f['DVISTA'];
			$r[$k]['PVISTA'] = $f['PVISTA'];
			$r[$k]['DPRAZO'] = $f['DPRAZO'];
			$r[$k]['PPRAZO'] = $f['PPRAZO'];

			$r[$k]['AVISTA_DESC'] = explode(".",$r[$k]['AVISTA_DESC']);
			$r[$k]['AVISTA_DESC'] = $r[$k]['AVISTA_DESC'][0].".".substr($r[$k]['AVISTA_DESC'][1],0,2);
			
			$r[$k]['APRAZO_DESC'] = explode(".",$r[$k]['APRAZO_DESC']);
			$r[$k]['APRAZO_DESC'] = $r[$k]['APRAZO_DESC'][0].".".substr($r[$k]['APRAZO_DESC'][1],0,2);

			$r[$k]['AVISTA'] = explode(".",$r[$k]['AVISTA']);
			$r[$k]['AVISTA'] = $r[$k]['AVISTA'][0].".".substr($r[$k]['AVISTA'][1],0,2);

			$r[$k]['PVISTA'] = explode(".",$r[$k]['PVISTA']);
			$r[$k]['PVISTA'] = $r[$k]['PVISTA'][0].".".substr($r[$k]['PVISTA'][1],0,2);

			$r[$k]['APRAZO'] = explode(".",$r[$k]['APRAZO']);
			$r[$k]['APRAZO'] = $r[$k]['APRAZO'][0].".".substr($r[$k]['APRAZO'][1],0,2);
			
			$r[$k]['PPRAZO'] = explode(".",$r[$k]['PPRAZO']);
			$r[$k]['PPRAZO'] = $r[$k]['PPRAZO'][0].".".substr($r[$k]['PPRAZO'][1],0,2);

			//$percentual = $t['D_PRAZO'] / 100.0; // 15%
			//$r[$k]['VVALORVISTA'] = $t['VVALOR'] - ($percentual * $t['VVALOR']);
			//$r[$k]['VVALORVISTA'] = round($r[$k]['VVALORVISTA'], 2);
						
			//$t = fetch_assoc_simples("SELECT * FROM EST_GRADES WHERE ID='$f[GRADE]'");
			$r[$k]['Q1'] =  $f['Q1'];
			$r[$k]['Q2'] =  $f['Q2'];
			$r[$k]['Q3'] =  $f['Q3'];
			$r[$k]['Q4'] =  $f['Q4'];
			$r[$k]['Q5'] =  $f['Q5'];
			$r[$k]['Q6'] =  $f['Q6'];
			$r[$k]['Q7'] =  $f['Q7'];
			$r[$k]['Q8'] =  $f['Q8'];
			$r[$k]['Q9'] =  $f['Q9'];
			$r[$k]['Q10'] = $f['Q10'];
			$r[$k]['Q11'] = $f['Q11'];
			$r[$k]['Q12'] = $f['Q12'];
			
			//$t = fetch_assoc_simples("SELECT * FROM EST_PROD_QUANTIDADES WHERE REDUZIDO='$f[REDUZIDO]' ORDER BY QDATA DESC");
			$r[$k]['QV1'] =  $f['QV1'];
			$r[$k]['QV2'] =  $f['QV2'];
			$r[$k]['QV3'] =  $f['QV3'];
			$r[$k]['QV4'] =  $f['QV4'];
			$r[$k]['QV5'] =  $f['QV5'];
			$r[$k]['QV6'] =  $f['QV6'];
			$r[$k]['QV7'] =  $f['QV7'];
			$r[$k]['QV8'] =  $f['QV8'];
			$r[$k]['QV9'] =  $f['QV9'];
			$r[$k]['QV10'] = $f['QV10'];
			$r[$k]['QV11'] = $f['QV11'];
			$r[$k]['QV12'] = $f['QV12'];
			
			$r[$k]['TOTAL'] = $t['QV1']+$t['QV2']+$t['QV3']+$t['QV4']+$t['QV5']+$t['QV6']+$t['QV7']+$t['QV8']+$t['QV9']+$t['QV10']+$t['QV11']+$t['QV12'];
			$r[$k]['ACMES'] = '-';
			$r[$k]['ULTVEND'] = '-';
			
			/* $t = fetch_assoc_simples("SELECT * FROM EST_INDICES");
			$r[$k]['CST_FIN']  = $t['CST_FIN'];
			$r[$k]['TXA_DEF']  = $t['TXA_DEF'];
			$r[$k]['CST_OPE']  = $t['CST_OPE'];
			$r[$k]['V0_15']    = $t['V0_15'];
			$r[$k]['V16_30']   = $t['V16_30'];
			$r[$k]['V31_45']   = $t['V31_45'];
			$r[$k]['V46_60']   = $t['V46_60'];
			$r[$k]['V61_75']   = $t['V61_75'];
			$r[$k]['V76_90']   = $t['V76_90'];
			$r[$k]['V91_105']  = $t['V91_105'];
			$r[$k]['V106_120'] = $t['V106_120'];
			$r[$k]['V121_135'] = $t['V121_135'];
			$r[$k]['V136_150'] = $t['V136_150'];
			$r[$k]['V151_165'] = $t['V151_165'];
			$r[$k]['V166_180'] = $t['V166_180'];
			*/			
		}
		return $r;
	}
	function atualizar(){
		$r=fetch_assoc("SELECT * FROM EST_PROD_PRECOS");
		foreach($r as $k=>$v){
			if($v[PPRAZO]==NULL){
				//$desconto = (($v[AVISTA]/$v[PVISTA])*100)-100;
				//$desconto = explode(".",$desconto);
				//$desconto = $desconto[0].".".substr($desconto[1],0,2);
				//$s = "UPDATE EST_PROD_PRECOS SET DVISTA='$desconto' WHERE REDUZIDO='$v[REDUZIDO]'";
				//$pprazo = $v[PVISTA]*1.15;
				//$pprazo = explode(".",$pprazo);
				//$pprazo = $pprazo[0].".".substr($pprazo[1],0,2);
				//$s = "UPDATE EST_PROD_PRECOS SET PPRAZO='$pprazo' WHERE REDUZIDO='$v[REDUZIDO]'";
				$s = "UPDATE EST_PROD_PRECOS SET DVISTA='0.00', PPRAZO='0.00' WHERE REDUZIDO='$v[REDUZIDO]'";
				echo $s."<BR/>";
				executa($s);
			}
		}
		return "ok";
	}
	function cadastrar($obj){
		$data = date("Y-m-d");
		executa("INSERT INTO EST_PRODUTOS VALUES (
				  '',
				  '$obj[REDUZIDO]',
				  '$obj[REF]',
				  '$obj[CODBARFAB]',
				  '$obj[CODBARLOJA]',
				  '$obj[NCM]',
				  '$obj[DESCRICAO]',
				  '$obj[DEPTO]',
				  '$obj[SUBDEPTO]',
				  '$obj[FORNECEDOR]',
				  '$obj[UNIDADE]',
				  '$obj[GRADE]'
				)");
				
		executa("INSERT INTO EST_PROD_CUSTO VALUES ('', '$obj[REDUZIDO]', '$data', '$obj[CMARGEM]', '$obj[CVALOR]')");
		executa("INSERT INTO EST_PROD_VENDA VALUES ('', '$obj[REDUZIDO]', '$data', '$obj[VMARGEM]', '$obj[VVALOR]')");
		executa("INSERT INTO EST_PROD_PROMOCAO VALUES (
			'', 
			'$obj[REDUZIDO]', 
			'$data', 
			'$obj[DPRAZO]', 
			'$obj[DVISTA]',
			'$obj[PPRAZO]',
			'$obj[PVISTA]',
			)");
			
		executa("INSERT INTO EST_QUANTIDADES (
			'',
			'$obj[REDUZIDO]', 
			'$data',
			'$obj[QV1]',
			'$obj[QV2]',
			'$obj[QV3]',
			'$obj[QV4]',
			'$obj[QV5]',
			'$obj[QV6]',
			'$obj[QV7]',
			'$obj[QV8]',
			'$obj[QV9]',
			'$obj[QV10]',
			'$obj[QV11]',
			'$obj[QV12]'		
		)");
	}

	function editar($obj){
		$data = date("Y-m-d");
		executa("UPDATE EST_PRODUTOS SET
				  REDUZIDO='$obj[REDUZIDO]',
				  CODBARFAB='$obj[CODBARFAB]',
				  CODBARLOJA='$obj[CODBARLOJA]',
				  NCM='$obj[NCM]',
				  DESCRICAO='$obj[DESCRICAO]',
				  DEPTO='$obj[DEPTO]',
				  SUBDEPTO='$obj[SUBDEPTO]',
				  FORNECEDOR='$obj[FORNECEDOR]',
				  UNIDADE='$obj[UNIDADE]',
				  GRADE='$obj[GRADE]',
				  WHERE REDUZIDO='$obj[REDUZIDO]'
				)");
				
		executa("DELETE FROM EST_PROD_CUSTO WHERE REDUZIDO='$obj[REDUZIDO]' AND CDATA='$data'");
		executa("DELETE FROM EST_PROD_VENDA WHERE REDUZIDO='$obj[REDUZIDO]' AND VDATA='$data'");
		executa("DELETE FROM EST_PROD_PROMOCAO WHERE REDUZIDO='$obj[REDUZIDO]' AND PDATA='$data'");
		
		executa("INSERT INTO EST_PROD_CUSTO VALUES ('', '$obj[REDUZIDO]', '$data', '$obj[CMARGEM]', '$obj[CVALOR]')");
		executa("INSERT INTO EST_PROD_VENDA VALUES ('', '$obj[REDUZIDO]', '$data', '$obj[VMARGEM]', '$obj[VVALOR]')");
		executa("INSERT INTO EST_PROD_PROMOCAO VALUES (
			'', 
			'$obj[REDUZIDO]', 
			'$data', 
			'$obj[DPRAZO]', 
			'$obj[DVISTA]',
			'$obj[PPRAZO]',
			'$obj[PVISTA]',
			)");
			
		executa("DELETE FROM EST_QUANTIDADES WHERE REDUZIDO='$obj[REDUZIDO]' AND QDATA='$data'");
			
		executa("INSERT INTO EST_QUANTIDADES (
			'',
			'$obj[REDUZIDO]', 
			'$data',
			'$obj[QV1]',
			'$obj[QV2]',
			'$obj[QV3]',
			'$obj[QV4]',
			'$obj[QV5]',
			'$obj[QV6]',
			'$obj[QV7]',
			'$obj[QV8]',
			'$obj[QV9]',
			'$obj[QV10]',
			'$obj[QV11]',
			'$obj[QV12]'		
		)");
	}

	function excluir($red){
		executa("DELETE FROM EST_PRODUTOS WHERE REDUZIDO='$red'");
		executa("DELETE FROM EST_PROD_CUSTO WHERE REDUZIDO='$red'");
		executa("DELETE FROM EST_PROD_VENDA WHERE REDUZIDO='$red'");
		executa("DELETE FROM EST_PROD_PROMOCAO WHERE REDUZIDO='$red'");
	}
}

?>