<h5>
	<?php // $this->shovel('breadlinks'); ?> 
	<a href="<?php echo URL.'sales/add'; ?>">Add</a>
	
</h5>

<script>

function showDiv(id){

	$('#S'+id).show();
	
}

</script>


<?php 

// pr($data);
// pr($data['selectsCustomers']);


?>

<form method='POST'>
<table class='gis-table-bordered table-fx'>

<tr>
	<th>By</th>
	<td>
		<input type='radio' name='by' value='1' checked onclick="showDiv(this.value);" >Product<br />
		<input type='radio' name='by' value='2' onclick="showDiv(this.value);" >Category<br />
		<input type='radio' name='by' value='3' onclick="showDiv(this.value);" >Customer<br />
	</td>
</tr>

	<?php $today = date('Y-m-d'); ?>
	<?php $newyear = date('Y').'-01-01'; ?>
<tr>
	<th>Start</th>
	<td><input type='date' name='start' value="<?php echo $today; ?>" ></td>
</tr>

<tr>
	<th>End</th>
	<td><input type='date' name='end' value="<?php echo $today; ?>" ></td>
</tr>

<tr id='S1' >
	<th>Product</th>
	<td>
		<select name='product' class='full' >
		<?php foreach($data['selectsProducts'] AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
		</select>
	</td>
</tr>


<tr class='hide' id='S2' >
	<th>Category</th>
	<td>
		<select name='category' class='full' >
		<?php foreach($data['selectsCategories'] AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
		</select>
	</td>
</tr>

<tr class='hide' id='S3' >
	<th>Customers</th>
	<td>
		<select name='customer' class='full' >
		<?php foreach($data['selectsCustomers'] AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
		</select>
	</td>
</tr>

</table>

<p>
	<input type='submit' name='submit' value='Search' />
</p>

</form>
