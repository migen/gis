<h5>
	Awards (AIR)

</h5>

<?php 

$headrow="<tr><th>#</th><th>Name</th><th>Acad</th><th>Cdt</th></tr>";


?>


<h4>Levels</h4>
<table class="gis-table-bordered" >
<?php echo $headrow; ?>
<?php for($i=0;$i<$numlvls;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $levels[$i]['name']; ?></td>
</tr>
<?php endfor; ?>
</table>


<h4>Classrooms</h4>
