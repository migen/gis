<h5>
	College Subjects | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'unisubjects/create'; ?>" >Create</a>
	| <a href="<?php echo URL.'unisubjects/reset'; ?>" >Reset</a>
	| <a href="<?php echo URL.'uniclassrooms'; ?>" >Classrooms</a>
	| <a href="<?php echo URL.'college'; ?>" >College</a>


</h5>


<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th class="" >Code</th>
	<th class="" >Name</th>
	<th class="" >Prerequisites</th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<?php $id=$rows[$i]['sub']; ?>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['sub']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['prerequisites']; ?></td>
	<td><a href='<?php echo URL."unisubjects/edit/$id"; ?>' >Edit</a></td>
</tr>
<?php endfor; ?>
</table>
