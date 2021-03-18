<h5>
	<?php echo $cr['classroom']; ?> Teachers
	| <a href="<?php echo URL; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	
	
</h5>

<?php 
	// pr($cr);
	// pr($rows[0]);
	
	
	
?>


<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" ><th>#</th><th>Tcid</th><th>Teacher</th><th>Traits</th>
<th class="hd" >Delete</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
	<tr>
		<td><?php echo $i+1; ?></td></td>
		<td><?php echo $rows[$i]['tcid']; ?></td></td>
		<td><?php echo $rows[$i]['teacher']; ?></td></td>
		<td><a href="<?php echo URL.'trs/view/'.$cr['trsid'].DS.$rows[$i]['tcid'].DS.$sy.DS.$qtr; ?>" >View</a></td></td>
		<td><a href="<?php echo URL.'trs/deleteTrsGradesByTeacher/'.$cr['trsid'].DS.$rows[$i]['tcid'].DS.$sy.DS.$qtr; ?>" 
			onclick="return confirm('Dangerous! Sure?');" >
			Delete</a></td></td>
		
	</tr>
<?php endfor; ?>
</table>
