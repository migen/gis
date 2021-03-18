<?php 

// pr($classrooms);

?>

<form method="GET" >

<table class="gis-table-bordered table-fx" >
<tr>
<th>From</th>
<td>
<select name="from" >
<?php foreach($classrooms AS $sel): ?>
<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
<?php endforeach; ?>
</select>
</td>
</tr>
<tr>
<th>To</th>
<td>
<select name="to" >
<?php foreach($classrooms AS $sel): ?>
<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
<?php endforeach; ?>
</select>
</td>
</tr>

<tr><td colspan="2" ><input type="submit" name="filter" value="Filter"  /></td></tr>

</table>
</form>


