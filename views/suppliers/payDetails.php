<?php 
// pr($rows[0]);
?>

<h5 class="screen" >
	Payments Details (<?php echo $supp['supplier']; ?>)
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	
	
</h5>

<div class="center" >
<?php 

// $inc = 'incs/sales_letterhead.php';include($inc); 
// $page="Suppliers PO Payments Summary Report";
$inc = SITE.'views/customs/'.VCFOLDER.'/incs/letterhead.php';include($inc); 

?>

</div>


<table class="gis-table-bordered" >
<tr><th>Date Range</th><td><?php echo $dateone.' - '.$datetwo; ?></td></tr>
</table><br />

<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>PO ID</th>
	<th>PO Total</th>
	<th>Date</th>
	<th>Amount</th>
</tr>

<?php $pototal=0; ?>
<?php $paytotal=0; ?>
<?php for($i=0;$i<$count;$i++): ?>
<?php $pototal+=$rows[$i]['total']; ?>
<?php $paytotal+=$rows[$i]['amount']; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><a href="<?php echo URL.'purchases/viewPO/'.$rows[$i]['po_id']; ?>" ><?php echo $rows[$i]['po_id']; ?></a></td>
	<td class="right" ><?php echo number_format($rows[$i]['total'],2); ?></td>	
	<td><?php echo $rows[$i]['date']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['amount'],2); ?></td>
</tr>
<?php endfor; ?>
<tr>
	<td colspan="2" >Total</td>
	<td class="right" ><?php echo number_format($pototal,2); ?></td>
	<td></td>
	<td class="right" ><?php echo number_format($paytotal,2); ?></td>
</tr>
</table>