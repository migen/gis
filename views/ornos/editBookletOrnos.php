<h3>
	Edit OR Booklet (OR No. Series Manager) | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'ornos/booklet'; ?>" >All</a>

</h3>
<?php 
extract($row);
?>

<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>Pkid</th><td><?php echo $pkid; ?></td></tr>
<tr><th>Ecid</th><td><?php echo $ecid; ?></td></tr>
<tr><th>Employee</th><td><?php echo $employee; ?></td></tr>
<tr><th>Last<br />OR No.</th>
	<td><input name="post[orno]" value="<?php echo $orno; ?>" ></td></tr>
<tr><td colspan=2><input type="submit" name="submit" value="Update" ></td></tr>
</table>
</form>
