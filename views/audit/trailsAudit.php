<h3>

	Audit Trails (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>

</h3>


<p><?php $this->shovel('hdpdiv'); ?></p>


<!-- filter -->
<form method="GET" >
<table class="gis-table-bordered " >
<tr>
	<th>Search</th><td><input name="search" value="<?php echo isset($search)? $search:NULL; ?>" >
	<th>Start</th><td><input type="date" name="start" value="<?php echo isset($start)? $start:NULL; ?>" >
	<th>End</th><td><input type="date" name="end" value="<?php echo isset($end)? $end:NULL; ?>" >
	<th>Limit</th><td><input type="number" name="limit" class="vc80" value="<?php echo isset($limit)? $limit:NULL; ?>" >
	<td><input type="submit" name="submit" value="Go" ></td>
</tr>
</table>
</form><br />



<!-- records -->
<table class="gis-table-bordered table-altrow table-fx" >
<tr>
	<th>#</th>
	<th class="hd" >ID</th>
	<th>SY</th>
	<th>Module</th>
	<th>User</th>
	<th>Datetime</th>
	<th>Details</th>
	<th>IP</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="hd" ><?php echo $rows[$i]['pkid']; ?></td>
	<td><?php echo $rows[$i]['sy']; ?></td>
	<td><?php echo $rows[$i]['module']; ?></td>
	<td>
		<span class="hd" ><?php echo '#'.$rows[$i]['ucid'].' - '; ?></span>
		<?php echo $rows[$i]['contact']; ?>	
	</td>
	<td><?php echo $rows[$i]['datetime']; ?></td>
	<td><?php echo $rows[$i]['details']; ?></td>
	<td><?php echo $rows[$i]['ip']; ?></td>
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


