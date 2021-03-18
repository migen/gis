<?php ?>

<h5>

Product Categories (<?php echo $count; ?>)
	<a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'products'; ?>" >Products</a>
</h5>


<form method="POST" >
<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>&nbsp;</th>
	<th>ID</th>
	<th>Code</th>
	<th class="vc300" >Name</th>
	<th>&nbsp;</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td class="screen" ><input type="checkbox" name="rows[<?php echo $rows[$i]['id']; ?>]" 
		value="<?php echo $rows[$i]['id']; ?>" /></td>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td>
		<a href='<?php echo URL."products/viewCategory/".$rows[$i]['id']; ?>' >View</a>	
		| <a href='<?php echo URL."products/editCategories/".$rows[$i]['id']; ?>' >Edit</a>	
	</td>
</tr>
<?php endfor; ?>

</table>

<p>	
	<input onclick="return confirm('Sure?');" type='submit' name='batch' value='Edit' >
	<?php $this->shovel('boxes'); ?>

</p>

</form>


