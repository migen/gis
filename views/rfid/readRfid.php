0729083385

<h5>
	<?php 
		
	?>
	Read RFID | <?php $this->shovel('homelinks'); ?>
	<?php $d=NULL; ?>	
	<?php $this->shovel('links_rfid',$d); ?>
	
	
</h5>




<form method="POST" >
<table class="gis-table-bordered" >
<tr>
	<th><input id="rfid" autofocus   ></th>
</tr>

</table>
</form>


<script>

var gurl = "http://<?php echo GURL; ?>";


$(function(){


	
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









</script>
