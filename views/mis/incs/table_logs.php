<?php 
	// pr($rows[1]); 
	
?>


<script>
	$(function(){
		excel();
	})



</script>



<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>




<table id="tblExport" class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>ID</th>
	<th>Datetime</th>
	<th>User</th>
	<th>IP</th>
	<th>Module</th>
	<th>Action</th>
	<th>Qtr</th>
	<th>ECID</th>
	<th>SCID</th>
	<th>CRS</th>
	<th>CRID</th>	
	<th>Fee</th>	
	<th>Amount</th>	
	<th>Orno</th>	
	<th class="vc300" >Details</th>	
	<th class="" >View</th>	
<tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['datetime']; ?></td>
	<td><?php echo $rows[$i]['user']; ?></td>
	<td><?php echo $rows[$i]['ip']; ?></td>
	<td><?php echo $rows[$i]['module']; ?></td>
	<td><?php echo $rows[$i]['action']; ?></td>
	<td><?php echo $rows[$i]['qtr']; ?></td>
	<td><?php echo $rows[$i]['ecid']; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['crsid']; ?></td>
	<td><?php echo $rows[$i]['crid']; ?></td>
	<td><?php echo $rows[$i]['feeid']; ?></td>
	<td class="right" ><?php echo $rows[$i]['amount']; ?></td>
	<td><?php echo $rows[$i]['orno']; ?></td>
	<td class="" ><?php echo $rows[$i]['details']; ?></td>	
	<td><a href="<?php echo URL.'logs/logdetails/'.$rows[$i]['id']; ?>" >View</a></td>
</tr>
<?php endfor; ?>
</table>



<script>
	$(function(){
		hd();
	})
</script>