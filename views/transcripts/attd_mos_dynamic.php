<?php 	

$q1months = array('jun','jul','aug');
$q2months = array('jun','jul','aug','sep','oct');
$q3months = array('jun','jul','aug','sep','oct','nov','dec');
$q4months = array('jun','jul','aug','sep','oct','nov','dec','jan','feb','mar','apr');


// $attendance = $students[$i]['attendance'];  

?>


<table class="gis-table-bordered-attd table-center table-vcenter" >	
<tr class="" > 
	<th class="" >&nbsp;</th>	
	<?php for($k=0;$k<$num_months;$k++): ?>
		<?php $month_code = $month_names[$k]['code'];  ?>
		<th class="" ><?php echo ucfirst($month_code); ?></th>
	<?php endfor; ?>
	<th>Total</th>
</tr>

<tr>
	<th class="" >Days of School</th>	
	<?php for($k=0;$k<$num_months;$k++): ?>		
		<?php $month_code=$month_names[$k]['code']; ?>		
		<td><?php echo (in_array($month_code,${'q'.$qtr.'months'}))? round($months[$month_code.'_days_total']) :''; ?></td>
		<?php endfor; ?>
	<td><?php echo (in_array($month_code,${'q'.$qtr.'months'}))? ($months['year_days_total']+0):''; ?></td>	
</tr>


<tr class="" >
	<th class="" >Days Present</th>	
	<?php for($k=0;$k<$num_months;$k++): ?>
		<?php $month_code = $month_names[$k]['code']; ?>
		<?php $attdp = $attendance[$month_code.'_days_present']+0; ?>
		<td><?php echo (in_array($month_code,${'q'.$qtr.'months'}))? $attdp:''; ?></td>
	<?php endfor; ?>	
	<td>	
		<?php if($qtr>3): ?>
			<?php echo ($attendance['total_days_present']+0); ?>		
		<?php endif; ?>
	</td>
	
</tr>

<tr>
	<th class="" >Times Tardy</th>
	<?php for($k=0;$k<$num_months;$k++): ?>
		<?php $month_code=$month_names[$k]['code']; ?>
		<?php $attdl = $attendance[$month_code.'_days_tardy']+0; ?>		
		<td><?php echo (in_array($month_code,${'q'.$qtr.'months'}))? round($attendance[$month_code.'_days_tardy']):''; ?></td>
	<?php endfor; ?>	
	<td>	
		<?php if($qtr>3): ?>
			<?php echo ($attendance['total_days_tardy']+0); ?>		
		<?php endif; ?>
	</td>
	
</tr>	
</table>