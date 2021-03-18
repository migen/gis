






<h5>
	
	Dashboard SY <?php echo $sy; ?>
	| <a href="<?php echo URL.'mis/index/'.$sy; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	| <a href="<?php echo URL.'setup/grading/'.$sy; ?>" > Setup </a>	
	| <a href="<?php echo URL.'dashboard/syncs/'.$sy; ?>" > Syncs </a>	
	| <a href="<?php echo URL.'locking/controls/'.$sy; ?>" >Locking</a>	
	
</h5>

<!---------------------------------------------------------------------------------------------------------------->


<?php 

	// pr($sy);
	// pr($_SESSION['q']);
	// pr($_SESSION['url']);

	$deadline 	= date('Y-m-d',strtotime($_SESSION['settings']['date_lockdown_q'.$qtr]));
	$today		= date('Y-m-d');
	$dt1 		= strtotime($deadline);
	$dt2 		= strtotime($today);
	$dtdiff 	= $dt1 - $dt2;	
	$days 		= $dtdiff/(3600*24);
	

?>


<!---------------------------------------------------------------------------------------------------------------->

<?php 
	
	$this_year = date('Y');
	
?>

<!---------------------------------------------------------------------------------------------------------------->


<table class="gis-table-bordered table-fx table-altrow"  >
<tr class="headrow" ><th class="white" >#</th><th class="vc200 white" > Particular </th><th class="vc50 white right" >Tally</th><th class="vc100 white" >Action</th></tr>



<tr class="rc" ><td  >&nbsp;</td><td class="vc200" ><a href="<?php echo URL.'mis/empDir'; ?>" > Active Employees </a></td><td class="right" ><?php echo $active_employees; ?></td><td>&nbsp;</td></tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" ><a href="<?php echo URL.'mgt/contacts/1'; ?>" > Users </a></td><td class="right" ><?php echo $num_users; ?></td><td> &nbsp; </td></tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" ><a href="<?php echo URL.'mgt/contacts/1/'.$sy; ?>" > Main-Contacts </a></td><td class="right" ><?php echo $num_parents; ?></td><td> &nbsp; </td></tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Profiles </td><td class="right" ><?php echo $num_profiles; ?></td>
<td> &nbsp; </td>
</tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" >Photos</td><td class="right" ><?php echo $num_photos; ?></td>
<td> &nbsp; </td>
</tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Contacts Passes </td><td class="right" ><?php echo $num_ctp; ?></td>
<td> &nbsp; </td>
</tr>


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
		<a onclick="return confirm('Are you sure?');" href="<?php echo URL.'mis/syncCalendar/'.$sy; ?>" >Sync</a>
	<?php else: ?>
		<a onclick="return confirm('Are you sure?');" href="<?php echo URL.'mis/syncCalendar/'.$sy; ?>" >Sync On</a>
	<?php endif; ?>
</td></tr>




<!---------------------------------------------------------------------------------------------------------------------->

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Open Courses - Q<?php echo $qtr; ?> </td><td class="right" ><?php echo $num_open_cq; ?></td>
<td>
<?php if($num_open_cq>0): ?>
	<a href="<?php echo URL.'locking/closeCQ/'.$qtr.DS.$sy; ?>" >Lock Courses - Q<?php echo $qtr; ?> </a> 
<?php else: ?>
	<a href="<?php echo URL.'locking/openCQ/'.$qtr.DS.$sy; ?>" >Open Courses - Q<?php echo $qtr; ?> </a> 
<?php endif; ?>

</td></tr>


<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Open Classrooms - Q<?php echo $qtr; ?> </a></td><td class="right" ><?php echo $num_open_aq; ?></td>
<td>
<?php if($num_open_aq>0): ?>
	<a href="<?php echo URL.'locking/closeAQ/'.$qtr.DS.$sy; ?>" >Lock Classrooms - Q<?php echo $qtr; ?> </a> 
<?php else: ?>
	<a href="<?php echo URL.'locking/openAQ/'.$qtr.DS.$sy; ?>" >Open Classrooms - Q<?php echo $qtr; ?> </a> 
<?php endif; ?>

</td></tr>




<!---------------------------------------------------------------------------------------------------------------------->

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Open Courses - Q<?php echo $qtr; ?> </td>
<td class="right" ><?php echo $num_open_cq; ?></td><td> &nbsp; </td></tr>


<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Open Classrooms - Q<?php echo $qtr; ?> </a></td>
<td class="right" ><?php echo $num_open_aq; ?></td><td> &nbsp; </td></tr>





<tr class="rc" ><td  >&nbsp;</td>
	<td class="vc200" > Date Lockdown Q1 </td>
	<td class="right" >	<input class="pdl05 vc100" id="date_lockdown_q1" value="<?php echo $_SESSION['settings']['date_lockdown_q1']; ?>" /></td>
	<td><button id="csb1" onclick="xeditLockdown(1);return false;"  >Save</button></td>
</tr>

<tr class="rc" ><td  >&nbsp;</td>
	<td class="vc200" > Date Lockdown Q2 </td>
	<td class="right" >	<input class="pdl05 vc100" id="date_lockdown_q2" value="<?php echo $_SESSION['settings']['date_lockdown_q2']; ?>" /></td>
	<td><button id="csb2" onclick="xeditLockdown(2);return false;"  >Save</button></td>
</tr>

<tr class="rc" ><td  >&nbsp;</td>
	<td class="vc200" > Date Lockdown Q3 </td>
	<td class="right" >	<input class="pdl05 vc100" id="date_lockdown_q3" value="<?php echo $_SESSION['settings']['date_lockdown_q3']; ?>" /></td>
	<td><button id="csb3" onclick="xeditLockdown(3);return false;"  >Save</button></td>
