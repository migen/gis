<?php 



?>



<div class="divright" >

<!-- schinfo -->
<table class="nogis-table-bordered center schfont tblwidth" >
	<tr><th><span class="schname" ><br />ST. JAMES ACADEMY</span></th></tr>
	<tr><td class="h5" >City of Malabon</td></tr>
	<tr><td class="h5" >PAASCU LEVEL II ACCREDITED</td></tr>
	<tr><th>&nbsp;</th></tr>
	<tr><th><img src="<?php echo $logo_src; ?>" alt="logo" height="220" width="210"></th></tr>
	<tr><th>&nbsp;</th></tr>
	<tr><th class="h5" ><?php echo ($classroom['level']); ?></th></tr>
	<tr><th class="h5" >Progress Report Card</th></tr>
	<tr><th class="h5" >SY <?php echo $sy.'-'.($sy+1); ?></th></tr>
</table>


<!-- studinfo -->
<p>&nbsp;</p>
<div class="center" >
<table class="nogis-table-bordered-print tblstud" >
	<tr><td class="studkey" >Name</td><td><?php echo $student['student']; ?></td></tr>		
	<tr><td class="" >Section</td><td><?php echo $classroom['section']; ?></td></tr>		
	<tr><td class="" >Teacher</td><td><?php echo $classroom['adviser']; ?></td></tr>		
	
	<tr><td class="" >Date of Birth</td><td class="" ><?php echo $student['birthdate']; ?></td></tr>
	<tr><td class="" >Sex</td><td class="" ><?php echo ($student['is_male']==1)? 'Male':'Female'; ?></td></tr>
	<?php $ar=getAgeYM($student['birthdate']); ?>
	<tr><td colspan=2>Age of child at the End of the School Year</td></tr>
	<tr><td colspan=2 >
		Years: __<span class="u" ><?php echo $ar['yrs']; ?></span>__ &nbsp;&nbsp; 
		Months: __<span class="u" ><?php echo $ar['mos']; ?></span>__		
	</td></tr>				
</table>
</div>	<!-- studinfo table -->
		
</div>


