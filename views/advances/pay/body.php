<?php 

$numcols="9";

// pr($tpays);
// pr($apays);
	
?>



<form method="POST" >
<h4>Details</h4>
<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Particulars</th>
	<th>Date</th>
	<th>Amount</th>
	<th class="vc80" >OR No</th>
	<th class="vc80 right" >Paid</th>
	<th class="vc80 right" >Due</th>
	<th><input type="checkbox" id="chkAlla" /></th>	
	<th></th>
</tr>

<?php 
	$tcoll=0;	/* total collectibles */
	$dcoll=0;	/* due collectibles */
	$nbal=0;	/* net collectibles */
	$tsurg=0;	/* total surcharge */
	
?>
<tr>
	<td><?php echo 1; ?></td>
	<td><?php echo 'Reservation | Tuition'; ?></td>
	<td class="" ><?php echo $rpaydates[0]; ?></td>
	<td class="right" ><?php echo number_format($dpfeeGross,2); ?></td>
<?php 
		$tcoll+=$dpfeeGross;
		$duedate=trim($rpaydates[0]);
		$isdue=($duedate<$cutoff)? true:false;				

		$tmpamt = round($dpfeeGross,2)-round($fpaid,2);		
		$fdue = ($tmpamt<0)? 0: $tmpamt;
		$fpaid = ($tmpamt<0)? $tmpamt*-1:0;
		$dcoll=($isdue)? $dcoll+round($dpfeeGross,2):$dcoll;
		
		/* 2 surg */		
		$surg = ($isdue && $fdue>0)? getSurcharge($fdue,$pmid,$duedate,$cutoff,$paymodes):0;
		$tsurg+=$surg;
				
		$ps=array();$j=0;		
		foreach($tpays AS $pay){
			if($pay['pointer']<2) {
				$ps[$j]['orno']=$pay['orno'];
				$ps[$j]['amount']=$pay['amount'];
				$j++;
			} 
		}	/* foreach */
?>	
<td><?php $ornos=""; foreach($ps AS $p){ 
	$ornos .= '<span class="u" onclick="copyOrnoValue('.$p['orno'].');return false;" >'.$p['orno'].'</span><br />'; } 
	echo $ornos; ?></td>
<td class="right" ><?php $amounts=""; foreach($ps AS $p){ $amounts .= number_format($p['amount'],2).'<br />'; } 
	echo $amounts; ?></td>
<td class="right" ><input class="vc80 right" name="multi[0][amount]"
	onchange="xcopyChk(0,this.value);return false;" <?php echo ($fdue>0)? NULL:'readonly'; ?>
	id="amt0" value="<?php echo number_format($fdue,2); ?>" /></td>	
<td><?php if($fdue>0): ?><input type="checkbox" class="chka" name="multi[0][checked]" id="chk0"
	value="<?php echo round($fdue,2); ?>" /><?php endif; ?></td>
<td></td>	
<input type="hidden" name="multi[0][pointer]" value="1" />
<input type="hidden" name="multi[0][feetype_id]" value="<?php echo $tfeeid; ?>" />
</tr>	<!-- end T1 -->

