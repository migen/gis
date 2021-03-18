<h5>
	Costs History
	| <?php $this->shovel('homelinks'); ?>
	
	
</h5>

<?php // $incs="incs/filter_costlogs.php";include_once($incs); ?>

<table class="gis-table-bordered table-fx" >
<tr>
	<th>#</th>
	<th>Date</th>
	<th>Prid</th>
	<th>Product</th>
	<th>Old Cost</th>
	<th>Cost</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['date']; ?></td>
	<td><?php echo $rows[$i]['prid']; ?></td>
	<td><?php echo $rows[$i]['product']; ?></td>
	<td><?php echo $rows[$i]['oldcost']; ?></td>
	<td><?php echo $rows[$i]['cost']; ?></td>
</tr>
<?php endfor; ?>

</table>


