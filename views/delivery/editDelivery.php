<h5>
	Edit Delivery
	| <?php $this->shovel('homelinks'); ?>
	
</h5>

<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr><th>ID</th><td><?php echo $row['pxid']; ?></td></tr>
<tr><th>Date</th><td><input type="date" name="post[rxdate]" value="<?php echo $row['rxdate']; ?>" ></td></tr>
<tr><th>Qty</th><td><input type="number" name="post[rxqty]" value="<?php echo $row['rxqty']; ?>" ></td></tr>
<tr><th colspan=2 ><input type="submit" name="submit" value="Save" /></th></tr>
</table>
</form>
