<h3>
	Batch Update Payables 
	| <?php $this->shovel('homelinks'); ?>
	| &field

</h3>


<?php 


$fields=[
	'amount',
	'feetype_id',
];

pr($fields);

?>



<form method="POST" >
<table class="gis-table-bordered table-altrow table-fx" >
<tr><th>SY</th><td><?php echo $sy; ?><td></tr>
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
	<select name="post[feetype_id]" >
		<?php foreach($feetypes AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" >
				<?php echo $sel['name'].' - #'.$sel['id']; ?></option>
		<?php endforeach; ?>	
	</select>
</td></tr>

<tr><th><?php echo ucfirst($field); ?></th>
<td><input name="post[<?php echo $field; ?>]"  ></td></tr>

<tr><th colspan=2><input type="submit" name="submit" value="Submit" ></th></tr>


</table>
</form>
