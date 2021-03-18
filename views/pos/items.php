<?php 
	// pr($rows[0]);
	
	$year = date('Y');
	$month_id = date('m',strtotime($_SESSION['today'])); 	
	$day_id = date('d',strtotime($_SESSION['today'])); 	
	$ldm  = date('Y-m-t');
	$today = $_SESSION['today'];
	$tomorrow = date('Y-m-d', strtotime($today . ' +1 day'));

?>

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>


<!---------------------------------------------------------------------------->



<h5 class="screen" >
	<span class="u" ondblclick="tracepass();" >POS</span>
		<?php $x= (isset($case))? str_replace('_',' ',$case):'ITEMS'; echo strtoupper($x); ?>	
	<span class="hd" >HD</span>
<span class="screen" >
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'opos'; ?>" >POS</a>
	| <a href="<?php echo URL.'pos/sales'; ?>" >Sales</a>
	| <a class="u" id="btnExport" >Excel</a> 
	| <a class="u txt-blue" onclick="window.print();" >Print</a>
</span> 	<!-- screen -->

</h5>

<?php 
if(isset($_POST['debug']) && ($_POST['debug']==1)){ pr($q); }

?>

<p><?php $this->shovel('hdpdiv'); ?></p>


<div class="center clear" >
<?php $inc = SITE.'views/elements/letterhead_logo_datetime.php';include($inc); ?>
</div>


<?php 

include_once('incs/reconcile_table.php');
echo "<br />";
include_once('incs/items_filter.php');






?>



<div class="clear" ></div>

<?php if(isset($_POST['submit'])): ?>
<br />
	<table class="gis-table-bordered" >
		<tr><th>Date Range</th><td><?php echo $_POST['start'].'  to  '.$_POST['end']; ?> </td></tr>
	</table>
<?php endif; ?>

<h4><?php echo (isset($params) && ($params['is_return']==1))? "Returns":"Sales"; ?> Itemized </h4>



<?php 


if(isset($_POST['submit'])){
	include_once("incs/{$case}.php");	
		
} 	/* if */


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
