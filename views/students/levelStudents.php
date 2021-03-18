<h3>
	<?php echo $level['name']; ?> Students <?php echo ($lvl)? $count:NULL; ?> SY<?php echo $sy; ?>
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'students/leveler/1/'.$sy; ?>" >Leveler</a>
	| <a href="<?php echo URL.'students/level/'.$lvl.DS.$sy; ?>" >LvlStuds</a>

</h3>

<?php 

?>


<?php foreach($levels AS $sel): ?>
	<a href="<?php echo URL.'students/level/'.$sel['id']; ?>" ><?php echo $sel['code']; ?></a> | 
<?php endforeach; ?>
<br/>
<br/>

<?php if($lvl): ?>
	<table class="gis-table-bordered" >
	<tr>
		<th>#</th>
		<th>Sxn</th>
		<th>Scid</th>
		<th>ID No.</th>
		<th>Birthdate</th>
		<th>Student</th>
		<th></th>
	</tr>
	<?php for($i=0;$i<$count;$i++): ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td><?php echo $rows[$i]['sxncode']; ?></td>
		<td><?php echo $rows[$i]['scid']; ?></td>
		<td><?php echo $rows[$i]['studcode']; ?></td>
		<td><?php echo $rows[$i]['birthdate']; ?></td>
		<td><?php echo $rows[$i]['studname']; ?></td>
		<td>
			<a href="<?php echo URL.'students/sectioner/'.$rows[$i]['scid'].DS.$sy; ?>" >Sxnr</a>
		</td>
	</tr>
	<?php endfor; ?>
	</table>
<?php endif; ?>	<!-- lvl -->
