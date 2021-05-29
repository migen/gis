<h3>
	Batch Update Payables 
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'syncPayables/batchUpdate'; ?>">Add/Destroy</a> 


</h3>


<?php 


$fields=[
	'amount',
	'feetype_id',
	'ptr',
];


?>



<form method="POST" >
<table class="gis-table-bordered table-altrow table-fx" >
<tr>
<th colspan=2>SELECT</th>
</tr>
<tr><th>SY</th><td><?php echo $sy; ?></td></tr>
<tr><th>Level</th><td>
	<select name="post[level_id]" >
		<option value=0>Select One</option>
		<?php foreach($levels AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" >
				<?php echo $sel['name'].' - #'.$sel['id']; ?></option>
		<?php endforeach; ?>	
	</select>
</td></tr>

<tr><th>Feetype</th><td>
	<select onchange="updateField('feetype_id',this.value)" >
		<option value=0 >Select One</option>
		<?php foreach($feetypes AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" >
				<?php echo $sel['name'].' - #'.$sel['id']; ?></option>
		<?php endforeach; ?>	
	</select>
	<input name="post[feetype_id]" id="feetype_id" class="vc50" value="0" >
</td></tr>

<tr>
<th colspan=2>Replace with</th>
</tr>
<tr>
	<th><select name="post[field]" >
		<option>Select one</option>
		<?php foreach($fields AS $sel): ?>
			<option value="<?php echo $sel; ?>" ><?php echo $sel; ?></option>
		<?php endforeach; ?>
	</select></th>
	<td><input name="post[value]" ></td>
</tr>


<tr>
	<th>Optional<br>
		<select name="post[field2]" >
		<option value='' >Select one</option>
		<?php foreach($fields AS $sel): ?>
			<option value="<?php echo $sel; ?>" ><?php echo $sel; ?></option>
		<?php endforeach; ?>
	</select></th>
	<td><br><input name="post[value2]" ></td>
</tr>

<tr><th colspan=2>
	<input onclick="return confirm('Dangerous! Sure?');" type="submit" name="submit" value="Replace" >
	<input type="submit" name="view" value="View" >
</th></tr>


</table>
</form>


<script>


$(function(){
	selectFocused();
	
})

function updateField(field,value){
	$('#'+field).val(value);
	
	
}	/* fxn */



</script>



