
<table class="syncboard accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('syncboard');" >Syncboard</th></tr>


	<tr><td style="width:250px;" ><a href="<?php echo URL.'cir'; ?>" >Class Index Report (CIR)</a></td></tr>

	<tr><td>
		Merge Duplicates (v5-20200603) <br />	
		1) <a href="<?php echo URL.'syncgrades/scid'; ?>" >Sync Grades <br /></a>
		2) <a href="<?php echo URL.'purge/one'; ?>" >Purge </a>
	</td></tr>	



	<tr><td>
		<a href="<?php echo URL.'syncers'; ?>" >Syncers</a>
		| <a href="<?php echo URL.'syncers/loop'; ?>" >Loop</a>
	</td></tr>	

	<tr><td>
		<a href="<?php echo URL.'booklists/sync'; ?>" >Sync Booklist Lvl</a>
	</td></tr>	

	<tr><td>
		<a href="<?php echo URL.'syncs/syncCQ'; ?>" >Init / Sync Course Locking</a>
	</td></tr>	

	<tr><td>
	   <a href="<?php echo URL.'syncs/syncAQ'; ?>" >Init / Sync Classroom Locking</a>	
	</td></tr>	

	<tr><td>
		<a href="<?php echo URL.'syncs/syncAttendance'; ?>" >Init / Sync Attendance Locking</a>	
	</td></tr>	
	
	<tr><td>
		<a href="<?php echo URL.'syncs/syncCQ'; ?>" >Crs-Qtrs</a>
	 |	<a href="<?php echo URL.'syncs/syncAQ'; ?>" >Adv-Qtrs</a>	
	 |	<a href="<?php echo URL.'syncs/syncAttendance'; ?>" >Attd</a>	
	</td></tr>	

	<tr><td>
		<a href="<?php echo URL.'syncs/promlvl'; ?>" >Promlvl</a>
	 |	<a href="<?php echo URL.'syncs/currlvl'; ?>" >Currlvl</a>	
	</td></tr>			

	<tr><td>
		<a href="<?php echo URL.'syncs/syncProfles'; ?>" >Profiles</a>
	 |	<a href="<?php echo URL.'syncs/syncCtp'; ?>" >CTP</a>	
	 |	<a href="<?php echo URL.'syncs/syncPhotos'; ?>" >Photos</a>	
	</td></tr>			

	<tr><td>
		<a href="<?php echo URL.'syncs/syncCalendar'; ?>" >Calendar</a>
	 |	<a href="<?php echo URL.'syncs/syncAwardeesAll'; ?>" >Awardees</a>	
	 |	<a href="<?php echo URL.'syncs/syncPromotions'; ?>" >Promotions</a>	
	</td></tr>				

	<tr><td>
		<a href="<?php echo URL.'tools'; ?>" >Tools</a>
	 |	<a href="<?php echo URL.'tools/upname'; ?>" >UPName | Prnt</a>	
	 |	<a href="<?php echo URL.'query/bdayPass'; ?>" >Bday Pass</a>	
	</td></tr>				
	
	<tr><td>
		<a href="<?php echo URL.'syncs/syncAll/'.DBYR; ?>" >Sync All/<?php echo DBYR; ?></a>
	</td></tr>					

	<tr><td> <a href="<?php echo URL.'files/read/transition'; ?>" >New SY Transition</a></td></tr>
	<tr><td><a href="<?php echo URL.'syncs/patronStats'; ?>" >Patron Stats</a></td></tr>

	
	<tr><td>
		<a href="<?php echo URL.'syncs/syncEnrollments/'.DBYR; ?>" >Enrollments</a>
	 |	<a href="<?php echo URL.'syncs/syncSS'; ?>" >Summaries</a>	<br />
	    <a href="<?php echo URL.'syncs/syncSummext'; ?>" >Summext</a>	
	 |  <a href="<?php echo URL.'syncs/syncTuitionSummaries'; ?>" >Tsum</a>	 
	</td></tr>					

	<tr><td>
		<a href="<?php echo URL.'syncs/payables/'.$_SESSION['year']; ?>" >Payables</a>
	</td></tr>					

	<tr><td>
		<a href="<?php echo URL.'enrollments/sync'; ?>" >Transcript-Enrollments Sync</a>
	</td></tr>					
	<tr><td>
		<a href="<?php echo URL.'enrollments/loopsync/'; ?>" >Enrollments Loopsync</a>
	</td></tr>					
	
	<tr><td>
		Q<?php echo $qtr; ?> - <a href="<?php echo URL.'locking/closeCQ/'.$qtr; ?>" >Lock Crs</a>
	 | <a href="<?php echo URL.'locking/closeAQ/'.$qtr; ?>" >Lock Classrooms </a>
	</td></tr>			

	<tr><td>
		Q<?php echo $qtr; ?> - <a href="<?php echo URL.'locking/openCQ/'.$qtr; ?>" >Open Crs</a>
	 | <a href="<?php echo URL.'locking/openAQ/'.$qtr; ?>" >Open Classrooms </a>
	</td></tr>				

	<tr><td>
		Q<?php echo $qtr; ?> - <a href="<?php echo URL.'locking/openAttd/'.$qtr; ?>" >Open Attd</a>
	 | <a href="<?php echo URL.'locking/openAttd/'.$qtr; ?>" >Close Attd</a>
	</td></tr>					
	
	<tr><td>
		Q<?php echo $qtr; ?> - <a href="<?php echo URL.'acad/unlockAll?qtr='.$qtr; ?>" >Open Crs & Classrooms</a>
	</td></tr>					

	<tr><td>
		Q<?php echo $qtr; ?> - <a href="<?php echo URL.'acad/lockAll?qtr='.$qtr; ?>" >Lock Crs & Classrooms</a>
	</td></tr>						
	

<?php if($qtr>3): ?>
	<tr><th>-- Yearend --</th></tr>	
	<tr><td><a href="<?php echo URL.'averages'; ?>" >Averages (Q4)</a></td></tr>	
	<tr><td><a href="<?php echo URL.'yearend/promotions'; ?>" >Safe - PromCrid/Lvl</a></td></tr>	
	<tr><td>
		Tally Yearend Attd - 
		<?php if($_SESSION['settings']['attd_qtr']==1): ?>
			<a href="<?php echo URL.'yearendAttd/quarterly'; ?>" >Quarterly</a>		
		<?php else: ?>
			<a href="<?php echo URL.'yearendAttd/monthly'; ?>" >Monthly</a>		
		<?php endif; ?>
	</td></tr>
	
<?php endif; ?>		<!-- qtr>3-->
	
	<tr><td>&nbsp;</td></tr>
	<tr><td>---Customs---</td></tr>
	<tr><td><a href="<?php echo URL.'syncoffenses/all'; ?>" >Sync Offenses</a></td></tr>	

	<tr><td>Purge GIS (Trunc All)</td></tr>

</table>



