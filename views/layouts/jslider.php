<style>
	div.navBulletsWrapper{background:blue;}

</style>


<!DOCTYPE html>
<html>
	<head>
		<title>Demo 1 - Urban School Image Slider</title>		
		<link href="<?php echo URL.'public/jslider/js-image-slider.css'; ?>" rel="stylesheet" type="text/css" />
		<link href="<?php echo URL.'public/jslider/generic.css'; ?>" rel="stylesheet" type="text/css" />
		<script type='text/javascript' src="<?php echo URL.'public/jslider/js-image-slider.js'; ?>" ></script>		
	</head>

<body>



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



</body>
</html>
