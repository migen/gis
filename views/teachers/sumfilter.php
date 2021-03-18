


<h5>Summarizer Filter</h5>


<?php 
	// pr($data); 
?>


<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr>

	<td>Classroom</td>
	<td>
		<select class="full" name="crid"  >
			<option>Choose Section</option>
			<?php for($i=0;$i<$num_classrooms;$i++): ?>
				<option value="<?php echo $classrooms[$i]['id']; ?>" >  <?php echo $classrooms[$i]['name']; ?> </option>			
			<?php endfor; ?>
		</select>
	</td>
</tr>

<tr>
	
	<td colspan=2>
		<input type="submit" name="submit" value="Go"  />
	</td>
</tr>


</table>

</form>