
<?php  

?>

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

<div id='header'>
<table class="nogis-table-bordered" style="font-family:Lucida Console, Monaco, monospace;" >
<tr>
	<td class="" style="width:76%;" >
		<h2 style="padding-left:16px;" class="i txt-white no-underline yellow" > CHINESE		
		<span style="font-size:0.6em;font-style:normal;font-weight:normal;" >		
		<?php if(isset($_SESSION['loggedin']) && ($_SESSION['loggedin']) && ($_SESSION['srid']==RMIS)): ?>			
			<a class='white no-underline' target='blank' href='<?php echo URL."mgt/pass/"; ?>' ><?php echo DBYR; ?></a>
		<?php else: ?>
			<?php echo DBYR; ?>
		<?php endif; ?>
		</span>
		</h2> 
	</td>
	<td class="unbordered" style='font-size:32px;color:white;'>
		<p style='opacity: 0.05;' ondblclick='tracepass();' > Trace </p>	
		<span class="right f18" style="padding-right:0%;" ><?php echo strtoupper(VCFOLDER); ?>  | G I S A</span>
		<span class="f12" ><?php echo VERSION; ?> </span>  
	</td>		
</tr>
</table>
</div>
	
<style>

</style>

	