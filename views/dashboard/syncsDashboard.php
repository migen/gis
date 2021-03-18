<style>


</style>

<?php 

// echo "num contacts: $num_contacts <br />";
// echo "num ctp: $num_ctp <br />";


?>




<h5>
	
	<span ondblclick="tracehd();" >Syncs SY <?php echo $sy; ?></span>
	| <a href="<?php echo URL.'mis/index/'.$sy; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	| <a href="<?php echo URL.'setup/grading/'.$sy; ?>" >Setup</a>	
	| <a href="<?php echo URL.'dashboard/mis/'.$sy; ?>" >Dashboard</a>	
	
</h5>

<h4>Contacts - summaries,tsum,profiles,photos,ctp,students,attd. </h4>


<p><?php $this->shovel('hdpdiv'); ?></p>


<?php 

	// pr($sy);
	// pr($_SESSION['q']);

	$deadline 	= date('Y-m-d',strtotime($_SESSION['settings']['date_lockdown_q'.$qtr]));
	$today		= $_SESSION['today'];
	$dt1 		= strtotime($deadline);
	$dt2 		= strtotime($today);
	$dtdiff 	= $dt1 - $dt2;	
	$days 		= $dtdiff/(3600*24);
	

?>


<?php $this_year = date('Y'); ?>


<?php if($current): ?>


<div style="float:left;width:40%" >		<!-- left 40 -->

<table class="gis-table-bordered table-fx table-altrow"  >
<tr class="headrow" ><th class="white" >#</th><th class="vc200 white" > Particular </th><th class="vc50 white right" >Tally</th><th class="vc100 white" >Action</th></tr>


<tr class="rc" ><td  >&nbsp;</td><td class="vc200" ><a href="<?php echo URL.'contacts'; ?>" > Users </a></td><td class="right" ><?php echo $num_users; ?></td><td class="vc200" > &nbsp; </td></tr>

<tr class="rc" ><td  >&nbsp;</td><td><a href="<?php echo URL.'misc/mcaDir'; ?>" >Courses-Quarters </a></td><td class="right" ><?php echo $num_cq; ?></td>
<td>
<?php if($num_courses>$num_cq): ?>
	<a href="<?php echo URL.'syncs/syncCQ/dashboard'; ?>" >Sync Crs-Qtrs</a>
<?php else: ?>
	<a href="<?php echo URL.'syncs/syncCQ/dashboard'; ?>" >Sync Crs-Qtrs On</a>
<?php endif; ?>
</td>
</tr>

<tr class="rc" ><td  >&nbsp;</td><td >
<a href="<?php echo URL.'misc/mcaDir'; ?>" >Advisers-Quarters</a></td><td class="right" ><?php echo $num_aq; ?></td>
<td>
<?php if($num_classrooms>$num_aq): ?>
	<a href="<?php echo URL.'syncs/syncAQ/dashboard'; ?>" >Sync</a>
<?php else: ?>
	<a href="<?php echo URL.'syncs/syncAQ/dashboard'; ?>" >Sync On</a>
<?php endif; ?>
</td>
</tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > <?php echo $sy; ?> Attendance Students</a>
	<?php if($num_attendance < $num_students): ?>
		| Sync lacking
	<?php elseif($num_attendance > $num_students): ?>
		| Trim over
	<?php endif; ?>			
</td><td class="right" ><?php echo $num_attendance; ?></td>
<td>
	  <a href="<?php echo URL.'syncs/syncAttendance/dashboard'; ?>" > Sync</a>
	| <a href="<?php echo URL.'syncs/trimSA/dashboard'; ?>" > Trim</a>				
</td>
</tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Sync Prev Summaries </td><td class="right" ></td>
<td>
	<a href="<?php echo URL.'setup/syncPrevSumm/'.DBYR; ?>" >Sync Previous Summaries</a>
</td>
</tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Modified Advisers </td><td class="right" ><?php echo $num_modified_advisers; ?></td>
<td>
	<?php if($num_modified_advisers > 0): ?>
		<a href="<?php echo URL.'utils/syncSummariesAcid/'.$ssy.'/syncs'; ?>" >Sync Summaries Advisers</a>
	<?php else: ?>
		<a href="<?php echo URL.'utils/syncSummariesAcid/'.$ssy.'/syncs'; ?>" >Sync On</a>	
	<?php endif; ?>
