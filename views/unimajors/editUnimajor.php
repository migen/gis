<h5>
	Edit Major | <?php $this->shovel('homelinks','College'); ?>
	
	
	
	
</h5>

<?php 

// pr($data);

?>

<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr><th>Code</th><td><?php echo $row['code']; ?></td></tr>
<tr><th>Major</th><td><?php echo $row['name']; ?></td></tr>
<tr><th>College</th><td>
<select name="post[college_id]" >
<?php foreach($unicolleges AS $sel): ?>
	<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$row['college_id'])? 'selected':NULL; ?> >
		<?php echo $sel['name']; ?></option>
<?php endforeach; ?>
</select>
</td></tr>
<tr><th>Years</th><td><input type="number" class="vc50" name="post[years]" value="<?php echo $row['years']; ?>" ></td></tr>

</table>
<br />
<input type="submit" name="submit" value="Save" >

</form>