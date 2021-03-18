<?php 

// pr($classroom);

?>

<h5>
	Edit Classroom Adviser
	
	
</h5>


<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr><th>CRID</th><td><?php echo $crid; ?></td></tr>
<tr><th>Classroom</th><td><?php echo $classroom['name']; ?></td></tr>
<tr><th>Adviser</th><td>
<select class="vc300" name="acid" >
	<?php foreach($teachers AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$classroom['acid'])? 'selected':NULL; ?> >
			<?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select>
</td></tr>

<tr><th>Coordinator</th><td>
<select class="vc300" name="hcid" >
	<?php foreach($coordinators AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$classroom['hcid'])? 'selected':NULL; ?> >
			<?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select>
</td></tr>


<tr><td colspan="2" ><input onclick="return confirm('Proceed?');" type="submit" name="submit" value="Update"  /></td></tr>
</table>
