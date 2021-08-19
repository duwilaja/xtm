<?php
$ptitle="Laporan Mingguan";
$mn="mingguan";

include 'inc.common.php';
include 'inc.session.php';
include 'inc.head.php';

include 'inc.db.php';

$breadcrumb="Home/Laporan/$ptitle";

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
			<form id="myf">
			<input type="hidden" name="mn" value="laporan">
			</form>
			<!--div class="col-md-2"><button class="btn btn-primary" onclick="create_report()">Create Report</button></div>
			<div class="col-md-2"><a class="btn btn-primary" href="#" data-fancybox data-type="iframe" data-src="print.php">Export Data</a></div-->
		</div>
		<br />
		<div class="row">
          <div class="col-12">
            <div class="card">
			  <div class="card-body table-responsive">
                
				<table id="example" class="table table-bordered table-stripped table-hover">
                <thead>
					<tr>
					  <!--th>Toko</th>
					  <th>Nama Barang</th>
					  <th>Jenis/Merk</th>
					  <th>Stok</th>
					  <th>Harga</th>
					  <th>Penyaluran</th-->
					  <th>Tanggal Laporan</th>
					  <th>Bahan Pokok</th>
					  <th>Bahan Penting Lainnya</th>
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

$tname="bltstok_reports i 
 join bltstok_goods g on i.goods=g.rowid 
 join bltstok_stores s on s.rowid=i.store 
left join bltstok_brands b on b.rowid=i.brand";
$cols="concat(s.name,'<br />',s.address) as toko,g.name,b.brand,
concat(stock,g.stockunit) as st,concat(price,'/',g.priceunit) as p,concat(sale,g.saleunit) as sl,i.rowid";
$where="dt=date(now())";

$where="";
$tname="bltstok_reports";
$cols="distinct dt, '' as x, '' as y";
?>

<script>
var mytbl, jvalidate;
$(document).ready(function(){
	mytbl = $('#example').DataTable({
		//dom: 'lfrtiBp',
		//buttons: ['copy', 'csv'],
		lengthMenu: [[10,50,100,-1],[10,50,100,"All"]],
		processing: true,
        serverSide: false,
		order: [[0,'desc']],
		ajax: {
			type: 'POST',
			url: 'datatablesall<?php echo $ext?>',
			data: function (d) {
				d.cols= '<?php echo base64_encode($cols); ?>',
				d.tname= '<?php echo base64_encode($tname); ?>',
				d.where= '<?php echo base64_encode($where); ?>',
				d.x= '<?php echo $mn?>'
			}
		},
		'columnDefs': [
         {
            'targets': [1,2],
            'orderable': false,
            'searchable': false
         }]/*,
		 'rowsGroup': [0]*/
	});
	jvalidate = $("#myf").validate({
    rules :{
        "plat" : {
            required : true
        },
		"merk" : {
			required : true
		},
		"model" : {
			required : true
		}
    }});
	
	$(".datepicker").daterangepicker({
		singleDatePicker: true,
		timePicker: true,
		timePicker24Hour: true,
		locale: {
		  format: 'YYYY-MM-DD HH:m'
		}
	});
	
});
function reloadtbl(){
	mytbl.ajax.reload();
}

function create_report(){
	sendDataFile();
	
}
</script>

</body>
</html>
