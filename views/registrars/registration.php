<?php 

// pr($_SESSION['q']);

// pr($code);

$registration = isset($_SESSION['registration'])? $_SESSION['registration'] : NULL;
// pr($registration);

?>


<!-- ------------------------------------------------------------------------------------------------->

<script>

/* IMPT* script on top of page so even when sectioning is locked,can still run search */

var gurl = 'http://<?php echo GURL; ?>';
var sy   = '<?php echo $sy; ?>';
var home = 'registrars';

$(function(){
	hd();	
	nextViaEnter();
	$('html').live('click',function(){
		$('#names').hide();
	});

})	


function nextCode(){
var code = $('#scode').val();
var url = gurl + '/registrars/nextCode/' +code;
alert(url);


}

function checkFields(){
	var fname = $('#fullname').val();
	var crid  = $('#crid').val();
	var scode = $('#scode').val();		
	
	if(scode.length<6){ alert('Minimum of 6 characters for ID.'); return false; }
	if(crid=='0'){ alert('Classroom required.'); return false; }
	if(fname==''){ alert('Name required.'); return false; }
	
	$('#checkBtn').hide();
	alert('You may register.');
	$('#newBtn').show();
	return true;
	
	
}	


function yearend(year){
	var ye = parseInt(year)+1;
	$('#yearend').text(ye);
}








function redirContact(ucid){
	var url 		= gurl + '/students/sectioner/' + ucid;	
	window.location = url;		
}




</script>

<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>

<!------------------------------------------------------------------------------------------------->

<?php

// pr($_SESSION['q']);

$yearend		= $sy + 1;
	
?>

<!------------------------------------------------------------------------------------------------->

<h5>
	Registration
	| <a href="<?php echo URL.$home; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href='<?php echo URL."students/sectioner"; ?>' > Sectioner</a> 
	| <a href='<?php echo URL."setup/students"; ?>' > Bulk </a>
</h5>


<!-- -------------------------- sectioning status 	check -------------------------------------- -->


<div class="half" >
<form method="POST" >	

<table id="tbl-1" class="gis-table-bordered " >



<tr><th class="vc200 bg-gray3" >Student</th><td class="vc500" >
	<select class="full" id="student" onchange="redirSectioner(this.value);return false;" >
		<option value="0" >Choose One</option>
		<?php foreach($students AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select>
</td></tr>

<tr><th class="bg-gray3" >Name | Surname</th><td>
<input class="pdl05" id="part"  />
<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart();return false;" />
</td></tr>

<tr><th class="bg-gray3" > ID Number</th><td>
<input class="pdl05" id="codes"  />
<input type="submit" name="auto" value="Filter" onclick="xgetContactsByCode();return false;" />
</td></tr>





</table>



<!-- -------------------------------------------------------------------------------------------------------- -->


<h5> New Student </h5>
<table class="gis-table-bordered table-fx" >
	<tr><th class="vc200 bg-gray3" >School Year</th>
	<td><span class="b">SY </span><input id="sy" onchange="yearend(this.value);" class="vc80 center" type="number" name="sy" value="<?php echo $sy; ?>"  readonly />
		- <span id="yearend" ><?php echo $yearend; ?> </span>
	</td></tr>

	<tr><th class="bg-gray3" >ID Number</th> <?php // echo $code; ?>
		<td class="vc500" ><input class="pdl05 vc120" id="scode" name="scode" type="text" value="<?php echo $code; ?>" />
			<button id="searchBtn" onclick="xgetContactByCode(); return false;" > Search </button>
	
			<!-- 
				<button id="nextCodeBtn();return false;" onclick="nextCode(); return false;" > Next </button>			
			-->
				
			</td>
	</tr>
		
	<tr><th class="bg-gray3" >Classroom</th>	
		<td class="vc200" >
		<select id="crid" class="full" name="crid" >
			<option value="0" > Classroom to enrol in... </option>
			<?php foreach($classrooms AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" 
				<?php echo (isset($registration['crid']) && ($sel['id']==$registration['crid']))? 'selected':NULL; ?> > <?php echo $sel['name']; ?> </option>
			<?php endforeach; ?>
		</select>
		</td>
	</tr>

	<tr><th class="vc200 bg-gray3" >Full Name</th>
	<td class="vc500" > <input class="pdl05 full" type="text" id="fullname" name="fullname" 
	value="<?php echo isset($registration['fullname'])? $registration['fullname']:NULL; ?>" placeholder="Surname,First Middle" /> </td></tr>
	

	<tr><th class="bg-gray3" >Is Male</th>
	<td class="" > 
		<select id="mle" class="vc200" name="is_male" >
			<option value="1">Boy</option>
			<option value="0">Girl</option>
		</select>
	</td></tr>


	<tr><td colspan="2" >
		<button class="hd" id="checkBtn" onclick="checkFields();return false;" > Validate </button>					
		<input class="hd" id="newBtn" type="submit" name="submit" value="Register"  />
	</td></tr>
</table>


<!-- ============================================================== -->


<h5> Optional Info </h5>
<table class="gis-table-bordered table-fx" >

	<tr><th class="bg-gray3" >phone</th>
	<td class="" > <input class="pdl05 full" type="text" name="phone" 
	value="<?php echo isset($registration['phone'])? $registration['phone']:NULL; ?>" placeholder="Phone Numbers" /> </td></tr>
	<tr><th class="bg-gray3" >Mobile</th>
	<td class="" > <input class="pdl05 full" type="text" name="sms" 
	value="<?php echo isset($registration['sms'])? $registration['sms']:NULL; ?>" placeholder="Mobile Number" /> </td></tr>
	<tr><th class="bg-gray3" >Email</th>
	<td class="" > <input class="pdl05 full" type="text" name="email" 
	value="<?php echo isset($registration['email'])? $registration['email']:NULL; ?>" placeholder="Email" /> </td></tr>

</table>


</form>

</div>


<!-- ============================================================== -->

<div class="third" id="names" > </div>


<!-- ============================================================== -->
