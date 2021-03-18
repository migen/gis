<h5>
	Edit PO Supplier
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				

	
</h5>

<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr><th>ID</th><td><?php echo $row['poid']; ?></td></tr>
<tr><th>Supplier</th><td><select name="suppid" >
	<?php foreach($suppliers AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$row['suppid'])?'selected':NULL; ?> >
			<?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select>
</td></tr>

<tr><td colspan="2" ><input type="submit" name="submit" value="Submit" onclick="return confirm('Sure?');"  /></td></tr>


</table>
</form>