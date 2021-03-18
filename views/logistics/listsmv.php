<h5>
	List Stocks Movements
	| <a href="<?php echo URL.$home; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>	

</h5>


<?php 

	include_once('incs/smv_filter.php');
	
?>

<table class="gis-table-bordered table-fx table-altrow" >
<tr>
	<th>#</th>
	<th>Status</th>
	<th>Date</th>
	<th>Src</th>
	<th>Dest</th>
	<th>Modified</th>
	<th>Action</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['status']; ?></td>
	<td><?php echo $rows[$i]['date']; ?></td>
	<td><?php echo "T".$rows[$i]['source_terminal']; ?></td>
	<td><?php echo "T".$rows[$i]['destination_terminal']; ?></td>
	<td><?php echo $rows[$i]['modified']; ?></td>
	<td>
		<a href="<?php echo URL.'logistics/editSmv/'.$rows[$i]['smvid']; ?>" >Edit</a>
	</td>
</tr>
<?php endfor; ?>
</table>