 <?php 

 
$numcols="9";
$resfee=&$_SESSION['resfee'];
$tfover=$fpaid-$adjusted;

	
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
	<!-- <input type="checkbox" id="chkAlla" /> -->
	<th><input type="checkbox" id="chkAlla" /></th>	
	<th></th>
</tr>

<?php 
	$tcoll=0;	/* total collectibles */
	$dcoll=0;	/* due collectibles */
	$nbal=0;	/* net collectibles */
	$tsurg=0;	/* total surcharge */
	
?>

<?php $p=0; ?>
<tr>
	<td><?php echo 0; ?></td>
	<td>  <?php echo 'Reservation'; ?></td>
	<td class="" ><?php echo $rpaydates[0]; ?></td>
	<td class="right" ><?php echo number_format($resfee,2); ?></td>
	
	<td>
		<?php 
			$tfirst=$dpfeeGross-$resfee;			
			$tcoll+=$resfee;
			$duedate=trim($rpaydates[0]);
			$isdue=($duedate<$cutoff)? true:false;				

			$tmpamt = round($resfee,2)-round($fpaid,2);		
			$fdue = ($tmpamt<0)? 0: $tmpamt;
			
			$fpaid = ($tmpamt<0)? $tmpamt*-1:0;
			$dcoll=($isdue)? $dcoll+round($resfee,2):$dcoll;
			
			/* 2 surg */		
			$surg = ($isdue && $fdue>0)? getSurcharge($fdue,$pmid,$duedate,$cutoff,$paymodes):0;
			$tsurg+=$surg;
					
			$ps=array();$j=0;		
			foreach($tpays AS $pay){
				if($pay['pointer']==0) {
					$ps[$j]['orno']=$pay['orno'];
					$ps[$j]['amount']=$pay['amount'];
					$j++;
				} 
			}	/* foreach */
		?>

		<?php $ornos=""; foreach($ps AS $pr){ 
		$ornos .= '<span class="u" onclick="copyOrnoValue('.$pr['orno'].');return false;" >'.$pr['orno'].'</span><br />'; } 
		echo $ornos; ?></td>
	<td class="right" ><?php $amounts=""; foreach($ps AS $pr){ $amounts .= number_format($pr['amount'],2).'<br />'; } 
		echo $amounts; ?></td>

	<td class="right" ><input class="vc80 right" name="multi[0][amount]"
		onchange="xcopyChk(0,this.value);return false;" <?php echo ($fdue>0)? NULL:'readonly'; ?>
		id="amt0" value="<?php echo number_format($fdue,2); ?>" /></td>	
	<td><?php if($fdue>0): ?><input type="checkbox" class="chka" name="multi[0][checked]" id="chk0"
		value="<?php echo round($fdue,2); ?>" /><?php endif; ?></td>
	<td></td>	
	<input type="hidden" name="multi[0][pointer]" value="0" />
	<input type="hidden" name="multi[0][feetype_id]" value="<?php echo $tfeeid; ?>" />
</tr>	<!-- end T0 -->

<?php $p++; ?>
<tr>
	<td><?php echo 1; ?></td>
	<td>  <?php echo 'Tuition'; ?></td>
	<td class="" ><?php echo $rpaydates[0]; ?></td>
	<?php $tfirst=$dpfeeGross-$resfee; ?>
	<td class="right" ><?php echo number_format($tfirst,2); ?></td>
<?php 
		$tcoll+=$tfirst;
		$duedate=trim($rpaydates[0]);
		$isdue=($duedate<$cutoff)? true:false;				

		$tmpamt = round($tfirst,2)-round($fpaid,2);		
		$fdue = ($tmpamt<0)? 0: $tmpamt;
		$fpaid = ($tmpamt<0)? $tmpamt*-1:0;
		$dcoll=($isdue)? $dcoll+round($dpfeeGross,2):$dcoll;
		
		/* 2 surg */		
		$surg = ($isdue && $fdue>0)? getSurcharge($fdue,$pmid,$duedate,$cutoff,$paymodes):0;
		$tsurg+=$surg;
				
		$ps=array();$j=0;		
		foreach($tpays AS $pay){
			if($pay['pointer']==1) {
				$ps[$j]['orno']=$pay['orno'];
				$ps[$j]['amount']=$pay['amount'];
				$j++;
			} 
		}	/* foreach */
?>	
<td><?php $ornos=""; foreach($ps AS $pr){ 
	$ornos .= '<span class="u" onclick="copyOrnoValue('.$pr['orno'].');return false;" >'.$pr['orno'].'</span><br />'; } 
	echo $ornos; ?></td>
