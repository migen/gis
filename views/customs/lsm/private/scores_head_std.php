<div class="screen" >
<div class='third'>
<table class='gis-table-bordered table-fx' width="100%" >
	<tr><th class='vc100 white headrow'>Course<span class="screen hd" >(<?php echo '&nbsp;'.$crid; ?>)</span></th>
		<td class="" ><?php echo $course['level'].' - '.$course['section'].' - '.$course['label']; ?></td></tr>
<?php if($admin): ?>		
	<tr><th class='white headrow'>Teacher <span class="" >(<?php echo $course['tcid']; ?>)</span></th>
		<td><?php echo $course['teacher'].'<br />'.$course['teacher_code']; ?></td></tr>
<?php endif; ?>
	<tr><th class='white headrow'>Status</th><td><?php echo 'Q'.$data['qtr'].' - '; echo ($is_locked)? 'Closed' : 'Open' ; ?></td></tr>
</table>

<?php if($num_crs_components != $num_acts_components): ?>
	<h4 class="red" >Incomplete Components!</h4>
<?php endif; ?>	

<?php if(!$is_locked): ?>
	<h4 class="red" >Please Finalize (ARSU)!</h4>
<?php endif; ?>	

</div>



<div class="fourth"></div>

<div class='half'>
<table class='gis-table-bordered table-fx f12'>
	
	<tr><th colspan="2" class=''>Legends:</th></tr>
	<tr><th class=''>PNV</th><td>Partial Numerical Value</td></tr>
	<tr><th class=''>TNV</th><td>Total Numerical Value</td></tr>
	<tr><th class=''>FTNV</th><td>Final Total Numerical Value</td></tr>
	<tr><th class=''>Trans (%)</th><td>Actual Percentage NOT Raw Transmuted</td></tr>

</table>
</div>

</div> <!-- screen -->

