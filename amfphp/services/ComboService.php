<?php

require_once "Conexao.php";
require_once "Object.php";

class ComboService
{	
	function ComboService(){  }

	function listar(){
		$s="SELECT * FROM CTS_FORNECEDORES ORDER BY ID ASC";
		return fetch_assoc($s);
	}
	 	              	
    function fornecedor() {
		$s="SELECT ID,RAZAO,NOME_FANTASIA FROM CTS_FORNECEDORES ORDER BY NOME_FANTASIA ASC";
		$r = fetch_assoc($s);
		foreach($r as $k=>$f){
			$r[$k]['DESCRICAO'] = $f['NOME_FANTASIA']==""? $f['ID']." - ".$f['RAZAO'] : $f['ID']." - ".$f['NOME_FANTASIA'];
		}
		return $r;
    }
	
	function localizador() {
		$s="SELECT ID,DESCRICAO FROM CTS_LOCALIZADORES ORDER BY DESCRICAO ASC";
		$r = fetch_assoc($s);
		foreach($r as $k=>$f){
			$r[$k]['DESCRICAO'] = $r[$k]['ID']." - ".$r[$k]['DESCRICAO'];
		}
		return $r;
    }
	
	function grupo() {
		$s="SELECT ID,DESCRICAO FROM CTS_GRUPOS ORDER BY DESCRICAO ASC";
		$r = fetch_assoc($s);
		foreach($r as $k=>$f){
			$r[$k]['DESCRICAO'] = $r[$k]['ID']." - ".$r[$k]['DESCRICAO'];
		}
		return $r;
    }
	
	function parcela($nota,$fornecedor) {
		$s="SELECT N.PARCELA,N.FORNECEDOR,N.DATA_VENCTO,N.VALOR,F.ID,F.NOME_FANTASIA,F.RAZAO FROM CTS_NOTA N, CTS_FORNECEDORES F WHERE N.FORNECEDOR=F.ID AND NOTA='$nota' AND FORNECEDOR='$fornecedor' ORDER BY N.DATA_VENCTO DESC";
		$r = fetch_assoc($s);
		foreach($r as $k=>$f){
			$r[$k]['FORNECEDOR_DESC'] = $f['RAZAO']==""? $f['ID']." - ".$f['NOME_FANTASIA'] : $f['ID']." - ".$f['RAZAO'];
			$d = explode("-",$f['DATA_VENCTO']);
			$r[$k]['DATA_VENCTO'] = $d[2]."/".$d[1]."/".$d[0];
		}
		return $r;
    }
	
	function lote() {
		$s="SELECT ID,DESCRICAO FROM AGA_LOTES ORDER BY ID DESC";
		$r = fetch_assoc($s);
		foreach($r as $k=>$f){
			$r[$k]['DESCRICAO'] = $r[$k]['ID']." - ".$r[$k]['DESCRICAO'];
			$r[$k]['DESCRICAO2'] = $f['DESCRICAO'];
		}
		return $r;
    }
	
	function escola() {
		$s="SELECT ID,DESCRICAO FROM AGA_INSTITUICOES ORDER BY DESCRICAO ASC";
		$r = fetch_assoc($s);
		foreach($r as $k=>$f){
			$r[$k]['DESCRICAO'] = $r[$k]['ID']." - ".$r[$k]['DESCRICAO'];
		}
		return $r;
    }
	
	function artigo($escola) {
		$s="SELECT A.ID,A.DESCRICAO FROM AGA_ARTIGOS A, AGA_PRODUTOS P WHERE P.ARTIGO=A.ID AND P.ESCOLA='$escola' ORDER BY A.DESCRICAO ASC";
		$r = fetch_assoc($s);
		$t = array();
		$re = array();
		foreach($r as $k=>$f){
			$t[$f[ID]][ID] = $f['ID'];
			$t[$f[ID]][DESCRICAO] = $r[$k]['ID']." - ".$r[$k]['DESCRICAO'];
		}
		$re = array_merge($t,$re);
		return $re;
    }
	
