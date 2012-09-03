<?php

require_once "Funcoes.php"
require_once "Object.php";
require_once "Conexao.php";

class ListagemService extends Conexao
{
	var $c;
	
    function ListagemService(){ $this->c = parent::getConexao(); }
	
	function conta($texto,$data_inicial,$data_final) {
		if($texto=="") {
			$data_inicial = explode("/",$data_inicial);
			$data_inicial = $data_inicial[2]."-".$data_inicial[1]."-".$data_inicial[0];
			$data_final = explode("/",$data_final);
			$data_final = $data_final[2]."-".$data_final[1]."-".$data_final[0];
			$sql = "SELECT n.nota,n.fornecedor,n.localizador,n.grupo,n.historico,n.observacao,n.data_lancto,f.nome_fantasia as fornecedor_desc,
				l.descricao as localizador_desc,g.descricao as grupo_desc, n.data_criacao as data, t.data_vencto as data_vencto, t.valor
				FROM CTS_NOTAS N,CTS_FORNECEDORES F,CTS_LOCALIZADORES L, CTS_GRUPOS G, CTS_NOTA T 
				WHERE n.fornecedor=f.id and n.localizador=l.id and n.grupo=g.id and n.nota=t.nota and t.data_vencto BETWEEN '$data_inicial' AND '$data_final' ORDER BY t.data_vencto ASC";
		}
		else {
			$sql = "SELECT n.nota,n.fornecedor,n.localizador,n.grupo,n.historico,n.observacao,n.data_lancto,f.nome_fantasia as fornecedor_desc,
				l.descricao as localizador_desc,g.descricao as grupo_desc, n.data_criacao as data, t.data_vencto as data_vencto, t.valor
				FROM CTS_NOTAS N,CTS_FORNECEDORES F,CTS_LOCALIZADORES L, CTS_GRUPOS G, CTS_NOTA T 
				WHERE n.fornecedor=f.id and n.localizador=l.id and n.grupo=g.id and n.nota=t.nota ORDER BY t.data_vencto ASC";
		}
		$query = ibase_query($this->c, $sql);
		$r = array();
		while($row= ibase_fetch_assoc($query)){
			$o = new Object();
			if($texto!=""){
				$passou = false;
				if(eregi($texto,$row['NOTA'])) $passou = true;
				if(eregi($texto,$row['RAZAO'])) $passou = true;
				if(eregi($texto,$row['FORNECEDOR_DESC'])) $passou = true;
				if(eregi($texto,$row['LOCALIZADOR_DESC'])) $passou = true;
				if(eregi($texto,$row['GRUPO_DESC'])) $passou = true;
				if($passou){
					$o->load($row);
					$o->set('ID',$o->get('NOTA'));
					$d = explode("-",$o->get('DATA'));
					$o->set('DATA_SEMANA',$this->diasemana($d));
					$o->set('DATA', $d[2]."/".$d[1]."/".$d[0]);
					
					$d = explode("-",$o->get('DATA_VENCTO'));
					$o->set('DATA_VENCTO_SEMANA',$this->diasemana($d));
					$o->set('DATA_VENCTO', $d[2]."/".$d[1]."/".$d[0]);
					
					$d = explode("-",$o->get('DATA_LANCTO'));
					$o->set('DATA_LANCTO', $d[2]."/".$d[1]."/".$d[0]);
					$o->set('LOCALIZADOR',$o->get('LOCALIZADOR')==""? '0' : $o->get('LOCALIZADOR'));
					$r[] = $o->get_all();
				}
			} else {
					$o->load($row);
					$o->set('ID',$o->get('NOTA'));
					$d = explode("-",$o->get('DATA'));
					$o->set('DATA_SEMANA',$this->diasemana($d));
					$o->set('DATA', $d[2]."/".$d[1]."/".$d[0]);
					
					$d = explode("-",$o->get('DATA_VENCTO'));
					$o->set('DATA_VENCTO_SEMANA',$this->diasemana($d));
					$o->set('DATA_VENCTO', $d[2]."/".$d[1]."/".$d[0]);
					
					$d = explode("-",$o->get('DATA_LANCTO'));
					$o->set('DATA_LANCTO', $d[2]."/".$d[1]."/".$d[0]);
					$o->set('LOCALIZADOR',$o->get('LOCALIZADOR')==""? '0' : $o->get('LOCALIZADOR'));
					$r[] = $o->get_all();
			}
		}
		return $r;
    }
	
