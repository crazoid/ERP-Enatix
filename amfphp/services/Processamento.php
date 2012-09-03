<?php

require_once "Conexao.php";
require_once "Funcoes.php";

class Processamento
{	
	function Processamento() { }
	
	function criarArquivo($obj){ 		
		$fp = fopen("1368.txt", "w");
		foreach($obj as $k=>$v){
			$texto = $v[codigo].",".$v[data].",".$v[nome_fiscal].",".$v[observacao].",".$v[farmacia].",".$v[farmaceutico].",".$v[infracao]."\r\n";
			$escreve = fwrite($fp, $texto);
		}
		return "Arquivo criado com sucesso!";
	}
}