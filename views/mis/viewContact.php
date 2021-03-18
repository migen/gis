
<?php


// pr($data);


// pr($_SESSION['user']);

//------------------------------------------------
$parts = rtrim($_GET['url'],'/'); 
$parts = explode('/',$parts);		
$home = ($c = ($parts[0]))? $c : 'index'; 			
echo "<h5>"; $this->shovel('homelinks',$home); echo "</h5>";


?>
	

<!--  =========   CONTACT BELOW =====================  -->

<!--
http://localhost/gis/registrars/editContact/2
-->

<div class="accordParent" >	
<button onclick="accorToggle('ctct')" class="vc300 bg-blue2" > <p class="b f16" > <?php echo "Contact"; ?> </p> </button>  	
<table id="ctct" class="gis-table-bordered table-fx" >
<tr class="hd" ><th class="vc150" >ID</th><td><?php echo $contact["id"]; ?></td></tr>


	
<tr><th class="vc150" >ID Number</th><td class="vc250" ><?php echo $contact["code"]; ?></td></tr>
<tr><th class="vc150" >Person</th><td><?php echo $contact["name"]; ?></td></tr>

<?php if($_SESSION['user']['role_id']!=1): ?>
	<tr><th class="vc150" >Status</th><td class="vc300" >
		<input id="active<?php echo $i; ?>" type="radio" name="contact[is_active]" value="1" <?php echo ($contact["is_active"] == 1)? "checked":""; ?> />  Active
		<input id="inactive<?php echo $i; ?>" type="radio" name="contact[is_active]" value="0" <?php echo ($contact["is_active"] == 0)? "checked":""; ?> />  Inactive				
	</td></tr>
	<tr><th class="vc140" >Remarks</th><td><input id="remarks" class="full pdl05 remarks" type="text" name="contact[remarks]" value="<?php echo $contact["remarks"]; ?>" ></td></tr>
	<tr><td colspan="2" >
		<button id="ucbtn" onclick="updateContact();return false;" >Update Contact</button>
	</td></tr>
<?php endif; ?>
	
</table>
</div>

<!--  =========   PROFILE BELOW =====================  -->

<div class="accordParent" >	
<button onclick="accorToggle('prof')" class="vc300 bg-blue2" > <p class="b f16" > <?php echo "Profile"; ?> </p> </button>  	
<table id="prof" class="gis-table-bordered table-fx" >
<tr><th class="vc150" >First Name</th><td class="vc300" ><input id="fname" class="full pdl05 fname" type="text" name="profile[first_name]" value="<?php echo $profile["first_name"]; ?>" ></td></tr>
<tr><th class="vc150" >Middle Name</th><td><input id="mname"  class="full pdl05 mname" type="text" name="profile[middle_name]" value="<?php echo $profile["middle_name"]; ?>" ></td></tr>
<tr><th class="vc150" >Last Name</th><td><input id="lname" class="full pdl05 lname" type="text" name="profile[last_name]" value="<?php echo $profile["last_name"]; ?>" ></td></tr>
<tr><th class="vc150" >Suffix Name</th><td><input id="suffix" class="full pdl05 suffix"  type="text" name="profile[suffix]" value="<?php echo $profile["suffix"]; ?>" ></td></tr>
<tr><th class="vc150" >Network</th><td>
	<select id="smsnet" class="full pdl05 smsnet" name="profile[nationality_id]" >
		<?php	foreach($data["selects"]["smsnetworks"] as $sel): ?>
		<option <?php echo ($sel["id"] == $profile["smsnetwork_id"])? "selected" : null; ?> value="<?php echo $sel["id"]; ?>" ><?php echo $sel["name"]; ?></option><?php	endforeach; ?>
	</select>		
</td></tr>
<tr><th class="vc150" >phone</th><td><input id="phone" class="full pdl05 phone" type="text" name="profile[phone]" value="<?php echo $profile["phone"]; ?>" ></td></tr>
<tr><th class="vc150" >SMS</th><td><input id="sms" class="full pdl05 sms" type="text" name="profile[sms]" value="<?php echo $profile["sms"]; ?>" ></td></tr>
<tr><th class="vc150" >Email</th><td><input id="email" class="full pdl05 email" type="text" name="profile[email]" value="<?php echo $profile["email"]; ?>" ></td></tr>
<tr><th class="vc150" >Birthdate</th><td><input id="bday" class="full pdl05 bday" type="date" name="profile[birthdate]" value="<?php echo $profile["birthdate"]; ?>" ></td></tr>
<tr><th class="vc150" >Nationality</th><td>
	<select id="nation" class="full pdl05 nation" name="profile[nationality_id]" >
		<?php	foreach($data["selects"]["nationalities"] as $sel): ?>
		<option <?php echo ($sel["id"] == $profile["nationality_id"])? "selected" : null; ?> value="<?php echo $sel["id"]; ?>" ><?php echo $sel["name"]; ?></option><?php	endforeach; ?>
	</select>		
