<h5>
	Credit POS Module
	
	
</h5>

<!-- cpos filter -->
<?php  if(!$ccid){ include_once('incs/filter_codename.php'); } else { 
	include_once('incs/cpos_body.php');
}


?>









<div class="twenty" id="names" >names</div>

<script>
var gurl="http://<?php echo GURL; ?>";
var ccid="<?php echo $ccid; ?>";

$(function(){ 
	// $('#names').hide(); 	
	nextViaEnter();		
	tabEnter('bc');			
	$('html').live('click',function(){ $('#names').hide(); });
	$('#posbarcode').focus();	
	// $( "#posform" ).submit(function( event ) { tallyTotal(); });	

	
	
	
}
	
)



</script>

