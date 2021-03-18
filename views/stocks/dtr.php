<h5 class="screen" >
	<?php echo $today; ?> Daily Terminal Report (DTR)
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				 	
	| <a class="u" id="btnExport" >Excel</a> 

	
</h5>

<?php 
	if(isset($_GET['debug'])){ pr($q); }

?>


<div class="" >
<?php 
	$numcols=($terminal>0)? '10':'9';
	$incs = "incs/dtr_filter.php"; include_once($incs); ?>
</div>

<div class="center clear" >
<?php $inc = SITE.'views/elements/letterhead_logo_datetime.php';include($inc); ?>
</div>

<table class="gis-table-bordered table-fx" >
	<tr><th>Date Range</th><td class="vc200" ><?php echo $start.' to '.$end; ?></td></tr>
<?php if($ecid): ?>	
	<tr><th>Terminal - ECID</th><td><?php echo $employee['terminal'].' - '.$ecid; ?></td></tr>	
	<tr><th>Employee</th><td><?php echo $employee['employee'].' | '.$employee['code']; ?></td></tr>
<?php endif; ?>
</table>
<br />

<table id="tblExport" class="gis-table-bordered table-fx table-altrow" >
<tr>
	<th>#</th>
	<th>Barcode</th>
	<th>Product</th>
	<th class="right" >Unit<br />Cost</th>
	<th class="right" >Price<br />SRP</th>
	<th>Paid</th>
	<th>Sold</th>
	<th>Revenue</th>
	<?php if($terminal>0): ?>
		<th>T<?php echo $terminal; ?></th>
	<?php endif; ?>
	<th>Level</th>
</tr>

<?php 
$total=0;
$tcgs=0;
$profits=0;
$subrevenues=0;

?>
<tr><th colspan="<?php echo $numcols; ?>" ><?php echo @$rows[0]['supplier']; ?></th></tr>

<?php for($i=0;$i<$count;$i++): ?>
<?php 
	$revenue=$rows[$i]['revenue'];
	$total+=$revenue;

	$cgs=$rows[$i]['cost']*$rows[$i]['sold'];
	$tcgs+=$cgs;

	$profit=$revenue-$cgs;
	$profits+=$profit;

	/* 2 */
	$subrevenues+=$rows[$i]['revenue']; 
	
	
?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="" ><?php echo $rows[$i]['barcode']; ?></td>
	<td class="" ><?php echo $rows[$i]['product']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['cost'],2); ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['price'],2); ?></td>
	<td class="right" ><?php echo ($rows[$i]['is_paid']==1)? 'Y':'N'; ?></td>
	<td class="right" ><?php echo $rows[$i]['sold']; ?></td>
	<td class="right" ><?php echo number_format($revenue,2); ?></td>
<?php if($terminal>0): ?>	
	<td class="right" ><?php echo $rows[$i]['tq']; ?></td>
<?php endif; ?>	
	<td class="right" ><?php echo $rows[$i]['level']; ?></td>
</tr>

<?php 
	$j=$i+1;
	if($rows[$i]['suppid']!=@$rows[$j]['suppid']){
	
		$subrevenues=number_format($subrevenues,2);
		
		$totalrow="<tr><th colspan='7' >Total</th>";
		$totalrow.="<th class='right'>".$subrevenues."</th><th></th>";
		echo $totalrow;
		$subrevenues=0;
	
		/* 2 */
		$lblsupp=isset($rows[$j]['suppid'])? $rows[$j]['supplier'].' - #'.$rows[$j]['suppid']:'NO Supplier';
		$lsrow="<tr><th colspan='".$numcols."' >".$lblsupp."</th></tr>";
		echo $lsrow;
	} 
?>	

<?php endfor; ?>



<tr>
<th colspan="7" >Inventory Sold Total</th>
<th class="right" ><?php echo number_format($total,2); ?></th>
<?php echo ($terminal>0)? '<td></td>':NULL; ?>
<th></th>
</tr>

<?php if(round($total)!=round($pos_total)): ?>
	<tr>
		<th colspan="7" >POS OR Sales Total</th>
		<th class="right" ><?php echo number_format($pos_total,2); ?></th>
		<?php echo ($terminal>0)? '<td></td>':NULL; ?>
		<th></th>
	</tr>
<?php endif; ?>

</table>

<div class="ht50" ></div>


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

