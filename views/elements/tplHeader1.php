<!DOCTYPE html>
<html lang="en">
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


/* Small devices (portrait tablets and large phones, 600px and upto 992) */
@media only screen and (max-width: 992px) {
	body{ color:red;font-size:2em; }	

}


/* Large devices (laptops/desktops, 992px and up) */
@media only screen and (min-width: 992px) {

	body{ color:blue;font-size:1.2em; }	
	
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

<div class="screen" id="header" ><table class="" >
<tr>
	<td style="width:600px;" >
		<h3 style="padding-left:16px;padding-top:2px;" class="nu white" > <span class="i" >Make IT Smarter</span>
			<a class="white nu" href="<?php echo URL; ?>" >GIS</a>&nbsp;<span style="font-size:0.6em;" >&nbsp;<?php echo DBYR; ?></span>						
			<span onclick="pclass('header');" style="font-size:0.6em;" > | Header</span>				
			<span onclick="pclass('bar');" style="font-size:0.6em;" > | Bar</span>				
			<span onclick="pclass('pagelinks');" style="font-size:0.6em;" > | Page</span>				
		</h3> 
	</td>
	<td><p ondblclick="tracepass();" class="white" style="padding-top:1.8em;font-size:0.6em;" >
		<?php echo strtoupper(VCFOLDER).' '.VERSION; ?>
		<?php echo (isset($_SESSION['today']))? $_SESSION['today']:date('Y-m-d'); ?>
		</p></td>		
</tr>		
</table></div>	<!-- #header -->
