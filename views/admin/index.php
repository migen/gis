
<?php 

// pr($levels);
// pr($_SESSION);

?>




<h5>
	Admin Home
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
</h5>



<?php 
	$user = $_SESSION['user'];
	$this->shovel('accor_admin'); 			

?>


<!----------------------------------------------------------------------------------->

<script>

var gurl = 'http://<?php echo GURL; ?>';


$(function(){
	$('.hd').hide();
	nextViaEnter();
	accorHd();
	
	
})

function accorToggle(sxn){ $("#"+sxn).toggle(); }
function accorHd(){ $(".accordParent table:not(:first)").hide(); }
	

	
</script>