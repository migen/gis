<!DOCTYPE html>
<html lang="en">
<head>
<title> <?php echo GISTITLE; ?> </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="description" content="school software, enterprise resource planning, accounting, registration, enrollment">
<meta name="keywords" content="automation, grading system, business software,information technology">
<meta name="author" content="aizent.com">
<!-- tinymce -->
<link rel="shortcut icon" href="<?php echo URL; ?>public/images/favicon.ico" type="image/x-icon"/>
<link type='text/css' rel='stylesheet' href="<?php echo URL; ?>public/css/style.css" />
<!-- modal --> 

<style type="text/css">

</style>

<?php 
	if(isset($this->css)){
 		foreach($this->css as $css){ echo '<link type="text/css" rel="stylesheet" href="'.URL."public/css/".$css.'" />'; }
	}

	if(isset($this->js)){
 		foreach($this->js as $js){
			echo '<script type="text/javascript" src="'.URL."views/".$js.'"></script>';
		}
	}

?>

<script type="text/javascript" src='<?php echo URL."/tiny_mce/tiny_mce.js"; ?>' ></script>
<script type="text/javascript">


tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	plugins : "media,searchreplace,print,contextmenu,paste,directionality,fullscreen,template,table,code",
	theme_advanced_buttons1 : "bold,italic,underline|,justifycenter,justifyfull,|,formatselect,fontselect,fontsizeselect,forecolor,backcolor,|,insertdate,inserttime,preview,|,undo,redo,|,tablecontrols,bullist,numlist,|,link,unlink,anchor,code,|fullscreen,image,media",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "bottom",
	theme_advanced_resizing : true,

});


</script>



</head>
<!-- bodyStart-->
<body>

<div id='header'>
<table style="font-family:san-serif;" class="white" >
	<tr>
		<td class="vc1000" > <h2 style="padding-left:16px;" class="i" >
			<span style="font-family:sans-serif;color:white;" >Make IT Smarter</span></h2> </td>
		<td style='font-size:12px;color:white;'>
			<?php echo " <p style='opacity: 0.05;' ondblclick='tracepass();' > Trace </p>	"; ?>		
					<span class="f18" >G I S </span><span class="f12" ><?php echo VERSION; ?> </span>  
		</td>
		
	</tr>
</table>	
</div>	<!-- #header -->



