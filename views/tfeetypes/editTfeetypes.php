<h5>
	Edit Fee
	| <?php echo $row['name']; ?>
	| <?php $this->shovel('homelinks'); ?>	
	| <a href="<?php echo URL.'tfeetypes/table'; ?>">Fees</a>


</h5>


<?php 

// pr($_SESSION['q']);

?>


<form method="POST" >
<table class="gis-table-bordered" >

<tr><th>ID</th><td><?php echo $row['id']; ?></td></tr>

<tr><th>Parent</th><td>
<select class="full" name="parent_id" >
<option value="0" >Parent</option>
<?php foreach($feetypes AS $sel): ?>
	<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$row['parent_id'])? 'selected':NULL; ?> >
		<?php echo $sel['name']; ?></option>
<?php endforeach; ?>
</select>
</td></tr>

<tr><th>Name</th><td>
<input class="pdl05" type="text" name="name" value="<?php echo $row['name']; ?>" />
</td></tr>

<tr><th>Label</th><td>
<input class="pdl05" type="text" name="label" value="<?php echo $row['label']; ?>" />
</td></tr>

<tr><th>Is Disc.</th><td>
<input class="pdl05" type="number" min="0" max="1" name="is_discount" value="<?php echo $row['is_discount']; ?>" />
</td></tr>


<tr><th>Amount</th><td>
<input class="pdl05" type="text" name="amount" value="<?php echo $row['amount']; ?>" />
</td></tr>

<tr><th>Is Percent</th><td>
<input class="pdl05" type="number" min=0 max=1 name="is_percent" value="<?php echo $row['is_percent']; ?>" />
</td></tr>

<tr><th>Percent</th><td>
<input class="pdl05" type="text" name="percent" value="<?php echo $row['percent']; ?>" />
</td></tr>

<tr><th>Position</th><td>
<input class="pdl05" type="number" name="position" value="<?php echo $row['position']; ?>" />
</td></tr>


<tr><td colspan="2" >
<input type="submit" name="submit" value="Save"  />
</td></tr>

</table>


</form>


