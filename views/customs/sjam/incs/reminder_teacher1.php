


<table class="vc200 table-fx table-altrow" >
	<tr><th colspan="2" ><span class="brown" >Reminders:</span></th></tr>
	<tr><th> > </th><td>Double check class records before finalizing - "Finalize" button.</td></tr>
	<?php if($_SESSION['qtr']==4): ?>
		<tr><th> > </th><td>Press Finalize (2x) to update Final Average.</td></tr>
	<?php endif; ?>

	<?php if(!empty($_SESSION['teacher']['advisories'])): ?>
		<tr><th> > </th><td>
			Ensure <span class="red">NO red boxes</span> <br />
			1) Spiral* 	<br />		
			2) Summarizer**  <br />	
			3) Print Report Cards  	
			
		</td></tr>	
	<?php endif; ?>
	
	<tr>
		<th> > </th>
		<td>
			Conducts
			<br />1) Classrooms > Tally
			<br />2) Attendance
			<br />3) Offenses
			<br />4) Process
		</td>
	</tr>
	

</table>