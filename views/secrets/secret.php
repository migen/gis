<h5>
	Secret
	
</h5>

<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr><th>Name</th><td>
	<input name="name" class="pdl05" value="<?php echo (isset($row))? $row['name']:NULL; ?>" />
</td></tr>
<tr><th>Clear</th><td>
	<input name="clear" class="pdl05" value="<?php echo (isset($row))? $row['clear']:NULL; ?>"  />
</td></tr>


</table>

<p>
	<input type="submit" name="submit" value="Submit"  />
	
</p>

</form>
