<?php
$restrict_grp=array("S");

include 'inc.common.php';
include 'inc.session.php';

$ptitle="Users";
$mn="user";

$breadcrumb="Home/$ptitle";

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
					  <th>User</th>
					  <th>Name</th>
					  <th>Org.</th>
					  <th>Access</th>
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
					<input type="hidden" name="cols" value="user,name,org,access" />
					<input type="hidden" name="tname" value="xtm_users" />
					
						<div class="form-group row">
							<label class="col-form-label col-sm-4">User</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="user" name="user" placeholder="" />
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-sm-4">Name</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="name" name="name" placeholder="" />
							</div>
						</div>
						<!--div class="form-group row">
							<label class="col-form-label col-sm-4">Bagian</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="company" name="company" placeholder="" />
							</div>
						</div-->
						<div class="form-group row">
							<label class="col-form-label col-sm-4">Org</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="org" name="org" placeholder="" />
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-sm-4">Access</label>
							<div class="col-sm-8">
								<select class="custom-select" id="access" name="access">
							<?php echo options($o_access)?>
								</select>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-sm-4">Set Password</label>
							<div class="col-sm-8">
								<input type="password" class="form-control" id="fpasswd" name="fpasswd" placeholder="" />
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

$tname="xtm_users";
$cols="user,name,org,access,rowid";
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
        "user" : {
            required : true
        },
		"name" : {
			required : true
		},
		"access" : {
			required : true
		}
    }});
});
function reloadtbl(){
	mytbl.ajax.reload();
}
</script>

</body>
</html>
