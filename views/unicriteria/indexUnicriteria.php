<h5>
	College Criteria | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'unicriteria/add'; ?>" >Add</a>
	| <a href="<?php echo URL.'unicriteria/reset'; ?>" >Reset</a>


</h5>


<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th class="vc100" >code</th>
	<th class="vc200" >Name</th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><a href="<?php echo URL.'unicriteria/edit/'.$rows[$i]['id']; ?>" >Edit</a></td>
</tr>
<?php endfor; ?>
</table>
