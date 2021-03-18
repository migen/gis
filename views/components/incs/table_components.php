<form method='post' > <!-- for batch edit/delete -->

<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th><input type="checkbox" id="chkAlla" /></th>
	<th>Com#</th>
	<th>Level</th>
	<th>Subject</th>
	<th>Criteria</th>
	<th>Weight</th>
	<th>Sem</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td class="screen" ><input class="chka" type="checkbox" name="rows[<?php echo $rows[$i]['component_id'];?>]" 
		value="<?php echo $rows[$i]['component_id']; ?>" /></td>
	<td><?php echo $rows[$i]['component_id']; ?></td>
	<td><?php echo $rows[$i]['level_id']; ?></td>
	<td><?php echo $rows[$i]['subject'].' #'.$rows[$i]['subject_id']; ?></td>
	<td><?php echo $rows[$i]['criteria'].' #'.$rows[$i]['criteria_id']; ?></td>
	<td class="right" ><?php echo $rows[$i]['weight']; ?></td>
	<td class="right" ><?php echo $rows[$i]['semester']; ?></td>	
</tr>
<?php endfor; ?>
</table>

<p class="screen" >
	<input type='submit' name='batch' value='Edit' >
</p>

</form> <!-- for batch -->



<script>
var gurl = 'http://<?php echo GURL; ?>';
			
$(function(){
	chkAllvar('a');
})




</script>

