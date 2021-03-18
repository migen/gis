<?php 

	$where = array(
		array('cond'=>'sxn.code','value'=>'TMP'),
		array('cond'=>'c.name','value'=>'TMP'),
	
	);
?>

<h5>
	TMP Sections

</h5>

<p class="f10" >

</p>


<form method="GET" >

<table class="gis-table-bordered" >
<tr class="headrow" >
	<th>Page</th>
	<th>Limit</th>
	<th>Condition</th>
</tr>
<tr>
	<td><input class="vc30" name="page" value="1" /></td>
	<td><input class="vc30" name="limit" value="100" /></td>
	<td><input class="vc300" name="condition" value="sxn.code='TMP'" /></td>
	<td><input type="submit" name="submit" value="Filter" /></td>
</tr>
</form>


<!------------------------------------------------------------------------------------->

<form method="POST" >
<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
<th></th>
<th>#</th>
<th>SCID</th>
<th>Name</th>
<th>Level</th>
<th>Section</th>
<th>Stud<br />Crid</th>
<th>Sum<br />Crid</th>
<th>StudSy</th>
<th>SumSy</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td class="screen" ><input type="checkbox" name="rows[<?php echo $i;?>]" value="<?php echo $students[$i]['scid']; ?>" /></td>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $students[$i]['scid']; ?></td>
	<td><?php echo $students[$i]['student']; ?></td>
	<td><?php echo $students[$i]['level']; ?></td>
	<td><?php echo $students[$i]['section']; ?></td>
	<td><?php echo $students[$i]['studcrid']; ?></td>
	<td><?php echo $students[$i]['sumcrid']; ?></td>
	<td><?php echo $students[$i]['studsy']; ?></td>
	<td><?php echo $students[$i]['sumsy']; ?></td>
	</tr>
<?php endfor; ?>
</table>

<p class="screen" >
	<input onclick="return confirm('You sure?');" type='submit' name='batch' value='Re-Section' >
</p>


</form>