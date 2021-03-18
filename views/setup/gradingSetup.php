<style>


</style>


<?php 

// pr($_SESSION);

$nsy = $sy+1;

?>


<!---------------------------------------------------------------------------------------------------------->

<h5>
	Setup Checklist 
	| <a href="<?php echo URL.'mis/index/'.$sy; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	| <a href="<?php echo URL.'gset'; ?>" >GSET</a>	
	| <a href="<?php echo URL.'dashboard/mis/'.$sy; ?>" >Dashboard</a>	
	| <a href="<?php echo URL.'mis/dbpanel'; ?>" >DB Panel</a>	
	| <a href="<?php echo URL.'mis/dbx/g/'.$sy; ?>" >DBG</a>	
		
</h5>


<!------ tracelogin ----------------------------------------->
	<?php $this->shovel('hdpdiv'); ?>


<div class="third" > 

<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" ><th class="vc300 white" > Grading </th></tr>


<tr><td class="vc300" > <a href="<?php echo URL.'mis/levels/'.$sy; ?>" > Levels - Courses, Components, Classrooms, Teachers </a></td></tr>
<tr><td> <a href="<?php echo URL.'misc/setupCourses'; ?>" >Courses</a></td></tr>
<tr><td> <a href="<?php echo URL.'misc/subjects/'.$sy; ?>" >Subjects</a></td></tr>
<tr><td> <a href="<?php echo URL.'sac/sacs/2/'.$sy; ?>" >Subject Area Coors (SAC)</a></td></tr>
<tr><td> 
	  <a href="<?php echo URL.'mis/descriptions/'.$sy; ?>" >Descriptive Grades</a>
	| <a href="<?php echo URL.'legends/descriptions?ctype=1'; ?>" >Setup</a>
</td></tr>
<tr><td>
	  <a href="<?php echo URL.'lookups/equivalents/'.$sy; ?>" > Equivalents (Transmutation)</a>
	| <a href="<?php echo URL.'legends/descriptions?ctype=1'; ?>" >Setup</a>	   
</td></tr>
<tr><td> <a href="<?php echo URL.'tmpGrades/crNumToMajor'; ?>" >CR Num-Major ID</a></td></tr>
<tr><td> <a href="<?php echo URL.'mis/purger'; ?>" >Purger</a></td></tr>
<tr><td> <a href="<?php echo URL.'mis/defvals'; ?>" >Default Values</a></td></tr>
<tr><td> <a href="<?php echo URL.'tools/upname'; ?>" >Tools:User Parent Name</a></td></tr>
<tr><th> <a href="<?php echo URL.'gtools/msg'; ?>" > Move Student Grades </a>  <br />Replaced TSG</th></tr>
<tr><th> <a href="<?php echo URL.'setup/editMonthsQuarters/'.$sy; ?>" >GIS Months Quarters (ATTD)</th></tr>
<tr><th> <a href="<?php echo URL.'morals/syncAwardeesAll'; ?>" > Sync Awardees </th></tr>
</table>

<!---------------------------------------------------------------------------------->

<p>&nbsp;</p>