	function departamento() {
		$s="SELECT ID,DESCRICAO FROM EST_DEPARTAMENTOS ORDER BY ID ASC";
		$r = fetch_assoc($s);
		foreach($r as $k=>$f){
			$r[$k]['DESCRICAO'] = $r[$k]['ID']." - ".$r[$k]['DESCRICAO'];
		}
		return $r;
    }
	
	function subdepartamento($departamento) {
		$s="SELECT ES.ID,ES.DESCRICAO FROM EST_SUBDEPARTAMENTOS ES, EST_PRODUTOS EP WHERE ES.ID=EP.SUBDEPTO AND EP.DEPTO='$departamento' ORDER BY ES.ID ASC";
		$r = fetch_assoc($s);
		$t = array();
		$re = array();
		$t[0][ID] = 0;
		$t[0][DESCRICAO] = '---------- TODOS ----------';
		foreach($r as $k=>$f){
			$t[$f[ID]][ID] = $f['ID'];
			$t[$f[ID]][DESCRICAO] = $r[$k]['ID']." - ".$r[$k]['DESCRICAO'];
		}
		$re = array_merge($t,$re);
		return $re;
    }
	
	function insumotipo() {
		$s="SELECT ID,DESCRICAO FROM AGA_INSUMOS_TIPOS ORDER BY DESCRICAO ASC";
		$r = fetch_assoc($s);
		foreach($r as $k=>$f){
			$r[$k]['DESCRICAO'] = $r[$k]['ID']." - ".$r[$k]['DESCRICAO'];
		}
		return $r;
    }
	
	function produto($produtos){
		$s = "SELECT E.ID AS ESCOLA, E.DESCRICAO AS ESCOLA_DESC, A.ID AS ARTIGO, A.DESCRICAO AS ARTIGO_DESC FROM AGA_PRODUTOS P, AGA_INSTITUICOES E, AGA_ARTIGOS A WHERE E.ID=P.ESCOLA AND A.ID=P.ARTIGO ORDER BY P.ID ASC";
		//$s = "SELECT M.ESCOLA, M.ARTIGO, M.LOTE, E.ID AS ESCOLA, E.DESCRICAO AS ESCOLA_DESC, A.ID AS ARTIGO, A.DESCRICAO AS ARTIGO_DESC FROM AGA_MARCACAO M, AGA_INSTITUICOES E, AGA_ARTIGOS A WHERE M.ARTIGO=A.ID AND M.ESCOLA=E.ID ORDER BY M.ID ASC";
		$tmp = fetch_assoc($s);
		$t = array();
		foreach($tmp as $k=>$v){
			$v['DESCRICAO'] = $v['ARTIGO']." / ".$v['ESCOLA']." - ".$v['ARTIGO_DESC']." ".$v['ESCOLA_DESC'];
			$t[$v['ARTIGO'].'-'.$v['ESCOLA']] = $v;
		}
		$r = array();
		if($produtos!=""){
			foreach($t as $k=>$v){
				foreach($produtos as $k2=>$s){
					if($k==$s['ARTIGO'].'-'.$s['ESCOLA']) unset($t[$k]);
				}
			}
		}
		foreach($t as $k=>$v){
			$r[] = $v;
		}
		return $r;
	}
	
	function produtoCopia(){
		$escolas = "SELECT ID,DESCRICAO FROM AGA_INSTITUICOES ORDER BY DESCRICAO ASC";
		$artigos = "SELECT ID,DESCRICAO FROM AGA_ARTIGOS ORDER BY DESCRICAO ASC";
		$escolas = fetch_assoc($escolas);
		$artigos = fetch_assoc($artigos);
		$t = array();
		$i = 0;
		foreach($escolas as $escola){
			foreach($artigos as $artigo){
				$t[$i]['DESCRICAO'] = $artigo[DESCRICAO]." - ".$escola[DESCRICAO];
				$t[$i]['ESCOLA'] = $escola[ID];
				$t[$i]['ARTIGO'] = $artigo[ID];
				$i++;
			}
		}
		return $t;
	}
	
