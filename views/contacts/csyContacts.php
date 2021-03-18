<h5>
	Edit Contact SY (Registered Year)
	
	
</h5>
<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr><td>SCID</td><td><?php echo $row['scid']; ?></td></tr>
<tr><td>Name</td><td><?php echo $row['student']; ?></td></tr>
<tr><td>CSY</td><td><input name="csy" value="<?php echo $row['sy']; ?>" /></td></tr>
<tr><td colspan=2 ><input type="submit" name="submit" value="Update" /></td></tr>
</table>
</form>