<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" ><th class="vc300 white" > General </th></tr>
<tr><td>
<select class="vc200" onchange="redirCalendar(this.value);" >
	<option> Attendance Calendar </option>
	<?php foreach($months AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select> &nbsp; Go
</td></tr>
<tr><td> <a href="<?php echo URL.'announcements/index/1?sy='.$sy; ?>" > Announcements </a> </td></tr>
<tr><td> <a href="<?php echo URL.'setup/attmonths/'.$sy; ?>" > Attendance Months </a></td></tr>
<tr><td> <a href="<?php echo URL.'mis/attschemas/'.$sy; ?>" > Attendance Schemas </a></td></tr>
<tr><td class="vc300" ><a href="<?php echo URL.'mis/dbCleanPage'; ?>" > DB Clean Page </a></td></tr>
<tr><td class="vc300" ><a href="<?php echo URL.'mis/dbpanel/dbgis_'.VCFOLDER; ?>" > DB Panel </a></td></tr>

<tr><td><a href="<?php echo URL.'mis/duplicates/'.$sy; ?>" > Duplicates </a></td></tr>
<tr><td><a href="<?php echo URL.'mis/actions/'.$sy; ?>" > Log Actions </a></td></tr>
<tr><td><a href="<?php echo URL.'img/jpg'; ?>" >Photo Download as JPEG (ucid)</a></td></tr>
<tr><td><a href="<?php echo URL.'mis/roles/'.$sy; ?>" > Roles </a></td></tr>
<tr><td><a href="<?php echo URL.'circles/'.$sy; ?>" > Circles </a></td></tr>
<tr><td><a href="<?php echo URL.'rooms/'.$sy; ?>" > Rooms </a></td></tr>
<tr><td><a href="<?php echo URL.'mis/titles/'.$sy; ?>" > Job Titles </a></td></tr>
<tr><td><a href="<?php echo URL.'tools'; ?>" >Tools</a></td></tr>
<tr><td><a href="<?php echo URL.'mis/batchDeleteFees'; ?>" >Batch Delete Fees Query</a></td></tr>
<tr><td><a href="<?php echo URL.'mis/resetCourseNames'; ?>" >Reset Course Names</a></td></tr>
<tr><td><a href="<?php echo URL.'mis/tuitionTypes/'.$sy; ?>" > Tuition Types </a></td></tr>
<tr><td><a href="<?php echo URL.'mis/trunker'; ?>" > Trunker </a></td></tr>
<tr><td><a href="<?php echo URL.'mis/zerofyTsum'; ?>" >Zerofy Tsum</a></td></tr>
<tr><td><a href="<?php echo URL.'tools/enye'; ?>" >Enye Contacts</a></td></tr>
<tr><td><a href="<?php echo URL.'libstats/sync'; ?>" >Library Sync Patronstats</a></td></tr>

<tr><td></td></tr>

</table>


<!----------------------------------------------------------------------------------->

<p> &nbsp; </p>

</div>

<div class="five"> </div>

<!----------------------------------------------------------------------------------->

<div class="third" >

<table class="hd gis-table-bordered table-fx table-altrow" >
<tr><th class="headrow white vc300" > MISC </th></tr>
<tr><td><a href="<?php echo URL.'mis/dgconductsForm'; ?>" > DG Conducts Overwriter </a></td></tr>
<tr><td><a href="<?php echo URL.'mis/dgacadForm'; ?>" > DG Academics Overwriter </a></td></tr>
<tr><td><a href="<?php echo URL.'mis/dgtraitsForm'; ?>" > DG Traits Overwriter </a></td></tr>
<tr><td><a href="<?php echo URL.'mis/reloading'; ?>" > Reloading </a></td></tr>
<tr><td><a href="<?php echo URL.'mis/terminals'; ?>" > Terminals </a></td></tr>
<?php if($_SESSION['settings']['has_pos']==1): ?>
	<tr><td><a href="<?php echo URL.'bills/add'; ?>" > POS </a></td></tr>
<?php endif; ?>
<tr><td> 
<select class="vc150" onchange="redirCrid('ccr',this.value);" >
	<option value="0"> CCR </option>
	<?php foreach($classrooms AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select> &nbsp; Go
</td></tr>
</table>


</div>

<!----------------------------------------------------------------------------------->


<div class="clear" > &nbsp; </div>



<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" ><th class="white" colspan="3" > SET NEW SY</th></tr>



<tr class="rc" ><td> &nbsp; </td>
<td><?php echo "# Sy Scid: $num_syscid | # Students: $num_students"; ?></td>
<td> 
	<?php if($num_syscid!=$num_students): ?>
		<a href='<?php echo URL."mis/syncSyScid/$sy"; ?>' > Sync SY-SCID <?php echo $sy; ?> </a> 
	<?php endif; ?>
</td></tr>


<tr class="rc" ><td> &nbsp; </td><td class="vc500" > 
PhpMyAdmin Operations <?php $sy; ?>  <br />
 &nbsp;&nbsp; > Export Full current DBM <br />
 &nbsp;&nbsp; > Rename current DBG  <br />
 &nbsp;&nbsp; > Rename current DBM  <br />
 &nbsp;&nbsp; > Export YYYY DBG schema only <br />
 </td><td class="" > <?php echo ''; ?> </td></tr>
 
 
<tr class="rc" ><td> &nbsp; </td><td> Create Current DBG and DBM <br />
 &nbsp;&nbsp; > Edit DBG Schema Name in SQL File <br />
 &nbsp;&nbsp; > Import YYYY DBG schema only to Current DBG <br />
 &nbsp;&nbsp; > Import Full DBM to Current DBM  <br />
</td><td class="" > <?php echo ''; ?> </td></tr>


<tr class="rc" ><td> &nbsp; </td><td> <a href='<?php echo URL."mis/setNewSY/"; ?>' > Set New SY </a> </td><td> 
1) SY, Qtr; 2) CrsQtrs, AdvQtrs, 3) CRIDS.init_grades</td></tr>

