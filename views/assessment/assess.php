<style>

div{width:860px;}
.divborder{ border:1px solid white; }

</style>


<?php 

// pr($_SESSION['q']);

// unset($data['feetypes']);
// pr($data);

if(isset($_GET['debug'])){ pr($q); pr($tsum); }

$font_assess="1.6em";

if(isset($taux)){ 
	$disr=array();foreach($taux AS $row){ if($row['is_discount']==1){ $disr[]=$row; } }
	$addr=array();foreach($taux AS $row){ if($row['is_discount']!=1){ $addr[]=$row; } }	
}


// pr($_SESSION['q']);

$tblwidth = "vc500";
$hd = (($_SESSION['srid']==RAXIS) || ($_SESSION['srid']==RMIS))? false:true;


/* paymodes schedule */	
if(!empty($tsum)){

	include_once(SITE.'views/enrollment/incs/assesshead.php');
	include_once(SITE.'views/ledgers/incs/soa_functions.php');

	$paydates = explode(',',$tsum['paydates']);	
	$numpays = count($paydates);
	$annuity = ($tsum['total']-$dpfee)/$numpays;	
	
	
	// $discperiod = $tsum['discounts']/$numperiods;		
	
	$discounts=0;
	foreach($data['taux'] AS $row){ if($row['is_discount']==1){ $discounts+=$row['amount']; } }
		
	$discperiod = $discounts/$numperiods;		
	$intrate = $_SESSION['settings']['intrate'];

	
}	/* has tsum */

	
?>



<h5 class="fp120">
	<?php include_once('incs/links.php'); ?>	
</h5>

<!------ tracelogin ---->
	<p><?php $this->shovel('hdpdiv'); ?></p>

<div style="float:left;width:20%" class="hd" id="names" > </div>

<div class="clear" >&nbsp;</div>


<div class="screen clear ht100" >

	<?php 
		$page="assessment/assess";
		include_once('incs/filter_codename.php'); 
	?>
	<?php if(!empty($tsum)){ $incs = SITE.'views/enrollment/incs/addons.php'; include($incs); } ?>
	
</div>


<div class="screen clear" style="height:0.4in;" ></div>


<div style="float:left;width:70%;border:1px solid white;"  >	<!-- body left -->



<?php if(!empty($tsum)): ?>
	

<div class="center clear" style="font-size:<?php echo $font_assess; ?>;" >
<?php if(!isset($_GET['hideheader'])): ?>
<?php $inc = SITE.'views/elements/letterhead_datetime_twologos.php';include($inc); ?>
<?php endif; ?>
</div>

<?php 
	$incs = SITE.'views/enrollment/incs/studinfo.php';
	include($incs);		
?>		

<?php if(!$is_blocked): ?>	<!-- is_blocked -->			

<?php 


if($obal>0){
	echo "<h5 class='brown' >Paid Old Balance Account: P".number_format($obalpaid,2)."</h5>";
}	/* has obal */

		
?>

<div style="border:1px solid white"  ><?php $incs = 'incs/numfees.php';include($incs);	?></div>
	
	
<div style="clear:both;height:10px;border:1px solid white;" ></div>

<?php 

$tpaid=0;
foreach($tpays AS $tpay){
	if($tpay['feetype_id']==$tfeeid){
		$tpaid+=$tpay['amount'];	
	}
}	/* fxn */
$tpaid=number_format($tpaid,2,'.','');

if(!empty($tsum) && $tsum['paymode_id']>0){
	include('incs/assessed_payables.php');
	include(SITE.'views/enrollment/incs/advpays.php');

}

	
?>
	
<?php else: ?>	<!-- is_blocked -->				

<h5 class="red" >Blocked! Please settle unpaid accounts of P<?php echo number_format($leftbalance,2); ?>.</h5>

<?php endif; ?>	<!-- is_blocked -->				





<?php else: ?>	<!-- if student is empty -->
	<h5>No record.</h5>
<?php endif; ?>	<!-- if student not empty -->



<div class="ht100" ></div>

</div>	<!-- body left -->






<script>
var gurl = "http://<?php echo GURL; ?>";
var sy   = '<?php echo $sy; ?>';
var home = '<?php echo $home; ?>';
var hidden = '<?php echo $hd; ?>';
var hdpass 	= '<?php echo HDPASS; ?>';
var tuition = "<?php echo isset($tsum['tuition'])? $tsum['tuition']:0; ?>";



$(function(){
	if(hidden){hd();}
	$('#hdpdiv').hide();
	nextViaEnter();
	selectFocused();
	$('html').live('click',function(){
		$('#names').hide();
	});


})




function redirContact(ucid){
	var url = gurl + '/assessment/assess/' + ucid + '/' + sy;	
	window.location = url;		
}


function redirSy(){
	var sy=$('#sy').val();
	var url=gurl+'/assessment/assess/'+scid+'/'+sy;
	window.location=url;	
}	/* fxn */









</script>


<script type="text/javascript" src='<?php echo URL."views/js/fees.js"; ?>' ></script>
<script type="text/javascript" src='<?php echo URL."views/js/enroll.js"; ?>' ></script>
<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>