<?php for($i=1;$i<$numperiods;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo 'Tuition - '; echo getOrdinal($i+1);  ?></td>
	<td class="" ><?php echo $rpaydates[$i]; ?></td>	
	<td class="right" ><?php echo number_format($annuity,2);  ?></td>
<?php 
		$tcoll+=$annuity;
		$duedate=trim($rpaydates[$i]);
		$isdue=($duedate<$cutoff)? true:false;		
		$dcoll=($isdue)? $dcoll+round($annuity,2):$dcoll;		
		
		$tmpamt = round($annuity,2)-round($fpaid,2);
		$fdue = ($tmpamt<0)? 0: $tmpamt;
		$fpaid = ($tmpamt<0)? $tmpamt*-1:0;
		
		/* 2 surg */		
		$surg = ($isdue && $fdue>0)? getSurcharge($fdue,$pmid,$duedate,$cutoff,$paymodes):0;
		$tsurg+=$surg;
						
		$ps=array();$j=0;		
		foreach($tpays AS $pay){
			if($pay['pointer']==$i+1){
				$ps[$j]['orno']=$pay['orno'];
				$ps[$j]['amount']=$pay['amount'];
				$j++;
			} 
		}	/* foreach */
?>	
<td><?php $ornos=""; foreach($ps AS $p){ 
	$ornos .= '<span class="u" onclick="copyOrnoValue('.$p['orno'].');return false;" >'.$p['orno'].'</span><br />'; } 
	echo $ornos; ?></td>
<td class="right" ><?php $amounts=""; foreach($ps AS $p){ $amounts .= number_format($p['amount'],2).'<br />'; } 
	echo $amounts; ?></td>
<td class="right" ><input class="vc80 right" name="multi[<?php echo $i; ?>][amount]" 
	id="amt<?php echo $i; ?>" onchange="xcopyChk(<?php echo $i; ?>,this.value);return false;" 
	value="<?php echo ($isdue)? number_format($fdue,2):0; ?>" 
	<?php echo ($fdue>0)? NULL:'readonly'; ?> /></td>		
<td><?php if($fdue>0): ?><input type="checkbox" class="chka" name="multi[<?php echo $i; ?>][checked]" 
	id="chk<?php echo $i; ?>" value="<?php echo round($fdue,2); ?>" /><?php endif; ?></td>	
<td></td>	
<input type="hidden" name="multi[<?php echo $i; ?>][pointer]" value="<?php echo $i+1; ?>" />
<input type="hidden" name="multi[<?php echo $i; ?>][feetype_id]" value="<?php echo $tfeeid; ?>" />
	
</tr>

<?php endfor; ?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td>Surcharge</td>
	<td><?php echo $today; ?></td>
	<td></td><td></td><td></td>
	<td><input class="vc80 right" name="multi[<?php echo $i; ?>][amount]" value="<?php echo round($tsurg,2); ?>" 
		onchange="xcopyChk(<?php echo $i; ?>,this.value);return false;" id="amt<?php echo $i; ?>" /></td>
		
	<td><input type="checkbox" class="chka" name="multi[<?php echo $i; ?>][checked]" id="chk<?php echo $i; ?>"
		value="<?php echo round($tsurg,2); ?>" /></td>		
	<td></td>
	<input type="hidden" name="multi[<?php echo $i; ?>][pointer]" value="0" />
	<input type="hidden" name="multi[<?php echo $i; ?>][feetype_id]" value="<?php echo $surgid; ?>" />
</tr>	<!-- surg column -->


<tr><th colspan="<?php echo $numcols; ?>" >Addons</th></tr>

<!-- addons -->
<?php 
	$fextra=round($tpaid,2)-round($adjusted,2);
	$apaid=($fextra>0)? $apaid+=$fextra:$apaid;
	$fdue=($fextra>0)? $apaid+=$fextra:$apaid;

	$k=$i+1;	
	foreach($addons AS $addon):	
	$rowdue=$addon['dueamt'];
?>
<tr>
	<td><?php echo $k+1; ?></td>
	<td><?php echo $addon['feetype'].' #'.$addon['num']; ?></td>
	<td>&nbsp;
		<?php 
			// echo "fextra: $fextra <br />";
		?>
	
	</td>
	<?php 
		$feeid=$addon['feetype_id'];	
		$dueamt=$addon['dueamt'];	
		$fdue=$addon['dueamt'];	
	
		$j=0;$ps2=array();
		foreach($apays AS $pay){
			if(($pay['feetype_id']==$addon['feetype_id']) && ($pay['pointer']==$addon['num'])){
				$rowdue=$dueamt-$pay['amount']; 			
				$ps2[$j]['orno']=$pay['orno'];
				$ps2[$j]['amount']=$pay['amount'];
				$j++;
			} 
		}	/* foreach */		

		
		
		if($fextra<0){	
			$j=0;	
			foreach($apays AS $pay){
				if(($pay['feetype_id']==$addon['feetype_id']) && ($pay['pointer']==$addon['num'])){
					$fdue-=$pay['amount'];
					$j++;
				} 
			}	/* foreach */	
		} else {
			$fdue-=$fextra;
			$fextra-=$dueamt;
		}
		

		

	?>	
	
<td class="right" ><?php echo number_format($dueamt,2); ?></td>	
<td><?php $ornos=""; foreach($ps2 AS $p){ 
	$ornos .= '<span class="u" onclick="copyOrnoValue('.$p['orno'].');return false;" >'.$p['orno'].'</span><br />'; } 
	echo $ornos; ?></td>
<td class="right" ><?php $amounts=""; foreach($ps2 AS $p){ $amounts .= number_format($p['amount'],2).'<br />'; } 
	echo $amounts; ?></td> 
<td class="right" ><input class="vc80 right" name="multi[<?php echo $k; ?>][amount]" 
	id="amt<?php echo $k; ?>" onchange="xcopyChk(<?php echo $k; ?>,this.value);return false;" 
	value="<?php echo ($rowdue>0)? number_format($rowdue,2):0; ?>" /></td>		
<td><?php if($rowdue>0): ?><input type="checkbox" class="chka" name="multi[<?php echo $k; ?>][checked]" id="chk<?php echo $k; ?>" value="<?php echo round($rowdue,2); ?>" /><?php endif; ?></td>	
<td><a href="<?php echo URL.'addons/edit/'.$addon['auxid']; ?>" >Edit</a></td>	
<input type="hidden" name="multi[<?php echo $k; ?>][pointer]" value="<?php echo $addon['num']; ?>" />
<input type="hidden" name="multi[<?php echo $k; ?>][feetype_id]" value="<?php echo $feeid; ?>" />
	
</tr>
<?php 
	$k++;
	endforeach; 
?>

<tr><th colspan="5" >Total Collected</th><th class="right" ><?php echo number_format($tpaid,2); ?></th><th colspan="3" ></th></tr>

<?php if($fextra>0): ?>
<tr><th colspan="5" >Overpayment</th><th class="right" ><?php  echo number_format($fextra,2); ?></th><th colspan="3" ></th></tr>
<?php endif; ?>


<tr><th colspan="<?php echo $numcols; ?>" >Non-Enrollment Related</th></tr>

<tr>
<td></td>
<td>
<select name="bills[feetype_id]" onchange="xgetAmount(this.value);return false;" >
<option value="0" >Choose</option>	
<?php foreach($feetypes AS $sel): ?>
<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
<?php endforeach; ?>
</select>
</td>
<td colspan="4" ></td>
<td><input class="vc80 right" name="bills[amount]" id="billAmount" value="0" onchange="sumAll();" /></td>
<td colspan="2" ></td>
</tr>


</table>

<p></p>

<table class="gis-table-bordered" >
<tr><th>Date</th><th>OR No</th><th class="" >Tender (A)</th><th class="right" >Amount (B)</th><th>Type<br />Reference</th>
</tr>
<tr>
<td><input type="date" name="pay[date]" class="vc150" value="<?php echo $today; ?>"  /></td>
<td><input class="vc80" name="pay[orno]" value="<?php echo ($last_orno+1); ?>"  />
Override<input type="checkbox" value="1" name="recycle" />
</td>
<td><input class="vc80 right" id="tender" value="0" onblur="getChange();return false;" /></td>
<td><input style="color:blue;font-size:1.6em;" class="vc150 right" id="total" name="pay[amount]" value="0" readonly />
<br /><span class="u b" style="padding-left:80px;font-size:1.2em;" onclick="getChange();return false;" >Change</span>
<input style="font-size:1.2em;" id="change" value="0" class="vc150 right" readonly />
</td>
<td>
<select name="pay[paytype_id]" class="vc120" >
	<?php foreach($paytypes AS $sel): ?>
		<option value="<?php echo $sel['id'];?>" ><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select><br />
<select name="pay[bank_id]" class="vc120" >
	<option value="0" >Bank</option>
	<?php foreach($banks AS $sel): ?>
		<option value="<?php echo $sel['id'];?>" ><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select><br />
<input class="vc120" name="pay[reference]" class="vc150"  />
</td>
</tr>
</table>

<p><?php // include_once('calculator.php'); ?></p>


<p><input id="paybtn" type="submit" name="submit" value="Pay" onclick="confirmPay();return false;" /></p>
</form>



<script>

var sy="<?php echo $_SESSION['sy']; ?>";

$(function(){

	chkAllvar('a');	
	sumChecked('a');
	
})


function getChange(){
	var tender=$('#tender').val();
	var tender = tender.replace(/\,/g,'');		
	var total=$('#total').val();
	var total = total.replace(/\,/g,'');	
	var change=parseFloat(tender)-parseFloat(total);	
	change=numberWithCommas(parseFloat(change));	
	$('#change').val(change);
}

function sumChecked(x){
	$('.chk'+x).click(function(){
		var total = 0;
		$('.chk'+x+':checked').each(function(){
			total+=parseFloat($(this).val());			
		})		
		total=parseFloat(total)+(parseFloat($('#billAmount').val()));		
		total=numberWithCommas(parseFloat(total));
		$('#total').val(total);	
	})	
}	/* fxn */

function sumAll(){
	var total = 0;
	$('.chka:checked').each(function(){
		total+= parseFloat($(this).val());
	})		
	total=parseFloat(total)+(parseFloat($('#billAmount').val()));		
	total=numberWithCommas(parseFloat(total).toFixed(2));
	$('#total').val(total);	

}	/* fxn */

function xcopyChk(i,val){
	val=parseFloat(val.replace(/,/g, ''));
	$('#chk'+i).val(val);
	sumAll();
}	/* fxn */


function xgetAmount(fid){
	var vurl 	= gurl + '/ajax/xfees.php';	
	var task	= "auxThis";

	if(fid>0){
		$.ajax({
			url: vurl,dataType: "json",type: 'POST',async: true,data:'task='+task+'&id='+fid+'&sy='+sy,		
			success: function(s) { 		
				$('#billAmount').val(parseFloat(s.amount).toFixed(2));
				sumAll();
			} 
		});	
	} else {
		$('#billAmount').val(0.00);	
		sumAll();
	}
}	/* fxn */


function confirmPay(){
	$('#paybtn').hide();		
	if (confirm('Sure?')){
		document.forms[0].submit();
	}
	return false;			
}

</script>

