<?php
$redirect=false;
$cleartext=true;
include "inc.session.php";
include "inc.db.php";

function get_count($id,$list){
	$ret=0;
	for($j=0;$j<count($list);$j++){
		if($id==$list[$j][0]){
			$ret++;
		}
	}
	return $ret;
}


$conn=connect();

$m=get("m",$conn,"1");
$y=get("y",$conn,"1900");
$dt=base64_decode(get("dt",$conn));
$where=$dt==''?"month(dt)=$m and year(dt)=$y":"dt='$dt'";
$fn=$dt==""?$y.'-'.$m:$dt;
$date=$dt==''?date_create($y.'-'.$m.'-1'):date_create($dt);

$poting=get("pokok")=="1"?"g.category='Sembako'":"g.category<>'Sembako'";
$tpoting=get("pokok")=="1"?"POKOK":"PENTING LAINNYA";

$activestore="store in (select rowid from bltstok_stores) AND goods IN (SELECT rowid FROM bltstok_goods)";

$sql="select distinct store,goods,b.brand from bltstok_reports i 
 join bltstok_goods g on i.goods=g.rowid 
 join bltstok_stores s on s.rowid=i.store 
left join bltstok_brands b on b.rowid=i.brand 
where $where and $activestore and $poting";
$rgrp=fetch_all(exec_qry($conn,$sql));
//echo $sql;

$sql="select g.name,b.brand,g.priceunit,g.stockunit,round(avg(price),2) as p from bltstok_reports i
 join bltstok_goods g on i.goods=g.rowid 
left join bltstok_brands b on b.rowid=i.brand
where $where and $activestore and $poting group by g.name,b.brand,g.priceunit,g.stockunit";
$ravg=fetch_alla(exec_qry($conn,$sql));

$sql="select g.name,g.stockunit,round(sum(stock),2) as st, round(sum(sale),2) as sl from bltstok_reports i
 join bltstok_goods g on i.goods=g.rowid 
where $where and $activestore and $poting group by g.name,g.stockunit";
$rsum=fetch_alla(exec_qry($conn,$sql));

$sql="select store,concat(s.name,'<br />',s.address) as toko,g.name,b.brand,
concat(round(sum(stock),2),' ',g.stockunit) as st,concat(round(avg(price),2),' /',g.priceunit) as p,concat(round(sum(sale),2),' ',g.saleunit) as sl
from bltstok_reports i 
 join bltstok_goods g on i.goods=g.rowid 
 join bltstok_stores s on s.rowid=i.store 
left join bltstok_brands b on b.rowid=i.brand 
where $where and $activestore and $poting
group by store,toko,g.name,b.brand,g.stockunit,g.priceunit,g.saleunit 
order by s.name,g.name,b.brand";
$rs=fetch_alla(exec_qry($conn,$sql));
//echo $sql;

disconnect($conn);

