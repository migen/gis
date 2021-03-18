<style>
	.signature{ width:250px;float:left; }
</style>

<?php $lvl=$course['level_id']; ?>
<?php if($lvl<4): ?>
<p>

<div class="signature" align="center" >Submitted by: <br /><br /><br /><hr width="80%" /><?php echo $teacher; ?></div> 
<?php $lvl=$course['level_id']; ?>
<?php if($lvl<4): ?>
	<div class="signature" align="center" >Checked and Noted by: <br /><br /><br /><hr width="80%" /><?php echo $vice_principal; ?></div>
<?php endif; ?>


<div class="signature" align="center" >Approved by: <br /><br /><br /><hr width="80%" /><?php echo strtoupper($principal); ?></div> 

</p>

<?php else: ?>

<p>
<div class="signature" align="center" >Submitted by: <br /><br /><br /><hr width="80%" /><?php echo $teacher; ?></div> 
<?php if(!$is_ec): ?>
	<div class="signature" align="center" >Checked by: <br /><br /><br /><hr width="80%" /><?php echo $sac; ?></div>
	<div class="signature" align="center" >Noted by: <br /><br /><br /><hr width="80%" /><?php echo strtoupper($vice_principal); ?></div> 
<?php endif; ?> 
<div class="signature" align="center" >Checked & Approved by: <br /><br /><br /><hr width="80%" /><?php echo strtoupper($principal); ?></div> 
</p>

<?php endif; ?>


