<h3>
	Tuition Amount SY<?php echo $sy; ?>
	
</h3>

<?php 
	pr("&exe");

?>


<table class="gis-table-bordered table-altrow" >
<tr>
	<th>Level</th>
	<th>Lvl</th>
	<th>Num</th>
	<th>Saved<br />Tuition<br />Amount</th>
	<th>Tuition<br />Amount</th>
	<th>Total</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $rows[$i]['level']; ?></td>
	<td><?php echo $rows[$i]['level_id']; ?></td>
	<td><?php echo $rows[$i]['num']; ?></td>
	<td><?php echo number_format($rows[$i]['saved_tuition_amount'],2); ?></td>
	<td><?php echo number_format($rows[$i]['tuition_amount'],2); ?></td>
	<td><?php echo number_format($rows[$i]['total'],2); ?></td>
</tr>
<?php endfor; ?>
</table>


<div class="ht100" ></div>