</td></tr>
<tr><th class="vc150" >Religion</th><td>
	<select id="rels" class="full pdl05 rels" name="profile[religion_id]" >
		<?php	foreach($data["selects"]["religions"] as $sel): ?>
		<option <?php echo ($sel["id"] == $profile["religion_id"])? "selected" : null; ?> value="<?php echo $sel["id"]; ?>" ><?php echo $sel["name"]; ?></option><?php	endforeach; ?>
	</select>		
</td></tr>
<tr><th class="vc150 pdl05" >Province</th><td>
	<select id="prov" class="full pdl05 prov" name="profile[province_id]" >
		<?php	foreach($data["selects"]["provinces"] as $sel): ?>
		<option <?php echo ($sel["id"] == $profile["province_id"])? "selected" : null; ?> value="<?php echo $sel["id"]; ?>" ><?php echo $sel["name"]; ?></option><?php	endforeach; ?>
	</select>		
	<input id="newprov" class="full pdl05 newprov" type="text" name="profile[province]" placeholder="New Province">		
</td></tr>

<tr><th class="vc150" >City</th><td>
	<select id="city" class="full pdl05 city" name="profile[city_id]" >
		<?php	foreach($data["selects"]["cities"] as $sel): ?>
		<option <?php echo ($sel["id"] == $profile["city_id"])? "selected" : null; ?> value="<?php echo $sel["id"]; ?>" ><?php echo $sel["name"]; ?></option><?php	endforeach; ?>
	</select>		
	<input id="newcity" class="full pdl05 newcity" type="text" name="profile[city]" placeholder="New City">			
</td></tr>

<tr><th class="vc150" >Barangay</th><td><input id="brgy" class="full pdl05 brgy" type="text" name="profile[barangay]" value="<?php echo $profile["barangay"]; ?>" readonly  ></td></tr>
<tr><th class="vc150" >Street</th><td><input id="street" class="full pdl05 street" type="text" name="profile[street]" value="<?php echo $profile["street"]; ?>" readonly ></td></tr>


</table>

</div>



<!----------------------------------------------------------------------------->





<p>
	<input id="cid" type="hidden" name="profile[contact_id]" value="<?php echo $profile["contact_id"]; ?>"  />
	<?php if(isset($_SERVER["HTTP_REFERER"])): ?>
		<button> <a class="no-underline" href="<?php echo $_SERVER["HTTP_REFERER"]; ?>"> Cancel </a> </button>
	<?php endif; ?>
</p>





<!------------------------------------------------------------------------------>
<script>
var gurl = 'http://<?php echo GURL; ?>';var ctlr = '<?php echo $home; ?>';


$(function(){
	hd();
	nextViaEnter();
	accorHd();
	
})

function accorToggle(sxn){ $("#"+sxn).toggle(); }
function accorHd(){ $(".accordParent table:not(:first)").hide(); }

// $(".accordParent table:not(:first)").hide();



function updateProfile(){

	// alert('11');

	$('#upbtn').hide();
	var cid			= $('#cid').val();	

	
	var fname	 	= $('#fname').val();
	

	
	var mname 		= $('#mname').val();
	var lname 		= $('#lname').val();
	var suffix 		= $('#suffix').val();

	var smsnet	 	= $('#smsnet').val();
	var phone 		= $('#phone').val();
	var sms 		= $('#sms').val();
	var email 		= $('#email').val();	
	
	var bday 		= $('#bday').val();	
	var nation 		= $('#nation').val();	
	var rels 		= $('#rels').val();	
	
	var prov	 	= $('#prov').val();
	var city 		= $('#city').val();
	var brgy 		= $('#brgy').val();	
	var street 		= $('#street').val();	


	
	var vurl 	= gurl + '/'+ctlr+'/xeditProfile';	

	var pdata = 'cid='+cid+'&fname='+fname+'&mname='+mname+'&lname='+lname+'&suffix='+suffix;
	pdata += '&smsnet='+smsnet+'&phone='+phone+'&sms='+sms+'&email='+email+'&bday='+bday;
	pdata += '&nation='+nation+'&rels='+rels+'&prov='+prov+'&city='+city+'&brgy='+brgy+'&street='+street;

	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: pdata,				
		async: true,
		success: function() { 	
			// location.reload();
		}		  
    });				
	
	
}	// fxn








</script>


<!------------------------------------------------------------------------------>


