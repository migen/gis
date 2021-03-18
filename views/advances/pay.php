<?php 




?>

<style>
	div.sixty{width:50%;}
	div.twenty{width:10px;}
	
</style>

<h5>
	Advances 	
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		

	
	

</h5>

<div class="sixty" >

<?php 

	include_once('pay/filter_codename.php');
	
	if($scid){
		include_once('pay/header.php');
		include_once('pay/body.php');
		include(SITE.'views/enrollment/incs/advpays.php');				
		
		
	}

?>


</div>	<!-- left -->


<div class="twenty" id="names" >names</div>

<script>
var gurl="http://<?php echo GURL; ?>";

$(function(){
	$('#names').hide();
})


function syOrnoValue(orno,sy){
	var url=gurl+'/invoices/printorno/'+orno+'/'+sy;
	window.open(url, '_blank');	
	
}

function copyOrnoValue(orno){
	orno=$.trim(orno);
	var url=gurl+'/invoices/printorno/'+orno;
	window.open(url, '_blank');		
}


function printOrno(){
	var orno=$('#orno').val();
	orno=$.trim(orno);
	var url=gurl+'/invoices/printorno/'+orno;
	window.open(url, '_blank');	
	
}	/* fxn */

</script>

