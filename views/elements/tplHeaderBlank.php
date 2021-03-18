<!DOCTYPE html>
<html lang="en">
<head>
<title> <?php echo GISTITLE; ?> </title>

<meta charset="utf-8">

<style type="text/css" >
	html{height:100%;width:100%; }
	body{width:inherit;margin:0 auto;background-color:#fff; }
	#content{ min-width:100%;  margin: 0 auto;  padding: 8px 10px;background-color: #fff; }
	#header{ background-color: #0174DF;	margin: 0 auto 0 auto;padding:0px;width:100%;height:42px;	}
	@media print{ .screen{display:none; } }	
	#slogan{ color:#fff;font-family: Arial,Helvetica Neue,Helvetica,sans-serif;font-style:italic;  }
</style>

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

<div id='header'>
	<table><tr><th class="screen" id="slogan" ><h5>Make IT Smarter</h5></th></tr></table>
</div>

	
	