	function regraArtigos(){
		$s="SELECT ID,DESCRICAO FROM AGA_ARTIGOS ORDER BY DESCRICAO ASC";
		$r = fetch_assoc($s);
		$t = array();
		$re = array();
		foreach($r as $k=>$f){
			$t[$f[ID]][ID] = $f['ID'];
			$t[$f[ID]][DESCRICAO] = $r[$k]['ID']." - ".$r[$k]['DESCRICAO'];
		}
		$re = array_merge($t,$re);
		return $re;
	}
	
	function regraInsumos(){
		$s="SELECT ID,DESCRICAO FROM AGA_INSUMOS ORDER BY DESCRICAO ASC";
		$r = fetch_assoc($s);
		$t = array();
		$re = array();
		foreach($r as $k=>$f){
			$t[$f[ID]][ID] = $f['ID'];
			$t[$f[ID]][DESCRICAO] = $r[$k]['ID']." - ".$r[$k]['DESCRICAO'];
		}
		$re = array_merge($t,$re);
		return $re;
	}
	
	function insumo($escola,$artigo) {
		$s0="SELECT INSUMO FROM AGA_PRODUTOS WHERE ESCOLA='$escola' AND ARTIGO!='$artigo'";
		$r0 = fetch_assoc($s0);
		$produto = array();
		foreach($r0 as $k=>$v){ $produto[$v['INSUMO']] = $v['INSUMO']; }
		
		$produtos = array();
		$s = "SELECT ID,DESCRICAO FROM AGA_INSUMOS";
		$r = fetch_assoc($s);
		foreach($r as $k=>$v){ $produtos[$v['ID']]['DESCRICAO'] = $v['DESCRICAO']; }

		$t = array();
		foreach($produtos as $k=>$v){
			if (!array_key_exists($k, $produto)) {
				$t[$k]['ID'] = $k;
				$t[$k]['DESCRICAO'] = $k." - ".$v['DESCRICAO'];
			}
		}
		$t = array_values($t);

		return $t;
    }
	
	function produtoInsumo($escola,$artigo) {
		$s0 = "SELECT INSUMO FROM AGA_PRODUTOS WHERE ESCOLA='$escola' AND ARTIGO!='$artigo'";
		$r0 = fetch_assoc($s0);
		$produto = array();
		foreach($r0 as $k=>$v){ $produto[$v['INSUMO']] = $v['INSUMO']; }
		
		$produtos = array();
		$s = "SELECT ID,DESCRICAO FROM AGA_INSUMOS";
		$r = fetch_assoc($s);
		foreach($r as $k=>$v){ $produtos[$v['ID']]['DESCRICAO'] = $v['DESCRICAO']; }

		$t = array();
		foreach($produtos as $k=>$v){
			//if (!array_key_exists($k, $produto)) {
				$t[$k]['ID'] = $k;
				$t[$k]['DESCRICAO'] = $k." - ".$v['DESCRICAO'];
			//}
		}
		$t = array_values($t);

		return $t;
    }
	
	function produtoEscola(){
		$s = "SELECT ID,DESCRICAO FROM AGA_INSTITUICOES ORDER BY ID ASC";
		$r = fetch_assoc($s);
		foreach($r as $k=>$v){
			$r[$k]['ID'] = $r[$k]['ID'];
			$r[$k]['DESCRICAO'] = $r[$k]['ID']." - ".$r[$k]['DESCRICAO'];
		}
		return $r;
	}
	
	function produtoArtigos(){
		$s = "SELECT ID,DESCRICAO FROM AGA_ARTIGOS ORDER BY ID ASC";
		$r = fetch_assoc($s);
		foreach($r as $k=>$v){
			$r[$k]['ID'] = $r[$k]['ID'];
			$r[$k]['DESCRICAO'] = $r[$k]['ID']." - ".$r[$k]['DESCRICAO'];
		}
		return $r;
	}
 }

?>