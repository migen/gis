<h5>
Add Feetype

</h5>

<form method="POST" >
<table class="gis-table-bordered" >

<tr><th>Parent</th><td>
<select class="full" name="parent_id" >
<?php foreach($feetypes AS $sel): ?>
	<option value="<?php echo $sel['id']; ?>"  ><?php echo $sel['name']; ?></option>
<?php endforeach; ?>
</select>
</td></tr>

<tr><th>Name</th><td>
<input class="pdl05" type="text" name="name"  />
</td></tr>

<tr><td colspan="2" >
<input type="submit" name="submit" value="Save"  />
</td></tr>

</table>


</form>


