<h3>
	Tuition Fees | <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."tuitions/edit/$lvl/$sy"; ?>' >Edit</a>
	
</h3>

<?php 

// pr($_SERVER);
// pr($level);

?>

<table class="gis-table-bordered" >
	<tr><th>Level</th><td><?php echo $level['name'].' #'.$level['id']; ?></td></tr>
</table><br />



<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>Detail</th>
	<th>Amount</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['detail']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['amount'],2); ?></td>
</tr>
<?php endfor; ?>
</table>
