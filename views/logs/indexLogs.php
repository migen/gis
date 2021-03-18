<h3>
	Logs <?php echo $sy; ?> | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'logs?sy='.$sy; ?>">Filter</a>
	| <a class="u" id="btnExport" >Excel</a> 	
	
	

</h3>

<p class="brown" >&get &filter &limit</p>

<?php 
	include_once('incs/filter_logs_simple.php');

?>


<?php if($count>0): ?>

<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Date</th>
	<th>User</th>
	<th>Details</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['datetime']; ?></td>
	<td><?php echo $rows[$i]['username']; ?></td>
	<td><?php echo $rows[$i]['details']; ?></td>
</tr>
<?php endfor; ?>
</table>

<?php endif; ?>

<div class="ht100" ></div>