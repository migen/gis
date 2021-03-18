<?php 	

$q4months = array('jun','jul','aug','sep','oct','nov','dec','jan','feb','mar','apr');



?>


<table class="gis-table-bordered table-altrow table-center" >	
<tr class="" > 
	<th class="" >&nbsp;</th>	
	<?php for($k=0;$k<$num_months;$k++): ?>
		<?php $month_code = $month_names[$k]['code'];  ?>
		<th class="" ><?php echo ucfirst($month_code); ?></th>
	<?php endfor; ?>
	<th>Total</th>
</tr>


<?php // in_array(); ?>

<tr>
	<th class="" >Days of School</th>	
	<?php for($k=0;$k<$num_months;$k++): ?>		
		<?php $month_code=$month_names[$k]['code']; ?>		
		<td><?php echo round($months[$month_code.'_days_total']); ?></td>
		<?php endfor; ?>
	<td><?php echo ($months['year_days_total']+0); ?></td>	
</tr>


<tr class="" >
	<th style="text-align:left;" >Days Present</th>	
	<?php for($k=0;$k<$num_months;$k++): ?>
		<?php $month_code=$month_names[$k]['code']; ?>
		<?php $attdpre=$attendance[$month_code.'_days_present']+0; ?>
		<td><?php echo $attdpre; ?></td>
	<?php endfor; ?>	
	<td><?php echo ($attendance['total_days_present']+0); ?></td>	
</tr>

<tr>
	<th style="text-align:left;" >Times Tardy</th>
	<?php for($k=0;$k<$num_months;$k++): ?>
		<?php $month_code=$month_names[$k]['code']; ?>
		<?php $attdtar=$attendance[$month_code.'_days_tardy']+0; ?>		
		<td><?php echo $attdtar; ?></td>
	<?php endfor; ?>	
	<td><?php echo ($attendance['total_days_tardy']+0); ?></td>	
</tr>	
</table>