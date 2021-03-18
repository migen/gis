<h5>
	SJAM SIR <?php echo ucfirst($type); ?>
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'sjam/gradhonors/'.$lvl; ?>" >Honors</a>
	
	<?php if($type=='acad'): ?>
		| <a href="<?php echo URL.'sjam/sirGrad/'.$lvl.'?type=cond'; ?>" >Cond</a>
	<?php else: ?>
		| <a href="<?php echo URL.'sjam/sirGrad/'.$lvl.'?type=acad'; ?>" >Acad</a>	
	<?php endif; ?>
	
</h5>

<?php 
	
	
	
	
?>

<?php $updated=true; ?>
<form method="POST" >
<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>Scid</th>
	<th>Student</th>
	<th>Total</th>
	<th>Rank<br />(DB)</th>
	<th>Rank<br /></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php $scid=$rows[$i]['scid']; echo $scid; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td><?php echo $rows[$i]['total']; ?></td>
	<?php 
		$dbrank=$rows[$i]['dbrank']; 
		$sir=$rows[$i]['rank']; 
	?>
	<td><?php echo $dbrank; ?></td>
	<td class="red" >
		<?php if($sir!=$dbrank): ?>
			<?php $updated=false; ?>
			<input type="" class="blue vc50 center" name="posts[<?php echo $i; ?>][rank]" value="<?php echo $sir; ?>" >
			<input type="hidden" name="posts[<?php echo $i; ?>][scid]" value="<?php echo $scid; ?>" >
		<?php endif; ?>
	</td>
	
</tr>
<?php endfor; ?>
</table><br />

<?php if(!$updated): ?>
	<p><input type="submit" name="submit" value="Update" /></p>
<?php endif; ?>


</form>
