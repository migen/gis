<h5>
	Edit Criteria
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'criteria'; ?>" >Criteria</a>

</h5>


<?php 
// pr($data);

?>

<style>
	.grid{
		width:80%;
		display:grid;
		grid-template-columns:2fr 1fr;
		justify-self:start;
		
	}
	
	
	
</style>


<div class="grid" >
	<div class="item" >

		<form method="POST" >

		<table class="gis-table-bordered table-fx">

		<tr><td>Criteria ID</td><td><input class="full pdl05" type="text" name="criteria[id]" value="<?php echo $criteria['id']; ?>" readonly /></td></tr>
		<tr><td>Criteria</td><td><textarea class="full" name="criteria[name]" rows=7 /><?php echo $criteria['name']; ?></textarea></td></tr>
		<tr><td>CritypeID</td><td><input class="full pdl05" type="text" name="criteria[critype_id]" value="<?php echo $criteria['critype_id']; ?>"  /></td></tr>
		<tr><td>Code</td><td><input class="full pdl05" type="text" name="criteria[code]" value="<?php echo $criteria['code']; ?>"  /></td></tr>

		<tr><td>CrsType</td><td><select class="full" name="criteria[crstype_id]"  ><?php foreach($crstypes as $sel): ?><option value="<?php echo $sel['id']; ?>" <?php echo ($criteria['crstype_id']==$sel['id'])? 'selected': null; ?>  ><?php echo $sel['name']; ?></option><?php	endforeach; ?> </select></td></tr>


		<tr><td>Position</td><td><input class="full pdl05" type="text" name="criteria[position]" value="<?php echo $criteria['position']; ?>"  /></td></tr>
		<tr><td>Active</td><td><select class="full pdl05" name="criteria[is_active]"  > <option value="0" <?php echo (!$criteria['is_active'])? 'selected': null; ?> >No</option> <option value="1" <?php echo ($criteria['is_active'])? 'selected': null; ?> >Yes</option> </select></td></tr>
		<tr><td>(0) Pct (1) Raw (2) Trns</td>
		<td><input name="criteria[is_raw]" class="vc50" value="<?php echo $criteria['is_raw']; ?>" /></td></tr>
		<tr><td>Is Kpup</td><td><select class="full pdl05" name="criteria[is_kpup]"  > <option value="0" <?php echo (!$criteria['is_kpup'])? 'selected': null; ?> >No</option> <option value="1" <?php echo ($criteria['is_kpup'])? 'selected': null; ?> >Yes</option> </select></td></tr>
		<tr><td>Is Kpup List</td><td><select class="full pdl05" name="criteria[is_kpup_list]"  > <option value="0" <?php echo (!$criteria['is_kpup_list'])? 'selected': null; ?> >No</option> <option value="1" <?php echo ($criteria['is_kpup_list'])? 'selected': null; ?> >Yes</option> </select></td></tr>

		<tr><td colspan="2" ><input type="submit" name="edit" value="Update"  />
		<button><a class="no-underline" href="<?php echo URL.'criteria'; ?>" >Cancel</a></button>
		</td></tr>
		</table>

		</form>

	</div>	<!-- item -->
	
	<div class="item" >
		<table class="gis-table-bordered" >
			<tr><th>Critypes</th></tr>
			<?php foreach($critypes AS $sel): ?>
				<tr><td><?php echo '#'.$sel['id'].' - '.$sel['name']; ?></td></tr>
			<?php endforeach; ?>
		</table>
	</div>
	
</div>

