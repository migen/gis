<?php  
	// echo 'tplHeaderBasic<br />';
?>

<html lang="en">
<head>
<title><?php echo GISTITLE; ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="description" content="custom school software,grading information systems,enterprise resource planning,accounting system,registration system,enrolment system">
<meta name="keywords" content="school grading information systems,business software,information technology,accounting system,payroll system,enrolment system">
<meta name="author" content="midasgen.com">

<!-- tinymce -->

<link rel="shortcut icon" href="<?php echo URL; ?>public/images/favicon.ico" type="image/x-icon"/>
<link type='text/css' rel='stylesheet' href="<?php echo URL; ?>public/css/style.css" />
	 

<script type='text/javascript' src="<?php echo URL; ?>views/js/jquery.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/rfid.js"></script>
	 
	 
<style type="text/css">
	div#basic{ margin:auto; padding:0 0 0 30px;}
</style>



<!-- jquery.js should come before this bootstrap.js -->


</head>
<!-- bodyStart-->


<body onload="javascript:RefreshReadersList();">


<object classid="clsid:8AD9C840-044E-11D1-B3E9-00805F499D93" codebase="http://java.sun.com/products/plugin/1.3/jinstall-13-win32.cab#Version=1,3,0,0" width=450 height=200>
  <param name="CODE" value="applet_pcsc.class">
  <param name="ARCHIVE" value="applet_pcsc.jar">
  <param name="type" value="application/x-java-applet;version=1.3">
  <param name="scriptable" value="true">
  <comment></comment>
 <embed type="application/x-java-applet;version=1.3" hidden="true" code="applet_pcsc.class" archive="applet_pcsc.jar" scriptable="true" pluginspage="http://java.sun.com/products/plugin/1.3/plugin-install.html" width=0 height=0 MAYSCRIPT>
</object>	

<div id='header'>
<table style="font-family:Lucida Console, Monaco, monospace;" >
	<tr>
		<td class="vc1000" > <h2 style="padding-left:16px;" class="i txt-white no-underline" >Make IT Smarter</h2> </td>
		<td style='color:white;'> <?php echo " <p style='opacity: 0.05;' ondblclick='tracepass();' > Trace </p>	"; ?>		
			<span class="f18" >G I S </span>  </td>
		
	</tr>
</table>			
</div> <!-- #header -->


