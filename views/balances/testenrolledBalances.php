<h5>
	<?php echo $level['name']; ?> Unenrolled (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'balances/updateEnrolled/'.$lvl; ?>" >Update Enrolled</a>

</h5>

<?php 
// pr($rows[0]);
pr($rows);
?>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Scid</th>
	<th>Student</th>
	<th>Amount</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['amount'],0); ?></td>
</tr>
<?php endfor; ?>
</table>
