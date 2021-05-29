<h5>
	Batch Add Payables | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'payables/batch'; ?>">Clear</a> 
	| <a href="<?php echo URL.'syncPayables/batchUpdate'; ?>">Update/Replace</a> 
	
</h5>




<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr><th>Level</th><td>
<select id="level" name="fee[lvl]" class="vc300" >
	<option value="0" >Choose</option>
	<?php foreach($levels AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" 
			<?php echo (isset($get['level']) && ($get['level']==$sel['id']))? 'selected':NULL; ?>		
		><?php echo $sel['name'].' #'.$sel['id']; ?></option>
	<?php endforeach; ?>
</select>
</td>
</tr>

<tr><th>Classroom</th><td>
<select id="classroom" name="fee[crid]" class="vc300" >
	<option value="0" >Choose</option>
	<?php foreach($classrooms AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" 
			<?php echo (isset($get['classroom']) && ($get['classroom']==$sel['id']))? 'selected':NULL; ?>
		><?php echo $sel['name'].' #'.$sel['id']; ?></option>
	<?php endforeach; ?>
</select>
</td>
</tr>

<tr><th>Feetype</th><td>
	<select onchange="updateField('feetype_id',this.value)" >
		<option value=0 >Select One</option>
		<?php foreach($feetypes AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" >
				<?php echo $sel['name'].' - #'.$sel['id']; ?></option>
		<?php endforeach; ?>	
	</select>
	<input onchange="xgetFeeAmount(this.value);" name="fee[feetype_id]" id="feetype_id" class="vc50" value="0" >
</td></tr>



<tr><th>SY</th>
<td>
	<input class="pdl05 vc100" id="sy" name="fee[sy]" value="<?php echo $sy; ?>" />
</td>
</tr>

<tr><th>Amount | Ptr (1) </th>
<td>
	<input class="pdl05 vc100" id="amount" name="fee[amount]" value="0.00" />
	<input class="vc20" id="num" name="fee[ptr]" value="1" />
</td>
</tr>

<tr><th>In Tuition </th>
<td>
	<input class="vc50" type="number" min=0 max=1 id="in_tuition" name="fee[in_tuition]" value="1" />
</td>
</tr>


<tr><th>Due</th>
<td><input class="pdl05 vc150" id="due" name="fee[due_on]" value="<?php echo $today; ?>" /></td>


</tr>

</table>


<p>
Notes<br />
Priority - Classroom over Level <br />

</p>

<p>
	<input type="submit" name="submit" value="Submit" onclick="return confirm('Sure?');"  />
	<input type="submit" name="delete" value="Destroy" onclick="return confirm('Dangerous! Sure?');"  />
</p>

</form>



<script>
var gurl="http://<?php echo GURL; ?>";
var today="<?php echo $today; ?>";


$(function(){
	chkAllvar('a');
	tickWithDue();
	selectFocused();
	
})	/* fxn */


function xgetFeeAmount(feeid){
	var vurl 	= gurl + '/ajax/xaccounts.php';	
	var task	= "xgetFeeAmount";		
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'task='+task+'&feeid='+feeid,						
		success: function(s) { 
			$('#amount').val(s.amount); 
		}		  
	});				

}	/* fxn */



function tickWithDue(){
	$('#withdue').click(function(event) {
		if(this.checked) {
			$('#due').val(today);				
		} else {
			$('#due').val(null);				
		}
	});
	
}	/* fxn */


function updateField(field,value){
	$('#'+field).val(value);
	
	
}	/* fxn */


</script>

