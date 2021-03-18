<h5>
Edit Feetype


</h5>


<?php 
?>

<form method="POST" >
<table class="gis-table-bordered" >

<tr><th>ID</th><td>
<input class="pdl05" type="text" name="ID" value="<?php echo $ftid; ?>" readonly />
</td></tr>

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

<tr><th>Is Disc.</th><td>
<input class="pdl05" type="number" min="0" max="1" name="is_discount" value="<?php echo $row['is_discount']; ?>" />
</td></tr>


<tr><th>Amount</th><td>
<input class="pdl05" type="text" name="amount" value="<?php echo $row['amount']; ?>" />
</td></tr>

<tr><th>Percentage</th><td>
<input class="pdl05" type="text" name="percentage" value="<?php echo $row['percentage']; ?>" />
</td></tr>

<tr><th>Position</th><td>
<input class="pdl05" type="number" name="position" value="<?php echo $row['position']; ?>" />
</td></tr>

<tr><th>Combo</th><td>
<input class="pdl05" type="" name="combo" value="<?php echo $row['combo']; ?>" />
</td></tr>

<?php if($row['is_fixed']!=1): ?>
<tr><td colspan="2" >
<input type="submit" name="submit" value="Save"  />
</td></tr>
<?php endif; ?>

</table>


</form>


