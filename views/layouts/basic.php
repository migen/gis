<!DOCTYPE html>
<html lang="en">
<head>
<title>Temp</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<?php
	if(isset($this->css)){
 		foreach($this->css as $css){ echo '<link type="text/css" rel="stylesheet" href="'.URL."public/css/".$css.'" />'; }
	}
 
	if(isset($this->js)){
 		foreach($this->js as $js){ echo '<script type="text/javascript" src="'.URL."views/".$js.'"></script>'; }
	}
?>
</head>
<body oncontextmenu="return true;">



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



<noscript>Your browser not supporting JS. <noscript>

</body>
</html>