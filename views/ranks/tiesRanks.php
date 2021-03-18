<h5>
	<?php echo $level['name']; ?> Ranks (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'lir'; ?>" >L I R</a>
	| <a href="<?php echo URL.'registrars/qlra/'.$lvl.DS.$sy.DS.$qtr; ?>" >Ranking</a>
	| <a href="<?php echo URL.'ranks/ties/'.$lvl.DS.$sy.DS.$qtr.'?num=1'; ?>" >Ties</a>
	| <a href="<?php echo URL.'ranks/level/'.$lvl.DS.$sy.DS.$qtr.'?num=1'; ?>" >Saved</a>
	| <a href="<?php echo URL.'ranks/update/'.$lvl.DS.$sy.DS.$qtr.'?exe'; ?>" >Submit</a>
		
</h5>

<?php 

	debug($rows[0]);
?>

<h5>Ties Count (<?php echo $count; ?>)</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Scid</th>
	<th>ID No.</th>
	<th>Student</th>
	<th>Classroom</th>
	<th>Genave</th>
	<th>Rank</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['studcode']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td><?php echo $rows[$i]['genave']; ?></td>
	<td><?php echo $rows[$i]['rank']; ?></td>
</tr>
<?php endfor; ?>
</table>

<button><a href="<?php echo URL.'ranks/update/'.$lvl.DS.$sy.DS.$qtr.'?exe'; ?>" >Submit</a></button>
