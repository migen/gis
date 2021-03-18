<h5>
	Batch Delete Fees Query
	
	
</h5>

<h4>Put 0 for all</h4>

<form method="GET" >
<table class="gis-table-bordered table-fx" >
<tr><th>Level</th><td><input name="lvl" class="vc50" value="0" /></td></tr>
<tr><th>Crid</th><td><input name="crid" class="vc50" value="0" /></td></tr>
<tr><th>Fees</th><td><input name="feetype_id" class="vc50" value="0" /></td></tr>
<tr><th>Num</th><td><input name="num" class="vc50" value="1" /></td></tr>


</table>
<p>
<input type="submit" name="submit" value="Delete Query"  />
</p>


</form>


<div class="third" >
<table class="gis-table-bordered table-altrow" >
<tr><th>Fee</th><th>FTID</th></tr>
<?php foreach($feetypes AS $sel): ?>
<tr><td><?php echo $sel['name']; ?></td>
<td><?php echo $sel['id']; ?></td>
</tr>
<?php endforeach; ?>
</table>
</div>

<div class="third" >
<table class="gis-table-bordered table-altrow" >
<tr><th>Classroom</th><th>CRID</th></tr>
<?php foreach($classrooms AS $sel): ?>
<tr><td><?php echo $sel['name']; ?></td>
<td><?php echo $sel['id']; ?></td>
</tr>
<?php endforeach; ?>
</table>
</div>
