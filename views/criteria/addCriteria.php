<h5>
	Add Criteria
	| <?php $this->shovel('homelinks'); ?>
	
</h5>

<div class="half" >
<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr><th>Crstype</th><td><input class="vc50" name="post[crstype_id]" /></td></tr>
<tr><th>Position</th><td><input class="vc50" name="post[position]" /></td></tr>
<tr><th>Code</th><td><input class="vc100" name="post[code]" /></td></tr>
<tr><th>Name</th><td><input class="vc200" name="post[name]" /></td></tr>
<tr><th>(0) P (1) R (2) T</th><td><input class="vc50" name="post[is_raw]" /></td></tr>
</table>
<p><input type="submit" name="submit" value="Submit" onclick="return confirm('Sure?');" /></p>

</form>

</div>


<div class="fourth" >
<table class="gis-table-bordered table-altrow" >
<tr><th>ID</th><th>Crstype</th></tr>
<?php foreach($crstypes AS $sel): ?>
<tr>
	<td><?php echo $sel['id']; ?></td>
	<td><?php echo $sel['name']; ?></td>
</tr>
<?php endforeach; ?>
</table>
</div>