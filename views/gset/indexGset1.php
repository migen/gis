

<h5>
	GSET (GIS Setup)
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'gset/syncboard'; ?>" >Syncboard</a>
		
</h5>

<div class="accordParent" style="float:left;width:35%;" >	
<button onclick="accorToggle('gset')" style="width:274px;" class="bg-blue2" > 
	<p class="b f16" >GSET</p> </button>  	
	
<table id="gset" class="gis-table-bordered table-fx table-altrow" >
	<tr><td style="width:250px;" ><a href="<?php echo URL.'settings/all'; ?>" >Settings</a></td></tr>
	<tr><td style="width:250px;" >
		<a href="<?php echo URL.'cir'; ?>" >Class Index Report (CIR)</a>
		| <a href="<?php echo URL.'mca/locking/4'; ?>" >MCA</a>
	</td></tr>
	<tr><td>
	  <a href="<?php echo URL.'gset/levels'; ?>" >Levels</a>
	| <a href="<?php echo URL.'gset/sections'; ?>" >Sections</a>
	| <a href="<?php echo URL.'sections'; ?>" >Simple Sxns</a>
	</td></tr>
	<tr><td>
		<a href="<?php echo URL.'gset/classrooms'; ?>" >Classrooms</a>
		| <a href="<?php echo URL.'classrooms/level?all'; ?>" >Assign</a>	
	</tr>
	<tr><td><a href="<?php echo URL.'gset/teachers'; ?>" >Teachers</a>
		| <a href="<?php echo URL.'gset/setupTeachers'; ?>" >Setup</a>
	</td></tr>
	<tr><td><a href="<?php echo URL.'gset/students'; ?>" >Students</a>
		| <a href="<?php echo URL.'gset/setupStudents'; ?>" >Setup</a>
		| <a href="<?php echo URL.'students/links'; ?>" >Links</a>
	</td></tr>
	<tr><td><a href="<?php echo URL.'gset/subjects'; ?>" >Subjects</a>
		| <a href="<?php echo URL.'gset/setupSubjects'; ?>" >Setup</a>
	</td></tr>	
	
	<tr><td>
		  <a href="<?php echo URL.'courses/set'; ?>" >All Courses</a>
		| <a href="<?php echo URL.'gset/courses/4'; ?>" >Setup</a>
		| <a href="<?php echo URL.'courses/config/4'; ?>" >Config</a>
	</td></tr>	
	<tr><td><a href="<?php echo URL.'gset/criteria'; ?>" >Criteria</a></td></tr>	
	<tr><td>
		<a href="<?php echo URL.'gset/components/4'; ?>" >Components</a>
		| <a href="<?php echo URL.'components/setup/1'; ?>" >Setup</a>
	</td></tr>	

	<tr><td>
		<a href="<?php echo URL.'rosters/classroom'; ?>" >Class Roster</a>
		| <a href="<?php echo URL.'rosters/batch'; ?>" >Batch</a>
		| <a href="<?php echo URL.'rosters/batchByScid'; ?>" >SCID</a>
	</td></tr>		

	<tr><td>
		<a href="<?php echo URL.'setup/attmonths'; ?>" >Attd Days</a>
		| <a href="<?php echo URL.'setup/editMonthsQuarters'; ?>" >Months-Quarters</a>
	</td></tr>		

	<tr><td><a href="<?php echo URL.'gset/crs/4'; ?>" >Loads / Assignment</a></td></tr>	

	<tr><td>
		<a href="<?php echo URL.'gset/clubs'; ?>" >Clubs</a>
		| <a href="<?php echo URL.'gset/setupClubs'; ?>" >Setup</a>
	</td></tr>			

	<tr><td><a href="<?php echo URL.'gset/syncboard'; ?>" >Syncboard</a></td></tr>	
	
	
	<tr><td>&nbsp;</td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td>&nbsp;</td></tr>
	<tr><td><a href="<?php echo URL.'gset/truncateDummies'; ?>" >Truncate (Grades Activities Scores)</a></td></tr>
	<tr><td>Purge GIS (Trunc All)</td></tr>
	
</table>
</div>	<!-- left -->

<div style="float:left;width:35%;" >	<!-- body right -->


<?php 
	$incs = SITE."views/elements/accor_grades.php";include_once($incs); 
	
?>


</div>	<!-- third right -->