<span class="hd" ><a href="<?php echo URL.'utils/syncSummariesAcid/'.$ssy.'/syncs'; ?>" > Sync Summ-Acid</a></span>
</td>
</tr>




</table>
<!------------------------------------------------------>
<p></p>

<table class="gis-table-bordered table-fx table-altrow"  >
<tr class="headrow" ><th class="white" >#</th><th class="vc200 white" > Particular </th><th class="vc50 white right" >Tally</th><th class="vc100 white" >Action</th></tr>


<tr class="rc" ><td  >&nbsp;</td><td class="vc200" ><a href="<?php echo URL.'contacts'; ?>" > Users </a></td><td class="right" ><?php echo $num_users; ?></td><td> &nbsp; </td></tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" ><a href="<?php echo URL.'contacts'; ?>" > Main-Contacts </a></td><td class="right" ><?php echo $num_parents; ?></td><td> &nbsp; </td></tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" ><a href="<?php echo URL.'profiles/student'; ?>" >Profiles</a></td><td class="right" ><?php echo $num_profiles; ?></td>
<td>
<?php if($num_parents!=$num_profiles): ?>
	<a href="<?php echo URL.'syncs/syncProfiles/syncs'; ?>" >Sync</a>
<?php else: ?>
	<a href="<?php echo URL.'syncs/syncProfiles/syncs'; ?>" >Sync On</a>
<?php endif; ?>
</td>
</tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" >Photos</td><td class="right" ><?php echo $num_photos; ?></td>
<td><a href="<?php echo URL.'syncs/syncPhotos/syncs'; ?>" >Sync</a></td>
</tr>

<tr class="rc <?php echo ($num_ctp!=$num_users)? 'red':NULL; ?> " ><td  >&nbsp;</td><td class="vc200" > Passwords </td>
<td class="right" ><?php echo $num_ctp; ?></td>
<td><span class="" ><a href="<?php echo URL.'syncs/syncCtp/syncs'; ?>" >Sync</a></span></td>
</tr>



