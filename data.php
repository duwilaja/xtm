<?php
$redirect=false;
include 'inc.common.php';
include 'inc.session.php';
include 'inc.db.php';

$conn = connect();

$code="200";
$ttl="OK";

$q=post('q',$conn);
$id=post('id',$conn,'0');

$sql="";

switch($q){
	case 'user': $sql="select * from xtm_users where rowid='$id'"; break;
	case 'cust': $sql="select * from xtm_customers where rowid='$id'"; break;
	case 'serv': $sql="select * from xtm_services where rowid='$id'"; break;
	case 'prob': $sql="select * from xtm_problems where rowid='$id'"; break;
	case 'ticket': $sql="select * from xtm_tickets where rowid='$id'"; break;
	
	case 'unitbarang': $sql="select priceunit,stockunit,saleunit from xtm_goods where rowid='$id'"; break;
	
}

//echo $sql;

if($sql==""){
	$code="404";
	$ttl="Error";
	$output="Query not found";
}else{
	$result = exec_qry($conn,$sql);
	if(db_error($conn)==''){
		$output = fetch_alla($result);
	}else{
		$output = db_error($conn);
		if($production){$output="System Error. Please contact admin.";}
		$ttl = "Error";
		$code= "505";
	}
}

disconnect($conn);

echo json_encode(array('code'=>$code,'ttl'=>$ttl,'msgs'=>$output));
?>