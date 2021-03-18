<?php 
	$sy = $data['sy'];
	$classrooms = $data['classrooms'];
	$axn = $data['axn'];
	
?>


<tr>
	<td><input class="pdl05 full" type="number" value="<?php echo $sy; ?>" id="sy" 
		min="<?php echo $_SESSION['settings']['year_start']; ?>" max="<?php echo DBYR; ?>" /></td>	
	<td>
		<select class="vc200" onchange="redirectClassroom('<?php echo $axn; ?>',this.value);" >
			<option value="0">Choose One</option>
			<?php foreach($classrooms AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>
</tr>