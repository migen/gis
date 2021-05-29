<h3>
	V2 Logs | <?php $this->shovel('homelinks'); ?>
	
	

</h3>

<p class="brown" >&get &filter &limit</p>

<?php 
	include_once('incs/filter_v2logs.php');

?>


<?php if(isset($data)): ?>

<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Date</th>
	<th>Details</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['datetime']; ?></td>
	<td><?php echo $rows[$i]['details']; ?></td>
</tr>
<?php endfor; ?>
</table>

<?php endif; ?>