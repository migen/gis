<!-- cr_filter for classlist,prom,prep -->

<?php 
	pr($data);
	echo '<hr />';
	pr($selectsClassrooms);
?>

<form method="POST" >
<table class="gis-table-bordered" >
<tr>
	<td>Class</td>
	<td>
		<select class="full" name="cf[crid]"  >
			<?php foreach($classrooms AS $row): ?>
				<option value="<?php echo $row['id']; ?>" > <?php echo $row['name']; ?> </option>
			<?php endforeach;?>
		</select>
	</td>
</tr>
<tr>
	<td>Current Year</td>
	<td> <input type="number" name="cf[sy]" value="<?php echo $sy; ?>"  > </td>
</tr>

<tr>
	<td>Current / Previous </td>
	<td> 
		<select class="full" name="cf[is_current]" >
			<option value="1" > Current </option>
			<option value="0" > Previous </option>
		</select>
	</td>
</tr>
<tr> <td colspan=2 > <input type="submit" name="filter" value="Filter"  > </td> </tr>
</table>
</form>
