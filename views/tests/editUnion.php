<h5>
	Edit Cxn Union
	| <?php $this->shovel('homelinks'); ?>
	
</h5>

<form method="POST" >
<table class="gis-table-bordered table-fx table-altrow" >
<tr>
	<th>ID</th>
	<td><?php echo $row['id']; ?></td>
</tr>

<tr>
	<th>Log</th>
	<td>
		<input name="log" value="<?php echo $row['log']; ?>" />
	</td>
</tr>

<tr>
	<td colspan="2" ><input type="submit" name="submit" value="Save" ></td>
</tr>

</table>
</form>