<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Active Students </td><td class="right" ><?php echo $num_students; ?></td>
<td>
<select class="vc200" onchange="jsredirect('classlists/classroom/'+this.value);" >
	<option value="0">Classroom Students</option>
	<?php foreach($classrooms AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select>
</td>
</tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Active C-Students </a></td><td class="right" ><?php echo $num_cstudents; ?></td>
<td>
	<?php if($num_cstudents < $num_students): ?>
		<a href="<?php echo URL.'syncs/syncCStudents/syncs'; ?>" >Sync</a>
	<?php elseif($num_cstudents > $num_students): ?>
		<a href="<?php echo URL.'syncs/trimCS/syncs'; ?>" >Trim</a>				
	<?php endif; ?>			

<?php if($num_cstudents == $num_students): ?>
	  <a href="<?php echo URL.'syncs/syncCStudents/syncs'; ?>" > Sync On</a>	
	| <a href="<?php echo URL.'syncs/trimCS/syncs'; ?>" > Trim On</a>				
<?php endif; ?>
	
</td></tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" ><a href="<?php echo URL.'misc/empDir'; ?>" > Active Employees </a></td><td class="right" ><?php echo $active_employees; ?></td><td>&nbsp;</td></tr>


<?php if($_SESSION['settings']['has_axis']==1): ?>
	<tr class="rc" ><td  >&nbsp;</td><td class="vc200" ><?php echo $sy; ?> Tuition Summaries </td><td class="right" ><?php echo $num_tsum; ?></td>
<?php endif; ?>

<?php if($_SESSION['settings']['has_hris']==1): ?>

<?php endif; ?>



<td>
	<a href="<?php echo URL.'syncs/syncTuitionSummaries/'.$sy; ?>" > Sync</a>
	| <a href="<?php echo URL.'syncs/trimTuitionSummaries/'.$sy; ?>" > Trim</a>				
</td>

</tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > <?php echo $sy; ?> Summaries </a>
	<?php if($num_summaries < $num_students): ?>
		| Sync lacking
	<?php elseif($num_summaries > $num_students): ?>
		| Trim over
	<?php endif; ?>			
</td><td class="right" ><?php echo $num_summaries; ?></td>
<td>
	<a href="<?php echo URL.'syncs/syncSS/dashboard'; ?>" >Sync</a>
	| <a href="<?php echo URL.'syncs/trimSS/dashboard'; ?>" >Trim</a>				
</td></tr>



<?php if($_SESSION['settings']['has_hris']==1): ?>
<tr class="rc" ><td  >&nbsp;</td><td class="vc200" ><a href="<?php echo URL.'misc/attemps'; ?>" >
		<?php echo $sy; ?> Attendance Employees</a></td><td class="right" ><?php echo $num_attemps; ?></td>
	<td>
	<?php if($num_attemps!=$num_employees): ?>
		<a href="<?php echo URL.'syncs/syncAttemps/dashboard'; ?>" >Sync</a>
	<?php endif; ?>
	</td>
</tr>
	
<?php endif; ?>	





<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > <?php echo $sy; ?> Sectioned Students </td><td class="right" ><?php echo $num_sectioned; ?></td><td> &nbsp; </td></tr>


</table>

<div class="ht100" ></div>


</div>


<!-------------------- left right divide ----------------------->

<div style="float:left;width:40%">

<table class="gis-table-bordered table-fx table-altrow"  >
<tr class="headrow" ><th class="white" >#</th><th class="vc200 white" > Particular </th><th class="vc50 white right" >Tally</th>
<th class="vc150 white" >Action</th></tr>



<tr class="rc" ><td  >&nbsp;</td><td class="vc200" ><a href="<?php echo URL.'subjects'; ?>" >Subjects </a></td><td class="right" ><?php echo $num_subjects; ?></td><td> &nbsp; </td></tr>
<tr class="rc" ><td  >&nbsp;</td><td class="vc200" ><a href="<?php echo URL.'departments'; ?>" > Departments </a></td><td class="right" ><?php echo $num_departments; ?></td><td> &nbsp; </td></tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > 
<select class="vc200" onchange="redirCalendar(this.value);" >
	<option> Calendar </option>
	<?php foreach($months AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select> 
</td><td class="right" ><?php echo $num_calendar; ?></td>
<td>
	<?php if($num_calendar<'366'): ?>
		<a onclick="return confirm('Are you sure?');" href="<?php echo URL.'misc/syncCalendar/'.$sy; ?>" >Sync</a>
	<?php else: ?>
		<a onclick="return confirm('Are you sure?');" href="<?php echo URL.'misc/syncCalendar/'.$sy; ?>" >Sync On</a>
	<?php endif; ?>
</td></tr>



<tr class="rc" ><td  >&nbsp;</td><td class="vc200" ><a href="<?php echo URL.'criteria'; ?>" > Criteria </a></td><td class="right" ><?php echo $num_criteria; ?></td><td> &nbsp; </td></tr>
<tr class="rc" ><td  >&nbsp;</td><td class="vc200" ><a href="<?php echo URL.'criteria'; ?>" ><a href="<?php echo URL.'components'; ?>" > Components </a></td><td class="right" ><?php echo $num_components; ?></td><td> &nbsp; </td></tr>



<tr class="rc" ><td  >&nbsp;</td><td> Students Finalized Profile </a></td><td class="right" ><?php echo $num_students_finalized; ?></td><td> &nbsp; </td></tr>

<tr class="rc" ><td  >&nbsp;</td><td> <a href="<?php echo URL.'misc/crsDir'; ?>" > Courses </a></td><td class="right" ><?php echo $num_courses; ?></td><td> &nbsp; </td></tr>


<tr class="rc" ><td  >&nbsp;</td><td> Quarter </td><td class="right" ><?php echo $qtr; ?></td><td> &nbsp; </td></tr>
<tr class="rc" ><td  >&nbsp;</td><td class="vc200 <?php echo ($days<=0)? 'red':NULL; ?> " > Lock Courses Days Left </td><td class="right <?php echo ($days<=0)? 'red':NULL; ?> " ><?php echo $days; ?></td><td> &nbsp; </td></tr>




<tr class="rc" ><td  >&nbsp;</td><td> Quarter </td><td class="right" ><?php echo $qtr; ?></td><td> &nbsp; </td></tr>
<tr class="rc" ><td  >&nbsp;</td><td> Open Qualified</td><td class="right" ><?php echo $qtr; ?></td><td> 
	<a onclick="return confirm('Sure?');" href='<?php echo URL."mis/openQualified/$sy/1"; ?>' >Q1</a>
	| <a onclick="return confirm('Sure?');" href='<?php echo URL."mis/openQualified/$sy/2"; ?>' >Q2</a>
	| <a onclick="return confirm('Sure?');" href='<?php echo URL."mis/openQualified/$sy/3"; ?>' >Q3</a>
	| <a onclick="return confirm('Sure?');" href='<?php echo URL."mis/openQualified/$sy/4"; ?>' >Q4</a>
</td></tr>







<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Classrooms </td><td class="right" ><?php echo $num_classrooms; ?></td><td> &nbsp; </td></tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > <?php echo $sy; ?> Promotions-Classrooms </a></td><td class="right" ><?php echo $num_prom_classrooms; ?></td>
<td>
<?php if($num_classrooms!=$num_prom_classrooms): ?>
	<a href="<?php echo URL.'utils/syncPromotions/dashboard'; ?>" >Sync</a> 
<?php else: ?>
	<a href="<?php echo URL.'utils/syncPromotions/dashboard'; ?>" >Sync On</a> 
<?php endif; ?>
</td></tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > <?php echo $sy; ?> Finalized Promotions-Classrooms </a></td><td class="right" >
<?php echo $num_promotions; ?></td><td>&nbsp;</td></tr>



<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > <?php echo $sy; ?> Eligibility</td><td class="right" ></td>
<td><a href="<?php echo URL.'syncs/syncEligibility'; ?>" >Sync</a></td></tr>


</table>

</div>	<!-- right 40 -->

<!------------------------------------------------------------------------------------------------------------>
	<?php else: ?> <!-- above for current sy with sync actions, below just for stats viewing no actions  -->
<!------------------------------------------------------------------------------------------------------------>



<table class="gis-table-bordered table-fx table-altrow"  >
<tr class="headrow" ><th class="white" >#</th><th class="vc200 white" > Particular </th><th class="vc50 white right" >Tally</th><th class="vc100 white" >Action</th></tr>



<tr class="rc" ><td  >&nbsp;</td><td class="vc200" ><a href="<?php echo URL.'mis/empDir'; ?>" > Active Employees </a></td><td class="right" ><?php echo $active_employees; ?></td><td>&nbsp;</td></tr>
<tr class="rc" ><td  >&nbsp;</td><td class="vc200" ><a href="<?php echo URL.'contacts/index/1'; ?>" > Main-Contacts </a></td><td class="right" ><?php echo $num_parents; ?></td><td> &nbsp; </td></tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" ><a href="<?php echo URL.'mis/profiles'; ?>" > Profiles </a></td><td class="right" ><?php echo $num_profiles; ?></td>
<td> &nbsp; </td>
</tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" >Photos</td><td class="right" ><?php echo $num_photos; ?></td>
<td> &nbsp; </td>
</tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Passwords <?php echo $sy; ?> </td><td class="right" ><?php echo $num_ctp; ?></td>
<td> &nbsp; </td>
</tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" ><a href="<?php echo URL.'subjects'; ?>" >Subjects </a></td><td class="right" ><?php echo $num_subjects; ?></td><td> &nbsp; </td></tr>
<tr class="rc" ><td  >&nbsp;</td><td class="vc200" ><a href="<?php echo URL.'departments'; ?>" > Departments </a></td><td class="right" ><?php echo $num_departments; ?></td><td> &nbsp; </td></tr>
<tr class="rc" ><td  >&nbsp;</td><td class="vc200" ><a href="<?php echo URL.'criteria'; ?>" > Criteria </a></td><td class="right" ><?php echo $num_criteria; ?></td><td> &nbsp; </td></tr>
<tr class="rc" ><td  >&nbsp;</td><td class="vc200" ><a href="<?php echo URL.'criteria'; ?>" ><a href="<?php echo URL.'components'; ?>" > Components </a></td><td class="right" ><?php echo $num_components; ?></td><td> &nbsp; </td></tr>




<tr class="rc" ><td  >&nbsp;</td><td> Students Finalized Profile </a></td><td class="right" ><?php echo $num_students_finalized; ?></td><td> &nbsp; </td></tr>

<tr class="rc" ><td  >&nbsp;</td><td> <a href="<?php echo URL.'misc/crsDir'; ?>" > Courses </a></td><td class="right" ><?php echo $num_courses; ?></td><td> &nbsp; </td></tr>

<tr class="rc" ><td  >&nbsp;</td><td><a href="<?php echo URL.'mis/mcaDir'; ?>" > Courses-Quarters </a></td><td class="right" ><?php echo $num_cq; ?></td>
<td> &nbsp; 
</td>
</tr>


<tr class="rc" ><td  >&nbsp;</td><td> Quarter </td><td class="right" ><?php echo $qtr; ?></td><td> &nbsp; </td></tr>
<tr class="rc" ><td  >&nbsp;</td><td class="vc200 <?php echo ($days<=0)? 'red':NULL; ?> " > Lock Courses Days Left </td><td class="right <?php echo ($days<=0)? 'red':NULL; ?> " ><?php echo $days; ?></td><td> &nbsp; </td></tr>



<!---------------------------------------------------------------------------------------------------->

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" ><a href="<?php echo URL.'mis/mcaDir'; ?>" > Classrooms-Quarters </a></td><td class="right" ><?php echo $num_aq; ?></td>
<td> &nbsp; </td>
</tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Classrooms </td><td class="right" ><?php echo $num_classrooms; ?></td><td> &nbsp; </td></tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > <?php echo $sy; ?> Promotions-Classrooms </a></td><td class="right" ><?php echo $num_prom_classrooms; ?></td>
<td> &nbsp; 
</td></tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > <?php echo $sy; ?> Finalized Promotions-Classrooms </a></td><td class="right" ><?php echo $num_promotions; ?></td><td>&nbsp;</td></tr>


<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Modified Advisers </td><td class="right" ><?php echo $num_modified_advisers; ?></td>
<td>&nbsp;</td>
</tr>


<?php if($_SESSION['settings']['has_hris']==1): ?>
	<tr class="rc" ><td  >&nbsp;</td><td class="vc200" ><a href="<?php echo URL.'misc/attemps'; ?>" > Attendance Employees - <?php echo $sy; ?> </a></td><td class="right" ><?php echo $num_attemps; ?></td>
	<td> &nbsp; 	</td>
	</tr>
<?php endif; ?>


<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Active Students </td><td class="right" ><?php echo $num_students; ?></td>
<td>
<select class="vc200" onchange="redirCls(this.value);" >
	<option value="0">Classroom Students</option>
	<?php foreach($classrooms AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select> &nbsp; Go
</td>
</tr>

<?php if($_SESSION['settings']['has_axis']==1): ?>
	<tr class="rc" ><td  >&nbsp;</td><td class="vc200" ><?php echo $sy; ?> Tuition Summaries </td><td class="right" ><?php echo $num_tsum; ?></td>
<?php endif; ?>

<td>
	<a href="<?php echo URL.'syncs/syncTuitionSummaries/dashboard/'.$sy; ?>" > Sync</a>
	| <a href="<?php echo URL.'syncs/trimTuitionSummaries/dashboard'.$sy; ?>" > Trim</a>				
</td>

</tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > <?php echo $sy; ?> Summaries </a></td><td class="right" ><?php echo $num_summaries; ?></td>
<td>&nbsp;</td></tr>


<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > <?php echo $sy; ?> Attendance </a></td><td class="right" ><?php echo $num_attendance; ?></td>
<td>&nbsp;</td>
</tr>


<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > <?php echo $sy; ?> Sectioned Students </td><td class="right" ><?php echo $num_sectioned; ?></td><td> &nbsp; </td></tr>


</table>



<?php endif; ?>

<p class="ht100" > &nbsp; </p>


<!----------------------------------------------------------------------------------->

<script>

var hdpass = '<?php echo HDPASS; ?>';
var gurl = 'http://<?php echo GURL; ?>';
var sy 	 = '<?php echo $sy; ?>';
var x;

$(function(){
	hd();
	rc('rc');
		$('#hdpdiv').hide();
	

	
})

	
function redirCls(crid){
	var rurl 	= gurl + '/mis/classyear/'+sy+'/'+crid;			
	window.location = rurl;		
}

	

function xeditLockdown(qtr){
	var vurl = gurl+'/mis/xeditLockdown/'+sy+'/'+qtr;
	var dl	 = $('#date_lockdown_q'+qtr).val();		
	$("#csb"+qtr).hide();
	
	$.ajax({		
	  type: 'POST',
	  url: vurl,
	  data: "dl="+dl,	  	  			  
	  success:function(){
		window.location = gurl+"/mis/reset/mis/"+sy;
	  } 		
	})
	
}	


	
</script>