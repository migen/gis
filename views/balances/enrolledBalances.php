<h5>
	<?php echo $level['name']; ?> Enrolled (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'balances/updateEnrolled/'.$lvl; ?>" >Update Enrolled</a>

</h5>

<p>*Made <span class="b" >payments</span> excluding reservation fee (#0).</p>

<?php 
// pr($rows[0]);
// pr($rows);
?>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Scid</th>
	<th>Code</th>
	<th>Student</th>
	<th>Total</th>
	<th>Ptr</th>
	<th>Enrl</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['total'],0); ?></td>
	<td><?php echo $rows[$i]['pointer']; ?></td>
	<td><?php echo $rows[$i]['is_enrolled']; ?></td>
</tr>
<?php endfor; ?>
</table>
