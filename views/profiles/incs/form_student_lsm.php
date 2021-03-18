<?php


// pr($tsum);
// echo '<hr />';
// pr($summary);
// pr($profile);

?>


<form method="POST" >

<div class="unbordered" style="float:left;width:40%;" >	<!-- left -->

<table class="gis-table-bordered" >

<tr class="" ><th colspan="2" class="vc300" ><span class="u" onclick="ilabas('trcontact')" >Contact</span></th></tr>
<tr class="trcontact" ><th>Fullname</th><td class="vc200" ><input class="pdl05 vc250 " 
	value="<?php echo (isset($contact['name']))? $contact['name']:NULL; ?>" readonly /></td></tr>

<tr class="trcontact" ><th>ID Number</th><td class="" ><input class="pdl05 vc250" name="contact[code]" 
	value="<?php echo (isset($contact['code']))? $contact['code']:NULL; ?>" /></td></tr>

<tr class="trcontact" ><th>Last Name</th><td><input class="pdl05 vc250" name="profile[last_name]" 
	value="<?php echo (isset($profile['last_name']) && ($profile['last_name']!=''))? $profile['last_name']:$last_name; ?>" /></td></tr>
	
<tr class="trcontact" ><th>Given Name</th><td><input class="pdl05 vc250" name="profile[first_name]" 
	value="<?php echo (isset($profile['first_name']) && ($profile['first_name']!=''))? $profile['first_name']:$first_name; ?>" /></td></tr>
	
