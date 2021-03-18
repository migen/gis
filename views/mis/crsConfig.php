<h5>
	MIS Courses Config
	| <?php $this->shovel('homelinks'); ?>
	
</h5>

<p>*Updates 1) courses </p>

<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr>
<th>Lookup</th>
<td>
	<select>
		<?php foreach($levels AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name'].' - #'.$sel['id']; ?></option>
		<?php endforeach; ?>
	</select>
</td>
</tr>
<tr><th>Subject</th><td>
<select class="full" >
<?php foreach($subjects AS $sel): ?>
	<option><?php echo '#'.$sel['id'].' - '.$sel['name']; ?></option>
<?php endforeach; ?>
</select>
</td></tr>
<tr><th colspan=2>---</th></tr>
<tr><th>Levels Array (CSV)</th><td><input name="levels" ></td></tr>
<tr><th>Subject ID</th><td><input name="sub" ></td></tr>
<tr><th>Field</th><td><input name="field" ></td></tr>
<tr><th>Value</th><td><input name="value" ></td></tr>

<tr><th colspan=2 ><input type="submit" name="submit" value="Submit" /></th></tr>

</table>
</form>
