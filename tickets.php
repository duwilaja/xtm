<?php
//$restrict_grp=array("S","A");

include 'inc.common.php';
include 'inc.session.php';

$ptitle="Tickets";
$mn="ticket";

$breadcrumb="Home/$ptitle";

include "inc.db.php";

$conn=connect();

$rs=exec_qry($conn,"select custid,custname from xtm_customers order by custname");
$cust=fetch_all($rs);

$rs=exec_qry($conn,"select servid,servname from xtm_services order by servname");
$serv=fetch_all($rs);

$rs=exec_qry($conn,"select probid,probname from xtm_problems order by probname");
$prob=fetch_all($rs);

$rs=exec_qry($conn,"select user,name from xtm_users order by name");
$usrs=fetch_all($rs);

disconnect($conn);

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
			<div class="col-md-2"><select id="fs" class="form-control"><option value="">All Status</option>
								<?php echo options($o_status)?>
								</select></div>
			<div class="col-md-2"><button class="btn btn-primary" onclick="reloadtbl();"><i class="fa fa-search"></i></button></div>
			<div class="col-md-8"><button class="btn btn-primary" style="float:right;" onclick="newticket();"><i class="fa fa-plus"></i></button></div>
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
					  <th>ClosedOn</th>
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
	  
	  <div class="modal fade" id="modal_new">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><?php echo $ptitle?></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="card">
				<div class="card-body">
					<form id="myfx" class="form-horizontal">
					<input type="hidden" name="mn" value="<?php echo $mn?>x" />
					<input type="hidden" name="rowid" value="0" />
					<input type="hidden" name="sv" value="NEW" />
					<input type="hidden" name="cols" value="calltime,customer,service,detail,assignedto" />
					<input type="hidden" name="tname" value="xtm_tickets" />
					<input type="hidden" name="assignedto" value="<?php echo $s_ID?>" />
						<div class="form-group row">
							<label class="col-form-label col-sm-4">Date/Time</label>
							<div class="col-sm-8">
								<input type="text" name="calltime" id="calltimex" class="form-control datepicker" placeholder="" />
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-sm-4">Customer</label>
							<div class="col-sm-8">
								<select class="form-control" name="customer" id="customerx">
								<?php echo options($cust)?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-sm-4">Service</label>
							<div class="col-sm-8">
								<select class="form-control" id="servicex" name="service">
								<?php echo options($serv)?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-sm-4">Detail</label>
							<div class="col-sm-8">
								<textarea class="form-control" id="detailx" name="detail"></textarea>
							</div>
						</div>
						
					</form>
				</div>
			  </div>
            </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onclick="saveDatax();">Save</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
	  
	  <div class="modal fade" id="modal_data">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title"><?php echo $ptitle?></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="card">
				<div class="card-body">
					<form id="myf" class="form-horizontal">
					<input type="hidden" name="mn" value="<?php echo $mn?>" />
					<input type="hidden" id="rowid" name="rowid" value="0" />
					<input type="hidden" id="sv" name="sv" />
					<input type="hidden" name="cols" value="status,lastnote,problem,solution,assignedto" />
					<input type="hidden" name="tname" value="xtm_tickets" />
						<div class="form-group row">
							<label class="col-form-label col-sm-2">Ticket#</label>
							<div class="col-sm-4">
								<input type="text" readonly name="ticketno" id="ticketno" class="form-control" placeholder="" />
							</div>
							<label class="col-form-label col-sm-2">Date/Time</label>
							<div class="col-sm-4">
								<input type="text" readonly name="calltime" id="calltime" class="form-control" placeholder="" />
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-sm-2">Customer</label>
							<div class="col-sm-4">
								<select readonly class="form-control" name="customer" id="customer">
								<?php echo options($cust)?>
								</select>
							</div>
							<label class="col-form-label col-sm-2">Service</label>
							<div class="col-sm-4">
								<select readonly class="form-control" id="service" name="service">
								<?php echo options($serv)?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-sm-2">Detail</label>
							<div class="col-sm-10">
								<textarea readonly class="form-control" id="detail" name="detail"></textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-sm-2">Latest Note</label>
							<div class="col-sm-4">
								<textarea readonly class="form-control" id="lastnote" name="not"></textarea>
							</div>
							<label class="col-form-label col-sm-2">AssignedTo</label>
							<div class="col-sm-4">
								<select class="form-control" id="assignedto" name="assignedto">
								<?php echo options($usrs)?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-sm-2">Status</label>
							<div class="col-sm-4">
								<select class="form-control" id="status" name="status">
								<?php echo options($o_status)?>
								</select>
							</div>
							<label class="col-form-label col-sm-2">Note</label>
							<div class="col-sm-4">
								<textarea class="form-control" name="lastnote"></textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-sm-2">Problem</label>
							<div class="col-sm-4">
								<select class="form-control" id="problem" name="problem">
								<?php echo options($prob)?>
								</select>
							</div>
							<label class="col-form-label col-sm-2">Solution</label>
							<div class="col-sm-4">
								<textarea class="form-control" id="solution" name="solution"></textarea>
							</div>
						</div>
						
					</form>
				</div>
			  </div>
            </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-warning" onclick="openHistory();">History</button>
				<button type="button" id="bdel" class="btn btn-danger hidden" onclick="confirmDelete();">Delete</button>
				<button type="button" class="btn btn-primary" onclick="saveData();">Save</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
	  
	  <div class="modal fade" id="modal_history">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title history"></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="card">
				<div class="card-body table-responsive">
					
					<table id="examplex" class="table table-bordered table-stripped table-hover">
					<thead>
						<tr>
						  <th>Date/Time</th>
						  <th>Note</th>
						  <th>Status</th>
						  <th>Updated By</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
					</table>
					
				</div>
			  </div>
            </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
	  
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<?php
include 'inc.js.php';

