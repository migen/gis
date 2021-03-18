<style>
	div{border:1px solid white;}

</style>

<h5>
	College
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'uni'; ?>" >Uni</a>
	
</h5>

<div style="float:left;width:35%" >


<table class="accordion college gis-table-bordered table-altrow" >
	<tr><th class="vc300 headrow center" onclick="accordionTable('college');" >College</th></tr>
	
	<tr><td>
		  <a href="<?php echo URL.'unicolleges'; ?>" >Colleges</a>
		| <a href="<?php echo URL.'majors'; ?>" >Majors</a>
		| <a href="<?php echo URL.'unilevels'; ?>" >Levels</a>	
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
		  <a href="<?php echo URL.'unistudents'; ?>" >College Student</a>
		| <a href="<?php echo URL.'professors'; ?>" >Professor</a>
		| <a href="<?php echo URL.'unidata/professors'; ?>" >List</a>
	</td></tr>	
	
	<tr><td>
		  <a href="<?php echo URL.'unicriteria'; ?>" >Criteria</a>
		| <a href="<?php echo URL.'unicomponents'; ?>" >Components</a>
	</td></tr>		
	
	
	
</table>
<br />


<table class="accordion enrollment gis-table-bordered table-altrow" >
	<tr><th class="vc300 headrow center" onclick="accordionTable('enrollment');" >Enrollment</th></tr>
	<tr><td>
		  <a href="<?php echo URL.'college/steps'; ?>" >Steps</a>
		| <a href="<?php echo URL.'uniregister/student'; ?>" >Register</a></td></tr>
		

</table>
<br />


<table class="accordion misc gis-table-bordered table-altrow" >
	<tr><th class="vc300 headrow center" onclick="accordionTable('misc');" > MISC </th></tr>
	<tr><td>
		  <a href="<?php echo URL.'unipromotions/scid/'; ?>" >Loads</a>
	</td></tr>	
	<tr><td>
		  <a href="<?php echo URL.'unischedules/major/1'; ?>" >Schedules</a>
	</td></tr>		
	
</table>
<br />

</div>	<!-- menus -->




<div style="float:left;width:30%" >
<h5>Tasks</h5>
<ol>
	<li>get array - crid / crs</li>
	<li>edit / promote students</li>
	<li>sync unisummaries</li>
	<li>custom profile for transcript</li>
	<li>gis clients schedules</li>
	<li>gogo portal</li>
	<li>course schedules</li>
	<li>attendance/crs</li>
	<li>access controls </li>
	<li>rest api json</li>
	<li>uni transcripts</li>
	<li>college rcard</li>
	<li>dbo-enrollments-studyears-transcript</li>
	<li>purge uni contact records</li>
	<li>ok - unisyncgrades</li>
	<li>contacts manager</li>
	<li>logs - lc,oc,</li>
	<li>ok - prof home</li>
	<li>stats</li>
	<li>ok - test prom k12-uni</li>
</ol>
</div>	<!-- tasks -->


<div class="full ht100" ></div>


<script>

$(function(){
	// accordion();
	// $('.accordion td').hide();
	
})


// function accordionTable(cls){ $("."+cls+" td").toggle(); }



</script>
