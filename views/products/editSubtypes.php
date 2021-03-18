<?php ?>

<h5>

Edit Subtypes (<?php echo $count; ?>) | <?php $this->shovel('homelinks'); ?>

</h5>


<form method="POST" >
<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th class="vc30" >ID</th>
	<th class="vc80" >Type</th>
	<th class="vc80" >Code</th>
	<th class="vc300" >Name</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td>
		<select name="posts[<?php echo $i; ?>][prodtype_id]" >
			<?php foreach($prodtypes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$rows[$i]['prodtype_id'])? 'selected':NULL; ?> >
					<?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>
	<td><input class="pdl05 full" maxlength="8" name="posts[<?php echo $i; ?>][code]" value="<?php echo $rows[$i]['code']; ?>"  /></td>
	<td><input class="pdl05 full" name="posts[<?php echo $i; ?>][name]" value="<?php echo $rows[$i]['name']; ?>"  /></td>
	<input type="hidden" name="posts[<?php echo $i; ?>][id]" value="<?php echo $rows[$i]['id']; ?>"  />
</tr>
<?php endfor; ?>

</table>

<br />

<p>	
	<input onclick="return confirm('Sure?');" type="submit" name="submit" value="Save"  />
	<button><a href="<?php echo URL.'products/subtypes'; ?>" class="no-underline" >Cancel</a></button>
</p>

</form>


