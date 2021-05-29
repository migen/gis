<?php 

$sqtr=$_SESSION['qtr'];

?>


<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><a href="<?php echo URL.'levels/students/'.$rows[$i]['id']; ?>" >List</a></td>
	<td><a href="<?php echo URL.'levels/cir/'.$rows[$i]['id']; ?>" >CIR</a></td>
	<td>
	  <?php for($q=1;$q<=$sqtr;$q++): ?>	
		<a href="<?php echo URL.'ranks/level/'.$rows[$i]['id'].DS.$sy.DS.$q; ?>" >Q<?php echo $q; ?></a>
		<?php echo ($q==$sqtr)? null:' | ';  ?>
	  <?php endfor; ?>	
	</td>
	<td>	
	  <?php for($q=1;$q<=$sqtr;$q++): ?>	
		<a href="<?php echo URL.'registrars/qlra/'.$rows[$i]['id'].DS.$sy.DS.$q; ?>" >Q<?php echo $q; ?></a>
		<?php echo ($q==$sqtr)? null:' | ';  ?>
	  <?php endfor; ?>			
	</td>
	<td>
	  <?php for($q=1;$q<=$sqtr;$q++): ?>	
		<a href="<?php echo URL.'honors/level/'.$rows[$i]['id'].DS.$sy.DS.$q; ?>" >Q<?php echo $q; ?></a>
		<?php echo ($q==$sqtr)? null:' | ';  ?>
	  <?php endfor; ?>					
	</td>
	<td>
	  <?php for($q=1;$q<=$sqtr;$q++): ?>	
		<a href="<?php echo URL.'honors/hnc/'.$rows[$i]['id'].DS.$sy.DS.$q; ?>" >Q<?php echo $q; ?></a>
		<?php echo ($q==$sqtr)? null:' | ';  ?>
	  <?php endfor; ?>						
	</td>
	<td>
	  <?php for($q=1;$q<=$sqtr;$q++): ?>	
		<a href="<?php echo URL.'honors/levelcert/'.$rows[$i]['id'].DS.$sy.DS.$q; ?>" >Q<?php echo $q; ?></a>
		<?php echo ($q==$sqtr)? null:' | ';  ?>
	  <?php endfor; ?>							
	</td>
	<td>
	  <?php for($q=1;$q<=$sqtr;$q++): ?>	
		<a href="<?php echo URL.'registrars/lbis/'.$rows[$i]['id'].DS.$sy.DS.$q; ?>" >Q<?php echo $q; ?></a>
		<?php echo ($q==$sqtr)? null:' | ';  ?>
	  <?php endfor; ?>								
	</td>
	<td><a href="<?php echo URL.'mca/locking/'.$rows[$i]['id'].DS.$sy.DS.$qtr; ?>" >MCA</a></td>
</tr>
<?php endfor; ?>