<?php 



?>


<h5>
	Column Highlighting (<?php echo $count; ?>)

</h5>


<table class="gis-table-bordered table-altrow table-fx" >
<tr>
<th>#</th>
<th>Code</th>
<th>Name</th>
<th>Sex</th>
<th>Actv</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td class="colshading" ><?php echo $i+1; ?></td>
	<td class="colshading" ><?php echo $rows[$i]['code']; ?></td>
	<td class="colshading" ><?php echo $rows[$i]['name']; ?></td>
	<td class="colshading" ><?php echo ($rows[$i]['is_male']==1)? 'M':'F'; ?></td>
	<td class="colshading" ><?php echo ($rows[$i]['is_active']==1)? 'Y':'-'; ?></td>
</tr>
<?php endfor; ?>
</table>

<div class="ht50" ></div>

<script>


$(function(){

	columnHighlighting();

})

</script>

