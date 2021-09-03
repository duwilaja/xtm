<?php
function connect(){
   $connection_id = mysqli_connect('localhost', 'root', '', 'xtm');
//$connection_id = mysqli_connect('localhost', 'id6050445_laundry', 'laundry', 'id6050445_laundry');

   if (!$connection_id) {
      die('Connect Error (' . mysqli_connect_errno() . ') '. mysqli_connect_error());
   }
   return $connection_id;
}
function disconnect($connection_id){
   return mysqli_close($connection_id);
}
function db_error($connection_id){
   return mysqli_error($connection_id);
}
function errno($connection_id){
   return mysqli_errno($connection_id);
}
function exec_qry($connection_id,$str_query,$debug=false){
	$res=mysqli_query($connection_id,$str_query);
	if($debug&&db_error($connection_id)!=""){echo db_error($connection_id).$str_query;}
   return $res;
}
function release_qry($result_set){
   return mysqli_free_result($result_set);
}
function fetch_all($result_set){
	$return=array();
	while($row=fetch_row($result_set)){
		$return[]=$row;
	}
   return $return;
}
function fetch_alla($result_set){
	$return=array();
	while($row=fetch_assoc($result_set)){
		$return[]=$row;
	}
   return $return;
}
function fetch_row($result_set){
   return mysqli_fetch_row($result_set);
}
function fetch_assoc($result_set){
   return mysqli_fetch_assoc($result_set);
}
function num_row($result_set){
   return mysqli_num_rows($result_set);
}
function num_field($connection_id){
   return mysqli_field_count($connection_id);
}
function affected_row($connection_id){
   return mysqli_affected_rows($connection_id);
}
function esc_str($database,$string){
   return mysqli_escape_string($database,$string);
}
function fetch_field($result_set){
   return mysqli_fetch_field($result_set);
}

function post($field,$theconn=null,$def=''){
	$return = isset($_POST[$field])?$_POST[$field]:$def;
	return $theconn==null?$return:esc_str($theconn,$return);
}
function get($field,$theconn=null,$def=''){
	$return = isset($_GET[$field])?$_GET[$field]:$def;
	return $theconn==null?$return:esc_str($theconn,$return);
}

function sql_insert($table,$columns,$conn=null,$fcols="",$fvals=""){
	$sql="";
	$afcols = explode(",",$fcols);
	$afvals = explode(",",$fvals);
	$acols = explode(",",$columns);
	
		for($i=0;$i<count($acols);$i++){
			$sql.=$sql==""?"":",";
			$val=post($acols[$i],$conn);
			$sql.="'".$val."'";
		}
		
		$columns.=$fcols==""?"":",$fcols";
		$sql.=$fvals==""?"":",$fvals";
		$sql="insert into $table ($columns) values ($sql)";
	
	return $sql;
}
function sql_update($table,$columns,$where,$conn=null,$fcols="",$fvals=""){
	$sql="";
	$w = $where==""?" where 1=0 ":" where $where"; //prevent update all without filter
	$afcols = explode(",",$fcols);
	$afvals = explode(",",$fvals);
	$acols = explode(",",$columns);
		
		for($i=0;$i<count($acols);$i++){
			if(isset($_POST[$acols[$i]])){
				$sql.=$sql==""?"":",";
				$sql.=$acols[$i]."='".post($acols[$i],$conn)."'";
			}
		}
		for($i=0;$i<count($afcols);$i++){
			$sql.=$sql!=""&&$afcols[$i]!=""?",":"";
			$sql.=$afcols[$i]==""?"":$afcols[$i]."=".$afvals[$i]."";
		}
		
		$sql="update $table set $sql $w";
	
	return $sql;
}
function sql_delete($table,$where){
	$sql="";
	$w = $where==""?" where 1=0 ":" where $where"; //prevent delete all without filter
	$sql="delete from $table $w";
	
	return $sql;
}

function upload_file($fileinput,$dir="/tmp/",$filename="",$replace=true){
		$flag = true;
		$text = "";
		if(isset($_FILES[$fileinput])&&is_uploaded_file($_FILES[$fileinput]['tmp_name'])){
			$file_name = $filename==""? basename($_FILES[$fileinput]['name']) : $filename. ".". pathinfo($_FILES[$fileinput]['name'], PATHINFO_EXTENSION);;
			$file_path = $dir .  $file_name;
			$dosave=false;
			if(file_exists($file_path)){
				if($replace){
					unlink($file_path);
					$dosave=true;
				}else{
					$flag = false;
					$text = "File already exist";
				}
			}else{
				$dosave=true;
			}
			if($dosave){
				if(move_uploaded_file($_FILES[$fileinput]['tmp_name'], $file_path)) {
					$text = $file_name;
				}else{
					$flag = false;
					$text = "Moving file failed";
				}
			}
		}
		return array($flag,$text);
}

function crud($conn=null,$fcols='',$fvals='',$where=''){
	$msg='no connection';
	$cod='202'; $t='Error';
	if($conn!=null){
		$sql=''; $rowid=post('rowid',$conn,'0'); $sv=post('sv');
		$tname=post('tname',$conn); $cols=post('cols',$conn);
		$where=$where==''?"rowid='$rowid'":" and rowid='$rowid'";
		if($sv=='NEW'){
			$sql=sql_insert($tname,$cols,$conn,$fcols,$fvals);
		}
		if($sv=='UPD'){
			$sql=sql_update($tname,$cols,$where,$conn,$fcols,$fvals);
		}
		if($sv=='DEL'){
			$sql=sql_delete($tname,$where);
		}
		if($sql==''){
			$msg='wrong flag';
		}else{
			$rs=exec_qry($conn,$sql);
			$msg=db_error($conn);
		}
	}
	if($msg==''){
		$msg=$sv=='DEL'?"Data deleted":"Data saved";
		$cod='200'; $t='Success';
	}
	return array($cod,$t,$msg);
}

function get_params($where,$conn,$params,$sign){
	for($i=0;$i<count($params);$i++){
		$param=post($params[$i],$conn);
		if($param!=""){
			switch($sign){
				case "not in" : $param=implode("','",explode(",",$param));
						$where=$where!=""?"$where and ".$params[$i]." $sign ('$param')":$params[$i]." $sign ('$param')"; break;
				case "in" : $param=implode("','",explode(",",$param));
						$where=$where!=""?"$where and ".$params[$i]." $sign ('$param')":$params[$i]." $sign ('$param')"; break;
				case "like" : $where=$where!=""?"$where and ".$params[$i]." $sign '%$param%'":$params[$i]." $sign '%$param%'"; break;
				default : $where=$where!=""?"$where and ".$params[$i]." $sign '$param'":$params[$i]." $sign '$param'"; break;
			}
		}
	}
	return $where;
}
