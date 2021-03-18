<?php 

	$where = array(
		array('cond'=>'sxn.code','value'=>'TMP'),
		array('cond'=>'c.name','value'=>'TMP'),
	
	);
?>

<h5>
	<span ondblclick="tracehd();" >All Students</span>
	

</h5>


<?php if(isset($_GET['debug'])): ?>
<div class="f12" >
	<table class="gis-table-bordered " >
		<tr><td>1=1</td></tr>
		<tr><td>sxn.code='TMP'</td></tr>
		<tr><td>c.name LIKE '%MICHAEL%'</td></tr>
	</table>
</div>
<?php pr($q); ?>
<?php endif; ?>

<form method="GET" >

<table class="gis-table-bordered" >
<tr class="headrow" >
	<th>Page</th>
	<th>Limit</th>
	<th>Condition</th>
</tr>
<tr>
	<td><input type="number" class="center vc50" name="page" value="<?php echo $page; ?>" /></td>
	<td><input class="center vc50" name="limit" value="<?php echo $limit; ?>" /></td>
	<td><input class="pdl05 vc300" name="condition" value="<?php echo $cond; ?>" /></td>
	<td><input type="submit" name="submit" value="Filter" /></td>
</tr>
</form>


<!------------------------------------------------------------------------------------->

<form method="POST" >
<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
<th></th>
<th>#</th>
<th>Actv</th>
<th>CYear</th>
<th>Clrd</th>
<th>SCID</th>
<th>Code</th>
<th>Name</th>
<th>Level</th>
<th>Section</th>
<th>Stud<br />Crid</th>
<th>Sum<br />Crid</th>
<th>ConSy</th>
<th></th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td class="screen" ><input type="checkbox" name="rows[<?php echo $i;?>]" value="<?php echo $students[$i]['scid']; ?>" /></td>
	<td><?php echo $i+1; ?></td>
	<td><?php echo ($students[$i]['is_active']==1)?'Y':'-'; ?></td>
	<td><?php echo $students[$i]['cyear']; ?></td>	
	<td><?php echo ($students[$i]['is_cleared']==1)?'Y':'-'; ?></td>
	<td><?php echo $students[$i]['scid']; ?></td>
	<td><?php echo $students[$i]['code']; ?></td>
	<td><?php echo $students[$i]['student']; ?></td>
	<td><?php echo $students[$i]['level']; ?></td>
	<td><?php echo $students[$i]['section']; ?></td>
	<td><?php echo $students[$i]['studcrid']; ?></td>
	<td><?php echo $students[$i]['sumcrid']; ?></td>
	<td><?php echo $students[$i]['consy']; ?></td>
	<td>
		<a href="<?php echo URL.'students/sectioner/'.$students[$i]['scid']; ?>" >Sxn</a>
		| <a href="<?php echo URL.'contacts/statuses/'.$students[$i]['scid']; ?>" >Status</a>	
		<?php if($_SESSION['srid']==RMIS): ?>
			| <a onclick="return confirm('Dangerous! Cannot Undo! Proceed?');" href="<?php echo URL.'mis/purge/'.$students[$i]['scid']; ?>" >DEL</a>	
		<?php endif; ?>
	</td>
	</tr>
<?php endfor; ?>
</table>

<p class="screen" >
	<input onclick="return confirm('You sure?');" type='submit' name='batch' value='Re-Section' >
</p>


</form>

<!------------------------------------------------------------------------------------->

<script>

var gurl = 'http://<?php echo GURL; ?>';
var hdpass = '<?php echo HDPASS; ?>';

$(function(){
	hd();
	// tracehd();
	$('#hdpdiv').hide();

})


</script>
