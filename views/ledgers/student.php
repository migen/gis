<style>


</style>


<?php 

// pr($banks);
// pr($taux);
// pr($_SESSION['q']);






/* paymodes schedule */	
if(!empty($tsum)){

	include_once(SITE.'views/enrollment/incs/assesshead.php');
	include_once(SITE.'/views/ledgers/incs/soa_functions.php');

	$obpaid=0;
	foreach($tpays AS $tpay){
		if($tpay['feetype_id']==$obid){
			$obpaid+=$tpay['amount'];			
		}
	}	/* fxn */
	$obpaid=number_format($obpaid,2,'.','');


	$paydates = explode(',',$tsum['paydates']);	
	$numpays = count($paydates);
	$annuity = ($tsum['total']-$dpfee)/$numpays;
	$discperiod = $tsum['discounts']/$numperiods;	
	
	

	$atotal=0;			
	foreach($taux AS $tx){
		if($tx['is_discount']!=1){
			$atotal+=$tx['amount'];
		}
	}	/* foreach */

	$apaid=0;			
	foreach($tpays AS $tpay){
		if($tpay['feetype_id']!=$tfeeid){
			$apaid+=$tpay['amount'];
		}
	}	/* foreach */

	$fpaid=$tpaid-$apaid;
	/* for summary */
	$tfpaid=$fpaid;
	$axpaid=$apaid;
	
	
} 

$empty = (empty($tsum))? true:false;	


	
?>

<form method="POST" >

<h5 class="fp120 screen">

	<span class="u" ondblclick="tracepass();" >Ledger & Cashier</span>

	<span class="hd" >HD</span>
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		

	<?php if(empty($scid)):	?>
		| <a href='<?php echo URL."assessment/assess"; ?>' >Assessment</a>
	<?php else: ?>
		| <a href='<?php echo URL."assessment/assess/$scid"; ?>' >Assessment</a>	
	<?php endif; ?>
<span>| <a href='<?php echo URL."students/sectioner/".$tsum['scid']; ?>' ><?php echo "Sectioner"; ?></a></span>
	| <a href='<?php echo URL."soas/soa/".$scid; ?>' >SOA</a>	
	| <a href='<?php echo URL."bills/add"; ?>' >Cashiering</a>
	<?php include_once(SITE.'views/invoices/incs/last_orno.php'); ?>
</h5>


<h4 class="screen" >
	  <a class="txt-blue u" onclick="expandAll()" >+Expand All</a>
	| <a class="txt-blue u" onclick="collapseAll()" >-Collapse All</a>
	| <a href='<?php echo URL."tfees/details/".$tsum['level_id']; ?>' ><?php echo "Tuition"; ?></a>
	| <a href='<?php echo URL."ledgers/filter"; ?>' ><?php echo "Report"; ?></a>
	| <a href='<?php echo URL."tfeetypes/table"; ?>' >Fees</a>	
	| <a href='<?php echo URL."paymodes/index"; ?>' ><?php echo "Modes"; ?></a>	
</h4>


<p><?php $this->shovel('hdpdiv'); ?></p>



<div style="float:left;width:20%;" class="hd screen" id="names" > </div>


<div style="float:left;width:100%;border:1px solid white;" >	<!-- body left -->

<div class="screen" >	<!-- filter -->
<?php  include_once('incs/filter.php'); ?>
</div><br /> <!-- filter -->


<?php if(!$empty): ?>



<div style="float:left;width:40%;border:1px solid white;"  >
<table class="gis-table-bordered table-fx table-altrow"  >
<?php 
	$incs = SITE.'views/enrollment/incs/assessmode.php';
	include($incs);


	
