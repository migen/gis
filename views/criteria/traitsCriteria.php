<h5>
	Edit Criteria (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	<?php if(isset($_GET['order']) && ($_GET['order']=='critype_id')): ?>
		| <a href="<?php echo URL.'criteria/traits?order=cri.name'; ?>" >Criteria</a>
	<?php else: ?>
		| <a href="<?php echo URL.'criteria/traits?order=cri.critype_id'; ?>" >CritypeID</a>	
	<?php endif; ?>
	| crstype_id | critype_id | all | edit
	
</h5>

<?php $colspan=6; ?>

<div style="float:left;width:60%;" >
<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Crstype</th>
	<th>Critype
		<br /><input class="pdl05 vc50" id="icty" /><br />	
		<input type="button" value="All" onclick="populateColumn('cty');" >
	</th>
	<th>Code</th>
	<th>Name</th>
</tr>
<?php if(isset($_GET['edit'])): ?>
	<?php for($i=0;$i<$count;$i++): ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td><?php echo $rows[$i]['id']; ?></td>
		<td><?php echo $rows[$i]['crstype_id']; ?></td>
		<input type="hidden" name="posts[<?php echo $i; ?>][id]" value="<?php echo $rows[$i]['id']; ?>" />
		<td><input class="vc50 cty" name="posts[<?php echo $i; ?>][critype_id]" value="<?php echo $rows[$i]['critype_id']; ?>" /></td>
		<td><?php echo $rows[$i]['code']; ?></td>
		<td><?php echo $rows[$i]['name']; ?></td>
	</tr>
	<?php endfor; ?>
	<tr><th colspan="<?php echo $colspan; ?>" ><input type="submit" name="submit" value="Save All" onclick="return confirm('Sure?');" ></th></tr>
<?php else: ?>
	<?php for($i=0;$i<$count;$i++): ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td><?php echo $rows[$i]['id']; ?></td>
		<td><?php echo $rows[$i]['crstype_id']; ?></td>
		<td><?php echo $rows[$i]['critype_id']; ?></td>
		<td><?php echo $rows[$i]['code']; ?></td>
		<td><?php echo $rows[$i]['name']; ?></td>
	</tr>
	<?php endfor; ?>
<?php endif; ?>
</table>
</form>
</div>	<!-- lcol -->

<div style="float:left;width:35%;" >
<table class="gis-table-bordered table-altrow" >
<tr><th>ID</th><th>Critype</th></tr>
<?php foreach($critypes AS $cri): ?>
<tr>
	<td><?php echo $cri['id']; ?></td>
	<td><?php echo $cri['name']; ?></td>
</tr>
<?php endforeach; ?>
</table>
</div> 	<!-- rcol -->


<div class="ht50 clear" ></div>