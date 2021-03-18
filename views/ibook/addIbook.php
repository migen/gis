<h5>
	Add Info
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'ibook'; ?>" >iBook</a>
		
</h5>

<form method="POST" >
<table class="gis-table-bordered" >
<input type="hidden" name="post[ucid]" value="<?php echo $_SESSION['ucid']; ?>"  />
<input type="hidden" name="post[itype_id]" value="1" /></td></tr>
<input type="hidden" name="post[room_id]" value="0" /></td></tr>

<tr><th>Date</th><td><input type="date" class="pdl05" name="post[date]" value="<?php echo $_SESSION['today']; ?>" /></td></tr>
<tr><th>Name</th><td><input class="pdl05 vc500" name="post[name]" value="" /></td></tr>
<tr><th colspan=2 ><input type="submit" name="submit" value="Add"  /></th></tr>
</table>
</form>




