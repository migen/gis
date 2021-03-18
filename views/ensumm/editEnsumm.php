<?php 
	// $enid=$row['enid'];

?>
<h3>
	Edit Enrollment Summary | <?php $this->shovel('homelinks'); ?>
	<?php if($_SESSION['srid']==RMIS): ?>
		| <a href="<?php echo URL.'ensumm/delete/'.$enid; ?>" >Delete</a>
	<?php endif; ?>


</h3>

<?php 

	debug($row);
	$sy=$row['sy'];
	$scid=$row['scid'];
	// pr($ar_row);
	$arid=(isset($row['arid']))? $row['arid']:false;
	$arbalance=(isset($row['arbalance']))? $row['arbalance']:false;
	$balance=$row['balance'];
	$remarks=$row['remarks'];
?>

<form method="POST" >
	<table class="gis-table-bordered" >
		<tr class="shd" ><th>Pkid</th><td><?php echo $pkid; ?></td></tr>
		<tr class="shd" ><th>Enid</th><td><?php echo $row['enid']; ?></td></tr>
		<tr class="shd" ><th>Arbalance</th><td><?php echo $arbalance; ?></td></tr>
		<tr class="shd" ><th>Scid</th><td><?php echo $row['scid']; ?></td></tr>
		<tr ><th>SY</th><td><?php echo $row['sy']; ?></td></tr>
		<tr ><th>ID No.</th><td><?php echo $row['studcode']; ?></td></tr>
		<tr><th>Name</th><td><?php echo $row['student']; ?></td></tr>
		<tr><th>Classroom</th><td><?php echo $row['classroom']; ?></td></tr>
		<tr><th>Balance</th><td><?php echo number_format($balance,2); ?></td></tr>
		<tr><th>Update Balance</th>
			<td><input type="text" name="post[balance]" value="<?php echo $balance; ?>" ></td>
		</tr>			
		<tr class="shd" >
			<td colspan=2 >
				<input name="post[subject_name]" value="<?php echo $row['student']; ?>" >
				<input name="post[enid]" value="<?php echo $enid; ?>" >
				<input name="post[arid]" value="<?php echo $arid; ?>" >
				<input name="post[sy]" value="<?php echo $sy; ?>" >
				<input name="post[scid]" value="<?php echo $scid; ?>" >
				<input name="post[balance_from]" value="<?php echo $row['balance']; ?>" >
			</td>
		</tr>		
		<tr><th>Remarks</th>
			<td><input type="text" name="post[remarks]" value="<?php echo $remarks; ?>" ></td>
		</tr>			
		<tr><td colspan=2 ><input type="submit" name="submit" value="Save" ></td></tr>
	</table>
</form>


<script>

$(function(){
	shd();
})




</script>