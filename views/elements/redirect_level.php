<?php 
	$sy = $data['sy'];
	$levels = $data['levels'];
	$axn = $data['axn'];
	$home = $data['home'];
	
?>


<tr><th class="white bg-blue2" >School Year</th>
<td><input class="pdl05 full" type="number" value="<?php echo $sy; ?>" id="sy" min="<?php echo $_SESSION['settings']['year_start']; ?>" max="<?php echo DBYR; ?>" /></td></tr>
<tr><th class="white bg-blue2" >Level</th>
	<td>
		<?php $url = "$home/$axn/"; ?>
		<select class="vc200" onchange="jsredirect('<?php echo $url; ?>'+this.value);" >
			<option value="0">Choose One</option>
			<?php foreach($levels AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>
</tr>