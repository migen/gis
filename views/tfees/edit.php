<?php

	// pr($_SESSION['q']);
	// pr($data);

?>

<!-- ============================================================== -->

<h5>
	Edit Fee | 	
	<?php $this->shovel('homelinks','accounts'); ?>
	
</h5>

<!-- ================ page details ============================================== -->

<table class="gis-table-bordered table-fx" >
	<tr><th class='white headrow'>Level</th><td><?php echo $fee['level']; ?></td></tr>
	<tr><th class='white headrow'>Total</th><td><?php echo $fee['total']; ?></td></tr>	
</table>

<h4>Tuition Detail</h4>
<!-- ============================================================== -->

<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr><th class="bg-blue2 white" >Type</th><td>
<select class="vc200" name="feetype_id" >
	<?php foreach($feetypes AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$fee['feetype_id'])? 'selected':null; ?> >
			<?php echo $sel['name']; ?></option>	
	<?php endforeach; ?>
</select>
</td></tr>

<tr><th class="bg-blue2 white" >Amount</th>
<td><input class="vc200 pdl05" type="text" name="amount" value="<?php echo $fee['amount']; ?>" ></td>
</tr>

<input type="hidden" name="level_id" value="<?php echo $fee['level_id']; ?>" />
<input type="hidden" name="old_amount" value="<?php echo $fee['amount']; ?>" />

<tr><td colspan="2" ><input type="submit" name="edit" value="Update" />
<button><a class="no-underline" href="<?php echo URL.'tfees/delete/'.$fee['level_id'].DS.$fee['tuition_detail_id']; ?>" >Delete</a></button>
</td></tr>

</table>
</form>