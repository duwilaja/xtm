<?php
session_start();

$s_ID = isset($_SESSION['s_ID'])? $_SESSION['s_ID'] : "";
$s_NAME = isset($_SESSION['s_NAME'])? $_SESSION['s_NAME'] : "";
$s_ACCESS = isset($_SESSION['s_ACCESS'])? $_SESSION['s_ACCESS'] : "";

$redir=isset($redirect)?$redirect:true;
$dttbl=isset($datatable)?$datatable:false;
$noformat=isset($cleartext)?$cleartext:false;

if($s_ID==""){
	if($redir){//default redirect to login
		header("Location: index$ext?x=error&m=Please login.");
	}else{
		if($noformat){ // redirect=false and clear text return
			echo "Session Expired. Please Login";
		}else{
			if($dttbl){ // no session and datatable call
				$output = array(
				  "draw"=>1,
				  "recordsTotal"=>0, // total number of records 
				  "recordsFiltered"=>0, // if filtered data used then tot after filter
				  "data"=>array(),
				  "msgs"=>"Session expired"
				);
				echo json_encode($output);
			}else{ // default return if redirect is false
				echo json_encode(array('code'=>"403",'ttl'=>"Error",'msgs'=>"Session Expired. Please Login"));
			}
		}
		exit;
	}
}//end if

if(isset($restrict_grp)){
	if($s_ACCESS!=""){
		if(!in_array($s_ACCESS,$restrict_grp)){
			header("Location: error$ext?m=You are not alowed to access this page.");
		}
	}
}