    function localizador() {
		$sql = "SELECT * FROM CTS_LOCALIZADORES ORDER BY ID ASC";
		$query = ibase_query($this->c, $sql);
		$r = array();
		while($row= ibase_fetch_assoc($query)){
			$o = new Object();
			$o->load($row);
			$r[] = $o->get_all();
		}
		return $r;
    }
	
	function artigo() {
		$sql = "SELECT * FROM AGA_ARTIGOS ORDER BY ID ASC";
		$query = ibase_query($this->c, $sql);
		$r = array();
		while($row= ibase_fetch_assoc($query)){
			$o = new Object();
			$o->load($row);
			$r[] = $o->get_all();
		}
		return $r;
    }
	
    function fornecedor() {
		$sql = "SELECT ID, RAZAO, NOME_FANTASIA, CNPJ, IE, DATA_CAD, ENDERECO, BAIRRO, MUNICIPIO, UF, CEP, FONE, FAX, CONTATO, REPRESENTANTE, FONE_REPRES FROM CTS_FORNECEDORES ORDER BY ID ASC";
		$query = ibase_query($this->c, $sql);
		$r = array();
		while($row= ibase_fetch_assoc($query)){
			$o = new Object();
			$o->load($row);
			if($o->get('DATA_CAD')==NULL) $o->set('DATA_CAD',date('Y-m-d'));
			$d = explode("-",$o->get('DATA_CAD'));
			$o->set('DATA_CAD', $d[2]."/".$d[1]."/".$d[0]);
			$r[] = $o->get_all();
		}
		return $r;
    }
	
    function grupo() {
		$sql = "SELECT * FROM CTS_GRUPOS G ORDER BY ID ASC";
		$query = ibase_query($this->c, $sql);
		$r = array();
		while($row= ibase_fetch_assoc($query)){
			$o = new Object();
			$o->load($row);
			$o->set('MENSAL',$o->get('MENSAL')=="S" ? "SIM" : "NÃO");
			$r[] = $o->get_all();
		}
		return $r;
    }
	
    function escola() {
		$sql = "SELECT * FROM AGA_INSTITUICOES ORDER BY ID ASC";
		$query = ibase_query($this->c, $sql);
		$r = array();
		while($row= ibase_fetch_assoc($query)){
			$o = new Object();
			$o->load($row);
			$r[] = $o->get_all();
		}
		return $r;
    }
	
    function insumo() {
		$sql = "SELECT I.ID, I.DESCRICAO, I.DATA, I.PRECO, I.PRAZO, T.ID as TIPO, T.DESCRICAO as TIPO_DESC FROM AGA_INSUMOS I, AGA_INSUMOS_TIPOS T WHERE I.TIPO=T.ID ORDER BY I.ID ASC";
		$query = ibase_query($this->c, $sql);
		$r = array();
		while($row= ibase_fetch_assoc($query)){
			$o = new Object();
			$o->load($row);
			$r[] = $o->get_all();
		}
		return $r;
    }
	
    function insumoTipo() {
		$sql = "SELECT * FROM AGA_INSUMOS_TIPOS ORDER BY ID ASC";
		$query = ibase_query($this->c, $sql);
		$r = array();
		while($row= ibase_fetch_assoc($query)){
			$o = new Object();
			$o->load($row);
			$r[] = $o->get_all();
		}
		return $r;
    }
	
	function lote(){
		$sql = "SELECT * FROM AGA_LOTES ORDER BY ID ASC";
		$query = ibase_query($this->c, $sql);
		$r = array();
		while($row= ibase_fetch_assoc($query)){
			$o = new Object();
			$o->load($row);
			$o->set('DESCRICAO',$o->get('ID')." - ".$o->get('DESCRICAO'));
			$r[] = $o->get_all();
		}
		return $r;
    }
	
