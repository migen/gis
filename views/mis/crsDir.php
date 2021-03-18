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
</tr>
<?php for($i=0;$i<$num_classrooms;$i++): ?>
<tr>
	<td> <?php echo $classrooms[$i]['id']; ?> </td>
	<td> 
		<a href="<?php echo URL.'mis/courses/'.$classrooms[$i]['id']; ?>" > <?php echo $classrooms[$i]['name']; ?> </a>
	 </td>
</tr>
<?php endfor; ?>

</table>