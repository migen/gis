<h3>
	Syncs Payables | <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."classfees/level/$lvl/$sy"; ?>' >Classfees</a>

</h3>

<p>
<?php foreach($levels AS $sel): ?>
	<a href='<?php echo URL."syncs/payables/$sy/".$sel['id']; ?>' ><?php echo $sel['code']; ?></a> | 
<?php endforeach; ?>
</p>

<p>&submit to exe <br /> * params - sy/lvl </p>

<form method="GET" >
<table class="gis-table-bordered" >
	<tr><th>SY</th><td><input name="sy" value="<?php echo $sy; ?>" ></td></tr>
	<tr><th>Lvl</th><td><input name="lvl" value="<?php echo $lvl; ?>" ></td></tr>
	<tr><th colspan=2><input type="submit" name="submit" value="Sync" ></th></tr>
</table>
</form>