<tr class="trcontact" ><th>Nationality</th><td>
<select name="profile[nationality_id]" >
	<?php foreach($nationalities AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" 			
			<?php if(!$profile['nationality_id']){ echo ($sel['id']==1)? 'selected':NULL; } ?> 
			<?php echo ($sel['id']==$profile['nationality_id'])? 'selected':NULL; ?> >
			<?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select>		
</td></tr>

<tr class="trcontact" ><th>Religion</th><td>
<select name="profile[religion_id]" >
	<?php foreach($religions AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" 			
			<?php if(!$profile['religion_id']){ echo (strtoupper($sel['id'])==1)? 'selected':NULL; } ?> 
			<?php echo ($sel['id']==$profile['religion_id'])? 'selected':NULL; ?> >
			<?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select>		
</td></tr>

<tr class="trcontact" ><th>Birthdate</th><td><input type="date" class="pdl05 vc250" name="profile[birthdate]" 
	value="<?php echo (isset($profile['birthdate']))? $profile['birthdate']:NULL; ?>" /></td></tr>
	
<tr class="trcontact" ><th>Birth Place</th><td><input class="pdl05 vc250" name="profile[birthplace]" 
	value="<?php echo (isset($profile['birthplace']))? $profile['birthplace']:NULL; ?>" /></td></tr>

<tr class="trcontact" ><th>phone</th>
	<td><textarea cols="30" rows="2" name="profile[phone]" ><?php echo (isset($profile['phone']))? $profile['phone']:NULL; ?></textarea></td></tr>		
	
<tr class="trcontact" ><th>Home Address</th>
	<td><textarea cols="30" rows="2" name="profile[address]" ><?php echo (isset($profile['address']))? $profile['address']:NULL; ?></textarea></td></tr>	
	
	
<!------------------------------------------------------------------------------------------>	

<tr class="" ><th colspan="2" ><span class="u" onclick="ilabas('trstudent')" >Student</span></th></tr>


<tr class="trstudent" ><th>Last School</th><td><input class="pdl05 vc250" name="student[last_school]" 
	value="<?php echo (isset($student['last_school']))? $student['last_school']:NULL; ?>" /></td></tr>

	
<tr class="trstudent" ><th>Last School SY</th><td><input class="pdl05 vc250" name="student[last_school_sy]" 
	value="<?php echo (isset($student['last_school_sy']))? $student['last_school_sy']:NULL; ?>" /></td></tr>


<tr class="trstudent" ><th>Last School Level</th><td>
<select name="student[last_school_level_id]" >
	<?php foreach($levels AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$student['last_school_level_id'])? 'selected':NULL; ?> >
			<?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select>	
</td></tr>
	
<tr class="trstudent" ><th>Last School Address</th><td class="" ><input class=" pdl05 vc250" name="student[last_school_address]" 
	value="<?php echo (isset($student['last_school_address']))? $student['last_school_address']:NULL; ?>" /></td></tr>
	
	
</table>

<p>
	<?php if($_SESSION['srid']!=RSTUD): ?>
		<input type="submit" name="submit" value="Submit" onclick="return confirm('Sure?');"  />
		<button><a href="<?php echo URL.'reservations/acknowledgement/'.$student['contact_id'].DS.$sy; ?>" 
			class="no-underline txt-black" >Acknowledgement Letter</a></button>
	<?php endif; ?>
	
</p>


</div>	<!-- left -->

<!------------------------------------------------------------------------------>

<div class="unbordered" style="float:left;width:45%;" >	<!-- left -->

<table class="gis-table-bordered" >

<tr class="" ><th colspan="2" class="vc300" ><span class="u" onclick="ilabas('trprofile')" >Profile</span></th></tr>

<tr class="trprofile" ><th class="vc200" >Father's Fullname</th><td class="" ><input class="pdl05 vc250" name="profile[father]" 
	value="<?php echo (isset($profile['father']))? $profile['father']:NULL; ?>" /></td></tr>

<tr class="trprofile" ><th>Father's Occupation</th><td><input class="pdl05 vc250" name="profile[father_occupation]" 
	value="<?php echo (isset($profile['father_occupation']))? $profile['father_occupation']:NULL; ?>" /></td></tr>
	
<tr class="trprofile" ><th>Father's Mobile</th><td><input class="pdl05 vc250" name="profile[father_mobile]" 
	value="<?php echo (isset($profile['father_mobile']))? $profile['father_mobile']:NULL; ?>" /></td></tr>

<tr class="trprofile" ><th>Father's Work Company</th><td><input class="pdl05 vc250" name="profile[father_work]" 
	value="<?php echo (isset($profile['father_work']))? $profile['father_work']:NULL; ?>" /></td></tr>

<tr class="trprofile" ><th>Father's Work Phone</th><td><input class="pdl05 vc250" name="profile[father_work_phone]" 
	value="<?php echo (isset($profile['father_work_phone']))? $profile['father_work_phone']:NULL; ?>" /></td></tr>

<tr class="trprofile" ><th>Father's Work Address</th><td><input class="pdl05 vc250 " name="profile[father_work_address]" 
	value="<?php echo (isset($profile['father_work_address']))? $profile['father_work_address']:NULL; ?>" /></td></tr>


<tr class="trprofile" ><th>Mother's Fullname</th><td><input class="pdl05 vc250" name="profile[mother]" 
	value="<?php echo (isset($profile['mother']))? $profile['mother']:NULL; ?>" /></td></tr>

<tr class="trprofile" ><th>Mother's Occupation</th><td><input class="pdl05 vc250" name="profile[mother_occupation]" 
	value="<?php echo (isset($profile['mother_occupation']))? $profile['mother_occupation']:NULL; ?>" /></td></tr>
	
<tr class="trprofile" ><th>Mother's Mobile</th><td><input class="pdl05 vc250" name="profile[mother_mobile]" 
	value="<?php echo (isset($profile['mother_mobile']))? $profile['mother_mobile']:NULL; ?>" /></td></tr>

<tr class="trprofile" ><th>Mother's Work Company</th><td><input class="pdl05 vc250" name="profile[mother_work]" 
	value="<?php echo (isset($profile['mother_work']))? $profile['mother_work']:NULL; ?>" /></td></tr>

<tr class="trprofile" ><th>Mother's Work Phone</th><td><input class="pdl05 vc250" name="profile[mother_work_phone]" 
	value="<?php echo (isset($profile['mother_work_phone']))? $profile['mother_work_phone']:NULL; ?>" /></td></tr>

<tr class="trprofile" ><th>Mother's Work Address</th><td><input class="pdl05 vc250 " name="profile[mother_work_address]" 
	value="<?php echo (isset($profile['mother_work_address']))? $profile['mother_work_address']:NULL; ?>" /></td></tr>
	

	
</table>

</div>	<!-- left -->










</form>