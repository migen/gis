<?php 

?>

<div style="width:38%;float:left" >
<p><table class="gis-table-bordered table-fx" >

	<tr>
		<th>OR No | CCID</th>
		<td>
			<input class='pdl05 vc100' name='pos[orno]' value="<?php echo $pos['orno']; ?>" />
			<input id="custpcid" class="vc50 pdl05" name="pos[ccid]" value="<?php echo $pos['ccid']; ?>" readonly />
		</td>
	</tr>	
	<tr>
		<th>Ecid | Trml</th>
		<td>
			<input class="center vc50" value="<?php echo $pos['ecid']; ?>" />
			<input class='pdl05 vc50' name='pos[terminal]' value="<?php echo $pos['terminal']; ?>" type="number" /></td>
	</tr>	
	<tr>
		<th>Time</th>
		<td><input class="pdl05" name="pos[datetime]" value="<?php echo $pos['datetime']; ?>" /></td>
	</tr>
	<tr>
		<th>Customer</th>
		<td>
			<input style="padding-left:5px;width:100px;" id="part" name="pos[guest]" accesskey="c" 
				value="<?php echo isset($pos['guest'])? $pos['guest']:NULL; ?>" />		
			<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart(limits);return false;" />		
		</td>
	</tr>	
	
</table>
</p>

	  <a class="u txt-blue" onclick="refresh();return false;" >Tally</a>
	| <a id="addrow" class="u txt-blue" onclick="newrow();return false;" >Add Row</a>
	| <a class="u txt-blue" onclick="jsredirect('opos');return false;" >Cancel</a>	

</div>


<div style="width:28%;float:left" >
<p><table class="gis-table-bordered table-fx" >
	<tr>
		<th>Discount</th>
		<td><input class="pdl05 vc120" id="discount" name="pos[discount]" value="<?php echo $pos['discount']; ?>" /></td>
	</tr>		
	<tr>
		<th>Total</th>
		<td><input class="pdl05 vc120" id="total" name="pos[total]" value="<?php echo $pos['total']; ?>" /></td>
	</tr>		
	<tr>
		<th>Tender Cash</th>		
		<td><input class="pdl05 vc120" id="tender" name="pos[tendercs]" 
			onchange="getChange();return false;" value="<?php echo $pos['tendercs']; ?>" /></td>
	</tr>		
	<tr>
		<th>
			  <span onclick="getChange();return false;" class="tf16 b u" >Change</span>
			| <span onclick="clearChange();return false;" class="tf16 b u" >Clear</span>		
		</th>		
		<td><input class="pdl05 vc120" id="change" value="0.00" name="pos[change]" /></td>
	</tr>				
	<input type='hidden' name='pos[ecid]' value="<?php echo $_SESSION['user']['pcid']; ?>" />	
	<input type='hidden' name='pos[id]' value="<?php echo $pos['id']; ?>" />	
	
</table>
</p>

</div>


<div class="more" style="width:30%;float:left" >
<p><table class="gis-table-bordered table-fx" >
	<tr><th>Sales</th>
	<td>
		<input type="radio" name="pos[is_credit]" value="0" checked 
			<?php echo ($pos['is_credit']!=1)? 'checked':NULL; ?> />Cash
		<input type="radio" name="pos[is_credit]" value="1" onclick="alert('Must assign customer.');"
			<?php echo ($pos['is_credit']==1)? 'checked':NULL; ?> />Credit
	</td>
	</tr>

	<tr><th>Payment</th><td>
	<select class="vc150" id="paytype" name="pos[paytype_id]" >
		<?php foreach($paytypes AS $sel): ?>
			<option value="<?php echo $sel['id']?>" <?php echo ($sel['id']==1)? 'selected':NULL; ?> >
				<?php echo $sel['name'].' #'.$sel['id']; ?></option>
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
		<th>Tender Etc</th>
		<td><input class="pdl05" name="pos[tenderetc]" value="0" /></td>
	</tr>	
	<tr>
		<th>Etc No.</th>
		<td><input class="pdl05" name="pos[etcno]" value="" /></td>
	</tr>	
	
	<tr>
		<th>Remarks</th>
		<td><input class="pdl05" name="pos[remarks]" value="" /></td>
	</tr>		
	
</table>
</p>


</div>