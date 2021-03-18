<?php 
	// pr($_SESSION['q']);
	$dbo=PDBO;
	$dbg=VCPREFIX.$sy.US.DBG;
	$dbcontacts="{$dbo}.00_contacts";
	$dbpayments="{$dbo}.30_payments";
	$colspan=9;
	
	// pr($data);
	// unset($data['feetypes']);
	// pr($data);


extract($user);
$is_admin=(($role_id==RMIS) || ($role_id==RAXIS && $privilege_id==0))? true:false;



?>
<h3>
	Student Bills (<?php echo ($scid)? $count:null; ?>) | <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."enrollment/ledger/$scid/$sy"; ?>' >Ledger</a>
	| <span class="u" onclick="traceshd();" >Outsider</span>

</h3>

<?php if($srid!=RSTUD): ?>
	<p><table id="tbl-1" class="gis-table-bordered " >
		<tr>
			<th>ID</th>
			<td>
			<input class="pdl05" id="part" autofocus placeholder="name" />
			<input type="submit" name="auto" value="Students" onclick='getDataByTable(dbcontacts,20);return false;' />		
		</td></tr>
	</table></p>
<div id="names" >names</div>
<?php endif; ?>	<!-- not student -->








<?php if($scid): ?>
<form method="POST" >



<table class="gis-table-bordered" >
	<tr>
		<th>ID No.</th><td><?php echo $student['studcode']; ?></td>
		<th>Student</th><td><?php echo $student['studname']; ?></td>
		<input type="hidden" id="studname" value="<?php echo $student['studname']; ?>" />			
	</tr>
</table><br />


<table class="gis-table-bordered" >
<tr>
	<th class="vc100" >Date</th>
	<th class="vc150" >Feetype</th>
	<th class="vc150 right" >Amount</th>
	<th class="vc150" >Paytype</th>
	<th class="vc100" >OR No</th>
	<th class="vc100" >Reference/ Notes</th>
	<th colspan=3 ></th>
</tr>
<tr>
	<td>
		<input type="date" name="post[date]" value="<?php echo $_SESSION['today']; ?>" />
		<input type="hidden" name="post[sy]" value="<?php echo $sy; ?>" />	
		<input type="hidden" name="post[scid]" value="<?php echo $scid; ?>" />	
		<input type="hidden" name="post[ecid]" value="<?php echo $_SESSION['ucid']; ?>" />	
		<input type="hidden" name="post[in_tuition]" value="<?php echo 0; ?>" />	
	</td>
	<td >
		<select class="vc200" name="post[feetype_id]" >
			<option value=0>Select One</option>
			<?php foreach($feetypes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>
	<td class="right" ><input id="amount" class="right vc100" type="text" name="post[amount]" 
		onchange="copyToReceived();return false;" value="<?php echo '0.00'; ?>" /></td>	
	<td>
		<select class="vc100" name="post[paytype_id]" >
			<?php foreach($paytypes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>	
	<td><input type="text" name="post[orno]" value="<?php echo $nextOrno; ?>" /></td>	
	<td><input type="text" name="post[reference]" value="" /></td>	
	<td colspan=3 ></td>		
</tr>
<tr>
	<th colspan="2" >
		<span class="shd" >
			Payer <input type="" name="post[payer]" class="vc200" >		
		</span>
	</th>
	<th colspan=2 >
		Received <input id="received" name="post[received]" onchange="getChange();return false;" value="0.00" ><br /><br />
		Change <input id="change"  name="post[change]" value="0.00" >				
	</th>
	<th colspan=3>
		<span class="b" >Notes:</span> <br />
		<textarea cols=20 rows=2 name="post[notes]" ></textarea>	
	</th>
	<th colspan=2>
		<input type="submit" name="submit" value="Pay" />	
	</th>
</tr>


<tr>
	<th colspan="<?php echo $colspan; ?>" >History</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $rows[$i]['date']; ?></td>
	<td><?php echo $rows[$i]['feetype']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['amount'],2); ?></td>
	<td><?php echo $rows[$i]['paytype']; ?></td>
	<td><?php echo str_pad($rows[$i]['orno'],5,'0',STR_PAD_LEFT); ?></td>
	<td>
		<?php echo (!empty($rows[$i]['payer']))? $rows[$i]['payer'].' &nbsp; ':NULL; ?>
		<?php echo $rows[$i]['reference']; ?>
		
		<?php echo isset($rows[$i]['notes'])? ' / '.$rows[$i]['notes']:NULL; ?>	
		
	</td>
	<td>
		<?php if($is_admin): ?>	
		<a href="<?php echo URL.'payments/edit/'.$rows[$i]['pkid']; ?>" >Edit</a>
		<?php endif; ?>								
	</td>
	<td><a href="<?php echo URL.'ornos/view/'.$rows[$i]['orno']; ?>" >Print OR</a></td>
	<td>
		<?php if($is_admin): ?>	
			<input type="submit" value="Delete" onclick="xdelete(dbpayments,<?php echo $i; ?>);return false;" />
		<?php endif; ?>							
		<input type="hidden" id="pkid-<?php echo $i; ?>" class="pdl05" value="<?php echo $rows[$i]['pkid']; ?>" />	
		<input type="hidden" id="feetype-<?php echo $i; ?>" value="<?php echo $rows[$i]['feetype']; ?>" />	
		<input type="hidden" id="amount-<?php echo $i; ?>" value="<?php echo $rows[$i]['amount']; ?>" />		
	</td>
	
</tr>
<?php endfor; ?>
</table>

<input type="hidden" name="studname" value="<?php echo $student['studname']; ?>" >

</form>
<?php endif; ?>		<!-- scid -->










<script>
var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";
var dbyr = "<?php echo DBYR; ?>";
var dbcontacts = "<?php echo $dbcontacts; ?>";
var dbpayments = "<?php echo $dbpayments; ?>";
var limit=20;
			
$(function(){
	$('html').live('click',function(){ $('#names').hide(); });
	$('#names').hide();
	shd();
	selectFocused();
	// alert(dbpayments);
})


function copyToReceived(){
	var amt = $('#amount').val();
	$('#received').val(amt);
	
}	/* fxn */


function getChange(){
	var received=$('#received').val();
	var amount=$('#amount').val();
	received=received.replace(",", "");		
	amount=amount.replace(",", "");			
	received=parseFloat(received).toFixed(2);
	amount=parseFloat(amount).toFixed(2);
	var change = received - amount;
	$('#change').val(change.toFixed(2));
}	/* fxn */



function axnFilter(id){
	var url=gurl+"/students/bills/"+id+"/"+sy;
	window.location=url;
}





function xdelete(dbpayments,i){
	var id=$('#pkid-'+i).val();
	var tableName='Payments';

	if (confirm('xxx DANGEROUS! Sure?')){
		var vurl = gurl+'/ajax/xdata.php';	
		var task = "xdeleteData";
		var amount=$('#amount-'+i).val();
		var feetype=$('#feetype-'+i).val();		
		var studname=$('#studname').val();		
		var sydetails=(dbyr!=sy)? ` for SY${sy}`:``;
		var logdetails=`${studname} - bill payment delete of P${amount} for ${feetype}${sydetails}.`;		
		var pdata='task='+task+'&id='+id+'&dbtable='+dbpayments+'&logdetails='+logdetails+'&logsy='+sy+'&module_id=2';

		$.ajax({
			url:vurl,dataType:"json",type:"POST",
			data:pdata,async:true,
			success: function() {  location.reload(); }		  
		});									
	}
	
}	/* fxn */




</script>



<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>

