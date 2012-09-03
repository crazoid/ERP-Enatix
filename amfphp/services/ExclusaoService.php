<?php

require_once "Funcoes.php"
require_once "Object.php";
require_once "Conexao.php";

class ExclusaoService extends Conexao
{
	var $c;
	
    function ExclusaoService(){ $this->c = parent::getConexao(); }
	
    function conta($nota){
     	ibase_query($this->c,"DELETE FROM CTS_NOTA WHERE NOTA='$nota'");
     	ibase_query($this->c, "DELETE FROM CTS_NOTAS WHERE NOTA='$nota'");
		return "Excluído com sucesso!";
     }
	 
	function localizador($id){
     	$sql = "DELETE FROM CTS_LOCALIZADORES WHERE ID='$id'";
     	if(ibase_query($this->c, $sql)) return "Excluído com sucesso!";
		else return "Erro!";     	
    }
	 
    function artigo($id){
     	$sql = "DELETE FROM AGA_ARTIGOS WHERE ID='$id'";
		if(ibase_query($this->c, $sql)) return "Excluído com sucesso!"; else return "Erro!";   	
    }
	 
    function fornecedor($codigo){
     	$sql = "DELETE FROM CTS_FORNECEDORES WHERE ID='$codigo'";
     	if(ibase_query($this->c, $sql)) return "Excluído com sucesso!";
     	else return "Erro!";     	
    }
	
     function grupo($id){
     	$sql = "DELETE FROM CTS_GRUPOS WHERE ID='$id'";
     	if(ibase_query($this->c, $sql)) return "Excluído com sucesso!";
     	else return "Erro!";     	
     }
	 
     function escola($id){
     	$sql = "DELETE FROM AGA_INSTITUICOES WHERE ID='$id'";
     	if(ibase_query($this->c, $sql)) return true;
     	else return false;     	
     }
	 
     function insumo($id){
     	$sql = "DELETE FROM AGA_INSUMOS WHERE ID='$id'";
     	if(ibase_query($this->c, $sql)) return "Excluído com sucesso!";
     	else return "Erro!";     	
     }
	 
     function insumoTipo($id){
     	$sql = "DELETE FROM AGA_INSUMOS_TIPOS WHERE ID='$id'";
     	if(ibase_query($this->c, $sql)) return true;
     	else return false;     	
     }
}