<h5>
	Level Names (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <a class="u" id="btnExport" >Excel</a> 
	<?php if(isset($_GET['edit'])): ?>
		| <a href="<?php echo URL.'names/level/'.$lvl; ?>">View</a>	
	<?php else: ?>
		| <a href="<?php echo URL.'names/level/'.$lvl.'&edit'; ?>">Edit</a>
	<?php endif; ?>
	

</h5>

<table id="tblExport" class="gis-table-bordered table-altrow" >
<tr><th>#</th><th>Scid</th><th>Name</th><th>Edit</th></tr>

<?php if(isset($_GET['edit'])): ?>
<form method="POST" >
	<?php for($i=0;$i<$count;$i++): ?>
		<tr>
			<td><?php echo $i+1; ?></td>
			<td><input type="text" name="posts[<?php echo $i; ?>][scid]" value="<?php echo $rows[$i]['scid']; ?>" class="vc50" readonly /></td>
			<td><input type="text" name="posts[<?php echo $i; ?>][name]" value="<?php echo $rows[$i]['name']; ?>" tabIndex=2 class="vc500" /></td>
		</tr>
	<?php endfor; ?>
	<tr><th colspan=3><input type="submit" name="submit" value="Clean"  /></th></tr>
</form>	
<?php else: ?>
	<?php for($i=0;$i<$count;$i++): ?>
		<tr>
			<td><?php echo $i+1; ?></td>
			<td><?php echo $rows[$i]['scid']; ?></td>
			<td><?php echo $rows[$i]['student']; ?></td>
			<td><a href="<?php echo URL.'codename/fullname/'.$rows[$i]['scid']; ?>" >Edit</a></td>
		</tr>
	<?php endfor; ?>
<?php endif; ?>
</table>

<div class="ht100" ></div>

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>


<script>

$(function(){
	excel();
	selectFocused();
	nextViaEnter();

})


</script>
