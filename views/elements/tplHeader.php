<!DOCTYPE html>
<html lang="en">
<!-- tplHeader -->
<head>
<title>Grading | RFID | POS & Inventory | GIS</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="description" content="school software, enterprise resource planning, accounting, registration, enrollment">
<meta name="keywords" content="automation, grading system, business software,information technology">
<meta name="author" content="aizent.com">
<!-- tinymce -->
<link rel="shortcut icon" href="<?php echo URL; ?>public/images/favicon.ico" type="image/x-icon"/>
<link type='text/css' rel='stylesheet' href="<?php echo URL; ?>public/css/style.css" />
<!-- modal --> 
<style type="text/css">


#header{ min-height:50px;color:#fff; }
#header div { font-size:2em;float:left; }
#header div.block { font-size:1.2em;padding-top:0.8em; }
.version { size:0.1em; }
#header div.right{ float:right;padding-right:10%; }
.slogan{ font-size:2em; padding-left:0.6em;padding-right:0.6em; }	

/* Small devices (portrait tablets and large phones, 600px and upto 992) */
@media only screen and (max-width: 992px) {
	h3,h5,h3 a,h5 a,#content{ font-size:1rem; }
	
}	


/* Large devices (laptops/desktops, 992px and up) */
@media only screen and (min-width: 992px) {

	
}


</style>
<script> </script>

<?php
	if(isset($this->css)){
 		foreach($this->css as $css){ echo '<link type="text/css" rel="stylesheet" href="'.URL."public/css/".$css.'" />'; }
	}
 
	if(isset($this->js)){
 		foreach($this->js as $js){ echo '<script type="text/javascript" src="'.URL."views/".$js.'"></script>'; }
	}
?>


<!-- jquery.js should come before this bootstrap.js -->
</head>
<body oncontextmenu="return true;">

<div class="screen" id="header" >
	<div class="slogan" ><span class="b i" >Make IT Smarter </span> | GIS</div>
	<div class="block" >	<?php echo DBYR; ?></div>
	<div class="block" >
			<span onclick="pclass('header');" > &nbsp; | Header</span>				
			<span onclick="pclass('bar');" > | Bar</span>				
			<span onclick="pclass('pagelinks');" > | Page</span>		
	</div>
	<div class="right" >	
		<span style="font-size:0.4em;" ondblclick="tracepass();"  >
			<?php echo strtoupper(VCFOLDER).'-'.VERSION.'.	'; ?><?php echo (isset($_SESSION['today']))? $_SESSION['today']:date('Y-m-d'); ?>
		</span>
	</div>


</div>	<!-- #header -->
