<!-- cr_filter for classlist,prom,prep -->

<?php 

// pr($data);
$classrooms = $data['classrooms'];

?>

<!--   =================== filter classroom =================================  -->
<form method="POST" >
<table class="gis-table-bordered screen" >
<tr>
	<th class="bg-blue2 white vc100" >Class</th>
	<td class="vc150" >
		<select class="full" name="cf[crid]"  >
			<?php foreach($classrooms AS $row): ?>
				<option value="<?php echo $row['id']; ?>" <?php echo ($row['id'] == $data['crid'])? 'selected' : null; ?>  > <?php echo $row['name']; ?> </option>
			<?php endforeach;?>
		</select>
	</td>
</tr>
<tr>
	<th class="bg-blue2 white vc100" >School Year</th>
	<td class="vc150" > <input class="pdl05 full" type="number" name="cf[sy]" value="<?php echo $data['sy']; ?>"  > </td>
</tr>


<input type="hidden" name="cf[is_curr]" value="1" />


<tr> <td colspan=2 > <input type="submit" name="filter" value="Filter"  > </td> </tr>
</table>
</form>