if(count($rs)<1){
	echo "No data found";
}else{

$trata="<b>Harga rata-rata:</b><table>";
$tstok="<b>Stok:</b><table>";
$tsale="<b>Penyaluran:</b><table>";
$rata="<b>Harga rata-rata:</b><br />";
$stok="<b>Stok:</b><br />";
$sale="<b>Penyaluran:</b><br />";
for($k=0;$k<count($ravg);$k++){
	$d=$ravg[$k];
	$trata.='<tr><td align="left">- '.$d['name'].' '.$d['brand'].'</td><td>=</td><td>Rp.</td><td align="right">'.round($d['p']).'</td><td> /'.$d['priceunit'].'</td></tr>';
	$rata.='- '.$d['name'].' '.$d['brand'].' = Rp. '.round($d['p']).' /'.$d['priceunit'].'<br />';
}
for($k=0;$k<count($rsum);$k++){
	$d=$rsum[$k];
	$tstok.='<tr><td align="left">- '.$d['name'].'</td><td>=</td><td align="right">'.round($d['st']).'</td><td> '.$d['stockunit'].'</td></tr>';
	$stok.='- '.$d['name'].' = '.round($d['st']).' '.$d['stockunit'].'<br />';
	$tsale.='<tr><td align="left">- '.$d['name'].'</td><td>=</td><td align="right">'.round($d['sl']).'</td><td> '.$d['stockunit'].'</td></tr>';
	$sale.='- '.$d['name'].' = '.round($d['sl']).' '.$d['stockunit'].'<br />';
}
$trata.='</table><br /><br />';
$tstok.='</table><br /><br />';
$tsale.='</table>';
$rata.='<br /><br />';
$stok.='<br /><br />';

	if(get("x")=="1"){
		header("Content-Type: application/vnd.ms-excel");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("content-disposition: attachment;filename=$fn.xls");
		$rata=str_ireplace("<br />",'<br style="mso-data-placement:same-cell;" />',$rata);
		$stok=str_ireplace("<br />",'<br style="mso-data-placement:same-cell;" />',$stok);
	}else{
		$rata=$trata;
		$stok=$tstok;
	}

?>
<html>
<head>
<title>Laporan <?php echo $dt==''?'bulan : '.date_format($date,"F Y"):'tanggal : '.date_format($date,"d M Y");?></title>
</head>
<body style="text-align:center; margin: 50px;">
<h3>LAPORAN <?php echo $dt==''?"BULANAN":"MINGGUAN";?> HASIL MONITORING STOK BAHAN <?php echo $tpoting?> <br />DI WILAYAH KOTA BLITAR <?php echo $dt==''?'BULAN '.date_format($date,"F Y"):'TANGGAL '.date_format($date,"d M Y");?></h3>
<?php //print_r($rgrp)?>
<table border="1" cellspacing="0" cellpadding="5px;" width="100%">
<tr>
<td rowspan="2" align="center">NO.</td>
<td rowspan="2" align="center">TOKO/UD/ALAMAT</td>
<td rowspan="2" align="center">JENIS BARANG</td>
<td colspan="3" align="center">HASIL MONITORING</td>
<td rowspan="2" align="center">KET.</td>
</tr>
<tr>
<td align="center">STOK</td>
<td align="center">RENC. PENYALURAN MINGGU</td>
<td align="center">HARGA (Rp.)</td>
</tr>
<tr>
<td align="center">1</td>
<td align="center">2</td>
<td align="center">3</td>
<td align="center">4</td>
<td align="center">5</td>
<td align="center">6</td>
<td align="center">7</td>
</tr>
<?php
$tk=""; $c=0;
for($i=0;$i<count($rs);$i++){
	$d=$rs[$i];
?>
<tr>
<?php if($tk!=$d['store']){
	$c++; $cnt=get_count($d['store'],$rgrp);?>
<td valign="top" rowspan="<?php echo $cnt?>" align="center"><?php echo $c?></td>
<td valign="top" rowspan="<?php echo $cnt?>"><?php echo $d['toko']?></td>
<?php }?>
<td valign="top" align="center"><?php echo $d['name'].' '.$d['brand']?></td>
<td valign="top" align="center"><?php echo $d['st']?></td>
<td valign="top" align="center"><?php echo $d['sl']?></td>
<td valign="top" align="center"><?php echo $d['p']?></td>
<?php if($i==0){?>
<td valign="top" align="left" rowspan="<?php echo count($rs)?>"><?php echo $rata?><?php echo $stok?><?php echo $sale?></td>
<?php }?>
</tr>
<?php
$tk=$d['store'];
}
?>
</table>

<br><br><br><br>
<?php if(get("x")!="1"){?>
<a href="JavaScript:window.print();">print</a> <a href="print.php?x=1&pokok=<?php echo get("pokok")?>&dt=<?php echo get("dt")?>&m=<?php echo $m?>&y=<?php echo $y?>">export</a>
<?php }?>
</body>
</html>
<?php
}
?>