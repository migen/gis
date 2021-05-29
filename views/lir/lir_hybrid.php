

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td>
	<?php if($is_dual): ?>
		<a href="<?php echo URL.'levels/students/'.$rows[$i]['id'].DS.$prevsy; ?>" ><?php echo $prevsy; ?></a> | 
	<?php endif; ?>		
	<a href="<?php echo URL.'levels/students/'.$rows[$i]['id']; ?>" >List</a>
	
	</td>
	<td><a href="<?php echo URL.'levels/cir/'.$rows[$i]['id']; ?>" >CIR</a></td>
	<td>
	<?php if($is_dual): ?>
		<a href="<?php echo URL.'ranks/level/'.$rows[$i]['id'].DS.$prevsy.DS.'4'; ?>" ><?php echo $prevsy; ?></a> | 
	<?php endif; ?>		
		<a href="<?php echo URL.'ranks/level/'.$rows[$i]['id'].DS.$sy.DS.$qtr; ?>" >Ranks</a>	
	</td>
	<td>
	<?php if($is_dual): ?>
		<a href="<?php echo URL.'registrars/qlra/'.$rows[$i]['id'].DS.$prevsy.DS.'4'; ?>" ><?php echo $prevsy_code; ?></a> | 	
	<?php endif; ?>	
		<a href="<?php echo URL.'registrars/qlra/'.$rows[$i]['id'].DS.$sy.DS.$qtr; ?>" >R-Genave</a>
	</td>
	<td>
	<?php if($is_dual): ?>
		<a href="<?php echo URL.'honors/level/'.$rows[$i]['id'].DS.$prevsy.DS.'4'; ?>" ><?php echo $prevsy_code; ?></a> | 
	<?php endif; ?>	
		<a href="<?php echo URL.'honors/level/'.$rows[$i]['id'].DS.$sy.DS.$qtr; ?>" >Honors</a>	
	</td>
	<td><a href="<?php echo URL.'honors/hnc/'.$rows[$i]['id'].DS.$sy.DS.$qtr; ?>" >H&C</a></td>
	<td><a href="<?php echo URL.'honors/levelcert/'.$rows[$i]['id'].DS.$sy.DS.$qtr; ?>" >Cert</a></td>
	<td>
	<?php if($is_dual): ?>
		<a href="<?php echo URL.'registrars/lbis/'.$rows[$i]['id'].DS.$prevsy.DS.'4'; ?>" ><?php echo $prevsy_code; ?></a>
	<?php endif; ?>	
		<a href="<?php echo URL.'registrars/lbis/'.$rows[$i]['id'].DS.$sy.DS.$qtr; ?>" >Subject</a>	
	</td>
	<td>
	<?php if($is_dual): ?>
		<a href="<?php echo URL.'mca/locking/'.$rows[$i]['id'].DS.$prevsy.DS.'4'; ?>" ><?php echo $prevsy; ?></a> | 	
	<?php endif; ?>
		<a href="<?php echo URL.'mca/locking/'.$rows[$i]['id'].DS.$sy.DS.$qtr; ?>" >MCA</a>	
	</td>
</tr>
<?php endfor; ?>