<?php 

// pr($data);
// exit;

$date=($start==$end)? $start:"$start to $end";
$data['page']="Daily Collection Report<br />Date: $date";

?>


<h5 class="screen" >
	Daily Collection Report (DCR)
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a class="u" id="btnExport" >Excel</a> 
	
</h5>
<?php 

// $colspan=$count+2; 
$ir=array();
$colspan=2;
for($i=0;$i<$count;$i++){
	if($sales[$i]['total']>0){ $colspan++; array_push($ir,$i); }
}


?>


<div class="" ><?php include_once('incs/dcr_filter.php'); ?></div>

<div class="center clear" >
<?php $page="Daily Collection Report"; 
$inc = SITE.'views/elements/letterhead_logo_datetime.php';include($inc); ?>
</div>




<?php 
	// include_once('incs/dcr_table.php'); 

?>


<table id="tblExport" class="gis-table-bordered table-fx table-altrow" >
<tr><th colspan="<?php echo $colspan; ?>" >DCR Date Range: <?php echo $start.' to '.$end; ?></th></tr>

<tr>
<th>Employee</th>
<?php foreach($ir AS $i): ?>
	<td><?php echo $cashiers[$i]['code']; ?></td>
<?php endforeach; ?>
<th class="right" >Total</th>
</tr>
<tr>
<th>Terminal</th>
<?php foreach($ir AS $i): ?>
	<td><?php echo ($cashiers[$i]['terminal']); ?></td>
<?php endforeach; ?>
<th class="right" ></th>
</tr>

<tr><th colspan="<?php echo $colspan; ?>" >OR Number</th></tr>
<tr>
<th class="left" >Beginning</th>
<?php foreach($ir AS $i): ?>
	<td><?php $ormin=$ornos[$i]['min']; print(substr($ormin,-6)); ?></td>
<?php endforeach; ?>
<td></td>
</tr>

<tr>
<th class="left" >Ending</th>
<?php foreach($ir AS $i): ?>
	<td><?php $ormax=$ornos[$i]['max']; print(substr($ormax,-6)); ?></td>
<?php endforeach; ?>
<td></td>
</tr>


<tr><th class="left"  colspan="<?php echo $colspan; ?>" >Sales & Collection</th></tr>
<tr>
<th>Sales Cash</th>
<?php $a=0; ?>
<?php foreach($ir AS $i): ?>
	<?php $a+=$sales[$i]['tender_cash']; ?>
	<td class="right" ><?php echo number_format($sales[$i]['tender_cash'],2); ?></td>
<?php endforeach; ?>
<th class="right" ><?php echo number_format($a,2); ?></th>
</tr>

<tr>
<th>Sales Cheque</th>
<?php $b=0; ?>
<?php foreach($ir AS $i): ?>
	<?php $b+=$sales[$i]['tender_etc']; ?>
	<td class="right" ><?php echo number_format($sales[$i]['tender_etc'],2); ?></td>
<?php endforeach; ?>
<th class="right" ><?php echo number_format($b,2); ?></th>
</tr>

<tr>
<th>Sales Paid</th>
<?php $c=0; ?>
<?php foreach($ir AS $i): ?>
	<?php $c+=$sales[$i]['paid']; ?>
	<td class="right" ><?php echo number_format($sales[$i]['paid'],2); ?></td>
<?php endforeach; ?>
<th class="right" ><?php echo number_format($c,2); ?></th>
</tr>

<tr>
<th>Sales Credit</th>
<?php $d=0; ?>
<?php foreach($ir AS $i): ?>
	<?php $d+=$sales[$i]['unpaid']; ?>
	<td class="right" ><?php echo number_format($sales[$i]['unpaid'],2); ?></td>
<?php endforeach; ?>
<th class="right" ><?php echo number_format($d,2); ?></th>
</tr>

<tr>
<th>Sales Total</th>
<?php $e=0; ?>
<?php foreach($ir AS $i): ?>
	<?php $e+=$sales[$i]['total']; ?>
	<td class="right" ><?php echo number_format($sales[$i]['total'],2); ?></td>
<?php endforeach; ?>
<th class="right" ><?php echo number_format($e,2); ?></th>
</tr>


<tr>
<th>Cash Count</th>
<?php $e=0; ?>
<?php foreach($ir AS $i): ?>
	<?php $e+=$sales[$i]['cash_count']; ?>
	<td class="right" ><?php echo number_format($sales[$i]['cash_count'],2); ?></td>
<?php endforeach; ?>
<th class="right" ><?php echo number_format($e,2); ?></th>
</tr>


<tr><th colspan="<?php echo $colspan; ?>" >Overage | Shortage (-)</th></tr>

<tr>
<th>Cash</th>
<?php $g=0; ?>
<?php foreach($ir AS $i): ?>
	<?php $difference = $sales[$i]['cash_count']-$sales[$i]['tender_cash']; ?>
	<?php $g+=$difference; ?>	
	<td class="right" ><?php echo number_format($difference,2); ?></td>
<?php endforeach; ?>
<th class="right" ><?php echo number_format($g,2); ?></th>
</tr>


</table>


<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>


<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>


<script>
var gurl     = "http://<?php echo GURL; ?>";

$(function(){
	excel();

})






</script>

