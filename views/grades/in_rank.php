<h5>
	Grades InRank
	
	
</h5>

<?php 

// pr($data);

if($crs && $scid):

?>

<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr><th>Course</th><th><?php echo $row['course']; ?></th></tr>
<tr><th>Student</th><th><?php echo $row['student']; ?></th></tr>
<tr><th>In Rank</th><th>
<input type="number" min=0 max=1 name="in_rank" value="<?php echo $row['in_rank']; ?>" />
</th></tr>
<tr><th colspan="2" ><input type="submit" name="submit" value="Save"  /></th></tr>


</table>
</form>

<?php endif; ?>


