<table class="gset accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('gset');" >GSET &nbsp;&nbsp; </th></tr>

	<tr><td> <a href="<?php echo URL.'files/read/transition'; ?>" >New SY</a>
	| <a href="<?php echo URL.'setup'; ?>" >Setup</a>
	| <a href="<?php echo URL.'gset'; ?>" >GSET</a>
	</td></tr>

	<tr><td>
		<a href="<?php echo URL.'cir'; ?>" >Class Index Report (CIR)</a>
		| <a href="<?php echo URL.'mca/locking/4'; ?>" >MCA</a>
	</td></tr>

	<tr><td>
		<a href="<?php echo URL.'batch/update'; ?>" >Batch Update</a>
		| <a href="<?php echo URL.'batch/setfield'; ?>" >Setfield</a>
	</td></tr>


	<tr><td>
		Courses <a href="<?php echo URL.'courses/byLevel'; ?>" >Level</a>
		| <a href="<?php echo URL.'courses/byClassroom'; ?>" >Classroom</a>
	</td></tr>


	
	<tr><td>
	  <a href="<?php echo URL.'contacts'; ?>" >Contacts</a>
	| <a href="<?php echo URL.'names/level/4'; ?>" >Names</a>
	</td></tr>	
	
	<tr><td>
	  <a href="<?php echo URL.'gset/levels'; ?>" >Levels</a>
	| <a href="<?php echo URL.'gset/sections'; ?>" >Sections</a>
	| <a href="<?php echo URL.'gset/classrooms'; ?>" >Classrooms</a>	
	</td></tr>

	<tr><td>
		<a href="<?php echo URL.'gset/subjects'; ?>" >Subjects</a>
		| <a href="<?php echo URL.'gset/courses'; ?>" >Courses</a>	
	</td></tr>	
	<tr><td>
		  <a href="<?php echo URL.'gset/criteria'; ?>" >Criteria</a>	
		  <a href="<?php echo URL.'gset/components/4'; ?>" >Components</a>
	</td></tr>	

	<tr><td><a href="<?php echo URL.'gset/teachers'; ?>" >Teachers</a>
		| <a href="<?php echo URL.'setup/contacts'; ?>" >Employees</a>
	</td></tr>
	
	<tr><td>	
		<a href="<?php echo URL.'gset/students'; ?>" >Students</a>
		| <a href="<?php echo URL.'rosters/classroom'; ?>" >Classlist <br />(Roster) / Batch</a>		
	</td></tr>
	<tr><td>	
		<a href="<?php echo URL.'grades'; ?>" >Grades</a>
	</td></tr>
		
	<tr><td>--------</td></tr>
	

	<tr><td>
		<a href="<?php echo URL.'setup/attmonths'; ?>" >Attd Days</a>
		| <a href="<?php echo URL.'setup/editMonthsQuarters'; ?>" >Months-Quarters</a>
	</td></tr>		

	<tr><td>
		  <a href="<?php echo URL.'gset/crs/4'; ?>" >Loads</a>
		| <a href="<?php echo URL.'courses/teachers?lvl=4'; ?>" >Simple</a>	
		| <a href="<?php echo URL.'loads/teacher'; ?>" >Teacher</a>	
	</td></tr>	

	<tr><td>
		<a href="<?php echo URL.'gset/clubs'; ?>" >Clubs</a>
		| <a href="<?php echo URL.'gset/setupClubs'; ?>" >Setup</a>
	</td></tr>			

	<tr><td>
		<a href="<?php echo URL.'gset/syncboard'; ?>" >Syncboard</a>
		| <a href="<?php echo URL.'settify'; ?>" >Zerofy (Settify)</a>	
	</td></tr>	

<?php if($_SESSION['settings']['has_axis']==1): ?>
	<tr><td><a href="<?php echo URL.'ledgers/setup'; ?>" >Class Ledgers</a></td></tr>
<?php endif; ?>	
	
	<tr><td>&nbsp;</td></tr>
	<tr><td><a href="<?php echo URL.'gset/truncateDummies'; ?>" >Trunc Grades-Actvt-Scores</a></td></tr>
	<tr><td>Purge GIS (Trunc All)</td></tr>

</table>

<br />

<table class="setup accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('setup');" >Grades Setup</th></tr>



