<h5>
	All Contacts (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'purge'; ?>">Purge</a>	
	
</h5>

<table class="gis-table-bordered" >
<tr>
	<th>url/currPage</th>
	<th>Total Count</th><td><?php echo $totalCount; ?></td>
	<th>Records</th><td><?php echo $record_start.' to '.$record_end; ?></td>
	<th>Page</th><td><?php echo $currPage.' of '.$totalPages; ?></td>
</tr>
</table><br />


<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>ucid</th>
	<th>Code</th>
	<th>Name</th>
	<th>R</th>
	<th>crid</th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php $id=$rows[$i]['id']; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['role_id']; ?></td>
	<td><?php echo $rows[$i]['crid']; ?></td>
	<td><a onclick="return confirm('Sure?');" href="<?php echo URL.'purge/one/'.$id; ?>" >Purge</a></td>
</tr>
<?php endfor; ?>
</table>





<script>
var gurl = 'http://<?php echo GURL; ?>';
var limits='20';


$(function(){

	
})





</script>



