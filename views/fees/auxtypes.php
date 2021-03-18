<?php 

// pr($rows);
?>

<h5>
	Aux Table
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href="<?php echo URL.'fees/addAuxtype'; ?>">Add</a>

</h5>

<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th class="vc30" >Is<br />Disc</th>
	<th class="vc150" >Name</th>
	<th class="vc100" >Amount</th>
	<th class="vc50" >Edit</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['is_discount']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['amount'],2); ?></td>
	<td>
		<a href='<?php echo URL."fees/editAuxtype/".$rows[$i]['id']; ?>' >Edit</a>
	</td>
</tr>
<?php endfor; ?>
</table>



