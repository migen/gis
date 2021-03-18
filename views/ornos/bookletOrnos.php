<h3>
	OR Booklet (OR No. Series Manager) | <?php $this->shovel('homelinks'); ?>

</h3>

<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>Ecid</th>
	<th>Name</th>
	<th>Last<br />OR No.</th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['ecid']; ?></td>
	<td><?php echo $rows[$i]['employee']; ?></td>
	<td><?php echo $rows[$i]['orno']; ?></td>
	<td><a href="<?php echo URL.'ornos/editBooklet/'.$rows[$i]['pkid']; ?>" >Edit</a></td>
</tr>
<?php endfor; ?>
</table>
