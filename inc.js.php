	  <div class="modal fade" id="modal_delete">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Delete Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Delete record permanently?</p>
            </div>
			<div class="modal-footer justify-content-between">
				
				<button type="button" class="btn btn-danger" onclick="deleteData();">Yes</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
				
			</div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
	  
	  <div class="modal fade" id="modal_password">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Change Password</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
				<form id="myfpass" class="form-horizontal">
					<input type="hidden" name="mn" value="chgpwd" />
						<div class="form-group row">
							<label class="col-form-label col-sm-4">Current Password</label>
							<div class="col-sm-8">
								<input type="password" class="form-control" id="opass" name="opass" placeholder="" />
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-sm-4">New Password</label>
							<div class="col-sm-8">
								<input type="password" class="form-control" id="npass" name="npass" placeholder="" />
							</div>
						</div>
						<div class="form-group row">
							<label class="col-form-label col-sm-4">Re-type New Password</label>
							<div class="col-sm-8">
								<input type="password" class="form-control" id="rpass" name="rpass" placeholder="" />
							</div>
						</div>
				</form>
            </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" onclick="sendDataFile('','#myfpass');">Change</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
	  
	  <div class="modal fade" id="modal_process">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="process_title">Process</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="process_result">
              <p>Processing, please wait ...</p>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->

<?php if($footer){?>
<footer class="main-footer" style="margin-left:0; text-align:center"><?php echo $sub?><br /><strong><?php echo strtoupper( $foo)?></strong></footer>
<?php }?>
<!-- jQuery -->
<script type='text/javascript' src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script type='text/javascript' src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<script type='text/javascript' src="plugins/datatables/jquery.dataTables.min.js"></script>
<script type='text/javascript' src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

<script type='text/javascript' src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script type='text/javascript' src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script type='text/javascript' src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>

<script type='text/javascript' src="plugins/datatables/dataTables.rowsGroup.js"></script>

<script type='text/javascript' src='plugins/jquery-validation/jquery.validate.js'></script>
<script type='text/javascript' src='plugins/jquery-fancybox/jquery.fancybox.min.js'></script>

<script type='text/javascript' src="plugins/daterangepicker/moment.min.js"></script>
<script type='text/javascript' src="plugins/daterangepicker/daterangepicker.js"></script>
<script type='text/javascript' src="plugins/chart.js/Chart.min.js"></script>

<!--script type='text/javascript' src="plugins/Leaflet.Icon.Glyph.js"></script-->

<!-- AdminLTE App -->
<script type='text/javascript' src="js/adminlte.min.js"></script>

<!-- global functions -->
<script>
//$.fancybox.defaults.smallBtn = true;

/*hack jquery validate*/
$.validator.setDefaults({
  highlight: function(element) {
    /*$(element).closest('.form-group').addClass('has-error');
    $(element).closest('.form-group').removeClass(
      'has-success has-feedback').addClass('has-error has-feedback');
    $(element).closest('.form-group').find('i.fa').remove();
    $(element).closest('.form-group').append(
      '<i class="fa fa-exclamation fa-lg form-control-feedback"></i>');*/
	$(element).removeClass("is-valid");
	$(element).addClass("is-invalid");

  },
  unhighlight: function(element) {
    /*$(element).closest('.form-group').removeClass('has-error');
    $(element).closest('.form-group').addClass('has-success');
    $(element).closest('.form-group').find('i.fa').remove();
    $(element).closest('.control-label').append(
      '<i class="fa fa-check fa-lg form-control-feedback"></i>');*/
	$(element).removeClass("is-invalid");
	$(element).addClass("is-valid");
  },
  errorElement: 'span',
  errorClass: 'help-block',
  errorPlacement: function(error, element) {
    if (element.parent('.input-group').length) {
      //error.insertBefore(element.parent());
    } else {
      //error.insertBefore(element);
    }
  }
});
$.validator.addMethod("equals", function(value, element, param) {
	//console.log(value);
	//console.log(param);
  return this.optional(element) || $.inArray(value,param) != -1;
}, "Please specify a different value");



function log(s){
	console.log(s);
}
function toast(ttl,body,cls='',hide=false,delay=1500){
	$(document).Toasts('create', {
        position: 'bottomRight',
		title: ttl,
        body: body,
		autohide: hide,
        delay: delay,
		class: cls
    });
}
function modal(ttl='Proses',body='Sedang proses, mohon tunggu ...'){
	$("#process_title").html(ttl);
	$("#process_result").html(body);
	$("#modal_process").modal('show');
}

function openForm(q='',id=0,f='#myf'){
	$("#modal_data").modal("show");
	jvalidate.resetForm();
	$(".is-invalid").removeClass("is-invalid");
	$(".is-valid").removeClass("is-valid");
	$('#rowid').val(id);
	$(f).find("input[type=text], input[type=password], input[type=file], textarea, select").val("");
	$(f).find("input[type=checkbox]").prop('checked',false);
	
	if(id==0){
		$("#bdel").hide();
	}else{
		$("#bdel").show();
		//modal();
		$.ajax({
			type: 'POST',
			url: 'data<?php echo $ext?>',
			data: {q:q,id:id},
			success: function(data){
					var json = JSON.parse(data);
					if(json['code']=='200'){
						$.each(json['msgs'][0],function (key,val){
							$('#'+key).val(val);
						});
						if(typeof(datacallback)=='function') datacallback(id);
					}else{
						modal(json['ttl'],json['msgs']);
						setTimeout(hideform,500);
					}
					$("#modal_process").modal("hide");
				},
			error: function(xhr){
					modal('Error','Kontak admin');
				}
		});
	}
}
function hideform(){
	$("#modal_data").modal("hide");
}
var deleteForm='#myf';
function confirmDelete(f='#myf'){
	deleteForm=f;
	$("#modal_delete").modal("show");
}
function deleteData(){
	$("#modal_delete").modal("hide");
	sendDataFile("DEL",deleteForm);
}
function saveData(f="#myf"){
	if($(f).valid()){
		if($("#rowid").val()=="0"){
			sendDataFile("NEW",f);
		}else{
			sendDataFile("UPD",f);
		}
	}
}
function sendDataFile(sv='DUM',f='#myf'){
	modal();
	$("#sv").val(sv);
	
	var url='datasave<?php  echo $ext?>';
	var mtd='POST';
	var frmdata=new FormData($(f)[0]);
			
	//alert(frmdata);
			
	$.ajax({
		type: mtd,
		url: url,
		data: frmdata,
		success: function(data){
				var json = JSON.parse(data);
				modal(json['ttl'],json['msgs']);
				if(json['code']=='200'){
					if(typeof(reloadtbl)=='function') reloadtbl();
					$("#modal_data").modal("hide");
					$("#modal_new").modal("hide");
				}
				
			},
		error: function(xhr){
				modal('Error','Kontak admin');
			},
		cache: false,
		contentType: false,
		processData: false
	});
			
};
function randomColor(){
	return "#"+(Math.random().toString(16)+"000000").slice(2, 8).toUpperCase();
}
function get(q,id){
		
		$.ajax({
			type: 'POST',
			url: 'data<?php echo $ext?>',
			data: {q:q,id:id},
			success: function(data){
					var json = JSON.parse(data);
					if(json['code']=='200'){
						$.each(json['msgs'][0],function (key,val){
							$('#'+key).val(val);
						});
					}else{
						log(json['msgs']);
					}
				},
			error: function(xhr){
					log(xhr);
				}
		});
}
<?php if(isset($mn)){?>
$(".<?php echo $mn?>").addClass("menu-open active");
<?php }?>
</script>