</tr>

<tr class="rc" ><td  >&nbsp;</td>
	<td class="vc200" > Date Lockdown Q4 </td>
	<td class="right" >	<input class="pdl05 vc100" id="date_lockdown_q4" value="<?php echo $_SESSION['settings']['date_lockdown_q4']; ?>" /></td>
	<td><button id="csb4" onclick="xeditLockdown(4);return false;"  >Save</button></td>
</tr>


<!---------------------------------------------------------------------------------------------------->


<tr class="rc" ><td  >&nbsp;</td><td class="vc200" ><a href="<?php echo URL.'mis/subjects'; ?>" >Subjects </a></td>
	<td class="right" ><?php echo $num_subjects; ?></td><td> &nbsp; </td></tr>
<tr class="rc" ><td  >&nbsp;</td><td class="vc200" ><a href="<?php echo URL.'mis/departments'; ?>" > Departments </a></td>
	<td class="right" ><?php echo $num_departments; ?></td><td> &nbsp; </td></tr>
<tr class="rc" ><td  >&nbsp;</td><td class="vc200" ><a href="<?php echo URL.'mis/criteria'; ?>" > Criteria </a></td>
	<td class="right" ><?php echo $num_criteria; ?></td><td> &nbsp; </td></tr>
<tr class="rc" ><td  >&nbsp;</td><td class="vc200" ><a href="<?php echo URL.'mis/criteria'; ?>" >
	<a href="<?php echo URL.'mis/componentsDir'; ?>" > Components </a></td><td class="right" ><?php echo $num_components; ?></td>
		<td> &nbsp; </td></tr>


<?php if($_SESSION['settings']['has_rfid']==1): ?>
	<tr class="rc" ><td  >&nbsp;</td><td class="vc200" ><a href="<?php echo URL.'mis/attemps'; ?>" > Attendance Employees - <?php echo $sy; ?> </a></td><td class="right" ><?php echo $num_attemps; ?></td>
	<td> &nbsp; 	</td>
	</tr>
<?php endif; ?>

<tr class="rc" ><td  >&nbsp;</td><td> Students Finalized Profile </a></td><td class="right" ><?php echo $num_students_finalized; ?></td><td> &nbsp; </td></tr>


<tr class="rc" ><td  >&nbsp;</td><td><a href="<?php echo URL.'mis/mcaDir'; ?>" > Courses-Quarters </a></td><td class="right" ><?php echo $num_cq; ?></td>
<td> <a href="<?php echo URL.'syncs/syncCQ'; ?>" >Sync On</a> </td>
</tr>


<tr class="rc" ><td  >&nbsp;</td><td> Quarter </td><td class="right" ><?php echo $qtr; ?></td><td> &nbsp; </td></tr>
<tr class="rc" ><td  >&nbsp;</td><td class="vc200 <?php echo ($days<=0)? 'red':NULL; ?> " > Lock Courses Days Left </td><td class="right <?php echo ($days<=0)? 'red':NULL; ?> " ><?php echo $days; ?></td><td> &nbsp; </td></tr>


<!---------------------------------------------------------------------------------------------------->

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" ><a href="<?php echo URL.'mis/mcaDir'; ?>" > Classrooms-Quarters (AdvQtr)</a></td><td class="right" ><?php echo $num_aq; ?></td>
<td> <a href="<?php echo URL.'syncs/syncAQ'; ?>" >Sync On</a></td>
</tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Classrooms </td><td class="right" ><?php echo $num_classrooms; ?></td><td> &nbsp; </td></tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > <?php echo $sy; ?> Promotions-Classrooms </a></td><td class="right" ><?php echo $num_prom_classrooms; ?></td>
<td> &nbsp; 
</td></tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > <?php echo $sy; ?> Finalized Promotions-Classrooms </a></td><td class="right" ><?php echo $num_promotions; ?></td><td>&nbsp;</td></tr>


<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Modified Advisers </td><td class="right" ><?php echo $num_modified_advisers; ?></td>
<td>&nbsp;</td>
</tr>


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
<?php if($has_axis): ?>
	<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > Tuition Summaries </td><td class="right" ><?php echo $num_tsum; ?></td>
	<td>&nbsp;</td>
	</tr>
<?php endif; ?>



<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > <?php echo $sy; ?> Attendance </a></td><td class="right" ><?php echo $num_attendance; ?></td>
<td>&nbsp;</td>
</tr>


<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > <?php echo $sy; ?> Sectioned Students </td><td class="right" ><?php echo $num_sectioned; ?></td><td> &nbsp; </td></tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > <?php echo $sy; ?> Summaries </a></td><td class="right" ><?php echo $num_summaries; ?></td>
<td>&nbsp;</td></tr>

<tr class="rc" ><td  >&nbsp;</td><td class="vc200" > <?php echo $sy; ?> Awardees</td><td class="right" ></td><td> 
<a href="<?php echo URL.'morals/syncAwardeesAll'; ?>" >Sync On</a>
</td></tr>


</table>

<p class="ht100" > &nbsp; </p>


<!----------------------------------------------------------------------------------->

<script>

var gurl = 'http://<?php echo GURL; ?>';
var sy 	 = '<?php echo $sy; ?>';
// var x;

$(function(){
	rc('rc');

	
})

	
function redirCls(crid){
	var rurl 	= gurl + '/mis/classyear/'+sy+'/'+crid;			
	window.location = rurl;		
}

function redirCalendar(moid){
	var rurl 	= gurl + '/mis/calendar/'+sy+'/'+moid;			
	// alert(rurl);
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