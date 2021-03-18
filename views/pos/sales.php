<?php 
	// pr($rows);
	// pr($rows[2]);

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
		<?php $x= (isset($case))? str_replace('_',' ',$case):'SALES'; echo strtoupper($x); ?>
	<span class="hd" >HD</span>
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'opos'; ?>" >POS</a>
	| <a href="<?php echo URL.'pos/sales'; ?>" >Sales</a>
	| <a href="<?php echo URL.'pos/items'; ?>" >Items</a>
	| <a class="u" id="btnExport" >Excel</a> 
	| <a class="u txt-blue" onclick="window.print();" >Print</a>
</h5>


<p><?php $this->shovel('hdpdiv'); ?></p>

<?php 

if(isset($_POST['debug']) && ($_POST['debug']==1)){ pr($q); }


include_once('incs/sales_filter.php');






?>


<div class="clear" ></div>



<?php if(isset($_POST['submit'])): ?>

<div class="center clear" >
<?php $inc = 'incs/sales_letterhead.php';include($inc); ?>


</div>

<h4><?php 
$start=$_POST['start'];
$end=$_POST['end'];
echo "From <span class='u'>$start</span> To <span class='u'>$end</span>";
?></h4>

<?php include_once("incs/{$case}.php");  ?>


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


function xpayPos(posid,i){
	var vurl = gurl+'/ajax/xposr.php';		
	var task = "xpayPos";			
	$.post(vurl,{task:task,posid:posid},function(){});	
	$('#pd'+i).text('Y');
	$('#xbtn'+i).hide();	
}	/* fxn */

function xunpayPos(posid,i){		
	var vurl = gurl+'/ajax/xposr.php';		
	var task = "xunpayPos";			
	$.post(vurl,{task:task,posid:posid},function(){});	
	$('#pd'+i).text('N');	
	$('#xbtn'+i).hide();
	
}	/* fxn */


</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