?>		
	<tr class="screen" ><th><span class="blue u" onclick="addToSurcharge(0);" >Surcharge</span>
		<input class="vc50 right pdr05" id="surcharge" value="0" >				
	</th><td>
		P <input class="right pdr05 vc80" id="principal0" />
		i <input class="vc50 center" id="rate0" value="<?php echo number_format($intrate,2); ?>" />
		D<input class="vc50 right pdr05" id="period0" placeholder="days" value="<?php  ?>" />
		<span class="u" onclick="surcharge(0);" >Go</span></td></tr>
	<tr class="screen" ><th colspan="2" >
		<?php $confirm_ledger = ($_SESSION['settings']['confirm_ledger']==1)? "return confirm('Sure?');":null; ?>
		<input onclick="<?php echo $confirm_ledger; ?>"  type="submit" name="submit" value="Update"  />	
		<span class="b trtsum" >&nbsp; *E = (A+B)-(C+D)</span>
	</th></tr>
</table>


<div style="border:1px solid white"  >	<!-- auxdiv -->

<?php 
	$incs = SITE.'views/enrollment/incs/addons.php';
	include($incs);
	
	
?>
</div><!-- auxdiv -->

</div> <!-- header left -->

<div style="float:left;width:20px;height:10px;border:1px solid white;" ></div>

<div style="float:left;width:35%;border:1px solid white;"  >
<table class="gis-table-bordered table-fx table-altrow"  >
		<?php $left_oldbalance = ($tsum['obal']-$obpaid); ?>
	<tr><th class="vc150" >Old Balance
			<span class="txt-blue u" onclick="ilabas('trtsum');" >T</span>
		</th><td class="vc200 right <?php echo ($left_oldbalance)?'red b':NULL; ?>" >
		<?php echo $left_oldbalance; ?></td></tr>
		<tr class="trtsum" ><th>Tuition</th><td class="right pdr05" ><?php echo number_format($tsum['tuition'],2); ?></td></tr>					
		
		<tr><th>A - Assessed</th><td class="right pdr05" ><?php echo number_format($tsum['total'],2); ?></td></tr>					

			
		<tr><th>B - Addons</th><td class="right" ><?php echo number_format($addons,2); ?></td></tr>				

		<tr><th>C - (Discounts)</th><td class="right" ><?php echo number_format($discounts,2); ?>
		<input class="full right pdr05" id="discounts0" type="hidden"
			name="discounts" value="<?php echo number_format($discounts,2,'.',''); ?>"  /></td></tr>				
		<tr><th>D - (Paid)</th><td class="right pdr05" ><?php echo number_format($tsum['paid'],2); ?></td></tr>	
		<tr class="trtsum" ><th>E - Balance</th><td class="right pdr05 b u" ><?php echo number_format($tsum['balance'],2); ?></td></tr>	
		<tr><th>Remarks</th><td><textarea class="full" id="remarks0" name="remarks"  ><?php echo $tsum['remarks']; ?></textarea></td></tr>			
</table>
</div> <!-- header right -->

<div style="clear:both;height:10px;border:1px solid white;" ></div>

<?php if($tsum['role_id']==RSTUD): ?>
<div style="float:left;width:50%;border:1px solid white;"  >
<table class="gis-table-bordered table-fx screen"  >
			
<?php if(empty($tsum['tsumscid'])): ?>
	<tr><td colspan="2" ><input type="submit" name="submit" value="Sync"  /></td></tr>	
<?php endif; ?>


</table>
</div>	<!-- tsum -->
<?php endif; ?>	<!-- if student -->

<?php else: ?>	<!-- if student is empty -->
	<h5>No record.</h5>
<?php endif; ?>	<!-- if student not empty -->


<div style="clear:both;height:10px;border:1px solid white;" ></div>



<!---------------------------------------------------------------------------------->


<!---------------------------------------------------------------------------------->



<?php if(!empty($tsum) && $tsum['paymode_id']>0): ?> <!-- paymode schedule -->

<?php 
	$incs = SITE.'views/enrollment/incs/payables.php';
	include($incs);

?>


<?php 

include_once('incs/payments.php');

?>


<div class="third" >	<!-- calculator -->

<h5 class="screen" >
	  <a class="txt-blue u" onclick="ilabas('tblcalculator')" >+Calculator</a>
