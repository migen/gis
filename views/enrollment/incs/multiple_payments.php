<table class="tblmultipay gis-table-bordered table-fx" >
<tr>
<td>
	<input type="hidden" class="pdl05 vc50" name="mpay[ecid]" value="<?php echo $ecid; ?>" readonly />
	<input type="hidden" class="pdl05 vc50" name="mpay[scid]" value="<?php echo $scid; ?>" readonly />
	<input class="pdl05 vc150" name="mpay[date]" value="<?php echo $today; ?>" type="date" />
	OR <input class="vc80 pdl05" id="mpayorno" name="mpay[orno]" value="<?php echo ($last_orno+1); ?>" >
</td>
<td>Payer <input class="pdl05 vc150" name="mpay[payer]" value="" /></td>

</tr>

<!------->
<tr>
<td>
<select name="mpay[paytype_id]" >	
<?php foreach($paytypes AS $sel): ?>
	<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==1)? 'selected':NULL; ?> ><?php echo $sel['name']; ?></option>
<?php endforeach; ?>
</select>
<select name="mpay[bank_id]" >	
<option value="0" >Bank</option>
<?php foreach($banks AS $sel): ?>
	<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
<?php endforeach; ?>
</select>
</td>
<td>Dtls <input class="vc100 pdl05" name="mpay[details]" value="" >
<input type="submit" onclick="hasDuplicateOrno($('#mpayorno').val());return false;" value="Check OR" />
<input type="submit" name="multipay" value="Multipay" onclick="return confirm('Sure?');" />
</td>
</tr>


</table>




<script>

function hasDuplicateOrno(orno){
	var vurl 	= gurl + '/ajax/xorno.php';	
	var task	= "hasDuplicateOrno";	
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'task='+task+'&orno='+orno,						
		success: function(s) { 			
			if(s.id){ alert('Payment id: '+s.id+' - OR No Used.'); 
			} else { alert('Available'); } 			
		}		  
	});				


}	/* fxn */

</script>