<tr><td class="b" ><a href="<?php echo URL.'syncers'; ?>" >9) Grades Syncer</a></td></tr>
<tr><td><a href="<?php echo URL.'setup/attmonths'; ?>" >10) Attendance Months Days</a></td></tr>
<tr><td>11) Promotions - 
	  <a href="<?php echo URL.'misc/openAllPromotions'; ?>" >Open</a>
	| <a href="<?php echo URL.'misc/closeAllPromotions'; ?>" >Close</a>
</td></tr>
<tr><td class="b" >
	 <a href="" >12) Sync Students (c.crid) </a><br />
	| <a href="<?php echo URL.'settify/initSummaries/'.PDBG.'.05_summaries'; ?>" >Qry Init Summaries</a>

</td></tr>
<tr><td><a href="<?php echo URL.'gtools/msg'; ?>" >13) Move Student Grades (MSG)</a></td></tr> 
<tr><td>
	Qry | <a href="<?php echo URL.'scripts/proma/'.DBYR; ?>" >Proma / Promote All-TMP</a>
</td></tr>
<tr><td>
	Qry | <a href="<?php echo URL.'proma/sy'.DBYR; ?>" >New Proma <?php echo DBYR; ?></a>
</td></tr>
<tr><td><a href="<?php echo URL.'syncers/loop'; ?>" >15) Loop Syncer</a></td></tr>
<tr><td><a href="<?php echo URL.'misc/propagateSubjects'; ?>" >16) Propagate Subjects</a></td></tr>
<tr><td>
<a href="<?php echo URL.'data/loading'; ?>" >17) Loading</a>
<?php if($_SESSION['settings']['trsgrades']==1): ?>
| <a href="<?php echo URL.'data/trsTeachers'; ?>" >Traits Teachers</a>
<br /><a href="<?php echo URL.'loads/crlist'; ?>" >Loads Crlist</a>
<?php endif; ?>
</td></tr>

<tr><td>18) 
  <a href="<?php echo URL.'data/traits'; ?>" >TraitsLevel</a>
  | <a href="<?php echo URL.'setup/traits'; ?>" >Setup Traits</a>
</td></tr>
<tr><td>19) 
  <a href="<?php echo URL.'legends/equivalents?ctype=1'; ?>" >Transmutation / Equivalents</a>
</td></tr>

<tr><td>19) 
	<a href="<?php echo URL.'legends/descriptions?ctype=1'; ?>" >DG / Descriptions</a>
</td></tr>

<tr><td>20) 
   <a href="<?php echo URL.'courses/index'; ?>" >Courses Settings</a>
 | <a href="<?php echo URL.'courses/config'; ?>" >Config</a>  
</td></tr>


<tr><td>22) 
   <a href="<?php echo URL.'gset/crs/4'; ?>" >Teachers</a>
 | <a href="<?php echo URL.'courses/teachers?lvl=4'; ?>" >Loads</a>
 | <a href="<?php echo URL.'stats/noloads'; ?>" >No Loads</a>
</td></tr>

<tr><td>23) 
   <a href="<?php echo URL.'submissions/report?qtr='.$_SESSION['qtr']; ?>" >All Submissions Report</a>
</td></tr>

<tr><td>24) <a href="<?php echo URL.'sac/sacs/2/'.$sy; ?>" >Subject Area Coors (SAC)</a></td></tr>
<tr><td>25) <a href="<?php echo URL.'misc/dgtl/4'; ?>" >DG Traits-Criteria by Level</a></td></tr>
<tr><td>--- Utils Misc ---</td></tr>
<tr><td>26) <a href="<?php echo URL.'misc/cleanScores'; ?>" >Clean Scores</a></td></tr>
<tr><td>27) <a href="<?php echo URL.'crsMis/codename'; ?>" >Crs Codename</a></td></tr>
<tr><td>27) <a href="<?php echo URL.'crsMis/config'; ?>" >Crs Config</a></td></tr>
<tr><td>28) <a href="<?php echo URL.'syncs/syncSummariesAcid'; ?>" >Sync Summaries Acid</a></td></tr>
<tr><td>
	<a href="<?php echo URL.'grades/scid'; ?>" >Student Scores Filter</a>	
</td></tr>

<tr><td>
	Filter - <a href="<?php echo URL.'courses/filter'; ?>" >Course</a>
	| <a href="<?php echo URL.'scores/filter'; ?>" >Scores</a>	
</td></tr>



<tr><td>&nbsp;</td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><a href="<?php echo URL.'schedules/rcards'; ?>" >Rcard Schedule</a></td></tr>


<tr><td>&nbsp;</td></tr>
</table>





