<?php 
	// pr($rows[0]);

	$year = date('Y');
	$month_id = date('m',strtotime($_SESSION['today'])); 	
	$day_id = date('d',strtotime($_SESSION['today'])); 	
	$ldm  = date('Y-m-t');
	$today = $_SESSION['today'];
	$tomorrow = date('Y-m-d', strtotime($today . ' +1 day'));

	// if(isset($_GET['debug'])){ pr($q); }	

	
?>

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>


<!---------------------------------------------------------------------------->



<h5 class="" >
	<span class="u" ondblclick="tracepass();" >Payments</span> Collection Report 
	<?php echo (isset($count))? '('.$count.')':NULL; ?>
	<span class="hd" >HD</span>
<span class="screen" >
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'collections/payments'; ?>" >Filter</a>
	| <a class="u" id="btnExport" >Excel</a> 
	| <a class="u txt-blue" onclick="window.print();" >Print</a>
</span> 	<!-- screen -->

<?php 
	// $d['sy']=$sy;$d['repage']="collections/payments";
	// $this->shovel('sy_selector',$d); 
?>	


</h5>


<p class="brown" >*Bill indicates non-enrollment related fees and will not reflect on the SOA and Ledger.</p>

<div class="clear" ></div>

<?php


if(isset($_GET['filter'])){
	$incs = 'incs/payments_tableCollections.php';
	include_once($incs);
} else {
	include_once('incs/payments_filterCollections.php');
}


?>






<script>

var gurl = "http://<?php echo GURL; ?>";
var month_id = "<?php echo $month_id; ?>";
var year = "<?php echo $year; ?>";
var ldm  = "<?php echo $ldm; ?>";
var hdpass = "<?php echo HDPASS; ?>";


var day_id = "<?php echo $day_id; ?>";
var tomorrow = "<?php echo $tomorrow; ?>";



$(function(){
	hd();
	$('#hdpdiv').hide();
	excel();
	$('html').live('click',function(){
		$('#names').hide();
	});
	

})


function nolimits(){
	$('#page').val(1);
	$('#limits').val(0);
}	/* fxn */


function redirContact(ucid){
	$('#ccid').val(ucid);
}	/* fxn */


</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
