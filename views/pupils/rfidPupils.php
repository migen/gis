<h3>

	Pupil RFID | <?php $this->shovel('homelinks'); ?>


</h3>



<input id="posbarcode" onchange="rfidHere();return false;" />





<script>
var gurl 	= "http://<?php echo GURL; ?>";


$(function(){
	hd();	
	nextViaEnter();		
	$('html').live('click',function(){ $('#names').hide(); });
	$('#posbarcode').focus();
	
	
	
})	/* fxn */


function rfidHere(){
	var barcode = $('#posbarcode').val();		
	alert(barcode);
	
}	/* fxn */



</script>