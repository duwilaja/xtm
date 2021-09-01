<?php
//$restrict_grp=array("S","A");

include 'inc.common.php';
include 'inc.session.php';
include 'inc.head.php';
include 'inc.menu.php';

$ptitle="Dashboard";
$breadcrumb="Home/$ptitle";
$mn="home";
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    	<div class="content-header">
		  <div class="container">
			<div class="row mb-2">
			  <div class="col-sm-6">
				<h1 class="m-0 text-dark"> <?php echo $ptitle?></h1>
			  </div><!-- /.col -->
			  <div class="col-sm-6">
				<?php echo breadcrumb($breadcrumb)?>
			  </div><!-- /.col -->
			</div><!-- /.row -->
		  </div><!-- /.container-fluid -->
		</div>
	<div id="content">
		<div class="container">
			<div class="row">

			  <div class="col-12 col-sm-6 col-md-3">
				<div class="info-box">
				  <span class="info-box-icon bg-info elevation-1"><i class="fas fa-sun"></i></span>

				  <div class="info-box-content">
					<span class="info-box-text">New</span>
					<span class="info-box-number new-t">0</span>
				  </div>
				  <!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			  </div>
			  <!-- /.col -->
			  <div class="col-12 col-sm-6 col-md-3">
				<div class="info-box mb-3">
				  <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

				  <div class="info-box-content">
					<span class="info-box-text">Solved</span>
					<span class="info-box-number solved-t">0</span>
				  </div>
				  <!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			  </div>
			  <!-- /.col -->

			  <!-- fix for small devices only -->
			  <div class="clearfix hidden-md-up"></div>

			  <div class="col-12 col-sm-6 col-md-3">
				<div class="info-box mb-3">
				  <span class="info-box-icon bg-success elevation-1"><i class="fas fa-clock"></i></span>

				  <div class="info-box-content">
					<span class="info-box-text">Progress</span>
					<span class="info-box-number progress-t">0</span>
				  </div>
				  <!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			  </div>
			  <!-- /.col -->
			  <div class="col-12 col-sm-6 col-md-3">
				<div class="info-box mb-3">
				  <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-hourglass-end"></i></span>

				  <div class="info-box-content">
					<span class="info-box-text">Pending</span>
					<span class="info-box-number pending-t">0</span>
				  </div>
				  <!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			  </div>
			  <!-- /.col -->
			
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="card">
					  <div class="card-header border-0">
						<div class="d-flex justify-content-between">
						  <h3 class="card-title">Daily Ticket</h3>
						</div>
					  </div>
					  <div class="card-body">
						<div class="position-relative mb-4">
						  <canvas id="daily-chart" height="250"></canvas>
						</div>
					  </div>
					</div>
					<!-- /.card -->
				</div> 
				<!-- /.col -->
				<div class="col-md-4">
					<div class="card">
					  <div class="card-header border-0">
						<div class="d-flex justify-content-between">
						  <h3 class="card-title">Problems</h3>
						</div>
					  </div>
					  <div class="card-body">
						<div class="position-relative mb-4">
						  <canvas id="pie-chart" height="250"></canvas>
						</div>
					  </div>
					</div>
					<!-- /.card -->
				</div> 
				<!-- /.col -->
			</div>
			<!-- /.row -->

		</div>
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<?php
include 'inc.js.php';
?>

<script>
var mypie,myday;
$(document).ready(function(){
	getwidget();
	getpie();
	getdaily();
});
function getwidget(){		
	$.ajax({
		type: 'POST',
		url: 'data<?php echo $ext?>',
		data: {q:'homewidget'},
		success: function(data){
				var json=JSON.parse(data);
				for(var i=0;i<json['msgs'].length;i++){
					  $('.'+json['msgs'][i]['label']+'-t').html(json['msgs'][i]['data']);
				  }
			},
		error: function(xhr){
				log(xhr);
			}
	});
}
function getpie(){		
	$.ajax({
		type: 'POST',
		url: 'data<?php echo $ext?>',
		data: {q:'homepie'},
		success: function(data){
				var json=JSON.parse(data);
				mypie=pie('#pie-chart',json['msgs']);
			},
		error: function(xhr){
				log(xhr);
			}
	});
}
function getdaily(){		
	$.ajax({
		type: 'POST',
		url: 'data<?php echo $ext?>',
		data: {q:'homedaily'},
		success: function(data){
				var json=JSON.parse(data);
				myday=series('#daily-chart','bar',['Total'],[],json['msgs']);
			},
		error: function(xhr){
				log(xhr);
			}
	});
}
</script>

</body>
</html>
