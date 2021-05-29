<h3>

	Pagination - Contacts (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
    | &multi

</h3>


<p><?php $this->shovel('hdpdiv'); ?></p>


<!-- filter -->
<form method="GET" >
<table class="gis-table-bordered " >
<tr>
	<th>Search</th><td><input name="search" value="<?php echo isset($search)? $search:NULL; ?>" >
	<th>Limit</th><td><input type="number" name="limit" class="vc80" value="<?php echo isset($limit)? $limit:NULL; ?>" >
	<td><input type="submit" name="submit" value="Go" ></td>
</tr>
</table>
</form><br />



<!-- records -->
<table class="gis-table-bordered table-altrow table-fx" >
<tr>
	<th>#</th>
	<th>SY</th>
	<th>U|P</th>
	<th>ID No.</th>
	<th>Contact</th>
	<th>T</th>
	<th>R</th>
	<th>P</th>
	<th>Sex</th>
	<th>Actv</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['sy']; ?></td>
	<td><?php echo $rows[$i]['id']; echo ($rows[$i]['id']!=$rows[$i]['parent_id'])? ' <br> '.$rows[$i]['parent_id']:NULL; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['title_id']; ?></td>
	<td><?php echo $rows[$i]['role_id']; ?></td>
	<td><?php echo $rows[$i]['privilege_id']; ?></td>
	<td><?php echo ($rows[$i]['is_male']==1)? 'M':'F'; ?></td>
	<td><?php echo ($rows[$i]['is_active']==1)? '':'NA'; ?></td>
</tr>
<?php endfor; ?>


</table>

<br />
<p><?php echo $pagenav; ?></p>



<script>
var hdpass 	= '<?php echo HDPASS; ?>';


$(function(){
	$('#hdpdiv').hide();
	hd();
	selectFocused();
	
	
})

</script>


