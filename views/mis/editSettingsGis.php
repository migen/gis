<h5>
	Edit Settings | 
	<?php 	$controller = 'mis'; $this->shovel('homelinks',$controller); ?>
	| <a href="<?php echo URL; ?>settings/allGis" >Settings</a>

</h5>

<!------------------------------------------------------------------------------------------------->


<?php 

// pr($data);
$rows 	 = $settings;
$numrows = count($rows);


?>

<form method='post'>

<table class="table-fx gis-table-bordered">
<tr class='headrow'>
	<th>#</th>
	<th>Setting</th>
	<th>Value</th>
</tr>


<?php for($i=0;$i<$numrows;$i++): ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td><?php echo $rows[$i]['name']; ?></td>
		<td><input type='text' name="settings[<?php echo $i; ?>][value]" value="<?php echo (isset($rows[$i]['value']))? $rows[$i]['value'] : ''; ?>" /></td>
	</tr>
		<input type='hidden' name="settings[<?php echo $i; ?>][id]" value="<?php echo $rows[$i]['id']; ?>" />
<?php endfor; ?>

</table>

<p>
	<input type='submit' name='submit' value='Submit' />
	<button><a href="<?php echo URL.'settings/allGis'; ?>" class="no-underline" >Cancel</a></button>
</p>


</form>