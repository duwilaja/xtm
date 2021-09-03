<?php
$redirect=false;
$datatable=true;

include 'inc.session.php';
include 'inc.common.php';
include 'inc.db.php';

$conn = connect();

$x=post("x",$conn,"");
$xtra=post("xtra",$conn);

if($x==""){
	$output = array(
          "draw"=>1,
          "recordsTotal"=>0, // total number of records 
          "recordsFiltered"=>0, // if filtered data used then tot after filter
          "data"=>array(),
		  "msgs"=>"X is blank"
        );
	echo json_encode($output);
	
	exit;
}
$where=base64_decode(post("where",$conn));
$tname=base64_decode(post("tname",$conn));
$cols=base64_decode(post("cols",$conn));
$csrc=base64_decode(post("csrc",$conn)); //global search like
$cseq=base64_decode(post("cseq",$conn)); //global search equal

$grpcol=base64_decode(post("grpcol",$conn));
$grpby=base64_decode(post("grpby",$conn));
$grpby=$grpby!=""?" group by $grpby":"";

$having=base64_decode(post("having",$conn));
$having=$having!=""?" having $having":"";

//filters
$where=get_params($where,$conn,explode(",",base64_decode(post("filtereq",$conn))),"=");
$where=get_params($where,$conn,explode(",",base64_decode(post("filtergt",$conn))),">");
$where=get_params($where,$conn,explode(",",base64_decode(post("filtergteq",$conn))),">=");
$where=get_params($where,$conn,explode(",",base64_decode(post("filterlt",$conn))),"<");
$where=get_params($where,$conn,explode(",",base64_decode(post("filterlteq",$conn))),"<=");
$where=get_params($where,$conn,explode(",",base64_decode(post("filterlike",$conn))),"like");
$where=get_params($where,$conn,explode(",",base64_decode(post("filterin",$conn))),"in");
$where=get_params($where,$conn,explode(",",base64_decode(post("filternotin",$conn))),"not in");

//specific param with col modif //todo more than 1 range in 1 page
$ranges=explode(",",post("ranges"));
$frange=post("frange");
if(count($ranges)>1){
$param=isset($_POST[$ranges[0]]) ? $_POST[$ranges[0]]:"";
	if($param!=""){
		$where=$where!=""?"$where and $frange>='$param'":"$frange>='$param'";
	}
$param=isset($_POST[$ranges[1]]) ? $_POST[$ranges[1]]:"";
	if($param!=""){
		$where=$where!=""?"$where and $frange<='$param'":"$frange<='$param'";
	}
}

/*tablename is tname plus where*/
$tablename=$tname;
if($where!=""){
	$tablename.=" where ($where)";
}

/*get field name*/
$result = exec_qry($conn,"select ".$cols." from ".$tablename." ".$grpby." limit 0");
$acol=array();
while($field = fetch_field($result)){
	$acol[]=$field->name;
}
$col=count($acol);

/*total record, use select count(), faster than recordcount from result*/
$sqlcount=$grpcol==""?"select count(*) as cntstar from $tablename":"select count(*) as cntstar from (select distinct $grpcol from $tablename) mytbl";
$result = exec_qry($conn,$sqlcount);
$iTotal = 0;
while($row=fetch_row($result)){
	$iTotal+=$row[0];
}
$iFilteredTotal = $iTotal;

/*limit*/
$draw = $_POST["draw"];
$limit="";
if ( isset($_POST['start']) && $_POST['length'] != -1 ) {
	$limit = "LIMIT ".intval($_POST['start']).", ".intval($_POST['length']);
}

/*global search*/
$str = $_POST["search"]["value"];
$search = "";
if($str!=""){
	if($csrc!=""){
		$acs=explode(",",$csrc);
		for($j=0;$j<count($acs);$j++){
			$search.=" or ".$acs[$j]." like '%".$str."%'";
		}
	}
	if($cseq!=""){
		$acseq=explode(",",$cseq);
		for($j=0;$j<count($acseq);$j++){
			$search.=" or ".$acseq[$j]." = '".$str."'";
		}
	}
	if($where==""){
		$search=" where (1=0".$search.")";
	}else{
		$search=" and (1=0".$search.")";
	}
}

/*individual column search*/
$totcols=count($_POST["columns"]);
$colsearch="";
for($i=0;$i<$totcols;$i++){
	$str=$_POST["columns"][$i]["search"]["value"];
	if($str!=""){
		$colsearch.=$colsearch==""?$acol[$i]." like '%$str%'":" and ".$acol[$i]." like '%$str%'";
	}
}
if($colsearch!=""){
	$search.=$search==""&&$where==""?" where ($colsearch)":" and ($colsearch)";
}

/*total record, after search*/
if($search!=""){
$sqlcount=$grpcol==""?"select count(*) as cntstar from $tablename $search":"select count(*) as cntstar from (select distinct $grpcol from $tablename $search) mytbl";
$result = exec_qry($conn,$sqlcount);
if($row=fetch_row($result)){
	$iFilteredTotal=$row[0];
}
}

/*sorting*/
$order="";
$ordercol=$_POST["order"][0]["column"];
$orderdir=$_POST["order"][0]["dir"];
if($ordercol<=$col){
	$order=" order by ".$acol[$ordercol]." ".$orderdir;
}

/*construct sql, exec and build output*/
$sql = "select ".$cols." from ". $tablename ." ".$search." ".$grpby." ".$having." ".$order." ".$limit;
//echo $sql;

$result = exec_qry($conn,$sql);

$output = array(
          "draw"=>$draw,
          "recordsTotal"=>$iTotal, // total number of records 
          "recordsFiltered"=>$iFilteredTotal, // if filtered data used then tot after filter
          "data"=>array(),
		  "msgs"=>""
        );
if(!$production){ $output["msgs"] = $sql;} //debug for dev

$i=0;
$xx="";
$tcol=$col>0?$col-1:$col;
while($row = fetch_row($result)){
	$i++;
	
	if($x=='lapor'){
		$lnk = '<a title="edit" href="JavaScript:;" data-fancybox data-type="iframe" data-src="print.php?xtra='.$xtra.'&id='.$row[$tcol].'">'.$row[0].'</a>';
		$row[0]=$lnk;
		$xx='-';
	}
	
	if($x!='-'&&$xx!='-'){
		$lnk = '<a title="edit" href="JavaScript:openForm(\''.$x.'\',\''.$row[$tcol].'\');">'.$row[0].'</a>';
		$row[0] = $lnk;
	}
	
	$output["data"][] = $row ;
}

disconnect($conn);

echo json_encode( $output );
?>