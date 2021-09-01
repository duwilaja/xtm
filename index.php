<?php
include 'inc.common.php';
include 'inc.db.php';
$user=post('user');
$passwd=post('passwd');
$loggedin=false;
$m=get('m');
$x=get('x')==''?'App':get('x');
$footer=false;

if($user!=''&&$passwd!=''){
	$conn=connect();
	$sql="select user, name, access from xtm_users where (user='$user') and (passwd=MD5('$passwd'))";
	$rs = exec_qry($conn,$sql);
	if ($row = fetch_row($rs)) {
		session_start();
		
		$_SESSION['s_ID'] = $user;
		$_SESSION['s_NAME'] = $row[1];
		$_SESSION['s_ACCESS'] = $row[2];
		
		$loggedin=true;
	}
	disconnect($conn);
}
if($loggedin){
	header("Location: home.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $app?> : Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  
  <style type="text/css">
	.help-block{
		font-size: 12px;
		color: red;
	}
	.bg {
	  background-image: url('sembako.jpg');
	  background-repeat: no-repeat;
	  background-attachment: fixed;
	  background-size: cover;
	  opacity: 0.12;
	  position: absolute;
	  width: 100%;
	  height: 100%;
	}
  </style>
  
  
</head>
<body class="hold-transition login-page">
<div class="bg"></div>
<div class="login-box" style="margin-top:0;opacity:1;">
  <div class="login-logo">
	<img src="AdminLTELogo.png" style="height:70px;" /><br />
    <a href="#"><b><?php echo $app?></b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg"><?php echo $sub?></p>

      <form method="post" id="myf" action="">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="User" name="user" id="user" value="<?php echo $user?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="passwd" id="passwd">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Log In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

	  <br />
      <!--p class="mb-2">
        <a href="#" data-toggle="modal" data-target="#modal_password">Lupa password</a>
      </p>
      <p class="mb-2">
        <a href="register.php" class="text-center">Pendaftaran pengguna baru</a>
      </p-->
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

	  <div class="modal fade" id="modal_password">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Forgot Password</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
				<form id="lp">
                <div class="input-group mb-3">
				  <input type="email" class="form-control" placeholder="Email" name="xemail" id="xemail">
				  <div class="input-group-append">
					<div class="input-group-text">
					  <span class="fas fa-envelope"></span>
					</div>
				  </div>
				</div>
				</form>
            </div>
			<div class="modal-footer">
              <button type="button" onclick="if($('#lp').valid()){modal('Reset Password','Sedang dalam pengembangan');}" class="btn btn-primary">Send</button>
            </div>
          </div>	
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->


<?php
include 'inc.js.php';
?>

<script>
var mytbl, jvalidate, jvalidate2;
$(document).ready(function() {
	jvalidate = $("#myf").validate({
    rules :{
        "passwd" : {
            required : true
        },
		"user" : {
            required : true
        }
    }});
	jvalidate2 = $("#lp").validate({
    rules :{
		"xemail" : {
            required : true
        }
    }});
	<?php if($m!=''){?>
	modal('<?php echo $x?>','<?php echo $m?>');
	<?php }?>
});
</script>

</body>
</html>
