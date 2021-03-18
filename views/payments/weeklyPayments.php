<?php 

// pr($action);
// echo $this->axn();

?>

<h3>
	Payments <?php echo $period; ?> | <?php $this->shovel('homelinks'); ?>
	<?php if($action=='today'): ?>
		| <a href="<?php echo URL.'payments/weekly'; ?>" >Weekly<a>
	<?php else: ?>
		| <a href="<?php echo URL.'payments/today'; ?>" >Today<a>	
	<?php endif; ?>
	
</h3>

<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>Date</th>
	<th>ID No.</th>
	<th>Student</th>
	<th>Classroom</th>
	<th class="right" >Amount</th>
	<th class="right" ></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['date']; ?></td>
	<td><?php echo $rows[$i]['studcode']; ?></td>
	<td><?php echo $rows[$i]['studname']; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['sum_amount'],2); ?></td>
	<td><a href="<?php echo URL.'enrollment/ledger/'.$rows[$i]['scid'].DS.$sy; ?>" >Ledger</td>
</tr>
<?php endfor; ?>
</table>
