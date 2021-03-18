<h5>
	College Sections | <?php $this->shovel('homelinks','College'); ?>
	| <a href="<?php echo URL.'unisections/add'; ?>" >Add</a>
	| <a href="<?php echo URL.'uniclassrooms'; ?>" >Classrooms</a>


</h5>


<p class="b brown" >*TMP (1), OUT (2) are constants.
<br />*If unique sections - unisections/syncCridSxn (ID's)</p>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th class="" >Code</th>
	<th class="" >Name</th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<?php $id=$rows[$i]['id']; ?>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><a href='<?php echo URL."unisections/edit/$id"; ?>' >Edit</a></td>
</tr>
<?php endfor; ?>
</table>