</h5>

<table class="screen gis-table-bordered table-fx table-altrow tblcalculator" >	<!-- calculator -->
<tr><th>Tender (A)</th><td>
	<input class="right pdr05" id="calctender"  />
</td></tr>

<tr><th>Total (B)</th><td>
	<input class="right pdr05" id="calctotal"  />
</td></tr>

<tr><th>Change (C)</th><td>
	<input class="right pdr05" id="calcchange"  />
</td></tr>

<tr><td colspan="2" >
	<button onclick="calcsum('calctender','calctotal','calcchange');return false;" >(+)</button>
	<button onclick="calcdiff('calctender','calctotal','calcchange');return false;" > (-) </button>
	<button onclick="calcproduct('calctender','calctotal','calcchange');return false;" >(X)</button>
	<button onclick="calcquotient('calctender','calctotal','calcchange');return false;" >(%)</button>
</td></tr>
<tr><td colspan="2" >
	<button onclick="clearPayables();return false;" >Clear</button>
	<button onclick="writeTotal();return false;" >Write</button>
</td></tr>

</table>	<!-- calculator -->
</div>	<!-- calculator -->

<div class="third" >	<!-- summary -->
	<h5 class="screen" >
		  <a class="txt-blue u" onclick="ilabas('tblsummary')" >+Summary</a>
	</h5>
	<table class="screen gis-table-bordered table-fx table-altrow tblsummary" >	<!-- calculator -->
	<tr><th>Tuition Paid</th><td class="right" ><?php echo number_format($tfpaid,2); ?></td></tr>
	<tr><th>Addons Paid</th><td class="right" ><?php echo number_format($axpaid,2); ?></td></tr>
	<tr><th>Current Due</th><td class="right" ><?php echo number_format($nowdues,2); ?></td></tr>
	<tr><th>Collectibles</th><td class="right" ><?php echo number_format($bill,2); ?></td></tr>
	<tr><th>Paid</th><td class="vc120 right" ><?php echo number_format($totalpaid,2); ?></td></tr>
	<?php $netbal=$bill-$totalpaid; ?>
	<tr><th>Net Balance</th><td class="vc120 right" ><?php echo number_format($netbal,2); ?></td></tr>
	</table>
</div>	<!-- summary -->


<?php endif; ?>	<!-- paymode schedule -->	

</div>	<!-- body left -->




<div class="clear ht100" >&nbsp;</div>

</form>



<!------------------------------------------------------------------------------------------>







<?php if($scid): ?>
<script>

var today = "<?php echo $today; ?>";
var tuition = "<?php echo $tsum['tuition']; ?>";
var oldsurcharge = "<?php echo $surcharge; ?>";
var surgid = "<?php echo $surgid; ?>";
var hdpass 	= "<?php echo MD5($_SESSION['settings']['hdpass_axis']); ?>";

</script>
<?php endif; ?>


<!------------------------------------------------------------------------------------------>


<script>
var gurl = 'http://<?php echo GURL; ?>';
var sy   = '<?php echo $sy; ?>';
var home = '<?php echo $home; ?>';
var page = 'ledgers/student';


$(function(){
	calcvar('a');
	calcvar('b');
	chkAllvar('a');
	chkAllvar('b');
	payfee();
	hdelems();
	$('#hdpdiv').hide();
	nextViaEnter();
	itago('tago');
	itago('tblmultipay');

	$('html').live('click',function(){ $('#names').hide(); });
	
})	/* fxn */


function latedays(i){
	var days = $('#days'+i).val();
	var pdue = $('#pdue'+i).val();
	$('#period0').val(days);
	$('#principal0').val(pdue);	
}	/* fxn */


function redirContact(ucid){
	var url 		= gurl + '/ledgers/student/' + ucid;	
	window.location = url;		
}


