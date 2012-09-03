<?php

//require_once "MeiService.php";

//require_once "MarcacaoService.php";
//require_once "FornecedorService.php";
//require_once "ProdutoService.php";
require_once "ProdutoEstService.php";
//require_once "ComboService.php";
//require_once "IndiceService.php";
//require_once "InsumoService.php";
//require_once "LoteService.php";
//require_once "ContaService.php";

//$in = new MeiService();
//$in = new LoteService();
//$in = new FornecedorService();
//$in = new ContaService();
//$in = new InsumoService();
//$in = new ProdutoService();
$in = new ProdutoEstService();
//$in = new ComboService();
//$in = new IndiceService();

//$in->inserir(array('ESCOLA'=>31,'ARTIGO'=>10,'INSUMOS'=>array(0=>array('ID'=>300,'DESCRICAO'=>'insumo 1'),1=>array('ID'=>301,'DESCRICAO'=>'insumo 2'))));
//print_r($in->listar(1,8,''));
//print_r($in->departamento());
print_r($in->atualizar());
//print_r($in->processar(array("DE_MES"=>"05/2012","PARA_MES"=>"06/2012")));
//print_r($in->processar(array("DE_MES"=>"08/2012","PARA_MES"=>"09/2012")));
//print_r($in->cadastrar(array("CODIGO"=>3338,"RAZAO"=>"FABIO","NOME_FANTASIA"=>"FABIO",
//"CNPJ"=>"","IE"=>"","DATA_CAD"=>"12/05/2012","ENDERECO"=>"","BAIRRO"=>"","MUNICIPIO"=>"","UF"=>"","CEP"=>"","FONE"=>"","FAX"=>"",
//"CONTATO"=>"","REPRESENTANTE"=>"","FONE_REPRES"=>"","MENSAL"=>"S", "EMAIL" => "FABIO@FABIOPALHANO.COM.BR", "SITE" => "WWW.FABIOPALHANO.COM.BR")));
//$produtos = array(0=>array("ESCOLA"=>"500","ARTIGO"=>"10"),1=>array("ESCOLA"=>"514","ARTIGO"=>"10"),2=>array("ESCOLA"=>"514","ARTIGO"=>"11"));
//$lote = array("ID"=>"0","ID2"=>"0","DESCRICAO"=>"TESTE","PRODUTOS"=>$produtos);
//print_r($in->editar(array("ID"=>1,"ID2"=>1,"DESCRICAO"=>'MALHA 100%POLIESTER BRANCA(08).',"TIPO"=>1,"DATA"=>'24/04/2011',"PRECO"=>'22.40',"PRAZO"=>56)));
//print_r($in->produto(0));
//print_r($in->imprimirListagem(array("DATA_INICIAL"=>"01/03/2012","DATA_FINAL"=>"31/03/2012","TEXTO"=>"")));
//print_r($in->copiar(array("ESCOLA_ORIGEM"=>571,"ARTIGO_ORIGEM"=>10,"ESCOLA_DESTINO"=>0,"ARTIGO_DESTINO"=>0)));
//print_r($in->cadastrar(array("ID"=>0,"DESCRICAO"=>"TESTE","TIPO"=>5,"DATA"=>"08/05/2012","PRECO"=>'26.50',"PRAZO"=>56)));
//print_r($in->editar(array("ESCOLA"=>571,"ARTIGO"=>10,"INSUMO"=>120,"DOIS"=>1,"QUATRO"=>1,"SEIS"=>1,"OITO"=>1,"DEZ"=>1,"DOZE"=>1,"QUATORZE"=>1,"DEZESSEIS"=>1,"P"=>1,"M"=>1,"G"=>1,"XG"=>1)));
//$p = array();
//$p[ESCOLA]=501;
//$p[ARTIGO]=10;
//$p[INSUMO]=109;
//$p[QUATRO]='0.450';
//$p[SEIS]='0.470'; 
//$p[OITO]='0.490';
//$p[DEZ]='0';
//$p[DOZE]='0.540';
//$p[QUATORZE]='0';
//$p[DEZESSEIS]='0';
//$p[P]='0';
//$p[M]='0';
//$p[G]='0';
//$p[XG]='0';
//print_r($in->editar($p));
//$in = new FornecedorService();
//print_r($in->procurar('nunes'));
//print_r($in->listar('fabio','',''));
//print_r($in->parcela('D POUP'));
//print_r($in->cadastrar(array(CODIGO=>0,RAZAO=>B,NOME_FANTASIA=>C,CNPJ=>D,IE=>E,DATA_CAD=>date('Y-m-d'),ENDERECO=>0,BAIRRO=>F,MUNICIPIO=>G,UF=>H,CEP=>1,FONE=>K,FAX=>L,CONTATO=>M,REPRESENTANTE=>N,FONE_REPRES=>O)));
//print_r($in->procurar(''));
//print_r($in->editar('1','1','MASH INDUSTRIA E COMERCIO LTDA','MASH','03.125.730/0001-07','11542330111','12/05/2012','AV MARECHAL TITO 6829','ITAIM BIBI','SAO PAULO','SP','08115-100','11 2571-9180','','','',''));
/*$c=array("DATA_LANCTO"=>"20/04/2012",
		 "NOTA"=>"TESTE",
		 "HISTORICO"=>"",
		 "OBSERVACAO"=>"",
		 "DATA_NOTA"=>"20/04/2012",
		 "FORNECEDOR"=>"1021",
		 "LOCALIZADOR"=>"0",
		 "GRUPO"=>"8",
		 "PARCELAS"=>
					 array(0=>array("NOTA"=>"TESTE","VALOR"=>"100","PARCELA"=>"1","DATA_VENCTO"=>"21/04/2012","FORNECEDOR"=>"1021"),
						   1=>array("NOTA"=>"TESTE","VALOR"=>"200","PARCELA"=>"2","DATA_VENCTO"=>"22/04/2012","FORNECEDOR"=>"1021"),
						   2=>array("NOTA"=>"TESTE","VALOR"=>"300","PARCELA"=>"3","DATA_VENCTO"=>"23/04/2012","FORNECEDOR"=>"1021")
					 )
		 );
print_r($in->cadastrar($c));*/
//echo "ok";
//print_r($in->gerarRelatorioCorte('10'));
//$a[0][ID] = 40;
//$b[0][ID] = 178;
//$tmp = array("501-1"=>true,"561-10"=>true);
//print_r($in->cadastrar(30,'TESTE3',$tmp));
//print_r($in->excluirTudo());
//print_r($in->editar(array("escola" => "500", "artigo" => "10", "insumo" => "182", "dois" => "-----", "quatro" => "-----", "seis" => "0.090", "oito" => "0.100", "dez" => "0.110", "doze" => "0.120", "quatorze" => "0.132", "dezesseis" => "0.138", "p" => "0.149", "m" => "0.164", "g" => "0.176", "xg" => "0.185")));
//print_r($in->listarMarcacao('10','8'));
//print_r($in->marcar('501','2','8','0','0','0','0','0','0','0','0','0','0','19','0'));
//print_r($in->cadastrar('501','1','200','1','1','500','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1','1'));
//print_r($in->cadastrar(509,0,0,0,0,0,1,0,0,0,0,0,0,0,'teste'));
//print_r($in->gerarRelatorio('milagres'));
echo "<BR>teste";
//echo "<BR><BR><BR>OK<BR><BR><BR>";
//print_r($in->listarEscolas());

?>