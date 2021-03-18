<h3>
	Loyalty Transcript
	| <?php $this->shovel('homelinks'); ?>
	
</h3>

<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>Scid</th>
	<th>Code</th>
	<th>Name</th>
	<th>Num</th>
	<th>Transcript</th>
	<th>Crids</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['studcode']; ?></td>
	<td><?php echo $rows[$i]['studname']; ?></td>
	<td><?php echo $rows[$i]['num']; ?></td>
	<td><a href="<?php echo URL.'transcripts/scid/'.$rows[$i]['scid']; ?>" >Transcript</a></td>
	<td><a href="<?php echo URL.'transcripts/crids/'.$rows[$i]['scid']; ?>" >Crids</a></td>
</tr>
<?php endfor; ?>
</table>
