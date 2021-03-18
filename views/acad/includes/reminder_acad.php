<table class="vc200 table-fx table-altrow" >
	<tr><th colspan="2" ><span class="brown" >Reminders:</span></th></tr>
	<tr><th> > </th><td>Double check before finalizing all class records to minimize service tickets.</td></tr>
	<tr><th> > </th><td>Create a service ticket for any requests.</td></tr>
	<?php if($_SESSION['qtr']==4): ?>
		<tr><th> > </th><td>Press Sort > Update (2x).</td></tr>
	<?php endif; ?>

	<?php if(!empty($_SESSION['teacher']['advisories'])): ?>
		<tr><th> > </th><td><?php // pr($_SESSION['teacher']); ?>
			*Summarizer - always summarize genave when red box (TG) exists before printing Rpt Cards. 			
		</td></tr>	
	<?php endif; ?>
	
		
</table>