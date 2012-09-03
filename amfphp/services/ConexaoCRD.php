<?

require_once "Object.php";

function c(){
	$_SESSION["con"] = ibase_connect("localhost:C:\Scuna\PREV2000\data\CREDIARIO.fdb","GERAL","160ahlzb");
	return $_SESSION["con"];
}

function fetch_assoc($sql){
	$r = array();
	$q = ibase_query(c(), $sql);
	while($a=ibase_fetch_assoc($q)){
		$o = new Object();
		$o->load($a);
		$r[] = $o->get_all();
	}
	return $r;
}

function fetch_assoc_simples($sql){
	$r = array();
	$q = ibase_query(c(), $sql);
	$a=ibase_fetch_assoc($q);
	$o = new Object();
	$o->load($a);
	$r = $o->get_all();
	return $r;
}

function executa($sql){
	ibase_query(c(), $sql);
}

?>