<td class="right" ><?php $amounts=""; foreach($ps AS $pr){ $amounts .= number_format($pr['amount'],2).'<br />'; } 
	echo $amounts; ?></td> 
<td class="right" ><input class="vc80 right" name="multi[1][amount]"
	onchange="xcopyChk(1,this.value);return false;" <?php echo ($fdue>0)? NULL:'readonly'; ?>
	id="amt1" value="<?php echo number_format($fdue,2); ?>" /></td>	
<td><?php if($fdue>0): ?><input type="checkbox" class="chka" name="multi[1][checked]" id="chk1"
	value="<?php echo round($fdue,2); ?>" /><?php endif; ?></td>
<td></td>	
<input type="hidden" name="multi[1][pointer]" value="1" />
<input type="hidden" name="multi[1][feetype_id]" value="<?php echo $tfeeid; ?>" />
</tr>	<!-- end T1 -->

<?php for($i=1;$i<$numperiods;$i++): ?>
<?php $p=$i+1; ?> 
<tr> 
	<td><?php echo $p; ?></td>
	<td> <?php echo 'Tuition - '; echo getOrdinal($p);  ?></td>
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
			if($pay['pointer']==$p){
				$ps[$j]['orno']=$pay['orno'];
				$ps[$j]['amount']=$pay['amount'];
				$j++;
			} 
		}	/* foreach */
?>	
<td><?php $ornos=""; foreach($ps AS $pr){ 
	$ornos .= '<span class="u" onclick="copyOrnoValue('.$pr['orno'].');return false;" >'.$pr['orno'].'</span><br />'; } 
	echo $ornos; ?></td> 
<td class="right" ><?php $amounts=""; foreach($ps AS $pr){ $amounts .= number_format($pr['amount'],2).'<br />'; } 
	echo $amounts; ?></td> 
<td class="right" ><input class="vc80 right" name="multi[<?php echo $p; ?>][amount]" 
	id="amt<?php echo $p; ?>" onchange="xcopyChk(<?php echo $p; ?>,this.value);return false;" 
	value="<?php echo ($isdue)? number_format($fdue,2):0; ?>" 
	<?php echo ($fdue>0)? NULL:'readonly'; ?> /></td>		
<td><?php if($fdue>0): ?><input type="checkbox" class="chka" name="multi[<?php echo $p; ?>][checked]" 
	id="chk<?php echo $p; ?>" value="<?php echo round($fdue,2); ?>" /><?php endif; ?></td>	
<td></td>	
<input type="hidden" name="multi[<?php echo $p; ?>][pointer]" value="<?php echo $p; ?>" />
<input type="hidden" name="multi[<?php echo $p; ?>][feetype_id]" value="<?php echo $tfeeid; ?>" />
	
</tr>

<?php endfor; ?>

<?php $p++; ?>

<tr>
	<td><?php echo $p; ?></td>
	<td>Surcharge</td>
	<td><?php echo $today; ?></td>
	<td></td><td></td><td></td> 
	<td><input class="vc80 right" name="multi[<?php echo $p; ?>][amount]" value="<?php echo round($tsurg,2); ?>" 
		onchange="xcopyChk(<?php echo $p; ?>,this.value);return false;" id="amt<?php echo $p; ?>" /></td>
		
	<td><?php if($tsurg>0): ?>
		<input type="checkbox" class="chka" name="multi[<?php echo $p; ?>][checked]" id="chk<?php echo $p; ?>"
			value="<?php echo round($tsurg,2); ?>" />
		<?php endif; ?>	
	</td>		
	<td></td>
	<input type="hidden" name="multi[<?php echo $p; ?>][pointer]" value="0" />
	<input type="hidden" name="multi[<?php echo $p; ?>][feetype_id]" value="<?php echo $surgid; ?>" />
</tr>	<!-- surg column -->


<?php 
	// echo "<br />tfpaid: $tfpaid <br />";
	// echo "<br />fextra: $fextra <br />";

?>

<?php if($tfover>0): ?>
<?php $p+=1; ?>
<tr>
	<th colspan="5" >Tuition Overpayment </th>
	<th class="right" ><?php echo number_format($tfover,2); ?></th>
	<td><input class="vc80 right" name="multi[<?php echo $p; ?>][amount]" value="<?php echo round($tfover*-1,2); ?>" 
		onchange="xcopyChk(<?php echo $p; ?>,this.value);return false;" id="amt<?php echo $p; ?>" /></td>
	<td><input type="checkbox" class="chka" name="multi[<?php echo $p; ?>][checked]" 
		id="chk<?php echo $p; ?>" value="<?php echo round($tfover*-1,2); ?>" /></td>			
	<td></td>
	<input type="hidden" name="multi[<?php echo $p; ?>][pointer]" value="0" />
	<input type="hidden" name="multi[<?php echo $p; ?>][feetype_id]" value="<?php echo $ovrid; ?>" />	
