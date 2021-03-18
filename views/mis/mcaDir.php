<?php 
	// pr($data);

?>


<!-- ============================================================== -->

<h5>
	<a href="<?php echo URL.'mis'; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'setup/grading'; ?>" > Setup </a>
	| <a href="<?php echo URL.'mis/dashboard'; ?>" > Dashboard </a>
	
</h5>

<!-- ============================================================== -->
<table class="gis-table-bordered table-fx" >
<tr class="headrow" >
	<td> # </td>
	<td> MCA </td>
</tr>
<?php for($i=0;$i<$num_levels;$i++): ?>
<tr>
	<td> <?php echo $levels[$i]['id']; ?> </td>
	<td class="u" > 
		<a href="<?php echo URL.'mis/mca/'.$levels[$i]['id'].DS.$sy; ?>" > <?php echo $levels[$i]['name']; ?> </a> </td>
	 
</tr>
<?php endfor; ?>

</table>