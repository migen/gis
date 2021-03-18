<?php 
	// pr($contact); 

?>


<tr><th class="vc150" >CID</th><td><?php echo $contact["id"]; ?></td></tr>
<tr><th class="vc150" >Status</th><td class="vc300" >
<select id="is_active" class="full" name="contact[is_active]" >
	<option value="1" <?php echo ($contact["is_active"])? "selected" : null; ?> >Active</option>
	<option value="0" <?php echo (!$contact["is_active"])? "selected" : null; ?> >Not Active</option>
</select>
</td></tr>

<tr><th class="vc150" >Gender</th><td class="vc300" >
<select id="mle" class="full" name="contact[mle]" >
	<option value="1" <?php echo ($contact["is_male"])? "selected" : null; ?> >Male</option>
	<option value="0" <?php echo (!$contact["is_male"])? "selected" : null; ?> >Female</option>
</select>
</td></tr>

<tr><th class="vc150" >Cleared</th><td class="vc300" >
<select id="is_cleared" class="full" name="contact[is_cleared]" >
	<option value="1" <?php echo ($contact["is_cleared"])? "selected" : null; ?> >Cleared</option>
	<option value="0" <?php echo (!$contact["is_cleared"])? "selected" : null; ?> >Not Cleared</option>
</select>
</td></tr>

<tr><th class="vc150" >Org / Person</th><td class="vc300" >
<select id="is_org" class="full" name="contact[is_org]" >
	<option value="1" <?php echo ($contact["is_org"])? "selected" : null; ?> >Org</option>
	<option value="0" <?php echo (!$contact["is_org"])? "selected" : null; ?> >Person</option>
</select>
</td></tr>

<tr><th class="vc150" >School Year</th><td><input id="sy" class="full pdl05 sy" type="number" name="contact[sy]" 
	value="<?php echo $contact['sy']; ?>" ></td></tr>

<tr><th class="vc150" >Beg SY</th><td><input id="begsy" class="full pdl05 sy" type="number" name="contact[begsy]" 
	value="<?php echo $contact['begsy']; ?>" ></td></tr>
	
	
<tr><th class="vc150" >Classroom</th><td>
	<select id="crid" class="full pdl05 crid" name="contact[crid]" >
		<?php	foreach($data["selects"]["classrooms"] as $sel): ?>
		<option <?php echo ($sel["id"]==$contact["crid"])? "selected" : null; ?> 
			value="<?php echo $sel['id']; ?>" >
			<?php echo $sel["name"]; ?>
		</option><?php	endforeach; ?>
	</select>		
</td></tr>


<tr><th class="vc140" >Remarks</th><td><input id="remarks" class="full pdl05 remarks" type="text" name="contact[remarks]" 
	value="<?php echo $contact["remarks"]; ?>" ></td></tr>


<tr><th class="vc150" >Title</th><td>
	<select onchange="xgetPriv(this.value);" id="title_id" class="full pdl05 title" name="contact[title_id]" >
		<option value="0">Select one</option>
		<?php	foreach($data["selects"]["titles"] as $sel): ?>
		<option <?php echo ($sel["id"] == $contact["title_id"])? "selected" : null; ?> value="<?php echo $sel["id"]; ?>" >
			<?php echo $sel["name"]; ?></option><?php	endforeach; ?>
	</select>		
</td></tr>
<tr>

<tr><th class="vc150" >R-Priv</th><td>
	<input id="role_id" class="pdl05 roleid" type="text" name="contact[role_id]" value="<?php echo $contact["role_id"]; ?>" readonly /> 
	<input id="privilege_id" class="pdl05 privid" type="text" name="contact[priv_id]" value="<?php echo $contact["privilege_id"]; ?>" readonly />
</td></tr>


<tr><td colspan="2" >
	<button id="ucbtn" onclick="xeditContact();return false;" >Update Contact</button>
</td></tr>

