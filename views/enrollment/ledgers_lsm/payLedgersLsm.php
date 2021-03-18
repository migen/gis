<?php 


// pr($data);
// exit;
// echo URL.'advances/student/'.$scid; 


?>

<style>
	div.sixty{width:50%;}
	div.twenty{width:10px;}
	
</style>

<h5>
	Ledgers Pay
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	| <a href='<?php echo URL."bills/add"; ?>' >Cashiering</a>
<?php if($scid): ?>	
	| <a href="<?php echo URL.'ledgers/edit/'.$scid.DS.$sy; ?>" >Edit</a>
	| <a href="<?php echo URL.'clearance/one/'.$scid; ?>" >Status</a>
	| <a href="<?php echo URL.'assessment/assess/'.$scid.DS.$sy; ?>" >Assmt</a>
	| <a href="<?php echo URL.'ledgers/pay/'.$scid.'?cutoff='.$_SESSION['today']; ?>" >Cutoff</a>
	| <a href="<?php echo URL.'soas/soa/'.$scid.DS.$sy; ?>" >SOA</a>	
	| <a href="<?php echo URL.'addons/add/'.$scid.DS.$sy; ?>" >Addon/Disc.</a>

<?php 
	$d['sy']=$sy;$d['repage']="ledgers/pay/$scid";
	$this->shovel('sy_selector',$d); 
?>	
	
	
	<br /><a href="<?php echo URL.'balances/level/'.$student['level_id']; ?>" >Balances</a>
	<?php if($student['paid']>=$student['tdue']): ?>
		| <a href="<?php echo URL.'advances/student/'.$scid; ?>" >Advance</a>
	<?php endif; ?>
	<?php if($_SESSION['srid']==RMIS): ?>
		| <a href="<?php echo URL.'students/sectioner/'.$scid; ?>" >Sectioner</a>
	<?php endif; ?>	
	<?php include_once(SITE.'views/invoices/incs/last_orno.php'); ?>
	
	Print Orno <input class="vc80" id="orno" value="<?php echo $last_orno; ?> " />
	<input type="submit" value="Print" onclick="printOrno();return false;"  />
	
<?php endif; ?>

</h5>

<div class="sixty" >

<?php 

	include_once('pay/filter_codename.php');

	if($scid){
		include_once('pay/headerLedgers.php');
		include_once('pay/bodyLedgers.php');
		// if($_SESSION['settings']['quarter']>3){
			// include(SITE.'views/enrollment/incs/advpays.php');						
		// }
		
		
	}




/* 
	
	if($scid){
		include_once('pay/headerLedgers.php');
		include_once('pay/bodyLedgers.php');
		if($_SESSION['settings']['quarter']>3){
			include(SITE.'views/enrollment/incs/advpays.php');						
		}
		
		
	}

 */
 
?>


</div>	<!-- left -->


<div class="" id="names" >names</div>

<script>
var gurl="http://<?php echo GURL; ?>";
var scid="<?php echo $scid; ?>";




function syOrnoValue(orno,sy){
	var url=gurl+'/invoices/printorno/'+orno+'/'+sy;
	window.open(url, '_blank');	
	
}

function copyOrnoValue(orno){
	orno=$.trim(orno);
	var url=gurl+'/invoices/printorno/'+orno;
	window.open(url, '_blank');	
	
}


function printOrno(){
	var orno=$('#orno').val();
	orno=$.trim(orno);
	var url=gurl+'/invoices/printorno/'+orno;
	window.open(url, '_blank');	
	
}	/* fxn */



</script>

