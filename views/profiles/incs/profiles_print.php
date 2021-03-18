
<?php for($i=0;$i<$num_profiles;$i++): ?>

<tr rel="<?php echo $profiles[$i]['scid']; ?>" class="<?php echo (even($i))? 'even':'odd'?>" >
	<td><?php echo $i+1; ?></td>	
	<td><?php echo $profiles[$i]['pcid']; ?></td>	
	<td><?php echo $profiles[$i]['student_code']; ?></td>	
	<td><?php echo $profiles[$i]['birthdate']; ?></td>	
	
	<td class="vc200" ><?php echo $profiles[$i]['fullname']; ?></td>
	<td><?php echo $profiles[$i]['lrn']; ?></td>
	<td class="vc100" ><?php echo date("M d, Y",strtotime($profiles[$i]['birthdate'])); ?></td>
	<td class="vc300" ><?php echo $profiles[$i]['address']; ?></td>
	<td><?php echo ($profiles[$i]['is_male']==1)? 'M':'F'; ?></td>
	<td><?php echo $profiles[$i]['remarks']; ?></td>
			
</tr>

<?php endfor; ?>
</table>



<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>

<script>
var gurl="http://<?php echo GURL; ?>";
$(function(){
	excel();

})

</script>

