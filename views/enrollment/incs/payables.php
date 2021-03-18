<script>
	$(function(){})

</script>

<?php 




?>

<h5>
	  <a class="txt-blue u" onclick="ilabas('tblpayables')" >+Payables</a>
	| <a class="txt-blue u" onclick="ilabas('trpayables')" >+Show</a>
	| <a class="txt-blue u" onclick="ilabas('tblmultipay')" >+Multipay</a>	
	
	
</h5>
<table class="gis-table-bordered table-fx tblpayables" >
<tr class="headrow" >
	<th class="" ></th>	<!-- 1 -->
	<th class="vc200" >Particulars</th>	<!-- 2 -->
	<th class="vc100" >Schedule</th>	<!-- 3 -->
	<th class="vc120 right" >Amount</th>	<!-- 4 -->
	<th class="" ><input type="checkbox" id="chkAlla"  /></th>		<!-- 5 -->
	<th class="vc100 right" >Balance</th>	<!-- 6 -->
	<th class="" >M<br /><input type="checkbox" id="chkAllb"  /></th>		<!-- 5 -->
	<th class="vc100" >Overdue</th>	<!-- 6 -->	
</tr>


<?php 

	$bill=0;
	$fdues=0;
	$adues=0;
	$datedue=$dpdue; 	
	$pamt = pamt($dpfee,$discperiod);	
	$isdue = isdue($datedue,$ldm);		
	$bill+=$pamt;

	$tmp = $pamt-$fpaid;
	$fdue = ($tmp<0)? 0: $tmp;
	$fpaid = ($tmp<0)? $tmp*-1:0;
	$fdues = ($isdue)? $fdues+=$fdue:$fdues;
	
	
	
?>


<tr class="<?php echo (($isdue) && ($fdue>0))? 'bg-pink':NULL;   ?>" >
	<?php $j=0; ?>
	<td class="" ><input class="btnfeetypeid" type="radio" value="<?php echo $j; ?>" name="tfid" /></td>	<!-- 1 -->
	<td><?php echo 'Tuition - 1st Payment';  ?></td>	<!-- 2 -->	
	<td id="sched<?php echo $i; ?>" ><?php echo $datedue; ?></td>	<!-- 3 -->
	<td class="right" > 
		<span class="u" onclick="copier(<?php echo $pamt; ?>,'amount');" >
			<?php echo number_format($pamt,2); ?></span></td>	<!-- 4 -->	
	<td class="" ><input type="checkbox" class="chka" value="<?php echo $pamt; ?>" /></td>	<!-- 5 io -->
	
	<td class="right" ><?php echo number_format($fdue,2); ?></td>	
			
	<td class="" ><input type="checkbox" class="chkb" value="<?php echo $fdue; ?>" /></td>	<!-- 5 io -->	
	<td class="" >
		<?php $days = (($isdue) && ($fdue>0))? (strtotime($ldm) - strtotime($datedue))/(3600*24):0; ?>
		<input class="center vc50" id="days<?php echo $j; ?>" value="<?php echo $days; ?>" />
		<a class="u" onclick="latedays(<?php echo $j; ?>);" >Days</a>

	</td>
<td class="tago" >	
<input id="pointer<?php echo $j; ?>" value="1"  name="multi[<?php echo $i; ?>][pointer]" />
<input id="pdue<?php echo $j; ?>" value="<?php echo $fdue; ?>" name="multi[<?php echo $i; ?>][fdue]" />
<input id="pfee<?php echo $j; ?>" value="<?php echo $tfeeid; ?>" name="multi[<?php echo $i; ?>][feeid]"  />
<input id="pamt<?php echo $j; ?>" value="<?php echo $pamt; ?>" name="multi[<?php echo $i; ?>][amt]"  />	
</td>	

</tr>

<?php if($tsum['paymode_id']>1): ?>	<!-- not yearly -->
<?php for($i=0;$i<$numpays;$i++): ?>		<!-- numpayments -->
<?php 
 
	$j=$i+1;	
	$datedue=trim($paydates[$i]); 
	$pamt=pamt($annuity,$discperiod); 		
	$bill+=$pamt;	
	$isdue = isdue($datedue,$ldm);		
	$tmp = $pamt-$fpaid;
	$fdue = ($tmp<0)? 0: $tmp;
	$fpaid = ($tmp<0)? $tmp*-1:0;
	$fdues = ($isdue)? $fdues+=$fdue:$fdues;
 	
	
?>


