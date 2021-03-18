<?php 
	// pr($data);
	// pr($levels[0]);

?>


<!-- ============================================================== -->

<h5>
	<a href="<?php echo URL.'info'; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	<?php if($_SESSION['user']['role_id']==RMIS): ?>
		| <a href='<?php echo URL."setup/grading/".$sy;  ?>' > Setup</a>	
		| <a href='<?php echo URL."dashboard/mis/".$sy;  ?>' > Dashboard </a>	
	<?php endif; ?>
</h5>

<!-- ============================================================== -->
<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th> # </th>
	<th> Components </th>
	<th> Classes </th>
	<th> Courses </th>
</tr>
<?php for($i=0;$i<$num_levels;$i++): ?>
<tr>
	<td> <?php echo $levels[$i]['id']; ?> </td>
	<td> <a href="<?php echo URL.'mis/components/'.$levels[$i]['id'].DS.$sy; ?>" > <?php echo $levels[$i]['name']; ?> </a> </td>
	<td> <a href="<?php echo URL.'data/students/'.$levels[$i]['id'].DS.$sy; ?>" > Students </a> </td>
	<td> <a href="<?php echo URL.'gset/courses/'.$levels[$i]['id'].DS.$sy; ?>" > Subjects </a> </td>
		 
</tr>
<?php endfor; ?>

</table>