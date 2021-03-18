<?php 
	/* $ts1 = time(); */
	$this->shovel('tplHeaderPOS'); 
	
?>


<div id="content">


<?php 
	$tpl = SITE.'views/'.$template.'.php';
	if(is_readable($tpl)){
		include_once(SITE.'views/'.$template.'.php');			
	} else {
		include_once(SITE.'views/Default.php');				
	}
	
?>


</div> <!-- #content -->


<?php 

	$this->shovel('tplFooter'); 

?>

