<?php 
	/* $ts1 = time(); */
// 	$this->shovel('tplHeaderBlank'); 	
?>

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

<?php $this->shovel('tplFooter'); ?>