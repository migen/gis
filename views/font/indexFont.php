<?php $size=isset($_GET['size'])? $_GET['size']:1; ?>

<style>

.tblFont{ font-size:<?php echo $size; ?>em; }

</style>

<h5>
	Font
	| <?php $this->shovel('homelinks'); ?>
<form method="GET" style="display:inline; " >	
	| Size <input class="center vc50" id="size" name="size" value="<?php echo (isset($_GET['size']))? $_GET['size']:1; ?>"  />
		<input type="submit" name="submit" value="Go" >	
</form>	
	
	
	
</h5>

<table class="tblFont gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Code</th>
	<th>Name</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
</tr>
<?php endfor; ?>
</table>
