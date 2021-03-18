<?php $spacerwidth="0.5in"; ?>

<table class="nogis-table-bordered full" >
<tr><td>LRN <span class="b" ><?php echo $student['lrn']; ?></span></td></tr>
<tr>
	<td>
	STUDENT NO. <span class="b" ><?php echo $student['code']; ?></span>
	<span style="padding-right:<?php echo $spacerwidth; ?>;" >&nbsp;</span>
	NAME &nbsp;&nbsp; <span class="b" style="font-size:1.2em;" >
		<a class="txt-black no-underline" href="<?php echo URL.'rcards/scid/'.$student['scid']; ?>" ><?php echo $student['name']; ?></a></span>	
	<span style="padding-right:<?php echo $spacerwidth; ?>;" >&nbsp;</span>
	GRADE & SECTION &nbsp;&nbsp;
		<span class="b" ><?php echo $classroom['level'].' - '.$classroom['section']; ?></span>	
	</td>
</tr>
</table>

