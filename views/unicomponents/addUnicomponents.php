<h5>
	Add Batch Components (MIS)
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'components'; ?>" >Components</a>
	| <a href="<?php echo URL.'components/filter'; ?>" >Filter</a>
	

</h5>

<p>
	Params[0] is ctype_id - 1:acad, 2:traits, 3:club, 5:conduct, default = 1; 
	<?php if(!isset($_GET['all'])): ?>
		| <a href="<?php echo URL.'components/setup?all'; ?>" >ALL</a>	
	<?php else: ?>
		| <a href="<?php echo URL.'components/setup/1'; ?>" >Acad</a>
	<?php endif; ?>
</p>

<h4>ID Lookups</h4>
<p>
<table class="gis-table-bordered" >
<tr><th>Level</th><td class="vc500" >
<select class="full" >
<?php foreach($levels AS $sel): ?>
	<option><?php echo '#'.$sel['id'].' - '.$sel['name']; ?></option>
<?php endforeach; ?>
</select>
</td></tr>
<tr><th>Subject</th><td>
<select class="full" >
<?php foreach($subjects AS $sel): ?>
	<option><?php echo '#'.$sel['id'].' - '.$sel['name']; ?></option>
<?php endforeach; ?>
</select>
</td></tr>
<tr><th>Criteria</th><td>
<select class="full" >
<?php foreach($criteria AS $sel): ?>
	<option><?php echo '#'.$sel['id'].' - '.$sel['name'].' - #'.$sel['crstype_id']; ?></option>
<?php endforeach; ?>
</select>
</td></tr>

</table>
</p>

<hr />

<h4>Batch Setup (CSV ID Strings)</h4>
<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr><th>Levels</th><td><input name="post[levels]"  /></td></tr>
<tr><th>Subjects</th><td><input name="post[subjects]"  /></td></tr>
<tr><th>Criteria</th><td><input name="post[criterias]"  /></td></tr>
<tr><th>Weights</th><td><input name="post[weights]"  /></td></tr>
</table>

<p><input type="submit" name="submit" value="Batch" /></p>

</form>