<tr class="<?php echo (($isdue) && ($fdue>0))? 'bg-pink':NULL; ; ?>" >
	<td class="" ><input type="radio" class="btnfeetypeid" value="<?php echo $j; ?>" name="tfid"  />
	<?php 

	
	?>
	
	</td>	<!-- 1 -->
	<td><?php echo 'Tuition - '; echo getOrdinal($j+1).' Payment';  ?></td>	<!-- 2 -->
	<td id="sched<?php echo $i; ?>" ><?php echo $datedue;  ?></td>	<!-- 3 -->
	<td class="right" ><span class="u" onclick="copier(<?php echo $pamt; ?>,'amount');" >
		<?php echo number_format($pamt,2); ?></span></td>	<!-- 4 -->
	<td class="" ><input type="checkbox" class="chka" value="<?php echo $pamt; ?>" /></td>	<!-- 5 io -->
	<td class="right" ><?php echo number_format($fdue,2); ?></td>				
	<td class="" ><input type="checkbox" class="chkb" value="<?php echo $fdue; ?>" 
		name="multi[<?php echo $i; ?>][checked]" /></td>	<!-- 5 io -->
	
	<td class="" >
		<?php $days = (($isdue) && ($fdue>0))? (strtotime($ldm) - strtotime($paydates[$i]))/(3600*24):0; ?>
		<input class="center vc50" id="days<?php echo $j; ?>" value="<?php echo $days; ?>" />
		<a class="u" onclick="latedays(<?php echo $j; ?>);" >Days</a>
	</td>
<td class="tago" >	
	<input id="pointer<?php echo $j; ?>" value="<?php echo $j+1; ?>" name="multi[<?php echo $i; ?>][pointer]"  />
	<input id="pdue<?php echo $j; ?>" value="<?php echo $fdue; ?>" name="multi[<?php echo $i; ?>][fdue]"  />
	<input id="pfee<?php echo $j; ?>" value="<?php echo $tfeeid; ?>" name="multi[<?php echo $i; ?>][feeid]"  />
	<input id="pamt<?php echo $j; ?>" value="<?php echo $pamt; ?>" name="multi[<?php echo $i; ?>][amt]"  />
</td>	
	
</tr> 
<?php endfor; ?>	<!-- numpayments -->
<?php endif; ?>	<!-- not yearly -->

<tr>
	<th class="" ></th>
	<th colspan="7" >Addons</th>
	<td class="tago" ></td>
</tr>
<!-- auxes -->

<?php 
	$j=$numpays; 	/* for btnfeetype_id */

?>

<?php for($i=0;$i<$numtaux;$i++): ?>	<!-- taux -->
<?php if($taux[$i]['is_discount']!=1): ?>	<!-- addons -->

<?php 

	$pfee = $feetype_id = $taux[$i]['feetype_id'];
	$datedue=$taux[$i]['due'];
	$pamt = $taux[$i]['amount'];
	$bill+=$pamt;	
	$isdue = isdue($datedue,$ldm);
	
	$tmp = $pamt-$apaid;
	$adue = ($tmp<0)? 0: $tmp;
	$apaid = ($tmp<0)? $tmp*-1:0;
	$adues = ($isdue)? $adues+=$adue:$adues;
	$j++; 	
	

	
?>
				
		
	<tr class="<?php echo (($isdue) && ($adue>0))? 'bg-pink':NULL; ?>" >		
		<td class="" ><input class="btnfeetypeid" type="radio" value="<?php echo $j; ?>" name="tfid" />
		</td>		
		<td><?php echo $taux[$i]['feetype'];  ?></td>
		<td><?php echo $datedue; ?></td>	
		<td class="right" >
			<?php $auxamt = $pamt; ?>
			<span class="u" onclick="copier(<?php echo $auxamt; ?>,'amount');" >
				<?php echo number_format($auxamt,2); ?></span></td>	

		<td class="" ><input type="checkbox" class="chka" value="<?php echo $pamt; ?>" /></td><!-- 5 -->	
		
		<td class="right" ><?php echo number_format($adue,2); ?></td>	
	
	<td class="" ><input type="checkbox" class="chkb" value="<?php echo $adue; ?>" 
		name="multi[<?php echo $j; ?>][checked]" /></td>	<!-- 5 io -->
	<td class="" >
		<?php $days = (($isdue) && ($fdue>0))? (strtotime($ldm) - strtotime($datedue))/(3600*24):0; ?>		
		<input class="center vc50" id="days<?php echo $j; ?>" value="<?php echo $days; ?>" />
		<a class="u" onclick="latedays(<?php echo $j; ?>);" >Days</a>
	</td>	
<td class="tago" >
	<input id="pointer<?php echo $j; ?>" value="0"  name="multi[<?php echo $j; ?>][pointer]" />
	<input class="vc50" type="" id="pdue<?php echo $j; ?>" value="<?php echo $adue; ?>" name="multi[<?php echo $j; ?>][fdue]"  />
	<input class="vc50" type="" id="pamt<?php echo $j; ?>" value="<?php echo $pamt; ?>"  name="multi[<?php echo $j; ?>][amt]" />
	<input class="vc50" type="" id="pfee<?php echo $j; ?>" value="<?php echo $pfee; ?>" name="multi[<?php echo $j; ?>][feeid]"  />
</td>

</tr>

		
<?php endif; ?>	<!-- addons -->
<?php endfor; ?>	<!-- taux -->

<?php 

$nowdues=$fdues+$adues;

?>


<!-- auxes -->
</table>


<?php 

include_once('multiple_payments.php');

?>