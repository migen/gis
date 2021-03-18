<h5>
	Students (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'gset'; ?>" >Gset</a>		
	| <a href="<?php echo URL.'gset/setupStudents'; ?>" >Setup</a>
	| <a href="<?php echo URL.'students/links'; ?>" >Links</a>	
	| <a href="<?php echo URL.'rosters/classroom'; ?>" >Roster</a>
	| <?php $this->shovel('links_gset'); ?>



</h5>

<?php 
pr($rows[0]);

?>


<table class="gis-table-bordered table-altrow" >
<tr><th>ID</th><th>Code</th><th>Name</th></tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td class="right" ><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
</tr>
<?php endfor; ?>
</table>
