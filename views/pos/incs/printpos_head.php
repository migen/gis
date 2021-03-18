<div style="width:36%;float:left" >
<p><table class="gis-table-bordered table-fx" >

	<tr>
		<th>OR No | CCID</th>
		<td>
			<input class='pdl05 vc100' name='pos[orno]' value="<?php echo 111; ?>" />
			<input id="custpcid" class="vc50 pdl05" name="pos[ccid]" value="0" readonly />					
		</td>
	</tr>	
	<tr>
		<th>Ecid | Trml</th>
		<td>
			<input class="center vc50" value="<?php echo $_SESSION['ucid']; ?>" readonly />
			<input class='pdl05 vc50' name='pos[terminal]' value="<?php echo $terminal; ?>" type="number" readonly /></td>
	</tr>	
	<tr>
		<th>Time</th>
		<td><input class="pdl05" name="pos[datetime]" value="<?php echo date('Y-m-d H:i:s'); ?>" /></td>
	</tr>
	<tr>
		<th>Customer</th>
		<td>
			<input style="padding-left:5px;width:100px;" id="part" name="pos[guest]" accesskey="c" />		
			<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart(limits);return false;" />		
		</td>
	</tr>	
	
</table>
</p>

	  <a class="u txt-blue" onclick="refresh();return false;" >Tally</a>
	| <a class="u txt-blue" onclick="jsredirect('opos');return false;" >Cancel</a>	

</div>


<div style="width:32%;float:left" >
<p><table class="gis-table-bordered table-fx" >
	<tr>
		<th>Discount</th>
		<td><input class="pdl05 vc120" id="discount" name="pos[discount]" value="0.00" readonly /></td>
	</tr>		
	<tr>
		<th>Total</th>
		<td><input class="pdl05 vc120" id="total" name="pos[total]" value="0.00" readonly /></td>
	</tr>		
	<tr>
		<th>Tender Cash</th>		
		<td><input class="pdl05 vc120" id="tender" name="pos[tendercs]" 
			onchange="getChange();return false;" value="0.00" /></td>
	</tr>		
	<tr>
		<th>
			  <span onclick="getChange();return false;" class="tf16 b u" >Change</span>
			| <span onclick="clearChange();return false;" class="tf16 b u" >Clear</span>		
		</th>		
		<td><input class="pdl05 vc120" id="change" value="0.00" name="pos[change]" readonly /></td>
	</tr>				
	<input type='hidden' name='pos[ecid]' value="<?php echo $_SESSION['user']['pcid']; ?>" />	
</table>
</p>

</div>


<div class="more" style="width:32%;float:left" >
<p><table class="gis-table-bordered table-fx" >
	<tr class="creditsales" ><th>Sales</th>
	<td>
		<input type="radio" name="pos[is_credit]" value="0" checked />Cash
		<input type="radio" name="pos[is_credit]" value="1" onclick="alert('Must assign customer.');" />Credit
	</td>
	</tr>

	<tr><th>Payment</th><td>
	<select class="vc150" id="paytype" name="pos[paytype_id]" >
		
		<?php foreach($paytypes AS $sel): ?>
			<?php if($sel['id']<3): ?>
			<option value="<?php echo $sel['id']?>" <?php echo ($sel['id']==1)? 'selected':NULL; ?> >
				<?php echo $sel['name'].' #'.$sel['id']; ?></option>
			<?php endif; ?>
		<?php endforeach; ?>
	</select>
	</td></tr>
	<tr class="" ><th>Bank</th><td>
	<select id="bank" onchange="changePaytype(2);return false;" class="vc150" name="pos[bank_id]" >
		<option value="0" >Choose</option>
		<?php foreach($banks AS $sel): ?>
			<option value="<?php echo $sel['id']?>"  ><?php echo $sel['name'].' #'.$sel['id']; ?></option>
		<?php endforeach; ?>
	</select>
	</td></tr>	
	
	<tr>
		<th class="u" onclick="getTenderetc();" >Tender Bank</th>
		<td><input id="tenderetc" onchange="lessTendercs();" class="pdl05" name="pos[tenderetc]" value="0" /></td>
	</tr>	
	<tr>
		<th>Reference No.</th>
		<td><input class="pdl05" name="pos[etcno]" value="" /></td>
	</tr>	
	
	
</table>
</p>


</div>


<script>


function lessTendercs(){

	var total=$('#total').val();	
	var tc=$('#tender').val();
	var te=$('#tenderetc').val();
	
	var total = total.replace(/\,/g,'');		
	var tc = tc.replace(/\,/g,'');		
	var te = te.replace(/\,/g,'');		
	
	var x = parseFloat(total)-parseFloat(te);
	$('#tender').val(x);
	
}	/* fxn */

function getTenderetc(){
	var total=$('#total').val();	
	var total = total.replace(/\,/g,'');			
	$('#tenderetc').val(total);
	$('#tender').val(0);

}	/* fxn */


</script>