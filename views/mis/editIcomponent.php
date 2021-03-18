<?php

// pr($data);
// pr($icomponent);

?>


<h5>Edit</h5>



<form method="POST"  >
<table class="gis-table-bordered table-fx table-altrow"  >
<tr><th>ID</th><td><?php echo $icomponent['id']; ?></td></tr>
<tr><th>Status</th><td>
<select class="full pdl05" name="icomp[is_active]" >
	<option value="1" <?php echo ($icomponent['is_active'])? 'selected':NULL; ?>  >Active</option>
	<option value="0" <?php echo (!$icomponent['is_active'])? 'selected':NULL; ?>  >NOT Active</option>
</select>
</td></tr>

<tr><th>Item</th><td>
<select class="full pdl05" name="icomp[icriteria_id]" >
	<?php foreach($icriteria AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id'] == $icomponent['icriteria_id'])? 'selected':NULL; ?>  ><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select>
</td></tr>

<tr><th>Max</th><td><input class="full pdl05" name="icomp[max]" value="<?php echo $icomponent['max']; ?>"  /></td></tr>
<tr><th>Weight</th><td><input class="full pdl05" name="icomp[weight]" value="<?php echo $icomponent['weight']; ?>"  /></td></tr>


</table>

<p><input type="submit" name="submit" value="Save"   /></p>

</form>