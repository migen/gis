<?php $spacerwidth="0.5in"; ?>

<table class="no-gis-table-bordered full" >
<tr>
	<td>	
	NAME: <span class="b" style="font-size:1.2em;" ><?php echo $student['name']; ?></span>	
	&nbsp;&nbsp;&nbsp; 
	STUDENT NO.: <span class="b" ><?php echo $student['code']; ?></span>	
	<span style="padding-right:<?php echo $spacerwidth; ?>;" >&nbsp;</span>
	GRADE & SECTION &nbsp;&nbsp;
		<span class="b" ><?php echo $classroom['name']; ?></span></td>
</tr>
<tr>
	<td><span class="b" >LEARNER REFERENCE NO</span>.: <?php echo $student['lrn']; ?></td>
</tr>
</table>