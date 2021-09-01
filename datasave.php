<?php
$redirect=false;

include 'inc.common.php';
include 'inc.session.php';
include 'inc.db.php';

$code='404';
$ttl='Error';
$msgs='Not found';

$conn = connect();

$mn=post('mn',$conn);

if($mn=='register'){
	$passwd=post('passwd');
	$email=post('email');
	$sql=sql_insert("users","name,email,company,phone",$conn,"passwd,lastupd","md5('$passwd'),now()");
	$rs=exec_qry($conn,$sql);
	if(db_error($conn)==''){
		$code='200'; $ttl='Success'; $msgs='Data saved';
	}else{
		$code='201'; $ttl='Failed'; $msgs="Email $email sudah terdaftar";
	}
}

if($mn=='chgpwd'){
	$code='200';
	$o=post('opass',$conn);
	$n=post('npass',$conn);
	$r=post('rpass',$conn);
	if($n!=$r){
		$code="220"; $ttl="Failed";
		$msgs="Please re type an equal new password";
	}
	if($o==''||$n==''){
		$code="210"; $ttl="Failed";
		$msgs="Current password and new password can not blank";
	}
	if($code=='200'){
		$tname=$s_ACCESS=='T'?"bltstok_stores":"xtm_users";
		$sql=sql_update($tname,"","user='$s_ID' and passwd=md5('$o')",$conn,"passwd","md5('$n')");
		$rs=exec_qry($conn,$sql);
		if(affected_row($conn)>0){
			$code='200'; $ttl='Success'; $msgs='Password changed';
		}else{
			$code='201'; $ttl='Failed'; $msgs="Invalid current password";
		}
	}
}

if($mn=='user'){
	$passwd=post('fpasswd',$conn);
	$fcols=$passwd==''?'':'passwd';
	$fvals=$passwd==''?'':"md5('$passwd')";
	$res=crud($conn,$fcols,$fvals);
	$code=$res[0]; $ttl=$res[1]; $msgs=$res[2];
}
if($mn=='cust'){
	$res=crud($conn);
	$code=$res[0]; $ttl=$res[1]; $msgs=$res[2];
}
if($mn=='serv'){
	$res=crud($conn);
	$code=$res[0]; $ttl=$res[1]; $msgs=$res[2];
}
if($mn=='prob'){
	$res=crud($conn);
	$code=$res[0]; $ttl=$res[1]; $msgs=$res[2];
}

if($mn=='ticket'){
	$f=""; $v="";
	$s=post("status"); $t=post('ticketno'); $n=post("lastnote");
	if($s=='solved'){$f="solvedon";$v="now()";}
	if($s=='closed'){$f="closedon";$v="now()";}
	
	$res=crud($conn,$f,$v);
	$code=$res[0]; $ttl=$res[1]; $msgs=$res[2];
}
if($mn=='ticketx'){
	$tn=date("YmdHis");
	
	$res=crud($conn,"rowid,ticketno,createdby,lastupdate,updatedby","'$tn','$tn','$s_ID',now(),'$s_ID'");
	$code=$res[0]; $ttl=$res[1]; $msgs=$res[2];
}

if($mn=='menu'){
	$up=upload_file("fpict","pict/");
	$sv=post('sv');
	$pict=$up[0]&&$up[1]!=''?$up[1]:post('pict');
	if($sv=='NEW'){
		$pict=$up[0]&&$up[1]!=''?$up[1]:'';
	}
	$res=crud($conn,"pict","'$pict'");
	$code=$res[0]; $ttl=$res[1]; $msgs=$res[2];
}
if($mn=='content'){
	$up=upload_file("fpict","pict/");
	$pdf=upload_file("ffile","docs/");
	$sv=post('sv');
	$pict=$up[0]&&$up[1]!=''?$up[1]:post('pict');
	if($sv=='NEW'){
		$pict=$up[0]&&$up[1]!=''?$up[1]:'';
	}
	$file=$pdf[0]&&$pdf[1]!=''?$pdf[1]:post('file');
	if($sv=='NEW'){
		$file=$pdf[0]&&$pdf[1]!=''?$pdf[1]:'';
	}
	$res=crud($conn,"pict,file","'$pict','$file'");
	$code=$res[0]; $ttl=$res[1]; $msgs=$res[2];
}


disconnect($conn);

echo json_encode(array('code'=>$code,'ttl'=>$ttl,'msgs'=>$msgs));
?>