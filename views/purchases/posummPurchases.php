<?php 

	// pr($rows[0]);
	// pr($_SESSION['q']);
	

	$year = date('Y');
	$month_id = date('m',strtotime($_SESSION['today'])); 	
	$day_id = date('d',strtotime($_SESSION['today'])); 	
	$ldm  = date('Y-m-t');
	$today = $_SESSION['today'];
	$tomorrow = date('Y-m-d', strtotime($today . ' +1 day'));


?>

<h5 class="screen" >
	PO Summary
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		

</h5>

<?php 

// if(isset($_GET['debug'])){ pr($q); }

include_once('incs/posumm_filter.php');

?>

<div class="clear" ></div>


<?php if(isset($_GET['submit'])): ?>
<div class="center" >
	<?php 
		$page.="<br /> ".date('M d, Y',strtotime($_GET['start']))." -- ".date('M d, Y',strtotime($_GET['end']))."";		
		$inc = SITE.'views/customs/'.VCFOLDER.'/incs/letterhead.php';include($inc); 
	?>
</div>


	<?php include_once("incs/posumm_table.php"); ?>
<?php endif; ?>






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
	chkAllvar('a');
	
	$('html').live('click',function(){
		$('#names').hide();
	});
	

})


function nolimits(){
	$('#page').val(1);
	$('#limits').val(0);
}	/* fxn */



function xgetProductByBarcode(){
	var barcode = $('#barcode').val();		
	var vurl = gurl+'/ajax/xpos.php';		
	var task = "xgetProductByBarcode";	
		
	$.post(vurl,{task:task,barcode:barcode},function(s){		
		$('input[name="product_id"]').val(s.id);		
	},'json');	
		
}	/* fxn */	


function redirLookup(ucid){
	$('#prid').val(ucid);
}


function redirContact(ucid){
	$('#ccid').val(ucid);
}	/* fxn */


function getContactID(id,val){
	$('#'+id).val(val);
}	/* fxn */





</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>
