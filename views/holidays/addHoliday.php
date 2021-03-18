<h5>
	Add Holiday
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'holidays'; ?>" >Holidays</a>
		
</h5>

<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>Date</th><td><input class="" name="post[date]" value="" ></td></tr>
<tr><th>Name</th><td><input class="" name="post[name]" value="" ></td></tr>
<tr><th>Payday TypeID</th><td>
<select name="post[paydaytype_id]" >
	<?php foreach($paydaytypes AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name'].' #'.$sel['id']; ?></option>
	<?php endforeach; ?>
</select>
</td></tr>
<tr><th colspan=2 ><input type="submit" name="submit" value="Add"  /></th></tr>
</table>
</form>




