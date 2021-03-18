<?php 	$attendance = $students[$i]['attendance'];  ?>

<table style="font-size:1em;width:<?php echo $ftw; ?>;" class="no-gis-table-bordered center" >	
	<tr><td class="b" >ATTENDANCE REPORT</td></tr>
</table>

<table style="width:<?php echo $ftw; ?>;" class="gis-table-bordered-print tf10 table-center table-vcenter" >	
<tr class="padding02 <?php echo $attheadrowfont; ?>" > 
	<th class="vc100" >&nbsp;</th>	
	<?php for($k=0;$k<$num_months;$k++): ?>
		<?php $month_code = $month_names[$k]['code'];  ?>
		<th class="" ><?php echo ucfirst($month_code); ?></th>
	<?php endfor; ?>
	<th>Total</th>
</tr>

<tr>
	<th class="left" >Days of School</th>	
	<?php for($k=0;$k<$num_months;$k++): ?>		
		<?php $month_code = $data['month_names'][$k]['code']; ?>		
			<td><?php echo (in_array($month_code,${'q'.$qtr.'months'}))? round($data['months'][$month_code.'_days_total']) :''; ?></td>		
	<?php endfor; ?>
	<td><?php if($qtr>3){ echo ($months['year_days_total']+0); } ?> </td>
</tr>


<tr  >
	<th class="left" >Days Present</th>	
	<?php for($k=0;$k<$num_months;$k++): ?>
		<?php $month_code = $data['month_names'][$k]['code']; ?>
		<?php $attdp = $attendance[$month_code.'_days_present']+0; ?>
		<td><?php echo (in_array($month_code,${'q'.$qtr.'months'}))? $attdp:''; ?></td>
	<?php endfor; ?>	
	<td><?php if($qtr>3) { $attdp = $attendance['total_days_present']+0; echo $attdp; } ?> </td>
</tr>

<tr>
	<th class="left" >Days Tardy</th>
	<?php for($k=0;$k<$num_months;$k++): ?>
		<?php $month_code = $data['month_names'][$k]['code']; ?>
		<td><?php echo (in_array($month_code,${'q'.$qtr.'months'}))? round($attendance[$month_code.'_days_tardy']):''; ?></td>
	<?php endfor; ?>	
	<td><?php if($qtr>3){ $attdl = $attendance['total_days_tardy']+0; echo $attdl; } ?> </td>
</tr>
</table>
