<?php  

?>

<!DOCTYPE html>
<html lang="en">
<head>
<title> <?php echo GISTITLE; ?> </title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<meta name="description" content="custom school software,grading information systems,enterprise resource planning,accounting system,registration system,enrolment system">
<meta name="keywords" content="school grading information systems,business software,information technology,accounting system,payroll system,enrolment system">
<meta name="author" content="midasgen.com">

<!-- tinymce -->

<link rel="shortcut icon" href="<?php echo URL; ?>public/images/favicon.ico" type="image/x-icon"/>
<link type='text/css' rel='stylesheet' href="<?php echo URL; ?>public/css/style.css" />

	 
<!-- modal -->

	 
<style type="text/css">

@media print{
	.screen,#sidebar,.invisible,#mainMenu,#creportsPager,#gui,#header,#footer{display:none;}
	body{font-size:8pt;}	
}

</style>

<script>


</script>

<?php 
	if(isset($this->js)){
 		foreach($this->js as $js){
			echo '<script type="text/javascript" src="'.URL."views/".$js.'"></script>';
		}
	}
?>


<!-- jquery.js should come before this bootstrap.js -->

</head>




<body onload="javascript:RefreshReadersList();">


    <object classid="clsid:8AD9C840-044E-11D1-B3E9-00805F499D93" codebase="http://java.sun.com/products/plugin/1.3/jinstall-13-win32.cab#Version=1,3,0,0" width=450 height=200>
      <param name="CODE" value="applet_pcsc.class">
      <param name="ARCHIVE" value="applet_pcsc.jar">	  
      <param name="type" value="application/x-java-applet;version=1.3">
	  
	  
      <param name="scriptable" value="true">
      <comment></comment>
     <embed type="application/x-java-applet;version=1.3" hidden="true" code="applet_pcsc.class" archive="applet_pcsc.jar" scriptable="true" pluginspage="http://java.sun.com/products/plugin/1.3/plugin-install.html" width=50 height=50 MAYSCRIPT>
    </object>

<div id='header'>
<table>
	<tr>
		<td>
			<a href="<?php echo URL; ?>">	
				<img src="<?php echo URL; ?>public/images/pcmed_banner2.png" width="1080" height="100"  >
				
			</a>
		</td>
		<td style='font-family:comic sans ms bold;font-size:32px;color:white;text-align:right;vertical-align:middle;'>
			<?php echo " <p class='blue2' style='opacity: 0.05;' ondblclick='tracepass();' > Trace </p>	"; ?>		
					G I S 
			</td>
		
	</tr>
</table>	


			
</div> <!-- #header -->


<?php echo URL.'rfid/'; ?>applet_pcsc.class <br />
<?php echo SITE.'rfid/'; ?>applet_pcsc.class


<?php $this->shovel('flashMessage'); ?>


<div id="content">

<?php 
	$tpl = SITE.'views/'.$template.'.php';
	if(is_readable($tpl)){
		include_once(SITE.'views/'.$template.'.php');			
	} else {
		include_once(SITE.'views/Default.php');				
	}
	
?>


</div> <!-- main -->

