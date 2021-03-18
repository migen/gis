<script>

$(function(){
	hd();
	nextViaEnter();
})

</script>

<!-- hyperlinks -->
<h5>
	Profiles 
	| <a href="<?php echo URL; ?>registrars">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
</h5>

<?php

// pr($data);

?>



<!--  =========   PROFILES BELOW =====================  -->

<?php $row = $data["profile"]; ?>

<form method="POST" >
<!-- div1 -->
<div class="accordParent" onclick="selectTable(this.id);return false;" id="1" >
<table class="gis-table-bordered table-fx" >
<tr><th class="vc150" >ID</th><td class="vc250" ><?php echo $row["contact_id"]; ?></td></tr>
<tr><th class="vc150" >Status</th><td>
	<input id='active_status<?php echo $i; ?>' type='radio' name='data[is_active]' value="1" <?php echo ($row['is_active'] == 1)? 'checked':''; ?> />  Active
	<input id='inactive_status<?php echo $i; ?>' type='radio' name='data[is_active]' value="0" <?php echo ($row['is_active'] == 0)? 'checked':''; ?> />  Inactive				
</td></tr>
<tr><th class="vc150" >Remarks</th><td><input class="full pdl05" type="text" name="data[remarks]" value="<?php echo $row['remarks']; ?>" ></td></tr>
<tr><th class="vc150" >ID Number</th><td class="vc250" ><?php echo $row["code"]; ?></td></tr>
<tr><th class="vc150" >Student</th><td><?php echo $row["name"]; ?></td></tr>
<tr><th class="vc150" >First Name</th><td><input class="full pdl05" type="text" name="data[first_name]" value="<?php echo $row['first_name']; ?>" ></td></tr>
<tr><th class="vc150" >Middle Name</th><td><input class="full pdl05" type="text" name="data[middle_name]" value="<?php echo $row['middle_name']; ?>" ></td></tr>
<tr><th class="vc150" >Last Name</th><td><input class="full pdl05" type="text" name="data[last_name]" value="<?php echo $row['last_name']; ?>" ></td></tr>
<tr><th class="vc150" >Suffix Name</th><td><input class="full pdl05"  type="text" name="data[suffix]" value="<?php echo $row['suffix']; ?>" ></td></tr>
<tr><th class="vc150" >Network</th><td><input class="full pdl05" type="text" name="data[sms_network_id]" value="<?php echo $row['sms_network_id']; ?>" ></td></tr>
<tr><th class="vc150" >SMS</th><td><input class="full pdl05" type="text" name="data[sms]" value="<?php echo $row['sms']; ?>" ></td></tr>
<tr><th class="vc150" >Email</th><td><input class="full pdl05" type="text" name="data[email]" value="<?php echo $row['email']; ?>" ></td></tr>
<tr><th class="vc150" >Birthdate</th><td><input class="full pdl05" type="date" name="data[birthdate]" value="<?php echo $row['birthdate']; ?>" ></td></tr>

<tr><th class="vc150" >Nationality</th>
	<td>
		<select class="full pdl05" name="data[nationality_id]" >
			<?php	foreach($data["selects"]["nationalities"] as $sel): ?>
			<option <?php echo ($sel["id"] == $row["nationality_id"])? "selected" : null; ?> value="<?php echo $sel['id']; ?>" ><?php echo $sel["name"]; ?></option><?php	endforeach; ?>
		</select>		
	</td>
</tr>

<tr><th class="vc150" >Religion</th>
	<td>
		<select class="full pdl05" name="data[religion_id]" >
			<?php	foreach($data["selects"]["religions"] as $sel): ?>
			<option <?php echo ($sel["id"] == $row["religion_id"])? "selected" : null; ?> value="<?php echo $sel['id']; ?>" ><?php echo $sel["name"]; ?></option><?php	endforeach; ?>
		</select>		
	</td>
</tr>

<tr><th class="vc150 pdl05" >Province</th>
	<td>
		<select class="full pdl05" name="data[province_id]" >
			<?php	foreach($data["selects"]["provinces"] as $sel): ?>
			<option <?php echo ($sel["id"] == $row["province_id"])? "selected" : null; ?> value="<?php echo $sel['id']; ?>" ><?php echo $sel["name"]; ?></option><?php	endforeach; ?>
		</select>		
		<input class="full pdl05" type='text' name='data[province]' placeholder='New Province'>		
	</td>
</tr>

<tr><th class="vc150" >City</th>
	<td>
		<select class="full pdl05" name="data[city_id]" >
			<?php	foreach($data["selects"]["cities"] as $sel): ?>
			<option <?php echo ($sel["id"] == $row["city_id"])? "selected" : null; ?> value="<?php echo $sel['id']; ?>" ><?php echo $sel["name"]; ?></option><?php	endforeach; ?>
		</select>		
		<input class="full pdl05" type='text' name='data[city]' placeholder='New City'>			
	</td>
</tr>

<tr><th class="vc150" >Barangay</th><td><input class="full pdl05" type="text" name="data[barangay]" value="<?php echo $row['barangay']; ?>" ></td></tr>
<tr><th class="vc150" >Street</th><td><input class="full pdl05" type="text" name="data[street]" value="<?php echo $row["street"]; ?>" ></td></tr>
<tr>
	<td><input type="submit" name="submit" value="Update" ></td>
	<td><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>"> <button> Cancel </button> </a></td>
</tr>


</table>
<!-- div1 -->
</div>



<input type="hidden" name="data[contact_id]" value="<?php echo $row['scid']; ?>"  />


</form>





