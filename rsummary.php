<?php
$restrict_grp=array("S","A");

include 'inc.common.php';
include 'inc.session.php';

$ptitle="Summary";
$mn="rpt-sum";

$breadcrumb="Home/Reports/$ptitle";

include "inc.db.php";
/*
$conn=connect();

$rs=exec_qry($conn,"select custid,custname from xtm_customers order by custname");
$cust=fetch_all($rs);

$rs=exec_qry($conn,"select servid,servname from xtm_services order by servname");
$serv=fetch_all($rs);

$rs=exec_qry($conn,"select probid,probname from xtm_problems order by probname");
$prob=fetch_all($rs);

disconnect($conn);
*/

$o_grpby=array(
	array(base64_encode("status as label,count(rowid) as data"),"by status"),
	array(base64_encode("date(calltime) as label,count(rowid) as data"),"by date"),
	array(base64_encode("problem as label,count(rowid) as data"),"by problem"),
	array(base64_encode("customer as label,count(rowid) as data"),"by customer"),
	array(base64_encode("service as label,count(rowid) as data"),"by service"),
);
$o_chart=array(
	array('pie','pie'),
	array('bar','bar'),
	array('line','line')
);

include 'inc.head.php';
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
		<div class="content-header">
		  <div class="container">
			<div class="row">
			  <div class="col-sm-6">
				<h1 class="m-0 text-dark"> <?php echo $ptitle?></h1>
			  </div><!-- /.col -->
			  <div class="col-sm-6">
				<?php echo breadcrumb($breadcrumb)?>
			  </div><!-- /.col -->
			</div><!-- /.row -->
		  </div><!-- /.container-fluid -->
		</div>
    <div class="content">
      <div class="container">
		<div class="row">
			<div class="col-2"><label>From</label><input type="text" id="df" class="form-control datepicker"></div>
			<div class="col-2"><label>To</label><input type="text" id="dt" class="form-control datepicker"></div>
			<div class="col-2"><label>Grouping</label><select id="grpby" class="form-control"><?php echo options($o_grpby)?></select></div>
			<div class="col-2"><label>Chart</label><select id="chart" class="form-control"><?php echo options($o_chart)?></select></div>
			<div class="col-2">&nbsp;<br /><button class="btn btn-primary" onclick="reloadtbl();"><i class="fa fa-search"></i></button></div>
		</div>
		<br />
		<div class="row">
          <div class="col-md-5">
            <div class="card">
			  <div class="card-body table-responsive">
                
				<table id="example" class="table table-bordered table-stripped table-hover">
                <thead>
					<tr>
					  <th class="grpby"></th>
					  <th>Total</th>
					</tr>
                </thead>
                <tbody>
				</tbody>
				</table>
				
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
			<div class="col-md-7">
				<div class="card">
				  <div class="card-header border-0">
					<div class="d-flex justify-content-between">
					  <h3 class="card-title">Chart</h3>
					</div>
				  </div>
				  <div class="card-body">
					<div class="position-relative mb-4">
					  <canvas id="my-chart" height="250"></canvas>
					</div>
				  </div>
				</div>
				<!-- /.card -->
			</div> 
			<!-- /.col -->
        </div>
        <!-- /. row -->
      </div><!-- /.container-fluid -->
	  
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<?php
include 'inc.js.php';

$tname="xtm_tickets";
$cols="ticketno,calltime,customer,service,detail,status,lastnote,lastupdate,updatedby,createdon,solvedon,closedon,rowid";
$grpby="label";
$where="";
?>

<script>
var mytbl, jvalidate, mych;
$(document).ready(function(){
	mych=null;
	
	$(".datepicker").daterangepicker({
		singleDatePicker: true,
		timePicker: false,
		timePicker24Hour: false,
		locale: {
		  format: 'YYYY-MM-DD'
		}
	});
	
	
	mytbl = $('#example').DataTable({
		buttons:[  'copy', 'csv'],
		//dom: "lrftBip",
		processing: true,
		serverSide: true,
		searching: false,
		order: [[0,"asc"]],
		ajax: {
			type: 'POST',
			url: 'datatable<?php echo $ext?>',
			data: function (d) {
				d.grpby= '<?php echo base64_encode($grpby); ?>',
				d.tname= '<?php echo base64_encode($tname); ?>',
				d.where= '<?php echo base64_encode($where); ?>',
				d.cols=$('#grpby').val(),
				d.frange='date(calltime)',
				d.ranges='df,dt',
				d.df=$('#df').val(),
				d.dt=$('#dt').val(),
				d.x= '-'
			}
		},
		initComplete: function () {
                mytbl.buttons().container()
                    .appendTo( '#example_wrapper .col-md-6:eq(1)' );
				$( '.btn-group' ).css("float","right");
            },
		drawCallback: function(){
			getchart(mytbl.data());
		}
	});
	
	$(".grpby").text('Group '+$( "#grpby option:selected" ).text());
});
function reloadtbl(){
	mytbl.ajax.reload();
	$(".grpby").text('Group '+$( "#grpby option:selected" ).text());
}
function getchart(data){		
	if(mych!=null){
		mych.destroy();
	}
	var chart=$("#chart").val();
	var datas=[];
	for(var i=0;i<data.length;i++){
		var obj={label:'Total', data:data[i][1], axis: data[i][0]};
		datas.push(obj);
	}
	switch(chart){
		case "pie": mych=pie('#my-chart',datas); break;
		case "bar": mych=series('#my-chart','bar',['Total'],[],datas); break;
		case "line": mych=series('#my-chart','line',['Total'],[],datas); break;
	}
	
}
</script>

</body>
</html>
