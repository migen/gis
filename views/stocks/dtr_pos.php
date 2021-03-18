<h5 class="screen" >
	<?php echo $today; ?> Daily Terminal Report (DTR)
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				 	
	| <a class="u" id="btnExport" >Excel</a> 

	
</h5>

<?php 
	$numcols='10';
	// pr($rows[1]);
	$incs = "incs/dtr_filter.php";
	include_once($incs);
?>


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
	<th>Supp</th>
	<th>Prid</th>
	<th>Barcode</th>
	<th>Product</th>
	<th class="right" >Price</th>
	<th>Paid</th>
	<th>Sold</th>
	<th>Amount</th>
	<?php if($terminal>0): ?>
		<th>T<?php echo $terminal; ?></th>
	<?php endif; ?>
	<th>Level</th>
</tr>

<?php 
$total=0;
?>
<tr><th colspan="<?php echo $numcols; ?>" ><?php echo @$rows[0]['supplier']; ?></th></tr>

<?php for($i=0;$i<$count;$i++): ?>
<?php 
	$amount=$rows[$i]['price']*$rows[$i]['sold'];
	$total+=$amount;
?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['suppid']; ?></td>
	<td><?php echo str_pad($rows[$i]['prodid'], 4, '0', STR_PAD_LEFT); ?></td>
	<td class="" ><?php echo $rows[$i]['barcode']; ?></td>
	<td class="" ><?php echo $rows[$i]['product']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['price'],2); ?></td>
	<td class="right" ><?php echo ($rows[$i]['is_paid']==1)? 'Y':'N'; ?></td>
	<td class="right" ><?php echo $rows[$i]['sold']; ?></td>
	<td class="right" ><?php echo number_format($amount,2); ?></td>
<?php if($terminal>0): ?>	
	<td class="right" ><?php echo $rows[$i]['tq']; ?></td>
<?php endif; ?>	
	<td class="right" ><?php echo $rows[$i]['level']; ?></td>
</tr>

<?php 
	$j=$i+1;
	if($rows[$i]['suppid']!=@$rows[$j]['suppid']){
		$lblsupp=isset($rows[$j]['suppid'])? $rows[$j]['supplier'].' - #'.$rows[$j]['suppid']:'NO Supplier';
		$lsrow="<tr><th colspan='".$numcols."' >".$lblsupp."</th></tr>";
		echo $lsrow;
	} 
?>	


<?php endfor; ?>
<tr>
<th colspan="8" >Inventory Sold Total</th>
<th class="right" ><?php echo number_format($total,2); ?></th>
<?php echo ($terminal>0)? '<td></td>':NULL; ?>
<th></th>
</tr>

<tr>
<th colspan="8" >POS OR Sales Total</th>
<th class="right" ><?php echo number_format($pos_total,2); ?></th>
<?php echo ($terminal>0)? '<td></td>':NULL; ?>
<th></th>
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

