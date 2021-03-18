<h5>Students</h5>
<table class="gis-table-bordered table-altrow table-fx" >
<tr>
	<th><input type="checkbox" id="chkAlla" /></th>
	<th>#</th>
	<th>Scid</th>
	<th>Classroom</th>
	<th>ID No.</th>
	<th>Student</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<?php $scid=$students[$i]['scid']; ?>
<tr>
	<td><input class="chka" type="checkbox" name="students[<?php $i; ?>]" value="<?php echo $scid; ?>"  /></td>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $students[$i]['scid']; ?></td>
	<td><?php echo $students[$i]['classroom']; ?></td>
	<td><?php echo $students[$i]['code']; ?></td>
	<td><?php echo $students[$i]['student']; ?></td>
</tr>
<?php endfor; ?>
</table>



