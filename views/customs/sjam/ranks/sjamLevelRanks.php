<?php 
	// pr($rows[3]);	
	$rows=getSir($rows);
	// pr($rows[3]);

?>

<h5>
	SJAM Level Ranks (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <span class="u" onclick="pclass('shd');" >SHD</span>
	| <a href="<?php echo URL.'registrars/qlra/'.$lvl.DS.$sy.DS.$qtr.'?debug'; ?>" >Std</a>
	| <a href="<?php echo URL.'sjam/levelRanks/'.$lvl.DS.$sy.DS.$qtr.'?debug'; ?>" >Debug</a>
	
	
</h5>

<?php $updated=true; ?>
<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th class="shd" >Scid</th>
	<th>Classroom</th>
	<th>Name</th>
	<th class="shd" >Cdt</th>
	<th>Genave</th>
	<th class="shd" >DB</th>
	<th>SIR</th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="shd" ><?php $scid=$rows[$i]['scid']; echo $scid; ?></td>
	<td><?php echo $rows[$i]['section']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td class="shd" ><?php echo $rows[$i]['conduct']; ?></td>
	<td><?php echo $rows[$i]['genave']; ?></td>
	<td class="shd" ><?php $dbrank = ($rows[$i]['dbrank']+0); echo $dbrank; ?></td>
	<td><?php $sir=$rows[$i]['rank']; echo $sir; ?></td>
	<td>
		<?php if($dbrank!=$sir): ?>
			<?php $updated=false; ?>
			<input type="text" class="vc50" name="posts[<?php echo $i; ?>][rank]" value="<?php echo $sir; ?>"  >
			<input type="hidden" class="vc50" name="posts[<?php echo $i; ?>][scid]" value="<?php echo $scid; ?>"  >
		<?php endif; ?>
	</td>
	
</tr>
<?php endfor; ?>
</table>

<?php if(!$updated): ?>
	<p><input type="submit" name="submit" value="Update" /></p>
<?php endif; ?>

</form>

<div class="clear ht50" ></div>


<script>

	$(function(){
		$('.shd').hide();
		
	})

</script>
