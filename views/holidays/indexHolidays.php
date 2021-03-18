<h5>
	Holidays
	| <?php $this->shovel('homelinks','HR'); ?>
	| <a href="<?php echo URL.'holidays/add'; ?>" >Add</a>	
	<?php if(!isset($_GET['sort'])): ?>
		| <a href="<?php echo URL.'holidays?sort=name'; ?>" >Name</a>
	<?php else: ?>	
		| <a href="<?php echo URL.'holidays?sort=date'; ?>" >Date</a>	
	<?php endif; ?>	
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Date</th>
	<th>Holiday</th>
	<th>PDT ID</th>
	<th></th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['date']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['paydaytype_id']; ?></td>
	<td><a href="<?php echo URL.'holidays/edit/'.$rows[$i]['id']; ?>" >Edit</a></td>
</tr>
<?php endfor; ?>
</table>




