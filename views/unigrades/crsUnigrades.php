<?php 

// pr($course);

$decicard=$_SESSION['college']['decicard'];
if(!empty($rows)){ debug($rows[0]); }


?>

<h5>
	Grades | <?php $this->shovel('homelinks','College'); ?>
	| <span class="u" onclick="traceshd();" >ID</span>
	| <a href="<?php echo URL.'uniscores/crs/'.$crs; ?>" >Scores</a>
	
	
</h5>



<?php require_once(SITE.'views/college/incs/courseDetails.php'); ?>
<br />


<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th class="shd" >Scid</th>
	<th class="vc200" >Student</th>	
	<?php if(!$is_numeric): ?><th>Num</th><?php endif; ?>
	<th class="center" >FG</th>
</tr>
<?php if($is_numeric): ?>
	<?php for($i=0;$i<$count;$i++): ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td class="shd" ><?php echo $rows[$i]['scid']; ?></td>
		<td><?php echo $rows[$i]['student']; ?></td>
		<td class="center" ><?php $fg=number_format($rows[$i]['grade'],$decicard); echo $fg; ?></td>
	</tr>
	<?php endfor; ?>
<?php else: ?>
	<?php for($i=0;$i<$count;$i++): ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td class="shd" ><?php echo $rows[$i]['scid']; ?></td>
		<td><?php echo $rows[$i]['student']; ?></td>
		<td class="center" ><?php $grade=number_format($rows[$i]['grade'],$decicard); echo $grade; ?></td>
		<td class="center" ><?php $fg=$rows[$i]['dg']; echo $fg; ?></td>
	</tr>
	<?php endfor; ?>
<?php endif; ?>

</table>


<script>

$(function(){
	shd();
	
})

</script>