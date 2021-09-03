<?php
$restrict_grp=array("S","A");

include 'inc.common.php';
include 'inc.session.php';

$ptitle="Ticket";
$mn="rpt-tick";

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
			<div class="col-md-2"><label>From</label><input type="text" id="df" class="form-control datepicker"></div>
			<div class="col-md-2"><label>To</label><input type="text" id="dt" class="form-control datepicker"></div>
			<div class="col-md-2">&nbsp;<br /><button class="btn btn-primary" onclick="reloadtbl();"><i class="fa fa-search"></i></button></div>
		</div>
		<br />
		<div class="row">
          <div class="col-12">
            <div class="card">
			  <div class="card-body table-responsive">
                
				<table id="example" class="table table-bordered table-stripped table-hover">
                <thead>
					<tr>
					  <th>Ticket#</th>
					  <th>Date/Time</th>
					  <th>Customer</th>
					  <th>Service</th>
					  <th>Detail</th>
					  <th>Status</th>
					  <th>Note</th>
					  <th>AssignedTo</th>
					  <th>UpdatedOn</th>
					  <th>Updated By</th>
					  <th>CreatedOn</th>
					  <th>SolvedOn</th>
					  <th>SolvedTime</th>
					  <th>ClosedOn</th>
					  <th>ClosedTime</th>
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
$cols="ticketno,calltime,customer,service,detail,status,lastnote,assignedto,lastupdate,updatedby,createdon,solvedon,MY_TIMEDIFF(calltime,solvedon) as st,closedon,MY_TIMEDIFF(calltime,closedon) as ct";

$where="";
?>

<script>
var mytbl;
$(document).ready(function(){
	
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
		//order: [[0,"desc"]],
		ajax: {
			type: 'POST',
			url: 'datatable<?php echo $ext?>',
			data: function (d) {
				d.cols= '<?php echo base64_encode($cols); ?>',
				d.tname= '<?php echo base64_encode($tname); ?>',
				d.where= '<?php echo base64_encode($where); ?>',
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
            }
	});
	
	
});
function reloadtbl(){
	mytbl.ajax.reload();
}

</script>

</body>
</html>
