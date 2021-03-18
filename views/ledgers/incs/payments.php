<?php if(!empty($tsum['tsumscid'])): ?>
<br />
<h5>
	  <a class="txt-blue u" onclick="ilabas('tblpayments')" >+Payments</a>
	| <a class="txt-blue u" onclick="ilabas('trpayments')" >+Show</a></h5>


<table class="gis-table-bordered table-fx tblpayments" >

<tr class="headrow" >
	<th>Date</th>
	<th>Employee</th>
	<th>Particulars</th>
	<th>Tender</th>
	<th class="right" >Amount</th>
	<th class="right" >OR No.</th>
	<th class="screen">&nbsp;</th>
	<th>Payer</th>
	<th>Details</th>
	<th class="hd screen vc100" >Bank</th>
</tr>

<?php $totalpaid=0;$tsurgpaid=0; ?>
<?php for($i=0;$i<$count;$i++): ?>
<?php // $totalpaid+=$tpays[$i]['amount']; ?>
<?php 
	if($tpays[$i]['feetype_id']!=$surgid){ $totalpaid+=$tpays[$i]['amount']; 
	} else { $tsurgpaid+=$tpays[$i]['amount']; }
?>
<tr class="trpayments" > 
	<td><?php echo $tpays[$i]['date']; ?></td>
	<td><?php echo substr($tpays[$i]['employee'],0,10); ?></td>
	<td>
		<?php 
			echo $tpays[$i]['feetype']; 
			echo ($tpays[$i]['feetype_id']==$tfeeid)? ' - '.getOrdinal($tpays[$i]['pointer']).' Payment':NULL;
		?>
	</td>
	<td><?php echo $tpays[$i]['paytype']; ?></td>
	<td class="right" ><?php echo number_format($tpays[$i]['amount'],2); ?></td>
	<td class="right pdr05" >
		<span class="u" onclick="copier(<?php echo $tpays[$i]['orno']; ?>,'orno');" ><?php echo $tpays[$i]['orno']; ?></span></td>
	<td class="pdr05 screen" >
		<button><a href="<?php echo URL.'invoices/printorno/'.$tpays[$i]['orno']; ?>" target="blank" >Print</a></button></td>
	<td><?php echo $tpays[$i]['payer']; ?></td>	
	<td><?php echo $tpays[$i]['details']; ?></td>	
	<td class="hd screen" >
		<?php $bc = $tpays[$i]['bank_code']; echo ($bc)? $bc.' | ':NULL; ?>
		<a href='<?php echo URL."tpays/edit/".$tpays[$i]['tpid']."/$sy"; ?>' >Edit</a>
		| <a onclick="return confirm('Dangerous! Sure?');" href='<?php echo URL."tpays/delete/".$tpays[$i]['tpid']."/$sy"; ?>' >Del</a>
	</td>
	
</tr>
<?php endfor; ?>

<tr class="screen" >
	<td><input class="vc100 pdl05" name="date" value="<?php echo $_SESSION['today']; ?>" /></td>
	<td><input class="vc100" value="<?php echo $_SESSION['user']['fullname']; ?>" readonly /></td>
	<td>
		<select name="feetype_id" id="payfee" >
			<?php foreach($feetypes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==1)? 'selected':NULL; ?> >
					<?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>	
	<td>
		<select name="paytype_id" id="paytype" >
			<?php foreach($paytypes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==1)? 'selected':NULL; ?> >
					<?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>
	<td><input style="color:blue;font-size:1.5em;" class="vc120 right pdr05" name="amount" value="0.00" /></td>
	<td class="right"><input class="vc80 right pdr05" type="text" name="orno" onclick="copier(this.value,'mpay[orno]');"
		value="<?php echo ($last_orno+1); ?>" /></td>
	<td class="">
		<input type="radio" value="1" name="addorno" />
		<input class="vc30" value="" name="pointer" />
	</td>		
	<td><input class="vc100" name="payer" /></td>		
	<td><input class="vc100" type="text" id="details" name="details" onchange="switchPaytype();" /></td>		
	<td class="screen">
		<select id="bank" name="bank_id" onchange="switchPaytypeBank();" class="vc100" >
			<option value="0" >Bank</option>
			<?php foreach($banks AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>
</tr>


</table> 	<!-- tpays -->


<p class="screen tblpayments" >
	<?php $confirm_ledger = ($_SESSION['settings']['confirm_ledger']==1)? "return confirm('Sure?');":null; ?>
	<input id="payBtn" onclick="payThis();"  type="submit" name="submit" value="PayX" />
</p>

<input type="hidden" name="totalpaid" value="<?php echo $totalpaid; ?>" />


<?php endif; ?>	<!-- if not empty tsumscid -->

<script>

var cl='0';
// var cl = "<?php echo $_SESSION['settings']['confirm_ledger']; ?>";

$(function(){
	// alert(cl);
})

function payThis(){	
	$('#payBtn').hide();
	
}	/* fxn */

</script>
