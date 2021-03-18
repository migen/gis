<style>

.btn-accordion{ height:32px;vertical-align:middle;
	font-size:0.9em;font-family: Arial,Helmet,Freesans,sans-serif; 
	text-decoration: none;font-color:red;padding: 2px 6px 2px 6px;
	box-shadow:1px 1px 1px 1px #ccc;
}

</style>


<table class="accordion college gis-table-bordered table-altrow" >
<thead>
	<tr><th class="btn-accordion vc250 headrow center" onclick="accordionTable('college');" >College</th></tr>
</thead>	
<tbody>	
	<tr><td>
		  <a href="<?php echo URL.'college'; ?>" >Home</a>
		| <a href="<?php echo URL.'unicolleges'; ?>" >Colleges</a>
		| <a href="<?php echo URL.'majors'; ?>" >Majors</a>
	</td></tr>	

	<tr><td>
		  <a href="<?php echo URL.'unilevels'; ?>" >Levels</a>	
		| <a href="<?php echo URL.'unisemesters'; ?>" >Semesters</a>	
	</td></tr>	
	
	<tr><td>
		<a href="<?php echo URL.'unisubjects'; ?>" >Subjects</a>	
		| <a href="<?php echo URL.'prerequisites'; ?>" >Prerequisites</a>
	</td></tr>
	
	<tr><td>
		  <a href="<?php echo URL.'unisections'; ?>" >Sections</a>
		| <a href="<?php echo URL.'uniclassrooms'; ?>" >Classrooms</a>
		| <a href="<?php echo URL.'uniadvisers/all'; ?>" >Advisers</a>
	</td></tr>	

	<tr><td>
		  <a href="<?php echo URL.'uniflowcharts'; ?>" >Flowcharts</a>
		| <a href="<?php echo URL.'unicourses'; ?>" >Courses</a>		
		| <a href="<?php echo URL.'unilocks'; ?>" >Locks</a>		
	</td></tr>	




	<tr><td>
		  <a href="<?php echo URL.'unistudents'; ?>" >Student</a>
		| <a href="<?php echo URL.'unidata/students'; ?>" >All</a>
		| <a href="<?php echo URL.'unipromoter/scid'; ?>" >Promoter</a>
	</td></tr>	
	
	<tr><td>
		  <a href="<?php echo URL.'professors'; ?>" >Professor</a>
		| <a href="<?php echo URL.'unidata/professors'; ?>" >List</a>
	</td></tr>	
	
	<tr><td>
		  <a href="<?php echo URL.'unicriteria'; ?>" >Criteria</a>
		| <a href="<?php echo URL.'unicomponents'; ?>" >Components</a>
	</td></tr>		
	

	<tr><td>Enrollment</td></tr>
	<tr><td>
		  <a href="<?php echo URL.'college/steps'; ?>" >Steps</a>
		| <a href="<?php echo URL.'uniregister/student'; ?>" >Register</a></td></tr>
	<tr><td>MISC</td></tr>
	<tr><td>
		  <a href="<?php echo URL.'unipromotions/scid/'; ?>" >Loads</a>
	</td></tr>	
	<tr><td>
		  <a href="<?php echo URL.'unischedules/major/1'; ?>" >Schedules</a>
	</td></tr>		
</tbody>	
</table>


<script>

function accordionTable(cls){ $("."+cls+" td").toggle(); }


</script>
