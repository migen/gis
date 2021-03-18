<div id="printable" >
<div class="screen legends" style="float:left;width:40%;" >
<table class="gis-table-bordered table-fx" width="100%" >
	<tr class="hd" ><th class='white headrow'>Locking</th><td>
			<?php if($is_locked): ?>
				<a href="<?php echo URL.'finalizers/openCourse/'.$course['crid'].DS.$course_id.DS.$sy.DS.$qtr; ?>" >Unlock</a>
			<?php else: ?>
				<a href="<?php echo URL.'finalizers/closeCourse/'.$course['crid'].DS.$course_id.DS.$sy.DS.$qtr; ?>" >Lock</a>			
			<?php endif; ?>		
			<span class="hd" > | <?php echo $course['teacher_code']; ?></span>
	</td></tr>
	<tr><th class='vc100 white headrow'>Course<span class="screen hd" >(<?php echo '&nbsp;'.$crid; ?>)</span></th>
		<td class="" ><?php echo $course['level'].' - '.$course['section'].' - '.$course['label']; ?></td></tr>
<?php if($admin): ?>		
	<tr><th class='white headrow'>Teacher <span class="" >(<?php echo $course['tcid']; ?>)</span></th>
		<td><?php echo $course['teacher'].'<br />'.$course['teacher_code']; ?></td></tr>
<?php endif; ?>
	<tr><th class='white headrow'>Status</th><td><?php echo 'Q'.$data['qtr'].' - '; echo ($is_locked)? 'Closed' : 'Open' ; ?></td></tr>
</table>


</div>

<div style="float:left;width:5%;min-height:100px;" ></div>

<div class="third screen legends">
<table class='gis-table-bordered table-fx f12'>	
	<tr><th colspan="2" class=''>Legends:</th></tr>
	<tr><th class=''>PNV</th><td>Partial Numerical Value</td></tr>
	<tr><th class=''>TNV</th><td>Total Numerical Value</td></tr>
	<tr><th class=''>FTNV</th><td>Final Total Numerical Value</td></tr>
	<tr><th class=''>Trans (%)</th><td>Actual Percentage NOT Raw Transmuted</td></tr>

</table>
</div>
