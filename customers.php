<?php
$restrict_grp=array("S","A");

include 'inc.common.php';
include 'inc.session.php';

$ptitle="Customers";
$mn="cust";

$breadcrumb="Master Data/$ptitle";

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
			<div class="col-12"><button class="btn btn-primary" onclick="openForm();"><i class="fa fa-plus"></i></button></div>
		</div>
		<br />
		<div class="row">
          <div class="col-12">
            <div class="card">
			  <div class="card-body table-responsive">
                
				<table id="example" class="table table-bordered table-stripped table-hover">
                <thead>
					<tr>
					  <th>ID</th>
					  <th>Name</th>
					  <th>PIC</th>
					  <th>Phone</th>
					  <th>Mail</th>
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
	  
	  <div class="modal fade" id="modal_data">
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
					<form id="myf" class="form-horizontal">
					<input type="hidden" name="mn" value="<?php echo $mn?>" />
					<input type="hidden" id="rowid" name="rowid" value="0" />
					<input type="hidden" id="sv" name="sv" />
					<input type="hidden" name="cols" value="custname,custid,pic,phone,mail" />
					<input type="hidden" name="tname" value="xtm_customers" />
					
						<div class="form-group row">
							<label class="col-form-label col-sm-4">ID</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="custid" name="custid" placeholder="" />
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-sm-4">Name</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="custname" name="custname" placeholder="" />
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-sm-4">PIC</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="pic" name="pic" placeholder="" />
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-sm-4">Phone</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="phone" name="phone" placeholder="" />
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-sm-4">Mail</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="mail" name="mail" placeholder="" />
							</div>
						</div>
						
					</form>
				</div>
			  </div>
            </div>
			<div class="modal-footer">
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
	  
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
</div>
<!-- ./wrapper -->

<?php
include 'inc.js.php';

$tname="xtm_customers";
$cols="custid,custname,pic,phone,mail,rowid";
?>

<script>
var mytbl, jvalidate;
$(document).ready(function(){
	mytbl = $('#example').DataTable({
		ajax: {
			type: 'POST',
			url: 'datatablesall<?php echo $ext?>',
			data: function (d) {
				d.cols= '<?php echo base64_encode($cols); ?>',
				d.tname= '<?php echo base64_encode($tname); ?>',
				d.x= '<?php echo $mn?>'
			}
		}
	});
	jvalidate = $("#myf").validate({
    rules :{
        "custid" : {
            required : true
        },
		"custname" : {
			required : true
		},
		"user" : {
			required : true
		},
		"fpasswd" : {
			required : function(element){
				return $("#rowid").val()=="0";
			}
		}
    }});
});
function reloadtbl(){
	mytbl.ajax.reload();
}
</script>

</body>
</html>
