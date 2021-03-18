<h5 class="screen" >
	Std Classrooms
	<?php $this->shovel('homelinks'); ?>
	| <?php echo "<a href='".URL."teachers/unsetter/classrooms' >RESET</a>"; ?>

</h5>


<table class="gis-table-bordered" >
<tr><th>ID</th><th>Classroom</th></tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
</tr>
<?php endfor; ?>
</table>
