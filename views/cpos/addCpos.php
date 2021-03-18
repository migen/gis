<?php 
// echo "T: "; pr($_SESSION['terminal']);

?>


<style>

</style>

<h5 class="screen" >
	Credit POS
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'cpos/add'; ?>" >Student</a>
	| <a class="u" onclick="ilabas('drow');" >Cancel</a>
	
</h5>

<!-- cpos filter -->

<form id="posform" method="POST" >

<?php  
if(!$ccid){ include_once('incs/filter_codename.php'); } else { 
	include_once('incs/cpos_header.php');
	include_once('incs/cpos_body.php'); 
}

?>
</form>








<div class="twenty" id="names" >names</div>

<script>

var gurl = 'http://<?php echo GURL; ?>';
var page = 'cpos/add';
var limits = '20';
var ccid="<?php echo $ccid; ?>";
var today="<?php echo $today; ?>";
var prow='';
var nr=0;


$(function(){ 
	// $('#chkoutbtn').hide(); 	
	$('#names').hide(); 	
	$('html').live('click',function(){ $('#names').hide(); });
	nextViaEnter();		
	tabEnter('bc');			
	itago('drow');
	$('#posbarcode').focus();	
	$( "#posform" ).submit(function( event ) { tallyTotal(); });	

	
})	/* fxn */




</script>

