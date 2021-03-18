<!-- hyperlinks -->
<?php 

// pr($data);
?>

<h5>
	<?php echo $data['classroom']['level'].' - '.$data['classroom']['section'].'<br />'; ?>
	Edit Units || 
	<a href="<?php echo URL; ?>registrars">Home</a> || 
	<a href="<?php echo URL.'registrars/units/'.$data['classroom']['crid']; ?>" />Cancel</a>	
</h5>

<?php // pr($data["students"][0]); ?>


<form method="POST">
<table class="gis-table-bordered table-fx ">
<!-- ======== headrow ======= -->
<tr class='bg-blue2'>
	<th class="50" >#</th>
	<th class="100" >ID Number</th>
	<th class="150" >Student</th>
	<th class="100" >Level Entry</th>
	<th class="100" >Previously <br /> Earned <br />Units</th>
	<th class="100" >Is <br />Active</th>	
</tr>


<tr>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>&nbsp;</td>
	<td>
		<input class="vc50" type="text" id="lvl" value="" >
		<input type="button" value="All" onclick="populateLevels();" >	
	
	</td>
	<td>
		<input class="vc50" type="text" id="up" value="" >
		<input type="button" value="All" onclick="populateUnits();" >			
	</td>
</tr>

<?php $i=1; ?>
<?php foreach($data['students'] AS $row): ?>
<tr>
	<td><?php echo $i; ?></td>
	<td><?php echo $row['student_code']; ?></td>
	<td><?php echo $row['student']; ?></td>
	<td class="colshading" ><input class="lvlInput" type="text" name="data[Student][<?php echo $i; ?>][level_entry]" value="<?php echo $row['level_entry']; ?>" /></td>
	<td class="colshading"><input class="upInput" type="text" name="data[Student][<?php echo $i; ?>][units_previous]" value="<?php echo $row['units_previous']; ?>" /></td>
	<td>
		<input type="radio" name="data[Student][<?php echo $i; ?>][is_active]" value="1" <?php echo ($row['is_active'] == 1)? "checked" : null; ?>  >Yes <?php // echo $row['is_active']; ?> <br />
		<input type="radio" name="data[Student][<?php echo $i; ?>][is_active]" value="0" <?php echo ($row['is_active'] == 0)? "checked" : null; ?> />No
	</td>
	
	
		<input type="hidden" name="data[Student][<?php echo $i; ?>][scid]" value="<?php echo $row['scid']; ?>" />
</tr>

<?php $i++; ?>
<?php endforeach; ?>
</table>

<input type="hidden" name="data[current_level]" value="<?php echo $data['classroom']['level_id']; ?>" />
<input type="hidden" name="data[sy]" value="<?php echo $_SESSION['sy']; ?>" />

<input type="submit" name="submit" value="Submit" /> &nbsp; 
<a class="button" href="<?php echo URL.'registrars/units/'.$data['classroom']['crid']; ?>">Cancel</a>
</form>



<script>
	$(function(){
		nextViaEnter();
		columnHighlighting();
	
	});

	function populateUnits(){
		var up = $("#up").val();
		$(".upInput").val(up);
		
	};
	
	function populateLevels(){
		var lvl = $("#lvl").val();
		$(".lvlInput").val(lvl);
		
	};
	

</script>


