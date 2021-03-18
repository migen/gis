<?php 
	// pr($data);

?>


<!-- ============================================================== -->

<h5>
	<a href="<?php echo URL.'mis'; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	
</h5>

<!-- ============================================================== -->
<table class="gis-table-bordered table-fx" >
<tr class="headrow" >
	<td> # </td>
	<td> Classrooms </td>
	<td> Components </td>
</tr>
<?php for($i=0;$i<$num_levels;$i++): ?>
<tr>
	<td> <?php echo $levels[$i]['id']; ?> </td>
	<td> <a href="<?php echo URL.'mis/classrooms/'.$levels[$i]['id'].DS.$sy; ?>" > <?php echo $levels[$i]['name']; ?> </a> </td>
	<td> <a href="<?php echo URL.'mis/components/'.$levels[$i]['id'].DS.$sy; ?>" > <?php echo 'Edit'; ?> </a> </td>
</tr>
<?php endfor; ?>

</table>