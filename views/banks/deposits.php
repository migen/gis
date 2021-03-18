
<h5>
	Bank Deposits (<?php echo $count; ?>)
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href="<?php echo URL.'banks/deposit'; ?>">Add</a> 	



</h5>

<?php 

	// include_once('incs/deposit_filter.php');

?>

<table class="gis-table-bordered table-fx" >
<tr>
	<th>#</th>
	<th>Date</th>
	<th>Bank</th>
	<th>Amount</th>
	<th>Reference</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['date']; ?></td>
	<td><?php echo $rows[$i]['bank']; ?></td>
	<td><?php echo $rows[$i]['amount']; ?></td>
	<td><?php echo $rows[$i]['reference']; ?></td>
</tr>
<?php endfor; ?>
</table>
