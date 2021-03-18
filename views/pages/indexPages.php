<h5>
	Pages | <?php $this->shovel('homelinks'); ?>
	| Page <?php echo $currPage; ?>
	| Total <?php echo $totalCount; ?>
	
</h5>


<?php


?>

<?php 
echo "Found: ".number_format($totalCount,0)." results.";
pr($pagenav);

?>


<form method="GET" >
<table class="gis-table-bordered table-altrow" >
<tr>
	<th>Name </th>
	<td><input name="name" autofocus value="<?php echo isset($_GET['name'])? $_GET['name']:NULL; ?>" ></td>
</tr>
<tr>
	<th>Sex </th>
	<td><select name="sex" >
		<option value="2" <?php echo ($sex==2)? "selected":NULL; ?> >All</option>
		<option value="1" <?php echo ($sex==1)? "selected":NULL; ?> >Boys</option>
		<option value="0" <?php echo ($sex==0)? "selected":NULL; ?> >Girls</option>
	</select></td>
</tr>
<tr>
	<th>Records Per Page </th>
	<td><input name="perPage" value="<?php echo isset($_GET['perPage'])? $_GET['perPage']:10; ?>" ></td>
</tr>
<tr><td colspan=2 ><input type="submit" name="submit" value="Search" /></td></tr>
</table>
</form>


<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Name</th>
	<th>Sex</th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo ($rows[$i]['is_male']==1)? "M":"F"; ?></td>
	<td><a href="<?php echo URL.'contacts/view/'.$rows[$i]['id']; ?>" >View</a></td>
</tr>
<?php endfor; ?>
</table>


<?php 

pr($pagenav);

?>