$tname="xtm_tickets";
$cols="ticketno,calltime,customer,service,detail,status,lastnote,assignedto,lastupdate,updatedby,createdon,solvedon,closedon,rowid";
$cseq="ticketno";
$csrc="customer,service,detail";
$where="";
if($s_ACCESS=='U'){$where="assignedto='$s_ID'";}
?>

<script>
var mytbl, mytblx, jvalidate, jvalidatex;
$(document).ready(function(){
	mytbl = $('#example').DataTable({
		processing: true,
		serverSide: true,
		searching: true,
		order: [[0,"desc"]],
		ajax: {
			type: 'POST',
			url: 'datatable<?php echo $ext?>',
			data: function (d) {
				d.cols= '<?php echo base64_encode($cols); ?>',
				d.tname= '<?php echo base64_encode($tname); ?>',
				d.where= '<?php echo base64_encode($where); ?>',
				d.csrc= '<?php echo base64_encode($csrc); ?>',
				d.cseq= '<?php echo base64_encode($cseq); ?>',
				d.filtereq='<?php echo base64_encode("status"); ?>',
				d.status=$('#fs').val(),
				d.x= '<?php echo $mn?>'
			}
		}
	});
	mytblx = $('#examplex').DataTable({
		processing: true,
		serverSide: true,
		searching: true,
		order: [[0,"desc"]],
		ajax: {
			type: 'POST',
			url: 'datatable<?php echo $ext?>',
			data: function (d) {
				d.cols= '<?php echo base64_encode("updatedon,lastnote,status,updatedby"); ?>',
				d.tname= '<?php echo base64_encode("xtm_notes"); ?>',
				d.where= '<?php echo base64_encode(""); ?>',
				d.csrc= '<?php echo base64_encode(""); ?>',
				d.filtereq= '<?php echo base64_encode("ticketno"); ?>',
				d.ticketno=$("#ticketno").val(),
				d.x= '-'
			}
		}
	});
	
	jvalidatex = $("#myfx").validate({
    rules :{
        "customer" : {
            required : true
        },
		"calltime" : {
			required : true
		},
		"service" : {
			required : true
		},
		"detail" : {
			required : true
		}
    }});
	jvalidate = $("#myf").validate({
    rules :{
        "lastnote" : {
            required : true
        },
		"status" : {
			required : true,
			equals : ["progress","pending","solved","closed"]
		},
		"problem" : {
			required : function(){
				if($("#status").val()=='solved'||$("#status").val()=='closed'){
					return true;
				}else{
					return false;
				}
			}
		},
		"solution" : {
			required : function(){
				if($("#status").val()=='solved'||$("#status").val()=='closed'){
					return true;
				}else{
					return false;
				}
			}
		}
    }});
	
	$(".datepicker").daterangepicker({
		singleDatePicker: true,
		timePicker: true,
		timePicker24Hour: true,
		locale: {
		  format: 'YYYY-MM-DD HH:mm'
		}
	});
});
function reloadtbl(){
	mytbl.ajax.reload();
}
function newticket(f="myfx"){
	$("#modal_new").modal("show");
	jvalidatex.resetForm();
	$(".is-invalid").removeClass("is-invalid");
	$(".is-valid").removeClass("is-valid");
	$(f).find("input[type=text], input[type=password], input[type=file], textarea, select").val("");
	$(f).find("input[type=checkbox]").prop('checked',false);
}
function saveDatax(f="#myfx"){
	if($(f).valid()){
		sendDataFile("NEW",f);
	}
}
function openHistory(){
	$(".history").text("Ticket# : "+$("#ticketno").val());
	$("#modal_history").modal("show");
	$("#examplex").css("width","100%");
	mytblx.ajax.reload();
}
</script>

</body>
</html>
