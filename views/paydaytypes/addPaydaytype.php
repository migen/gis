<h5>
	Add Payday Type
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'paydaytypes'; ?>" >Payday Types</a>
		
</h5>

<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>Code</th><td><input class="" name="post[code]" value="" ></td></tr>
<tr><th>Name</th><td><input class="" name="post[name]" value="" ></td></tr>
<tr><th>Factor</th><td><input class="" name="post[factor]" value="" ></td></tr>
<tr><th>Factor OT</th><td><input class="" name="post[factor_overtime]" value="" ></td></tr>
<tr><th colspan=2 ><input type="submit" name="submit" value="Add"  /></th></tr>
</table>
</form>




