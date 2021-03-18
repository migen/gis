
<form method="GET" >
<table class="gis-table-bordered" >
<tr>
	<th>Name</th>
	<td><input name="name" ></td>
	
	<th>Level</th>
	<td>
		<select name="lvl" >
		<option value="0" >Choose Level</option>
		<?php foreach($levels AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>"
				<?php echo (isset($_GET['lvl']) && $_GET['lvl']==$sel['id'])? 'selected':NULL; ?> >
				<?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select>	
	</td>
	
	<td><input type="submit" name="submit" value="Filter" >	
</tr>




</table>
</form>

