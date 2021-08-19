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
				<div class="col-md-6">
					<div class="card">
					  <div class="card-header border-0">
						<div class="d-flex justify-content-between">
						  <h3 class="card-title">Daily Ticket</h3>
						</div>
					  </div>
					  <div class="card-body">
						<div class="position-relative mb-4">
						  <canvas id="visitors-chart" height="250"></canvas>
						</div>
					  </div>
					</div>
					<!-- /.card -->
				</div> 
				<!-- /.col -->
				<div class="col-md-6">
					<div class="card">
					  <div class="card-header border-0">
						<div class="d-flex justify-content-between">
						  <h3 class="card-title">Problems</h3>
						</div>
					  </div>
					  <div class="card-body">
						<div class="position-relative mb-4">
						  <canvas id="sales-chart" height="250"></canvas>
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
include 'inc.db.php';

$conn=connect();

$label=array();
$rs=exec_qry($conn,"select distinct g.name from bltstok_reports r join bltstok_goods g on g.rowid=r.goods order by g.name");
while($row=fetch_row($rs)){
	$label[]=$row[0];
}

$rs=exec_qry($conn,"select distinct dt from bltstok_reports order by dt desc limit 12");
$rows=fetch_all($rs);
$rows=array_reverse($rows);

$tgl=array();
$price=array();
$stock=array();

for($i=0;$i<count($rows);$i++){
	$dt=$rows[$i][0];
	$tgl[]=$dt;
	for($j=0;$j<count($label);$j++){
		$price[$label[$j]][$dt]=0;
		$stock[$label[$j]][$dt]=0;
	}
	$sql="select g.name as b,avg(price) as p, sum(stock) as s from bltstok_reports r join bltstok_goods g on  g.rowid=r.goods where dt='$dt' group by b order by b";
	$rs=exec_qry($conn,$sql);
	while($row=fetch_row($rs)){
		$price[$row[0]][$dt]=$row[1];
		$stock[$row[0]][$dt]=$row[2];
	}
}
disconnect($conn);

/*
echo "tgl=".json_encode($tgl)."<br />";
echo "label=".json_encode($label)."<br />";
echo "price=".json_encode($price)."<br />";
echo "stock=".json_encode($stock)."<br />";

echo "price beras=".json_encode(array_values($price['Beras']));
*/

?>

<script>
var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode      = 'index'
  var intersect = true


$(document).ready(function(){
	price();
	sales();
});

function price(){
	var $visitorsChart = $('#visitors-chart')
    var visitorsChart  = new Chart($visitorsChart, {
    data   : {
      labels  : <?php echo json_encode($tgl)?>,//['18th', '20th', '22nd', '24th', '26th', '28th', '30th'],
      datasets: [
	  <?php for($i=0;$i<count($label);$i++){?>
	  {
        label :'<?php echo $label[$i]?>',
        type   : 'line',
        data   : <?php echo json_encode(array_values($price[$label[$i]])) ?>,//[100, 120, 170, 167, 180, 177, 160],
		fill : false,
		  borderColor : randomColor()
      },
	  <?php }?>
	  ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips           : {
        mode     : mode,
        intersect: intersect
      },
      hover              : {
        mode     : mode,
        intersect: intersect
      },
      legend             : {
        display: true
      },
      scales             : {
        yAxes: [{
          // display: false,
          gridLines: {
            display      : true,
            //lineWidth    : '4px',
            color        : 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks    : $.extend({
            beginAtZero : true
          }, ticksStyle)
        }],
        xAxes: [{
          display  : true,
          gridLines: {
            display: false
          },
          ticks    : ticksStyle
        }]
      }
    }
  })
}

function sales(){
  var $salesChart = $('#sales-chart')
  var salesChart  = new Chart($salesChart, {
    type   : 'bar',
    data   : {
      labels  : <?php echo json_encode($tgl)?>,//['JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
      datasets: [
        <?php for($i=0;$i<count($label);$i++){?>
		{
		  label: '<?php echo $label[$i]?>',
          backgroundColor: randomColor(),
          //borderColor    : '#007bff',
          data           : <?php echo json_encode(array_values($stock[$label[$i]])) ?>,//[1000, 2000, 3000, 2500, 2700, 2500, 3000]
        },
        <?php }?>
      ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips           : {
        mode     : mode,
        intersect: intersect
      },
      hover              : {
        mode     : mode,
        intersect: intersect
      },
      legend             : {
        display: true
      },
      scales             : {
        yAxes: [{
          // display: false,
          gridLines: {
            display      : true,
            lineWidth    : '4px',
            color        : 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks    : $.extend({
            beginAtZero: true,

            // Include a dollar sign in the ticks
            callback: function (value, index, values) {
              if (value >= 1000) {
                value /= 1000
                value += 'k'
              }
              return value //'$' + value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display  : true,
          gridLines: {
            display: false
          },
          ticks    : ticksStyle
        }]
      }
    }
  })
}
</script>

</body>
</html>