<tr class="rc" ><td> &nbsp; </td><td>
Truncate CAP <br />
 &nbsp;&nbsp; > DBM.calendar <br />
 &nbsp;&nbsp; > DBM.promotions <br />
 &nbsp;&nbsp; > DBM.attendance_months <br />

</td><td class="" > <?php echo ''; ?> </td></tr>


<?php if($sqtr==1): ?>
	<tr class="rc" ><td></td><td> <a href='<?php echo URL."mis/initClassrooms/$sy"; ?>' > Open Classrooms </a> </td><td> &nbsp; </td></tr>
	<tr class="rc" ><td></td><td> <a href='<?php echo URL."mis/openCQ/$sy"; ?>' > Open Courses </a> </td><td> &nbsp; </td></tr>
	<tr class="rc" ><td></td><td> <a href='<?php echo URL."mis/openAQ/$sy"; ?>' > Open Advisories </a> </td><td> &nbsp; </td></tr>
<?php endif; ?>

</table>

<br /><br /><br /><br /><br /><br /> <p class="hd" > &nbsp; </p>

<!----------------------------------------------------------------------------------->


<!----------------------------------------------------------------------------------->

<script>

var gurl 	= 'http://<?php echo GURL; ?>';
var x;
var hdpass 	= '<?php echo HDPASS; ?>';
var sy  	= '<?php echo $sy; ?>';
var qtr 	= '<?php echo $qtr; ?>';
var period 	= $('#period').val();

$(function(){
	hd();
	$('#hdpdiv').hide();
	rc('rc');

	
})


function redirCrid(axn,crid){
	var rurl 	= gurl + '/mis/'+axn+'/'+crid+'/'+sy+'/'+qtr;		// redirect url	
	window.location = rurl;		
}




function rc(cls){
	var x;
	$('.'+cls).each(function(){
		x = this.rowIndex;
		$(this).find("td:first").text(x);
	});
}
	
function redirMIS(axn,param){
	var rurl 	= gurl + '/mis/'+axn+'/'+param;		/* redirect url */	
	alert(rurl)
	// window.location = rurl;		
}

function redirIteacher(params){
	sy 		= $('#sy').val(); 
	period 	= $('#period').val(); 
	var suffix = sy+'/'+period+'/'+params;
	var rurl 	= gurl + '/mis/iteacher/'+suffix;		/* redirect url */	
	// alert(rurl)
	window.location = rurl;		
}


function redirCalendar(moid){
	var rurl 	= gurl + '/misc/calendar/'+sy+'/'+moid;			
	// alert(rurl);
	window.location = rurl;		
}

	
</script>