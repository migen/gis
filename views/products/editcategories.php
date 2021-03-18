<?php ?>

<h5>

Products Categories (<?php echo $count; ?>)

</h5>


<form method="POST" >
<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th class="vc30" >ID</th>
	<th class="vc80" >Code</th>
	<th class="vc300" >Name</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $rows[$i]['id']; ?></td>
	<?php $tab = 1000+$i; ?>
	<td><input class="pdl05 full" maxlength="8" name="posts[<?php echo $i; ?>][code]" tabindex="<?php echo $tab; ?>"
		value="<?php echo $rows[$i]['code']; ?>"  /></td>
	<?php $tab = 2000+$i; ?>		
	<td><input class="pdl05 full" name="posts[<?php echo $i; ?>][name]" tabindex="<?php echo $tab; ?>"
		value="<?php echo $rows[$i]['name']; ?>"  /></td>
	<input type="hidden" name="posts[<?php echo $i; ?>][id]" value="<?php echo $rows[$i]['id']; ?>"  />
</tr>
<?php endfor; ?>

</table>

<p>	
	<input onclick="return confirm('Sure?');" type="submit" name="submit" value="Save"  />
	<button><a href="<?php echo URL.'products/categories'; ?>" class="no-underline" >Cancel</a></button>
</p>

</form>


<script>

$(function(){
	nextViaEnter();
	selectFocused();

})


</script>
