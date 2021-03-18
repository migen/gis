<?php 

// pr($rows);
?>

<h5>
	Discounts Table
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href="<?php echo URL.'fees/addDisctype'; ?>">Add</a>

</h5>

<table class="gis-table-bordered table-fx" >
<tr class="headrow" >
	<th>#</th>
	<th class="vc150" >Name</th>
	<th class="vc100" >Amount</th>
	<th class="vc50" >Edit</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo number_format($rows[$i]['amount'],2); ?></td>
	<td>
		<a href='<?php echo URL."fees/editDisctype/".$rows[$i]['id']; ?>' >Edit</a>
	</td>
</tr>
<?php endfor; ?>
</table>



