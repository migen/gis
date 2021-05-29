<style>

select,input:not([type='submit']){ width:180px; }

</style>

<?php 

	$has_axis=$_SESSION['settings']['has_axis'];	
	extract($data);
	
?>

<?php 
	$sch=VCFOLDER;
	$clinks=SITE."views/customs/".VCFOLDER."/accor_registrar_{$sch}.php"; 
	if(is_readable($clinks)){ include_once($clinks); }
	
?>


<!-------------xxxxxxxx ---------->

<table class="enrollment accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('enrollment');" >REGISTRAR</th></tr>
	<tr><td class="vc250" >
		<input class="pdl05" id="part"   />
		<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart(limits);return false;" />		
	</td></tr>
	
	
<?php if($_SESSION['settings']['has_axis']): ?>
	<tr><td><a href="<?php echo URL.'files/read/enrollment'; ?>" >Enrollment Guide</a></td></tr>
	<tr><td class="" >
		  Enrollment  - <a target="_blank" href="<?php echo URL.'enrollment/report'; ?>" >Report</a> 	  
		  | <a target="_blank" href="<?php echo URL.'enrollment/level'; ?>" >Level</a> 	  
	</td></tr>	
<?php endif; ?>


<tr><td class="" >
  	  1) <a target="_blank" href="<?php echo URL.'students/leveler'; ?>" >Leveler</a> 	  
  	  | <a target="_blank" href="<?php echo URL.'students/sectioner'; ?>" >Sectioner</a> 	  
	  | <a href="<?php echo URL.'students/register'; ?>" >Register</a>	  	 
</td></tr>

<?php if($has_axis): ?>
	<tr><td class="" >
		  2) <a href="<?php echo URL.'students/assessment'; ?>" >Assessment</a>	  
	</td></tr>
<?php endif; ?>

<tr><td class="" >
	  3) <a href="<?php echo URL.'rosters/classroom'; ?>" >Classlist</a> (Roster)	  
</td></tr>

<tr><td class="" >
	  4) <a href="<?php echo URL.'studentpromotions/year'; ?>" >Student Promotions</a>	  
</td></tr>

<tr><td>&nbsp;</td></tr>

<tr><td>
	<a href='<?php echo URL."files/read/enrollment"; ?>' >Enrollment Guide</a>
</td></tr>
<tr><td>
	<a href='<?php echo URL."ensteps/student"; ?>' >Ensteps (student locking)</a>
</td></tr>
<tr><td>
	Schedules - 
	<a class="" href='<?php echo URL."schedules/ensteps"; ?>' >Rcards</a>
	| <a class="" href='<?php echo URL."schedules/ensteps"; ?>' >Ensteps</a>
</td></tr>

<tr><td>
	Schedules - 
	<a class="" href='<?php echo URL."schedules/tuitions"; ?>' >Tuitions</a>
	| <a class="" href='<?php echo URL."schedules/booklists"; ?>' >Booklists</a>
</td></tr>


<tr><td>&nbsp;</td></tr>


<tr><td><a class="b" href="<?php echo URL.'cir/index'; ?>" >*CLASS INDEX REPORTS (CIR)</a></td></tr>
<tr><td> 
<select class="vc200" onchange="jsredirect('mca/locking/'+this.value);" >
	<option value="0">Advisories & Courses</option>
	<?php foreach($levels AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select> &nbsp; Go
</td></tr>

<tr><td><a href="<?php echo URL.'codename/one'; ?>" >CodeName</a>
	| <a href="<?php echo URL.'registrars/filter'; ?>" >Filter</a>
	| <a href="<?php echo URL.'gradebook/classroom/1'; ?>" >Gradebook</a>
</td></tr>
<tr><td class="" >
	  <a href="<?php echo URL.'students/links'; ?>" >Links</a>

	<?php if($has_axis): ?>
		| <a href="<?php echo URL.'enrollees/official/'.DBYR; ?>" >Official</a>
	<?php endif; ?>
	| <a href="<?php echo URL.'ranks'; ?>" >Rankings</a>	  	  
</td></tr>
<tr><td class="" >
	<a href="<?php echo URL.'sy/level/4'; ?>" >SY Registered</a>	  
</td></tr>
<tr><td><a href="<?php echo URL.'clearance/one'; ?>" >Clearance Status</a></td></tr>
<tr><td><a href="<?php echo URL.'schedules/rcards'; ?>" >Rcard Schedule</a></td></tr>
<tr><td><a href="<?php echo URL.'employeeChild/status'; ?>" >Employee Child Status</a></td></tr>


<tr><td>
	<a href="<?php echo URL.'foundation/index/'.DBYR; ?>" >Foundation</a>
	| <a href="<?php echo URL.'shs'; ?>" >SHS</a>	
	| <a href="<?php echo URL.'transcripts/scid'; ?>" >Transcript</a>	
</td></tr>

<tr><td>
	Student Scores - <a href="<?php echo URL.'grades/scid/'; ?>" >Filter</a>
</td></tr>


<tr><td> 
<select class="" onchange="jsredirect('foundation/crid/'+this.value+'/'+sy);" >
	<option value="0">Foundation</option>
	<?php foreach($classrooms AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select> &nbsp; Go
</td></tr>



<?php if($_SESSION['settings']['trsgrades']==1): ?>
<tr><td>
<select class="" onchange="jsredirect('trs/matrix/'+this.value+'/'+sy+'/'+qtr);" >
	<option value="0">Traits Matrix</option>
	<?php foreach($classrooms AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select> 
</td></tr>
<?php endif; ?>


<?php if($_SESSION['settings']['has_clubs']): ?>
	<tr><th class="center" >- Clubs -</th></tr>
	<tr><td><a href="<?php echo URL.'clubs/all'; ?>" >Clubs list</a></td></tr>
<?php endif; ?>



<tr><td>&nbsp;</td></tr>
</table>
<br />

<script>
var limits="20";

$(function(){
	// $("#registrars").hide();	
})

function redirContact(ucid){
	var url = gurl + '/students/sectioner/' + ucid + '/' + sy;
	window.open(url);
	
}


</script>
<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
