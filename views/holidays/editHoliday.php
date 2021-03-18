<h5>
	Edit Payday Type
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'paydaytypes'; ?>" >Payday Types</a>
	| <a href="<?php echo URL.'paydaytypes/delete/'.$id; ?>" onclick="return confirm('Sure?');" >Delete</a>
		
</h5>

<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>ID</th><td><?php echo $row['id']; ?></td></tr>
<tr><th>Name</th><td><input class="" name="post[date]" value="<?php echo $row['date']; ?>" ></td></tr>
<tr><th>Name</th><td><input class="" name="post[name]" value="<?php echo $row['name']; ?>" ></td></tr>
<tr><th>Payday Type</th><td>
<select name="post[paydaytype_id]" >
	<?php foreach($paydaytypes AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$row['paydaytype_id'])?'selected':NULL; ?> >
			<?php echo $sel['name'].' #'.$sel['id']; ?></option>
	<?php endforeach; ?>
</select>
</td></tr>
<tr><th colspan=2 ><input type="submit" name="submit" value="Save"  /></th></tr>
</table>
</form>




