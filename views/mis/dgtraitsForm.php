<h5>
DG Traits Form
	| <a href="<?php echo URL.'mis'; ?>" > Home </a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'setup/grading'; ?>" > Setup </a>
	| <a href="<?php echo URL.'mis/dgconductsForm'; ?>" > DG Conducts </a>
	| <a href="<?php echo URL.'mis/dgacadForm'; ?>" > DG Academics </a>

</h5>

<form method="POST" >
<table class="gis-table-bordered table-altrow" >



<tr>
<th class="bg-blue3" >Classroom</th>
<td> 
<select class="full" name="crid"  >
	<option value="0"> Choose One </option>
	<?php foreach($classrooms AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select> 
</td></tr>

<tr>
	<th class="bg-blue3" >Course Type</th>
	<td><select class="full" name="is_trait" >
		<option value="1">Trait</option>
		<option value="0">PSMapeh</option>
	</select></td>
</tr>


<tr>
	<th class="bg-blue3" >SY</th>
	<td><input class="pdl05" name="sy" value="<?php echo $sy; ?>" ></td>
</tr>

<tr>
	<th class="bg-blue3" >Qtr</th>
	<td><input class="pdl05" name="qtr" value="<?php echo $qtr; ?>" ></td>
</tr>


<tr><td colspan="2" ><input type="submit" name="submit" value="Submit"   /></td></tr>

</table>
</form>
