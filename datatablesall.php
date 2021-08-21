<?php
include 'inc.db.php';
include 'inc.common.php';

$conn = connect();

$x=post("x",$conn);
$columns=base64_decode(post("cols",$conn));
$where=base64_decode(post("where",$conn));
$tablename=base64_decode(post("tname",$conn));

$grpby=base64_decode(post('grpby',$conn));
$grpby=$grpby!=""?" group by $grpby":"";

$having=base64_decode(post('having',$conn));
$having=$having!=""?" having $having":"";

$tcol=0;//count(explode(',',$columns))-1;

//standard param
$params=explode(",","");
for($i=0;$i<count($params);$i++){
	$param=post($params[$i],$conn);
	if($param!=""){
		$where=$where!=""?"$where and ".$params[$i]."='$param'":$params[$i]."='$param'";
	}
}

//$df=date('Y-m-d 00:00:00');
//$dt=date('Y-m-d 23:59:59');

$param=post('df',$conn);
	if($param!=""){
		$where=$where!=""?"$where and dtm>='$param'":"dtm>='$param'";
		//$df=$param.' 00:00:00';
	}
$param=post('dt',$conn);
	if($param!=""){
		$where=$where!=""?"$where and dtm<='$param'":"dtm<='$param'";
		//$dt=$param." 23:59:59";
		//if($param==date('Y-m-d')) { $dt=date('Y-m-d H:i:s'); }
	}

if($where!=""){
	$tablename.=" where ($where)";
}

$sql = "select ".$columns." from ". $tablename ." ".$grpby.$having;
//echo $sql;
$result = exec_qry($conn,$sql);
$rows = fetch_all($result);
if(count($rows)>0) $tcol=count($rows[0])-1;
$xx='';
for($i=0;$i<count($rows);$i++){
	//if($x=='x'){
	//	$lnk = '<a title="edit" href="JavaScript:;" data-fancybox data-type="iframe" data-src="frm.php?id='.$rows[$i][$tcol].'">'.$rows[$i][0].'</a>';
	//}
	
	if($x=="mingguan"){
		$lnk = '<a class="btn btn-icon btn-primary" title="buka laporan" href="JavaScript:;" data-fancybox data-type="iframe" data-src="print.php?pokok=1&dt='.base64_encode($rows[$i][0]).'"><i class="fas fa-search"></i></a>';
		$rows[$i][1]=$lnk;
		$lnk = '<a class="btn btn-icon btn-primary" title="buka laporan" href="JavaScript:;" data-fancybox data-type="iframe" data-src="print.php?pokok=0&dt='.base64_encode($rows[$i][0]).'"><i class="fas fa-search"></i></a>';
		$rows[$i][2]=$lnk;
		$xx='-';
	}
	if($x=="bulanan"){
		$lnk = '<a class="btn btn-icon btn-primary" title="buka laporan" href="JavaScript:;" data-fancybox data-type="iframe" data-src="print.php?pokok=1&dt=&m='.$rows[$i][2].'&y='.$rows[$i][3].'"><i class="fas fa-search"></i></a>';
		$rows[$i][1]=$lnk;
		$lnk = '<a class="btn btn-icon btn-primary" title="buka laporan" href="JavaScript:;" data-fancybox data-type="iframe" data-src="print.php?pokok=0&dt=&m='.$rows[$i][2].'&y='.$rows[$i][3].'"><i class="fas fa-search"></i></a>';
		$rows[$i][2]=$lnk;
		$xx='-';
	}
	
	if($x!='-'&&$xx!='-'){
		$lnk = '<a title="edit" href="JavaScript:openForm(\''.$x.'\',\''.$rows[$i][$tcol].'\');">'.$rows[$i][0].'</a>';
		$rows[$i][0] = $lnk;
	}
}

disconnect($conn);

echo json_encode(array("data"=>$rows));
?>