function surcharge(i){
	var rate = $('#rate'+i).val()/100;
	var annuity = $('#principal'+i).val();
	var period = $('#period'+i).val()/30;
	var surcharge = parseFloat(rate)*parseFloat(annuity)*parseFloat(period);
	$('#surcharge').val(surcharge.toFixed(2));
	$('#auxamt0').val(parseFloat(surcharge).toFixed(2));			
	
	
}


function addToSurcharge(i){
	var newsurcharge = $('#surcharge').val();
	var surgtotal = parseFloat(oldsurcharge)+parseFloat(newsurcharge);	
	$('#auxtype'+i).val(surgid);
	$('#auxamt'+i).val(surgtotal);
}


function switchPaytype(){
	var details = $("#details").val();
	if(details!=""){
		$('#paytype').val(2);
	} else {
		$('#paytype').val(1);
	}
}	/* fxn */

function switchPaytypeBank(){
	var bank = $("#bank").val();
	if(bank!=0){
		$('#paytype').val(2);
	} else {
		$('#paytype').val(1);
	}

}	/* fxn */



function payfee(){
	$('.btnfeetypeid').change(function(){
		var j  = ($(this).val());
		var a = $('#pfee'+j).val();
		var b = $('#pdue'+j).val();
		var c = $('#pointer'+j).val();
		// alert('j:'+j+',pfee: '+a+',pdue: '+b);
		$('select[name="feetype_id"]').val(a);
		$('input[name="amount"]').val(parseFloat(b).toFixed(2));
		$('input[name="pointer"]').val(c);
		$('#calctotal').val(parseFloat(b).toFixed(2));
		
	})

}	/* fxn */


function copier(val,id){
	$('input[name="'+id+'"]').val(val);
}	/* fxn */


function writeTotal(){
	var total = $('#calctotal').val();
	$('input[name="amount"]').val(parseFloat(total).toFixed(2));	
}	/* fxn */


function calcvar(x){
	$('.chk'+x).click(function(){
		var total = 0;
		$('.chk'+x+':checked').each(function(){
			total+= parseFloat($(this).val());
		})
		$('#calctotal').val(parseFloat(total).toFixed(2));	
	})	

}	/* fxn */



function clearPayables(){
	$('#chkAlla').attr('checked',false);
	$('.chka').attr('checked',false);
	
	$('#chkAllb').attr('checked',false);
	$('.chkb').attr('checked',false);
	$('#calctender').val(0);
	$('#calctotal').val(0);
	$('#calcchange').val(0);
	$('input[name="amount"]').val(0);	
}	/* fxn */


function expandAll(){	
	ilabas('tblaux');
	ilabas('tblpayments');
	ilabas('tblpayables');
	ilabas('tblcalculator');	
	ilabas('trtsum');

}	/* fxn */



function collapseAll(){	
	itago('trtsum');
	itago('trpayments');
	itago('trpayables');
	itago('tblaux');
	itago('tblpayments');
	itago('tblpayables');
	itago('tblcalculator');	


}	/* fxn */

function hdelems(){
	itago('trtsum');
	
}	/* fxn */



function printorno(orno){

	var vurl = gurl+'/ajax/xfees.php';	
	var task = "orno";
	
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&orno='+orno,				
		async: true,
		success: function(s) { 
			console.log(s);
			var cs = s.length;
			content = '<tr><th>Fee</th><th>Amount</th></tr>';
			var ortotal=0;
			var od = $('#ordetails');			
for (var i = 0; i < cs; i++) {			
	ortotal+=parseFloat(s[i].amount);
	content += '<tr><td>'+s[i].feetype+'</td><td>'+s[i].amount+'</td></tr>';
}
			od.html(content);
			$('#ortotal').html(ortotal);
			PrintElem('#ornopage');						

		}		  
    });				
	
	
	
}	/* fxn */






</script>


<script type="text/javascript" src='<?php echo URL."views/js/fees.js"; ?>' ></script>
<script type="text/javascript" src='<?php echo URL."views/js/enroll.js"; ?>' ></script>
<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>
<script type="text/javascript" src='<?php echo URL."views/js/calculator.js"; ?>' ></script>


<?php 



?>