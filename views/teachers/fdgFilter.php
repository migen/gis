<h5> Finals and DG Filter 
	| <a href="<?php echo URL.'teachers'; ?>" > Home </a>
</h5>


<?php


?>

<table class="gis-table-bordered" >

<tr class="headrow" >
	<th>#</th>
	<th>Level</th>
</tr>

<?php for($i=0;$i<$num_levels;$i++): ?>
<tr>
	<td> <?php echo $levels[$i]['id']; ?> </td>
	<td> <a href="<?php echo URL.'teachers/fdg/'.$levels[$i]['id']; ?>" > <?php echo $levels[$i]['name']; ?> </a> </td>
</tr>	
<?php endfor; ?>
</table>
