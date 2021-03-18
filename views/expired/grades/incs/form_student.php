<?php


// pr($tsum);
// echo '<hr />';
// pr($summary);
// pr($profile);
// pr($contact);

?>


<form method="POST" >

<div class="unbordered" style="float:left;width:40%;" >	<!-- left -->

<table class="gis-table-bordered" >

<tr class="" ><th colspan="2" class="vc300" ><span class="u" onclick="ilabas('trcontact')" >Contact</span></th></tr>
<tr class="trcontact" ><th>Fullname</th><td class="vc200" ><?php echo $contact['name']; ?></td></tr>

<tr class="trcontact" ><th>ID Number</th><td class="" ><?php echo $contact['code']; ?></td></tr>

<tr class="trcontact" ><th>Last Name</th><td><?php echo $profile['last_name']; ?></td></tr>
	
<tr class="trcontact" ><th>Given Name</th><td><?php echo $profile['first_name']; ?></td></tr>
	
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

<tr class="trcontact" ><th>Birthdate</th><td><?php echo $profile['birthdate']; ?></td></tr>
<tr class="trcontact" ><th>Birth Place</th><td><?php echo $profile['birthplace']; ?></td></tr>
<tr class="trcontact" ><th>phone</th><td><?php echo $profile['phone']; ?></td></tr>
	
<tr class="trcontact" ><th>Home Address</th>
	<td><textarea cols="30" rows="2" name="profile[address]" ><?php echo (isset($profile['address']))? $profile['address']:NULL; ?></textarea></td></tr>	
	
	
<!------------------------------------------------------------------------------------------>	

<tr class="" ><th colspan="2" ><span class="u" onclick="ilabas('trstudent')" >Student</span></th></tr>


<tr class="trstudent" ><th>Last School</th><td><?php echo $student['last_school']; ?></td></tr>
<tr class="trstudent" ><th>Last School SY</th><td><?php echo $student['last_school_sy']; ?></td></tr>

	


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



</div>	<!-- left -->

<!------------------------------------------------------------------------------>

<div class="unbordered" style="float:left;width:45%;" >	<!-- left -->

<table class="gis-table-bordered" >

<tr class="" ><th colspan="2" class="vc300" ><span class="u" onclick="ilabas('trprofile')" >Profile</span></th></tr>

<tr class="trprofile" ><th class="vc200" >Father's Fullname</th><td class="" ><?php echo $profile['father']; ?></td></tr>
<tr class="trprofile" ><th class="vc200" >Father's Occupation</th><td class="" ><?php echo $profile['father_occupation']; ?></td></tr>

<tr class="trprofile" ><th class="vc200" >Father's Mobile</th><td class="" ><?php echo $profile['father_mobile']; ?></td></tr>
<tr class="trprofile" ><th class="vc200" >Father's Work Company</th><td class="" ><?php echo $profile['father_work']; ?></td></tr>
<tr class="trprofile" ><th class="vc200" >Father's Work Phone</th><td class="" ><?php echo $profile['father_work_phone']; ?></td></tr>
<tr class="trprofile" ><th class="vc200" >Father's Work Address</th><td class="" ><?php echo $profile['father_work_address']; ?></td></tr>

<tr class="trprofile" ><th class="vc200" >Mother's Fullname</th><td class="" ><?php echo $profile['mother']; ?></td></tr>
<tr class="trprofile" ><th class="vc200" >Mother's Occupation</th><td class="" ><?php echo $profile['mother_occupation']; ?></td></tr>

<tr class="trprofile" ><th class="vc200" >Mother's Mobile</th><td class="" ><?php echo $profile['mother_mobile']; ?></td></tr>
<tr class="trprofile" ><th class="vc200" >Mother's Work Company</th><td class="" ><?php echo $profile['mother_work']; ?></td></tr>

<tr class="trprofile" ><th class="vc200" >Mother's Work Phone</th><td class="" ><?php echo $profile['mother_work_phone']; ?></td></tr>

<tr class="trprofile" ><th class="vc200" >Mother's Work Address</th><td class="" ><?php echo $profile['mother_work_address']; ?></td></tr>



	
</table>

</div>	<!-- left -->










</form>