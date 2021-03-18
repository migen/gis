

<div class="screen" >	<!-- filter -->
<form method="GET" >
<table class="gis-table-bordered" >
	<tr>
		<th>Classroom</th>
		<td><select name="crid" onchange="clearLvl();return false;" >
			<option value="0" >Classroom</option>
			<?php foreach($classrooms AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" >
					<?php echo $sel['name']; ?></option>
			<?php endforeach; ?>	
		</select></td>
	</tr>
		
	<tr>
		<th>Level</th>	
		<td><select name="lvl" onchange="clearCrid();return false;" >
			<option value="0" >Level</option>
			<?php foreach($levels AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>"  >
					<?php echo $sel['name']; ?></option>
			<?php endforeach; ?>	
		</select></td>
	</tr>
	<tr>	
		<th>Mode</th>	
		<td><select name="mode" >
			<option value="0" >Mode</option>
			<?php foreach($paymodes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>"  >
					<?php echo $sel['name']; ?></option>
			<?php endforeach; ?>	
		</select></td>
	</tr>
	<tr>
		<th>View</th>	
		<td><select name="view" >
			<option value="1" >With View</option>
			<option value="0" >No View</option>
		</select></td>
	</tr>
	<tr>
		<th>SY</th>	
		<td>
			<select name="sy" >
				<option><?php echo DBYR; ?></option>
				<option value="0">All SY</option>
				<option><?php echo (DBYR-1); ?></option>
				<option><?php echo (DBYR+1); ?></option>
			</select>
		</td>
	</tr>
	
	<input type="hidden" name="active" value="1"  />

	<tr>
		<th>Active</th>	
		<td>
			<select name="active" >
				<option value="1">Active</option>
				<option value="0">All</option>
			</select>
		</td>
	</tr>
	
	<tr>		
		<th>&nbsp;</th>	
		<td>
			<input type="submit" name="filter" value="Filter"   />
			<button><a href='<?php echo URL."ledgers/filter"; ?>' >Clear</a></button>			
		</td>
	</tr>


</table>
</form>
</div>	<!-- filter -->