<?php 

$sy_enrollment=$_SESSION['settings']['sy_enrollment'];

?>

<h5>
	<?php echo $level['name']; ?> Students SY<?php echo $sy; ?> (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	<?php if($sy<$sy_enrollment): ?>
		| <a href="<?php echo URL.'levels/students/'.$lvl.DS.$sy_enrollment; ?>" ><?php echo $sy_enrollment; ?></a>	
	<?php endif; ?>
	<?php if(DBYR<$sy): ?>
		| <a href="<?php echo URL.'levels/students/'.$lvl.DS.DBYR; ?>" ><?php echo DBYR; ?></a>	
	<?php endif; ?>	
</h5>
<?php 
// pr($rows[0]);
?>

<p>
	<?php foreach($levels AS $sel): ?>
		<a href="<?php echo URL.'levels/students/'.$sel['id']; ?>" ><?php echo $sel['code']; ?></a> &nbsp;&nbsp; 
	<?php endforeach; ?>
</p>

<table class="gis-table-bordered table-altrow" >
<tr>
<th>#</th>
<th>CT</th>
<th>ID No.</th>
<th>Student</th>
<th>Login</th>
<th>Pass</th>
<th>Edit</th>
</tr>
<tr><th colspan=4><?php echo $rows[0]['classroom']; ?></th></tr>
<?php $k=0; ?>
<?php for($i=0;$i<$count;$i++): ?>
<?php $k+=1; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $k; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['account']; ?></td>
	<td><?php echo $rows[$i]['ctp']; ?></td>
	<td><a href="<?php echo URL.'profiles/scid/'.$rows[$i]['scid']; ?>" >Profile</a></td>
</tr>

	<?php $j=$i+1; ?>
	<?php if($rows[$i]['sxn']!=@$rows[$j]['sxn']): ?>
	<?php $k=0; ?>
	<tr><th colspan=4><?php echo @$rows[$j]['classroom']; ?></th></tr>
	<?php endif; ?>

<?php endfor; ?>
</table>

<div class="clear ht100" ></div>
