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
	<td> Components </td>
</tr>
<?php for($i=0;$i<$num_levels;$i++): ?>
<tr>
	<td> <?php echo $levels[$i]['id']; ?> </td>
	<td class="u" > 
		<a href="<?php echo URL.'mis/components/'.$levels[$i]['id']; ?>" > <?php echo $levels[$i]['name']; ?> </a> </td>
	 
</tr>
<?php endfor; ?>

</table>