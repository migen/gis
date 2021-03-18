<h5>
	Teacher Crids (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	
	| <a href="<?php echo URL.'loads/crids?reset'; ?>" >Reset</a>
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr><th>#</th><th>ID-Classroom</th><th>ID-Adviser</th><th>CDT</th></tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<?php 
		$crid=$rows[$i]['crid'];
		$acid=$rows[$i]['acid'];
		$adviser=$rows[$i]['adviser'];
		$classroom=$rows[$i]['classroom'];
		$srid=$_SESSION['srid'];
		$tcid=$_SESSION['ucid'];
		$url="cdt/grades/$crid/$tcid"; 
	?>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $crid.'-'.$classroom; ?></td>
	<td><?php echo $acid.'-'.$adviser; ?></td>
	<td><a href='<?php echo URL.$url; ?>' >CDT</a>
		<?php if($tcid==$acid): ?>
			| <a href='<?php echo URL."cdt/tally/$crid"; ?>' >Tally</a>		
		<?php endif; ?>
	</td>
</tr>
<?php endfor; ?>
</table>
