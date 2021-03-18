<?php 

$dbo=PDBO;

?>

<h5>
	Subjects (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'gset'; ?>" >Gset</a>	
	| <a href="<?php echo URL.'subjects/set'; ?>" >Subjects</a>	
	| <a href='<?php echo URL."records/set/{$dbo}.05_subjects"; ?>' >Set</a>
	| <a href='<?php echo URL."records/setup/{$dbo}.05_subjects"; ?>' >Setup</a>
	| <a href='<?php echo URL."gset/setupSubjects"; ?>' >Simple</a>
	| <a href='<?php echo URL."subjects/byLevels"; ?>' >ByLevels</a>	
	| <a href='<?php echo URL."courses/set"; ?>' >Courses</a>	
	<?php if(isset($_GET['order']) && ($_GET['order']=='id')): ?>
		| <a href="<?php echo URL.'gset/subjects'; ?>" >Sort-Name</a>	
	<?php else: ?>
		| <a href="<?php echo URL.'gset/subjects?order=id'; ?>" >Sort-ID</a>
	<?php endif; ?>
	| <?php $this->shovel('links_gset'); ?>
	
	
</h5>

<h4 class="brown" >Code must be 4 characters long.</h4>

<table class="gis-table-bordered table-altrow" >
<tr><th>#</th><th>ID</th><th>Code</th><th>Name</th></tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
</tr>
<?php endfor; ?>

</table>
