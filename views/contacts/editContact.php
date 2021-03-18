
<?php

/* gcontroller and gmodel - xedit contact and profile */
/* gScontroller and gSmodel - xedit student */



$home = $_SESSION['home']; 			
$dbo=PDBO;
// pr($contact);

?>


<h5>
	Contact | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'profiles/scid/'.$ucid; ?>" >Profile</a>
	| <a href='<?php echo URL."records/edit/{$dbo}.00_profiles?key=contact_id&value={$ucid}"; ?>' >Edit Profile</a>

</h5>

<p>
<?php 
	require_once(SITE.'/views/elements/filter_codename.php');
?>
</p>
<div id="names" >names</div>
	
	
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
	// include_once('includes/profile.php');
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
var gurl = "http://<?php echo GURL; ?>";
var ctlr = '<?php echo $home; ?>';
var sy 	 = '<?php echo $sy; ?>';
var limits=50;


$(function(){
	$('#names').hide();
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






function redirContact(ucid){
	var url = gurl+'/contacts/edit/'+ucid;	
	window.location = url;		
}



</script>


<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>


<!------------------------------------------------------------------------------>