</tr>
<?php endif; ?>



<tr><th colspan="<?php echo $numcols; ?>" >Addons</th></tr>

<!-- addons -->
<?php 


	$fextra=round($tpaid,2)-round($adjusted,2);		
	$totalbal=$total_payables-$tpaid;
	// echo "<br />totalbal: $totalbal <br />";
	
	
	
	$p++;
	foreach($addons AS $addon):	
		$dueamt=$addon['dueamt'];
		if($fextra>0){
			$fdue=$fextra-$dueamt;	
			$fextra-=$dueamt;			
		} else {
			$fdue=$dueamt*-1;
		}
	
?> 
<tr>
	<td><?php echo $p; ?></td>
	<td> <?php echo $addon['feetype'].' #'.$addon['num']; ?></td>
	<td>&nbsp;
		<?php // echo "p: $p"; ?>
		<?php 
		
		?>
	
	</td>
	<?php 
		$feeid=$addon['feetype_id'];	
		
		$j=0;$ps2=array();
		$pdamt=0;
		foreach($apays AS $pay){
			if(($pay['feetype_id']==$addon['feetype_id']) && ($pay['pointer']==$addon['num'])){
				$ps2[$j]['orno']=$pay['orno'];
				$ps2[$j]['amount']=$pay['amount'];
				$pdamt+=$pay['amount'];
				$j++;
			} 
		}	/* foreach */		
		$auxbal=$dueamt-$pdamt;

		

	?>	
	
<td class="right" ><?php echo number_format($addon['dueamt'],2); ?></td>	
<td><?php $ornos=""; foreach($ps2 AS $pr){ 
	$ornos .= '<span class="u" onclick="copyOrnoValue('.$pr['orno'].');return false;" >'.$pr['orno'].'</span><br />'; } 
	echo $ornos; ?></td>
<td class="right" ><?php $amounts=""; foreach($ps2 AS $pr){ $amounts .= number_format($pr['amount'],2).'<br />'; } 
	echo $amounts; ?></td> 
<td class="right" ><input class="vc80 right" name="multi[<?php echo $p; ?>][amount]" 
	id="amt<?php echo $p; ?>" onchange="xcopyChk(<?php echo $p; ?>,this.value);return false;" 
	value="<?php echo number_format($auxbal,2); // echo (($totalbal>0) && ($dueamt>$pdamt))? number_format($auxbal,2):0; ?>" />
		
	</td>		
<td><?php if(($totalbal>0) && ($dueamt<>$pdamt)): ?><input type="checkbox" class="chka" name="multi[<?php echo $p; ?>][checked]" id="chk<?php echo $p; ?>" value="<?php echo round($auxbal,2); ?>" /><?php endif; ?></td>	
<td><a href="<?php echo URL.'addons/edit/'.$addon['auxid'].DS.$sy; ?>" >Edit</a></td>	
<input type="hidden" name="multi[<?php echo $p; ?>][pointer]" value="<?php echo $addon['num']; ?>" />
<input type="hidden" name="multi[<?php echo $p; ?>][feetype_id]" value="<?php echo $feeid; ?>" />
	
</tr>
<?php 
	$p++;
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
<td><input class="vc80" name="pay[orno]" value="<?php echo ($last_orno+1); ?>"  type="number" />
Override<input type="checkbox" value="1" name="recycle" />
</td>
<td><input class="vc80 right" id="tender" value="0" onblur="getChange();return false;" /></td>
<td><input style="color:blue;font-size:1.6em;" class="vc200 right" id="total" name="pay[amount]" value="0" readonly />
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

<div class="ht100" >&nbsp;</div>



<script>

var sy="<?php echo DBYR; ?>";

$(function(){
	
	$('#names').hide();	
	chkAllvarCalc('a');	
	sumChecked('a');
	
	
})


function testParse(){
	var x=46999.20;
	var y=48149.30;
	var z=parseFloat(x)+parseFloat(y);
	z=numberWithCommas(parseFloat(z).toFixed(2))	
	$('#total').val(z);
	
}

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
			var val=parseFloat($(this).val());
			total+=val;	
		})		
		// total=numberWithCommas(parseFloat(total));
		total=parseFloat(total.toFixed(2));
		total=numberWithCommas(total);		
		$('#total').val(total);
			
	})	

}	/* fxn */

function sumAllxxx(){	
	var total = 0;
	$('.chka:checked').each(function(){
		total+= parseFloat($(this).val());
	})		
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

