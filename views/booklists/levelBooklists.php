<h3>
	<?php echo $level['name']; ?> Books | <?php $this->shovel('homelinks'); ?>
	<?php include('linksBooklists.php'); ?>

</h3>

<?php 
	
?>


<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Subject</th>
	<th>Sem</th>
	<th>Code</th>
	<th>Name</th>
	<th>Company</th>
	<th class="right" >Amount</th>
</tr>
<?php $total=0; ?>
<?php for($i=0;$i<$count;$i++): ?>
<?php $total+=$rows[$i]['amount']; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['subjname']; ?></td>
	<td><?php echo $rows[$i]['semester']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['company']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['amount'],2); ?></td>
</tr>
<?php endfor; ?>
<tr>
	<th colspan=7>Total</th>
	<th class="right" ><?php echo number_format($total,2); ?></th>
</tr>
</table>


<div class="ht100" ></div>
