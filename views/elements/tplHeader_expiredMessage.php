<!DOCTYPE html>
<html lang="en">
<head>
<title> <?php echo GISTITLE; ?> </title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<meta name="description" content="custom school software, grading information systems, enterprise resource planning, accounting system, registration system, enrollment system">
<meta name="keywords" content="school information systems, grading software,business software,information technology, accounting system, payroll system, enrollment system">
<meta name="author" content="midasgen.com">

<!-- tinymce -->

<link rel="shortcut icon" href="<?php echo URL; ?>public/images/favicon.ico" type="image/x-icon"/>
<link type='text/css' rel='stylesheet' href="<?php echo URL; ?>public/css/style.css" />

	 
<!-- modal -->

	 
<style type="text/css">

@media print{
	.screen, #sidebar,.invisible,#mainMenu,#creportsPager,#gui,#header,#footer{display:none;}
	body{font-size:8pt;}	
}

@media screen {
	.printNoScreen{ display:none; }
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
<script type='text/javascript' src="<?php echo URL; ?>views/js/crypto.js"></script>


<!-- jquery.js should come before this bootstrap.js -->

</head>


<body oncontextmenu="return true;">




<div id='header' >
<table class="nogis-table-bordered" style="font-family:Lucida Console, Monaco, monospace;" >
<tr>
	<td style="width:600px;" >
		<h2 style="padding-left:16px;" class="txt-white no-underline" > <span class="i" >Make IT Smarter</span>
			<a href="<?php echo URL; ?>" >GIS</a><span style="font-size:0.6em;" >&nbsp;<?php echo DBYR; ?></span>						
			<span onclick="toggleHeader();" style="font-size:0.6em;" > | Header</span>				
			<span onclick="toggleSmartlinks();" style="font-size:0.6em;" > | Bar</span>				
		</h2> 
	</td>
	<td class="unbordered" style="font-size:32px;color:white;" >
		<p style="padding-top:1.6em;" ondblclick="tracepass();" class="f12 bottom" style="" >
			<?php echo strtoupper(VCFOLDER).'-'.VERSION; ?>
			<?php echo isset($_SESSION['today'])? $_SESSION['today']:NULL; ?>			
		</p>		
	</td>		
</tr>
</table>
</div>

<div class="bar screen" >
<?php if(loggedin()): ?>
	<?php 
		// $expired_message="Your GIS subscription will expire on April 30, 2019. <br />Please renew soon to avoid service interruption."; 
		$expired_message="Your GIS subscription has expired last April 30, 2019. <br />You will continue to see this message until renewed."; 
	?>	
	<h1 id="expiredReminder" class="red center" ><?php echo $expired_message; ?></h1>
<?php endif; ?>	

</div>

	
	
	
<script>


$(function(){	
	$("#expiredReminder").hide();	
	var url = GetURLParameter();	
	var url_list=["mis","cir","teachers","registrars","acad","cir","index"];	
	if(jQuery.inArray(url, url_list)!== -1){ $("#expiredReminder").show();	}	
	
	
})

function GetURLParameter() {
	var sPageURL = window.location.href;
	var indexOfLastSlash = sPageURL.lastIndexOf("/");
	if(indexOfLastSlash>0 && sPageURL.length-1!=indexOfLastSlash)
		return sPageURL.substring(indexOfLastSlash+1);
	else 
	   return 0;
}

function toggleSmartlinks(){
	$('#smartlinks').toggle();
}

function toggleHeader(){
	$('#header').toggle();
	$('#smartlinks').toggle();	
}




</script>	

<script type="text/javascript" src="<?php echo URL.'views/js/renewal.js'; ?>"></script>