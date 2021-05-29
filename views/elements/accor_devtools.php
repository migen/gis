<?php 

	
?>




<table class="tools accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('tools');" >Tools</th></tr>	
		

	<tr><td class="vc250" >
		<a href='<?php echo URL."tests/levelCrid/4/".DBYR; ?>' >*Level Crid</a>
	</td></tr>
	
	<tr><td><a href='<?php echo URL."syncaxis/showTfeedetails/".$_SESSION['year']; ?>' >Show Tfeedetails</a></td></tr>
	<tr><td><a href='<?php echo URL."classfees/level/4/".$_SESSION['year']; ?>' >Classfees</a></td></tr>
	
	<tr><td>
		<a  href='<?php echo URL."tests/levelCrid/4/".DBYR; ?>' >*Level Crid</a>
		| <a href='<?php echo URL."students/encrid"; ?>' >Student Encrid</a>	
	</td></tr>
	<tr><td>&nbsp;</td></tr>

</table>

<br>

<table class="dev accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('dev');" >Dev</th></tr>	


	<tr><td>
		<a href="<?php echo URL.'abc'; ?>" >Abc</a>
		| <a href="<?php echo URL.'mini'; ?>" >Mini</a>
	</td></tr>

	<tr><td>
		<a href="<?php echo URL.'ensteps/student'; ?>" >Ensteps</a>
	</td></tr>


	<tr><td>
		<a href="<?php echo URL.'syncs/levelConductsToSummaries/14/'.DBYR.'/'.$_SESSION['qtr'].'&debug'; ?>" >SyncCondSumm - G11</a>
		| <a href="<?php echo URL.'syncs/levelConductsToSummaries/15/'.DBYR.'/'.$_SESSION['qtr'].'&debug'; ?>" >G12</a>
	</td></tr>


	<tr><td>
		<a href="<?php echo URL.'studentpromotions/year'; ?>" >Student promotions</a>
	</td></tr>

	<tr><td>
		<a href="<?php echo URL.'promlevels/year'; ?>" >Promotion Level</a>
	</td></tr>

	<tr><td>
		<a href="<?php echo URL.'genave/shsLevels'; ?>" >SHS Level Genave Index</a>
	</td></tr>

	<tr><td>
		<a href="<?php echo URL.'classroomLevel/index'; ?>" >Classroom Level Index</a>
	</td></tr>

	<tr><td>
		<a href="<?php echo URL.'audit/trails'; ?>" >Audit Trails</a>
	</td></tr>
	<tr><td>
		<a href="<?php echo URL.'clearance/one'; ?>" >Clearance Status</a>
	</td></tr>
	<tr><td>
		Schedules - <a href="<?php echo URL.'schedules/rcards'; ?>" >Rcard</a>
		| <a href="<?php echo URL.'schedules/ensteps'; ?>" >Ensteps</a>
	</td></tr>

	<tr><td>
		  <a href="<?php echo URL.'fix/lsa'; ?>" >Juxtapose (Lvl Single Aggregate)</a>
	</td></tr>

	<tr><td>
		<a href="<?php echo URL.'components'; ?>" >Components</a>
		| <a href="<?php echo URL.'components/scripts'; ?>" >Scripts</a>
		| <a href="<?php echo URL.'components/roots'; ?>" >Roots</a>
	</td></tr>

	<tr><td>
		<a href="<?php echo URL.'datasheets/crid'; ?>" >Datasheets Directory </a>
	</td></tr>


	<tr><td>
		Components <a href="<?php echo URL.'components/crid/'; ?>" >Classroom</a>
	</td></tr>

	<tr><td>
		Courses <a href="<?php echo URL.'courses/byLevel'; ?>" >Level</a>
		| <a href="<?php echo URL.'courses/byClassroom'; ?>" >Classroom</a>
	</td></tr>

	<tr><td>
		<a href='<?php echo URL."cdt/index"; ?>' >Conduct Tally Index</a>	
	</td></tr>


	<tr><td>
		<a href='<?php echo URL."ranks"; ?>' >Rankings</a>	
	</td></tr>

	<tr><td>
		<a href='<?php echo URL."conducts/editOne"; ?>' >Conducts One</a>	
	</td></tr>

	<tr><td>
		<a href='<?php echo URL."rosters/rollback"; ?>' >Rollback</a>	
		| <a href='<?php echo URL."rosters/drafter"; ?>' >Drafter</a>			
	</td></tr>


	<tr><td>
		<a href='<?php echo URL."data/traits/4"; ?>' >Traits by Level</a>	
	</td></tr>

	<tr><td>
		<a href='<?php echo URL."sy/level/4"; ?>' >SY Registered</a>	
	</td></tr>


	<tr><td>
		<a href='<?php echo URL."employeeChild/status"; ?>' >Employee Chiid Status</a>	
	</td></tr>

	<tr><td>
		<a href='<?php echo URL."prevbal"; ?>' >Previous Balance</a>	
	</td></tr>

	<tr><td>
		<a href="<?php echo URL.'pupils/rfid'; ?>" >RFID</a>
	</td></tr>


	<tr><td>
		<a href='<?php echo URL."prevbal/level/11"; ?>' >Prevbal Level (PBL)</a>	
	</td></tr>

	<tr><td>
		<a href='<?php echo URL."students/reps"; ?>' >Sample Reps</a>	
	</td></tr>


	<tr><td>
		<a href='<?php echo URL."syncContacts/sy/".$_SESSION['settings']['sy_enrollment']; ?>' >Sync SY <?php echo $_SESSION['settings']['sy_enrollment']; ?></a>	
	</td></tr>
	
	
	<tr><td>
		<a href='<?php echo URL."students/register"; ?>' >Register</a>	
		| <a href='<?php echo URL."students/leveler"; ?>' >Leveler</a>	
		| <a href='<?php echo URL."students/sectioner"; ?>' >Sectioner</a>	
	</td></tr>


	
	<tr><td>
		<a href='<?php echo URL."students/bills"; ?>' >Bills</a>
		| <a href='<?php echo URL."enrollment/ledger"; ?>' >Ledger</a>	
		| <a href='<?php echo URL."ornos/view"; ?>' >Orno</a>	
	</td></tr>	

	<tr><td><a href='<?php echo URL."tuitions/syncTuitionAmount"; ?>' >Sync Tuition Amount</a></td></tr>
	<tr><td>
		Enrollment - 
		<a href='<?php echo URL."enrollment/report"; ?>' >Payments</a>
		| <a href='<?php echo URL."enrollment/level"; ?>' >Level</a>
	</td></tr>

	<tr><td>
		<a href='<?php echo URL."booklists"; ?>' >Booklists</a>
		| <a href='<?php echo URL."tuitions/table"; ?>' >Tuitions</a>			
	</td></tr>

	
	<tr><td>
		Student - <a href='<?php echo URL."students/datasheet"; ?>' >Datasheet</a>
		| <a href='<?php echo URL."students/booklist"; ?>' >Booklist</a>
	</td></tr>	
	
	<tr><td>
		Students - <a href='<?php echo URL."students/logbooks"; ?>' >Logs</a>
		| <a href='<?php echo URL."students/level"; ?>' >Level</a>
	</td></tr>	

	<tr><td>
		<a href='<?php echo URL."students/registered/".$_SESSION['settings']['sy_enrollment']; ?>' >New Students</a>
	</td></tr>	
	
	
	<tr><td>
		<a href='<?php echo URL."data/nocrid"; ?>' >No Crid</a>
		| <a href='<?php echo URL."data/students"; ?>' >All Students</a>
	</td></tr>	

		
	<tr><td>
		<a href='<?php echo URL."finance"; ?>' >Finance</a>	
		| <a href='<?php echo URL."finance/search"; ?>' >Search</a>	
		| <a href='<?php echo URL."enrollment/paydates/".$_SESSION['year']; ?>' >Paydates</a>	
	</td></tr>

	<tr><td>
		Reports - <a href='<?php echo URL."payments/report"; ?>' >Payments</a>	
		| <a href='<?php echo URL."payables/report"; ?>' >Payables</a>	
	</td></tr>

	<tr><td>
		Setup - 
		<a href='<?php echo URL."payments/setup"; ?>' >Payments</a>	
	</td></tr>

	<tr><td>
		Payables - 
		<a href='<?php echo URL."payables/setup"; ?>' >Setup</a>	
		| <a href='<?php echo URL."payables/batch"; ?>' >Batch</a>	
		| <a href='<?php echo URL."syncPayables/batchUpdate"; ?>' >Update</a>	
	</td></tr>

	<tr><td>
		<a href='<?php echo URL."families"; ?>' >Families</a>	
		| <a href='<?php echo URL."ornos/booklet"; ?>' >OR Booklet</a>	
		| <a href='<?php echo URL."students/paymode"; ?>' >Paymode</a>	
	</td></tr>

	<tr><td>
		<a href='<?php echo URL."enrollees/official"; ?>' >Enrollees</a>	
	</td></tr>


	
	<tr><td>
		<a href='<?php echo URL."syncs/payables/".DBYR."/4/1"; ?>' >Sync Payables</a>
		| <a href='<?php echo URL."feetypes/table"; ?>' >Feetypes</a>
	</td></tr>

	
	<tr><td><a href='<?php echo URL."classfees/level/4/".$_SESSION['year']; ?>' >Classfees</a></td></tr>

	<tr><td>&nbsp;</td></tr>
	
</table>