	function marcacao($lote){
		$r = array();
		if($artigo!="null"){
	     	$resultado = ibase_fetch_assoc(ibase_query($this->c, "SELECT COUNT(*) FROM AGA_MARCACAO WHERE LOTE='$lote'"));
	     	if($resultado[COUNT]<1){ 
					$o = new Object();
					$o->load($row);
					$q=ibase_fetch_assoc(ibase_query($this->c,"SELECT DESCRICAO FROM AGA_LOTES WHERE ID='$lote'"));
					$o->set('LOTE',$lote);
					$o->set('LOTE_DESC',$lote." - ".$q['DESCRICAO']);
					$o->set('DESCRICAO','Insira produto(os)');
					$r[] = $o->get_all();

			} else {
		     	$sql = "SELECT M.ID, M.LOTE, M.ESCOLA, M.ARTIGO, M.DOIS, M.QUATRO, M.SEIS, M.OITO, M.DEZ,
		     	M.DOZE, M.QUATORZE, M.DEZESSEIS, M.P, M.M, M.G, M.XG, E.ID AS ESCOLA, E.DESCRICAO AS ESCOLA_DESC, A.ID AS ARTIGO, A.DESCRICAO AS ARTIGO_DESC, L.DESCRICAO AS LOTE_DESC FROM AGA_MARCACAO M, AGA_INSTITUICOES E, AGA_ARTIGOS A, AGA_LOTES L
		     	WHERE M.LOTE='$lote' AND M.ARTIGO=A.ID AND M.ESCOLA=E.ID AND L.ID='$lote'";
		     	$query = ibase_query($this->c, $sql) or die(ibase_errmsg());
				while($row = ibase_fetch_assoc($query)){
					$o = new Object();
					$o->load($row);
					$o->set('DESCRICAO',$o->get('ARTIGO_DESC')." ".$o->get('ESCOLA_DESC'));
					$o->set('LOTE_DESC',$o->get('LOTE')." - ".$o->get('LOTE_DESC'));
					$o->set('TOT',(double)$row[DOIS]+(double)$row[QUATRO]+(double)$row[SEIS]+(double)$row[OITO]+(double)$row[DEZ]+(double)$row[DOZE]+(double)$row[QUATORZE]+(double)$row[DEZESSEIS]+(double)$row[P]+(double)$row[M]+(double)$row[G]+(double)$row[XG]);
					$r[] = $o->get_all();
				}
			} 
			return $r;
		} else {
			$objeto = new Object();
			$objeto->escola = "Insira escolas";
			$objeto->codigo= "-";
			$objeto->dois= "-";
			$objeto->quatro= "-";
			$objeto->seis= "-";
			$objeto->oito= "-";
			$objeto->dez= "-";
			$objeto->doze= "-";
			$objeto->quatorze= "-";
			$objeto->dezesseis= "-";
			$objeto->p= "-";
			$objeto->m= "-";
			$objeto->g= "-";
			$objeto->xg= "-";
			$objeto->tot= "-";
			$r[] = $objeto;
			return $r;
		}
	 }
	
    function fornecedorSimples() {
		$sql = "SELECT CODIGO,NOME_FANTASIA FROM CTS_FORNECEDORES ORDER BY NOME_FANTASIA ASC";
		$query = ibase_query($this->c, $sql);
		$this->retorno = array();
		while($row= ibase_fetch_object($query)){
			$obj = new Combo();
			$obj->id = $row->CODIGO;
			$obj->descricao = $row->NOME_FANTASIA;
			$this->retorno[] = $obj;
		}
		return $this->retorno;
    }
	
	function localizadorSimples() {
		$sql = "SELECT ID,DESCRICAO FROM CTS_LOCALIZADORES ORDER BY DESCRICAO ASC";
		$query = ibase_query($this->c, $sql);
		$this->retorno = array();
		while($row= ibase_fetch_object($query)){
			$obj = new Combo();
			$obj->id = $row->ID;
			$obj->descricao = trim(utf8_decode($row->DESCRICAO));
			$this->retorno[] = $obj;
		}
		return $this->retorno;
    }
	
	function grupoSimples() {
		$sql = "SELECT ID,DESCRICAO FROM CTS_GRUPOS ORDER BY DESCRICAO ASC";
		$query = ibase_query($this->c, $sql);
		$this->retorno = array();
		while($row= ibase_fetch_object($query)){
			$obj = new Combo();
			$obj->id = $row->ID;
			$obj->descricao = trim(utf8_decode($row->DESCRICAO));
			$this->retorno[] = $obj;
		}
		return $this->retorno;
    }
	

}