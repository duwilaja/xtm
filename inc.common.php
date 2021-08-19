<?php
$production=false;

$app="TICKETING";
$sub="Silakan login menggunakan user dan password anda";
$sub="Ticketing System";
$foo="@SofwareHouse &copy;2021";
$ext=".php";

$footer=true;

date_default_timezone_set("Asia/Jakarta");

$o_access=array(
	array("U","User"),
	array("S","Super"),
	array("A","Admin")
);

$o_status=array(
	array("new","new"),
	array("pending","pending"),
	array("progress","progress"),
	array("solved","solved"),
	array("closed","closed")
);

/*common php functions*/
function getVal($k,$kv){
	$ret="";
	for($i=0;$i<count($kv);$i++){
		if($kv[$i][0]==$k) $ret=$kv[$i][1];
	}
	return $ret;
}
function options($kv){
	$ret="";
	for($i=0;$i<count($kv);$i++){
		$ret.='<option value="'.$kv[$i][0].'">'.$kv[$i][1].'</option>';
	}
	return $ret;
}
function multiple_select($f){
	$return="";
	for($i=0;$i<count($_POST[$f]);$i++){
		$return.=$return==""?"":";";
		$return.=$_POST[$f][$i];
	}
	return $return;
}
function breadcrumb($breadcrumb,$sep="/"){
	$ret='<ol class="breadcrumb float-sm-right">';
	$array=explode($sep,$breadcrumb);
	for($i=0;$i<count($array);$i++){
		$ret.='<li class="breadcrumb-item">'.$array[$i].'</a></li>';
	}
	$ret.='</ol>';
	return $ret;
}