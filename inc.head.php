<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo isset($ptitle)? $app .' - '. $ptitle : $app?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  
  <link rel="stylesheet" href="plugins/jquery-fancybox/jquery.fancybox.min.css">
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
  
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
   integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
   crossorigin=""/>
   
   <!-- Make sure you put this AFTER Leaflet's CSS -->
 <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"
   integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
   crossorigin=""></script>
  
  <style type="text/css">
	/*.layout-navbar-fixed .wrapper .content-wrapper {
		margin-top: calc(3.5rem + 1px);
	}*/
	.sidebar-light-primary .nav-sidebar > .nav-item > .nav-link.active {
		background-color: rgba(0,0,0,0.1);
		color: #000;
	}
	.help-block{
		font-size: 12px;
		color: red;
	}
	.center{
		text-align: center;
	}
	.right{
		text-align: right;
	}
	.hidden{
		display: none;
	}
	.form-group {
		margin-bottom: 0.25rem;
	}
	.btn-app{
		margin: 0px;
		margin-top: 10px;
		width: 110px;
		height: 110px;
		padding: 5px;
	}
	.btn-menu{
		width: 80px;
		height: 80px;
	}
	.modal{
		overflow-y: auto;
	}
	.modal-title{
		line-height: 1;
	}
	.col-form-label{
		font-weight: 100;
	}
	label:not(.form-check-label):not(.custom-file-label){
		font-weight: 100;
	}
	.fancybox-slide--iframe .fancybox-content{
		max-height: 100%;
		max-width: 100%;
		min-height: 100%;
		min-width: 100%;
		width: 100%;
		height: 100%;
		margin: 0;
	}
	
	  /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      .map {
        height: 500px;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
  </style>
  
</head>
<!--body class="hold-transition layout-top-nav layout-navbar-fixed"-->
<body class="sidebar-mini sidebar-collapse">
<div class="wrapper">
<?php
include "inc.menuside.php";
?>      
