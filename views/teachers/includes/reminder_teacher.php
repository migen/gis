<table class="vc200 table-fx table-altrow" >
	<tr><th colspan="2" ><span class="brown" >Reminders:</span></th></tr>
	<tr><th> > </th><td>Double check class records before finalizing - "Finalize" button.</td></tr>
	<?php if($_SESSION['qtr']==4): ?>
		<tr><th> > </th><td>Press Finalize (2x) to update Final Average.</td></tr>
	<?php endif; ?>

	<?php if(!empty($_SESSION['teacher']['advisories'])): ?>
		<tr><th> > </th><td>			
			*Summarizer - must "Summarize" genave when any red box (TG) exists before printing Rpt Cards. 			
		</td></tr>	
	<?php endif; ?>
	
	<?php if($_SESSION['settings']['trsgrades']==1): ?>
		<tr><th> > </th><td>Has <?php echo $_SESSION['settings']['trs']; ?></td></tr>	
	<?php endif; ?>		
</table>