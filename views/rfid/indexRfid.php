
<h5>
	<?php 
		
	?>
	RFID | <?php $this->shovel('homelinks'); ?>
	<?php $d=NULL; ?>	
	<?php $this->shovel('links_rfid',$d); ?>
	
	
</h5>


<?php 


pr($_SESSION['q']);

?>


<h3 id="name" ></h3>

<form method="POST" >
<table class="gis-table-bordered" >
<tr>
	<th><input id="uid" autofocus onkeypress="return getUid(this,event);"  ></th>
</tr>

</table>
</form>


<script>

var gurl = "http://<?php echo GURL; ?>";


$(function(){

	// $("#name").html("hahaha");


	
	
})



function getUid(obj,e){
	var e=(typeof event!="undefined")?window.event:e;
	if(e.keyCode==13){
		var uid=$('#uid').val();
		$('#uid').val('');
		getContactByUid(uid);
		return false;		

	}
	
	
}	/* fxn */

function getContactByUid(uid){
	var vurl 	= gurl + '/ajax/rfid.php';	
	var task	= "getContactByUid";		

	$.ajax({
		url: vurl,dataType: "json",type: "POST",async: true,
		data: "uid="+uid+"&task="+task,				
		success: function(s) { 		
			$("#name").html(s.name);
		}		  
    });				

	
}	/* fxn */









</script>
