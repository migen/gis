<h3>
	Student Reps <?php echo $sy.' ('.$count.')'; ?> | <?php $this->shovel('homelinks'); ?>

</h3>

<?php 
debug($rows[0]);

$axis=$_SESSION['settings']['has_axis'];

?>


<table class="gis-table-bordered table-altrow table-fx" >
<tr>
	<th>#</th>
	<th>Crid</th>
	<th>Classroom</th>
	<th>Scid</th>
	<th>Account</th>
<?php if(isset($_GET['ctp'])): ?>	
		<th>Ctp</th>
<?php endif; ?>
	<th>Bday</th>
	<th>Name</th>
<?php if($axis): ?>
	<th>Paymode</th>
<?php endif; ?>
	<th>Links</th>
	<th>Class</th>
	<th>Matrix</th>
	<th>Rcard</th>
	<th>Reset</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php 
	$scid=$rows[$i]['scid'];
	$crid=$rows[$i]['crid'];
	$level_id=$rows[$i]['level_id'];
	$dept_id=$rows[$i]['dept_id'];
?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['crid']; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?>
		<?php if($rows[$i]['num']>1){ echo " | N#".$rows[$i]['num']; } ?>
	</td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['account']; ?></td>
<?php if(isset($_GET['ctp'])): ?>	
	<td><?php echo $rows[$i]['ctp']; ?></td>
<?php endif; ?>
	<td><?php echo $rows[$i]['birthdate']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
<?php if($axis): ?>	
	<td><?php echo $rows[$i]['paymode'].' #'.$rows[$i]['paymode_id']; ?></td>
<?php endif; ?>	
	<td><a href="<?php echo URL.'students/links/'.$scid; ?>" >Links</a></td>	
	<td><a href="<?php echo URL.'classlists/classroom/'.$crid.DS.DBYR; ?>" >List</a></td>	
	<td><a href="<?php echo URL.'matrix/grades/'.$crid.DS.DBYR.DS.'4'; ?>" >Matrix</a></td>	
	<td>
	<?php 
		$rcard_ctlr=($level_id<14)? 'rcards':'srcards'; 
		$rcget=$_SESSION['settings']['rcard_get'];
	?>
	<?php if($level_id<2): ?>
		<a target="_blank" href='<?php echo URL."rcards/scid/$scid/$sy/$qtr?{$rcget}&tpl=5"; ?>' >PN Rcard</a>
	<?php elseif($level_id<14): ?>
		<a target="_blank" href='<?php echo URL."rcards/scid/$scid/$sy/$qtr?{$rcget}&tpl=$dept_id"; ?>' >Rcard</a>
	<?php else: ?>
		<?php 
			$half=($qtr<3)? 1:2;		
			$both=$_SESSION['settings']['srcard_both'];			
		?>
		<a target="_blank" href='<?php echo URL."srcards/scid/$scid/$sy/$qtr/$half?{$rcget}&both=$both"; ?>' >SHS Rcard</a>
	<?php endif; ?>
	
	
	
	</td>
	
	<td><a href="<?php echo URL.'passwords/resets/'.$rows[$i]['scid']; ?>" >Pass</a></td>
</tr>
<?php endfor; ?>
</table>


<div class="ht100" >&nbsp;</div>

