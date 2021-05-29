<h3>

	Student Abc | <?php $this->shovel('homelinks'); ?>


</h3>


<?php 

pr($data);

?>

<table class="gis-table-bordered table-altrow table-fx" >
<tr>
	<th class="vc200" >Ensteps<t/th>
</tr>

<tr><td>Step 1 - Datasheet</td></tr>
<tr><td>Step 2 - Paymode <?php echo $sy_enrollment; ?></td></tr>
<tr><td>Step 3 - Assessment <?php echo $sy_enrollment; ?></td></tr>

<tr>
	<th class="vc200" >Student<t/th>
</tr>
<tr><td>View Payments <?php echo $sy_enrollment; ?></td></tr>

<?php if($hasRcard): ?>
	<tr><td>Rcard <?php echo $sy_grading; ?></td></tr>
	<tr><td>Certificates <?php echo $sy_grading; ?></td></tr>
<?php else: ?>
	<tr><td>NO HasRcard</td></tr>
<?php endif; ?>




</table>
