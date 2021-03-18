<h5>
	Setup Courses
	
	
</h5>


<form method="POST" >

<table class="gis-table-bordered table-fx table-altrow"  >
<tr class="headrow" >
	<th>&nbsp;</th>
	<th>Sub#</th>
	<th>Subject</th>
	<th>Label</th>
	<th>Position</th>
	<th>Aggre</th>
	<th>Weight</th>
	<th>Indent</th>
	<th>Sem</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr id="trow<?php echo $i; ?>"  >
	<td class="screen" ><input type="checkbox" name="rows[<?php echo $i;?>]" value="<?php echo $subjects[$i]['id']; ?>" /></td>
	<td><?php echo $subjects[$i]['id']; ?></td>
	<td><?php echo $subjects[$i]['name']; ?></td>
	<td><input class="vc100" name="crs[<?php echo $i; ?>][label]" value="<?php echo $subjects[$i]['name']; ?>"  /></td>
	<td><input class="vc30" name="crs[<?php echo $i; ?>][position]" value="<?php echo $subjects[$i]['position']; ?>"  /></td>
	<td><input class="vc30" name="crs[<?php echo $i; ?>][is_aggregate]" value="<?php echo '0'; ?>"  /></td>
	<td><input class="vc30" name="crs[<?php echo $i; ?>][course_weight]" value="<?php echo '0'; ?>"  /></td>
	<td><input class="vc30" name="crs[<?php echo $i; ?>][indent]" value="<?php echo '0'; ?>"  /></td>
	<td><input class="vc30" name="crs[<?php echo $i; ?>][sem]" value="<?php echo '0'; ?>"  /></td>
	<td class="u" onclick="deltrow(<?php echo $i; ?>);" > Delete </td>
	
</tr>
<?php endfor; ?>
</table>



<p class="screen" >
	<input onclick="return confirm('DANGEROUS! CANNOT UNDO!');" type='submit' name='submit' value='Submit' >
</p>



</form>



<!-------------------------------------------------------------------------------------->

<script>

var gurl = 'http://<?php echo GURL; ?>';
var home = '<?php echo 'mis'; ?>';

$(function(){
	hd();

})


function deltrow(i){
	$('#trow'+i).remove();
}	




</script>


