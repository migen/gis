<h5>
	Edit Pay Period
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'payperiods?sy='.DBYR; ?>" >PayPeriods</a>
		
</h5>

<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>ID</th><td><?php echo $row['id']; ?></td></tr>
<tr><th>Actv</th><td><input type="number" min=0 max=1 name="post[is_active]" value="<?php echo $row['is_active']; ?>" ></td></tr>
<tr><th>Beg</th><td><input class="" name="post[begdate]" value="<?php echo $row['begdate']; ?>" ></td></tr>
<tr><th>End</th><td><input class="" name="post[enddate]" value="<?php echo $row['enddate']; ?>" ></td></tr>
<tr><th>Name</th><td><input class="" name="post[name]" value="<?php echo $row['name']; ?>" ></td></tr>
<tr><th colspan=2 ><input type="submit" name="submit" value="Save"  /></th></tr>
</table>
</form>




