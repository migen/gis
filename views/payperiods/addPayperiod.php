<h5>
	Add Pay Period
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'payperiods?sy='.DBYR; ?>" >Pay Periods</a>
		
</h5>

<?php $today=$_SESSION['today']; ?>
<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>Beg</th><td><input type="date" name="post[begdate]" value="<?php echo $today; ?>" ></td></tr>
<tr><th>End</th><td><input type="date" name="post[enddate]" value="<?php echo $today; ?>" ></td></tr>
<tr><th>Name</th><td><input class="" name="post[name]" value="" ></td></tr>
<tr><th>Actv</th><td><input class="" name="post[is_active]" value="1" ></td></tr>
<tr><th colspan=2 ><input type="submit" name="submit" value="Add"  /></th></tr>
</table>
</form>




