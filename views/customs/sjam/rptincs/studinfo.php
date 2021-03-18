


<table class="vc700 tf16 notable-bordered" >
<tr id="<?php echo $student['scid']; ?>" ondblclick="alert(this.id);" 
><td colspan=2 class="left" >Name :<span class="u" ><?php echo $student['student']; ?></span></td></tr>
<tr><td class="left" >Student No. <span class="u" ><?php echo $student['student_code']; ?></span></td>
<td class="left" >LRN <span class="u" ><?php echo $student['lrn']; ?></span></td></tr>

<tr><td colspan=2 class="left" >Address :<span class="u" ><?php echo $student['address']; ?></span></td></tr>
<tr><td colspan=2 class="left" >
	Grade & Section: <span class="u" ><?php echo $student['level'].'-'.$student['section']; ?></span>
</td></tr>

<tr><td colspan=2 style="padding-bottom:6px;" class="left" >School Year :<span class="u" ><?php echo $sy.' - '.($sy+1); ?></span></td></tr>
</table>

