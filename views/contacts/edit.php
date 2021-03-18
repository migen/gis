
<?php

/* gcontroller and gmodel - xedit contact and profile */
/* gScontroller and gSmodel - xedit student */



$home = $_SESSION['home']; 			



?>


<h5>
	<a href="<?php echo URL.$home; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>					
</h5>
	
	
<!--  =========   CONTACT BELOW =====================  -->

<div class="accordParent" >	
<button onclick="accorToggle('ctct')" class="vc300 bg-blue2" > <p class="b f16" > <?php echo "Contact"; ?> </p> </button>  	
<table id="ctct" class="gis-table-bordered table-fx" >
<tr class="hd" ><th class="vc150" >ID</th><td><?php echo $contact["id"]; ?></td></tr>	
<tr><th class="vc150" >ID Number</th><td class="vc250" ><?php echo $contact["code"]; ?></td></tr>
<tr><th class="vc150" >Person</th><td><?php echo $contact["name"]; ?></td></tr>

<input id="cid" type="hidden" value="<?php echo $contact["id"]; ?>" />

<?php if($_SESSION['user']['role_id']!=RSTUD): ?>
	<?php include_once('includes/contact.php'); ?>
<?php endif; ?>
	
</table>
</div>

<!--  =========   PROFILE BELOW =====================  -->


<?php 
	include_once('includes/profile.php');
?>

<!----------------------------------------------------------------------------->

<!--  =========   PROFILE BELOW =====================  -->


<?php 
	if($contact['role_id']==RSTUD){
		include_once('includes/student.php');	
	}
?>






<!------------------------------------------------------------------------------>
<script>
var gurl = 'http://<?php echo GURL; ?>';
var ctlr = '<?php echo $home; ?>';
var sy 	 = '<?php echo $sy; ?>';


$(function(){
	// alert(sy+ctlr+gurl);
	// hd();
	$('.hd').hide();
	nextViaEnter();
	accorHd();
	
	
})

function accorToggle(sxn){ $("#"+sxn).toggle(); }
function accorHd(){ $(".accordParent table:not(:first)").hide(); }


function xgetPriv(tid){
	var vurl 	= gurl + '/ajax/xcontacts.php';		
	var task 	= 'xgetPriv'; 
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&tid='+tid,				
		async: true,
		success: function(s) { 
			$('#role_id').val(s.roleid);
			$('#privilege_id').val(s.privid);						
		}		  		
	});					

	
	

}	




function xeditProfile(){
	$('#upbtn').hide();
	var cid			= $('#cid').val();	
	var fname	 	= $('#fname').val();	
	var mname 		= $('#mname').val();
	var lname 		= $('#lname').val();
	var suffix 		= $('#suffix').val();
	var mle 		= $('#mle').val();
	
	var smsnet	 	= $('#smsnet').val();
	var phone 		= $('#phone').val();
	var sms 		= $('#sms').val();
	var email 		= $('#email').val();	
	
	var bday 		= $('#bday').val();	
	var age 		= $('#age').val();	
	var nation 		= $('#nation').val();	
	var rels 		= $('#rels').val();	
	
	var prov	 	= $('#prov').val();
	var city 		= $('#city').val();
	var brgy 		= $('#brgy').val();	
	var street 		= $('#street').val();	
	
	
	var vurl 	= gurl + '/ajax/xcontacts.php';			
	var task	= 'xeditProfile';
	
	var pdata = 'task='+task+'&id='+cid+'&first_name='+fname+'&middle_name='+mname+'&last_name='+lname+'&suffix='+suffix+'&is_male='+mle;
	pdata += '&smsnetwork_id='+smsnet+'&phone='+phone+'&sms='+sms+'&email='+email+'&birthdate='+bday+'&age='+age;	
	pdata += '&nationality_id='+nation+'&religion_id='+rels+'&province_id='+prov+'&city_id='+city+'&barangay='+brgy+'&street='+street;

	// alert(vurl+' - '+pdata);
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: pdata,				
		async: true,
		success: function() { }		  
    });				
	
	
}	


function xeditContact(){
	$('#ucbtn').hide();
	var cid			= $('#cid').val();	

	var mle 		= $('#mle').val();	
	var is_active	= $('#is_active').val();	
	var is_cleared 	= $('#is_cleared').val();
	var is_org 		= $('#is_org').val();
	var remarks 	= $('#remarks').val();

	var title_id 	= $('#title_id').val();
	var role_id		= $('#role_id').val();	
	var privilege_id	= $('#privilege_id').val();	

	var sy	 		= $('#sy').val();
	var begsy	 	= $('#begsy').val();
	var crid 		= $('#crid').val();
		
	var vurl 	= gurl + '/ajax/xcontacts.php';	
	var task	= 'xeditContact';
	
	var pdata = 'task='+task+'&id='+cid+'&is_active='+is_active+'&is_cleared='+is_cleared+'&is_org='+is_org+'&remarks='+remarks;
	pdata += '&title_id='+title_id+'&role_id='+role_id+'&privilege_id='+privilege_id+'&is_male='+mle+'&crid='+crid+'&sy='+sy+'&begsy='+begsy;

	// alert(pdata);
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: pdata,				
		async: true,
		success: function() { }		  
    });				
	
}	



function updateStudent(){
	$('#usbtn').hide();
	var cid			= $('#cid').val();	
	var am	 		= $('#am').val();	
	var discount 	= $('#discount').val();
	var yis 		= $('#yis').val();
	var ye 			= $('#ye').val();
	var le 			= $('#le').val();

	var incsubj	 	= $('#incsubj').val();
	var batch	 	= $('#batch').val();
	var sy	 		= $('#sy').val();
	var crid 		= $('#crid').val();
	var ccrsid 		= $('#ccrsid').val();	
			
	var vurl 	= gurl + '/ajax/xstudents.php';	
	var task	= "xeditStudent";
	
	var pdata = 'task='+task+'&cid='+cid+'&discount='+discount+'&yis='+yis+'&ye='+ye+'&le='+le;
	pdata += '&incsubj='+incsubj+'&batch='+batch+'&sy='+sy+'&crid='+crid;

	// alert(pdata);
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: pdata,				
		async: true,
		success: function() { }		  
    });				
	
	
}	






</script>


<!------------------------------------------------------------------------------>


