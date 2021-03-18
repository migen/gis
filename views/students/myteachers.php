<?php 



?>


<h5>
	Evaluation SY-<?php echo $sy; ?> Period-<?php echo $period; ?>
	| <a href="<?= URL.'students/dashboard'; ?>" > Home </a>


</h5>




<table class="gis-table-bordered table-fx table-altrow"  >
<tr class="headrow" ><th>#</th><th>Teacher</th></tr>

<?php for($i=0;$i<$num_teachers;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><a href='<?php echo URL."students/evaluation/$sy/$period/".$teachers[$i]['tcid']; ?>' ><?php echo $teachers[$i]['teacher']; ?></a></td>
</tr>
<?php endfor; ?>
</table>
