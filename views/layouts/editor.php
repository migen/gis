<?php 
	// $this->shovel('tplHeader'); 
	$this->shovel('tplHeaderEditor'); 
	$this->shovel('smartlinks'); 
	
	
?>

<?php $this->shovel('flashMessage'); ?>

<div id="content">

<?php 
	$tpl = SITE.'views/'.$template.'.php';
	if(is_readable($tpl)){
		include_once(SITE.'views/'.$template.'.php');			
	} else {
		include_once(SITE.'views/Default.php');				
	}
	/* echo $content_for_layout; */
?>
</div> <!-- main -->
<?php $this->shovel('tplFooter'); ?>
