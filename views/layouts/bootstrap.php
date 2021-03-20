<?php 
	/* $ts1 = time(); */
	$this->shovel('tplHeaderBootstrap'); 
	include_once(SITE."views/elements/smartlinks.php");
	
?>

<!-- Bootstrap CSS -->
<link type='text/css' rel='stylesheet' href="<?php echo URL.'externals/bootstrap4/css/bootstrap.min.css'; ?>" />



<?php $this->shovel('flashMessage'); ?>

<div id="content">

<?php 
	$tpl = SITE.'views/'.$template.'.php';
	if(is_readable($tpl)){
		include_once(SITE.'views/'.$template.'.php');			
	} else {
		$one=SITE.'views/templates/'.VCFOLDER.'/Default.php';
		$two=SITE.'views/Default.php';
		if(is_readable($one)){ include_once($one);	
		} else { include_once($two); }

	}
		
	
?>


</div> <!-- #content -->

<!-- comment
<script type='text/javascript' src="<?php echo URL; ?>views/js/jquery.js"></script>

-->

<!-- jQuery first, then Popper.js, then Bootstrap JS -->




<?php $this->shovel('tplFooter'); ?>

