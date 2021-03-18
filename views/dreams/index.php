<h5>
	List Trans 
	| <?php $this->shovel('homelinks'); ?>

</h5>

<table class="gis-table-bordered table-altrow" >
<tr><th>ID</th><th>Year</th><th>Item</th></tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['year']; ?></td>
	<td><?php echo $rows[$i]['item']; ?></td>
</tr>
<?php endfor; ?>
</table>
