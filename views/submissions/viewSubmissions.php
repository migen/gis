<!--   -->
<?php 



$cr 		 	= $data['classroom'];
$num_pending 	= 0;		
$adv_switch=$_SESSION['settings']['adv_switch'];


for($i=0;$i<$num_parents;$i++){
	if($parents[$i]['is_aggregate']){
		$parents[$i]['complete'] = true;		
		foreach($children AS $row){			
			if(($row['supsubject_id'] == $parents[$i]['subject_id']) && (@$row['is_finalized_q'.$qtr]==0)){
				$parents[$i]['complete'] = false;						
				break;			
			}
		}
	}
}



	
?>


<h5>

	<a href="<?php echo URL.$home; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| AdvSwitch (<?php echo $adv_switch; ?>)
	| <a href='<?php echo URL."advisers/crscfg/".$cr['crid']; ?>'>Config</a>
	| <a href='<?php echo URL."files/read/rcard";  ?>' >Rcard Notes</a>
	| <a href='<?php echo URL."classrooms/courses/$crid";  ?>' >Setup</a>
	| <span class="u txt-blue" onclick="pclass('hd');" >ID's</span>
	
<?php if($qtr < 5 && $is_locked): ?>	
	| <a href='<?php echo URL."mcr/view/".$cr['crid']."/$sy/$qtr";  ?>' > Academic Report </a>
<?php endif; ?>	

<?php if(($qtr == 4) && ($_SESSION['srid'] == RTEAC)): ?>	
	| <a href='<?php echo URL."customs/cocurrs/".$cr['crid']."/$sy/$qtr"; ?>' > Honors </a> 
<?php endif; ?>	

	<a class="hd" href='<?php echo URL."fyi/subjects"; ?>' >| &nbsp; Subjects</a>
	
	| <a href="<?php echo URL.'matrix/grades/'.$cr['crid'].DS.$sy.DS.$qtr; ?>" >Matrix</a>
	| <a href="<?php echo URL.'spiral/crid/'.$cr['crid']; ?>" >1-Spiral</a>
	| <a href="<?php echo URL.'summarizers/genave/'.$cr['crid'].DS.$sy.DS.$qtr; ?>" >2-Summarizer</a>
	

	&nbsp;&nbsp;&nbsp;  <span class="brown" id="display" ></span>
	
	
</h5>

<?php if(isset($_GET['debug'])){ pr($q); } ?>


<!------ tracelogin ---->
<?php $this->shovel('hdpdiv'); ?>



<h2 class='darkgray'> Submissions <?php if($qtr < 5): ?> - Q<?php echo $qtr; ?> <?php endif; ?>AdvSwitch (1-Locked, 0-Open)</h2>

<table class='gis-table-bordered table-fx table-altrow'>
	<tr class="hd" ><th class='white bg-blue2'>-Class</th><td><?php echo $cr['crid']; ?></td></tr>
	<tr class="hd" ><th class='white bg-blue2'>-ACID</th><td><?php echo $cr['acid']; ?></td></tr>
	<tr class="hd" ><th class='white bg-blue2'>QCR</th><td>
		<a href="<?php echo URL.'qcr/qcr/'.$classroom['crid'].DS.$sy.DS.$qtr; ?>">QCR</a> 	
	</td></tr>
	<tr><th class='white bg-blue2'>Classroom | Adviser</th><td>
		<?php echo $cr['level'].' - '.$cr['section'].' | '.$cr['adviser']; ?>	
	</td></tr>
<?php if($qtr < 5): ?> <tr><th class='white bg-blue2'>Status</th><td><?php echo 'Q'.$data['qtr'].' - '; 
	echo ($is_locked)? 'Closed' : 'Open' ; ?>	</td></tr> <?php endif; ?>	
	<tr class="hd" ><th class='white bg-blue2' >Locking</th> 
		<th>
			<?php if($is_locked): ?>
				<a href="<?php echo URL.'finalizers/openClassroom/'.$cr['crid'].DS.$sy.DS.$qtr; ?>" onclick="return confirm('Sure');" > Unlock </a>
			<?php else: ?>
				<a href="<?php echo URL.'finalizers/closeClassroom/'.$cr['crid'].DS.$sy.DS.$qtr; ?>" onclick="return confirm('Sure');" > Lock </a>			
			<?php endif; ?>				
		</th>
	</tr>
</table>


<p class="screen" > 1) Press <span class="underline" >Tally Aggregates</span> 
(BOTTOMS UP - Tally Component Aggregates BEFORE Non-Component Aggregates). 
<br /> 2) Go to <span class="underline" >Summarizer</span> if no pending submissions. </p>


<h5 class="darkgray" >All Non-Component Subjects</h5>

<table class='gis-table-bordered table-fx table-altrow'>
<tr class='bg-blue2'>
	<th>#</th>
	<th class="vc50 hd" >-SubID</th>
	<th class="vc50 hd" >-CrsID</th>
	<th class="vc50 hd" >-Agg</th>
	<th class="vc50 hd" >-Wt</th>
	<th class="vc50 hd" >-SupSub <br />ID</th>
	<th class="vc50 hd" >-Acad</th>
	<th class="vc50 hd" >-Account</th>
	<th class="vc50 hd" >-TCID</th>
	<th class="vc200" >Teacher</th>
	<th class="vc100" >Average</th>
	
<?php if($qtr > 4): ?>
	<th class="vc100" >Q1</th>
	<th class="vc100" >Q2</th>
	<th class="vc100" >Q3</th>
	<th class="vc100" >Q4</th>
<?php else: ?>
	<th class="vc100" >Q<?php echo $data['qtr']; ?> Submitted </th>
	<th class="vc100" > Action </th>
	<th class="vc100 " > Locking </th>
<?php endif; ?>

</tr>

<?php for($i=0;$i<$num_parents;$i++): ?> 	<!-- loop thru number of courses -->
	<tr>
		<td><?php echo $i+1; ?></td>
		<td class="hd" >
			<span id="<?php echo $parents[$i]['subject_id']; ?>" ondblclick="xname('dbm','subjects',this.id);" >
				<?php echo $parents[$i]['subject_id']; ?>
			</span>
		</td>		
		
		<td class="hd" >
			<span id="<?php echo $parents[$i]['course_id']; ?>" ondblclick="xname('dbm','courses',this.id);" >
				<?php echo $parents[$i]['course_id']; ?>
			</span>
		</td>		
		
		<td class="hd" ><?php echo $parents[$i]['is_aggregate']; ?></td>
		<td class="hd" ><?php echo $parents[$i]['weight']; ?></td>
		<td class="hd" >
			<span id="<?php echo $parents[$i]['supsubject_id']; ?>" ondblclick="xname('dbm','subjects',this.id);" >
				<?php echo $parents[$i]['supsubject_id']; ?>
			</span>
		</td>		
		
		<td class="hd" ><?php echo $parents[$i]['is_acad']; ?></td>
		<td class="hd" ><?php echo $parents[$i]['account']; ?></td>
		<td class="hd" ><?php echo $parents[$i]['tcid']; ?></td>
		<td id="<?php echo 'Sub#'.$parents[$i]['subject_id'].'. Crs#'.$parents[$i]['course_id'].'. TCID#'.$parents[$i]['tcid'].'. Code#'.$parents[$i]['code']; ?>"  ondblclick="alert(this.id);" ><?php echo $parents[$i]['teacher']; ?></td>
		
		<td class="vc120" ><a href='<?php echo URL."averages/course/".$parents[$i]['course_id']."/$sy/$qtr"; ?>' >
			<?php echo $parents[$i]['label']; ?></a></td>

	<?php if($qtr > 4): ?>
		<td class="<?php echo (!$parents[$i]['is_finalized_q1'])? 'bg-red' : null; ?>" ><?php if($parents[$i]['is_finalized_q1']){ echo !is_null($parents[$i]['finalized_date_q1'])? date('M-d-y',strtotime($parents[$i]['finalized_date_q1'])) : 'Submitted';  } else { echo 'Pending'; } ?></td>
		<td class="<?php echo (!$parents[$i]['is_finalized_q2'])? 'bg-red' : null; ?>" ><?php if($parents[$i]['is_finalized_q2']){ echo !is_null($parents[$i]['finalized_date_q2'])? date('M-d-y',strtotime($parents[$i]['finalized_date_q2'])) : 'Submitted';  } else { echo 'Pending'; } ?></td>
		<td class="<?php echo (!$parents[$i]['is_finalized_q3'])? 'bg-red' : null; ?>" ><?php if($parents[$i]['is_finalized_q3']){ echo !is_null($parents[$i]['finalized_date_q3'])? date('M-d-y',strtotime($parents[$i]['finalized_date_q3'])) : 'Submitted';  } else { echo 'Pending'; } ?></td>
		<td class="<?php echo (!$parents[$i]['is_finalized_q4'])? 'bg-red' : null; ?>" ><?php if($parents[$i]['is_finalized_q4']){ echo !is_null($parents[$i]['finalized_date_q4'])? date('M-d-y',strtotime($parents[$i]['finalized_date_q4'])) : 'Submitted';  } else { echo 'Pending'; } ?></td>
	<?php else: ?>
		<td class="<?php echo (!$parents[$i]['is_finalized_q'.$qtr])? 'bg-red' : null; ?>" >
		<?php 		
			if($parents[$i]['is_finalized_q'.$qtr]){
				echo !is_null($parents[$i]['finalized_date_q'.$qtr])? date('M-d-y',strtotime($parents[$i]['finalized_date_q'.$qtr])) : 'Submitted';  			
			} else {
				echo 'Pending'; $num_pending++;
			}
		?>
		</td>
		<td class="" >					
		
			<?php $params = $classroom['id'].DS.$parents[$i]['course_id'].DS.$parents[$i]['subject_id'].DS.$sy.DS.$qtr;   ?>			
			<?php // if($parents[$i]['is_aggregate'] && !$parents[$i]['is_finalized_q'.$qtr] && $parents[$i]['complete'] ): ?>
			<?php if($parents[$i]['is_aggregate'] && !$parents[$i]['is_finalized_q'.$qtr] ): ?>
					<a href="<?php echo URL.'aggregates/tally/'.$params; ?>">Tally</a> 
			<?php elseif($parents[$i]['is_aggregate'] ): ?>
					<a href="<?php echo URL.'aggregates/tally/'.$params; ?>">Aggregates</a> 
			<?php endif; ?>		
		
			<?php // echo "-".$parents[$i]['complete']."-"; ?>
		</td>
		<td class="" > 
		<?php if(!$adv_switch): ?>		
			<?php if($parents[$i]['is_finalized_q'.$qtr]): ?>
				<a href="<?php echo URL.'finalizers/openCourse/'.$cr['crid'].DS.$parents[$i]['course_id'].DS.$sy.DS.$qtr; ?>" 
					onclick="return confirm('Sure');"> Unlock</a>
			<?php else: ?>
				<a href="<?php echo URL.'finalizers/closeCourse/'.$cr['crid'].DS.$parents[$i]['course_id'].DS.$sy.DS.$qtr; ?>" 
					onclick="return confirm('Sure');" > Lock</a>			
			<?php endif; ?>		
		<?php endif; ?>	<!-- adv_switch -->
		</td>
	<?php endif; ?>	
		<td class="hd">
			<input value="<?php echo $parents[$i]['finalized_date_q'.$qtr]; ?>" onchange="xupdateSubmitted(<?php echo $parents[$i]['course_id']; ?>,this.value);return false;"  />
		
		</td>
	
	</tr>
<?php endfor; ?>								
		
</table>


<?php 
//	echo "num_pending: $num_pending <br />"; 
?>


<!-- ================== Aggregates Below ======================================================================== -->

<br />
<h5 class="darkgray" >Aggregates & Subcomponents</h5>

<table class='gis-table-bordered table-fx table-altrow'>
<tr class='bg-blue2'>
	<th>#</th>
	<th class="vc50 hd" >-SubID</th>
	<th class="vc50 hd" >-CrsID</th>
	<th class="vc50 hd" >-Agg</th>
	<th class="vc50 hd" >-Wt</th>
	<th class="vc50 hd" >-SupSub <br />ID</th>
	<th class="vc50 hd" >-Acad</th>
	<th class="vc50 hd" >-Account</th>
	<th class="vc50 hd" >-TCID</th>
	<th class="vc200" >Teacher</th>
	<th class="vc100" >Average</th>	
	
<?php if($qtr > 4): ?>
	<th class="vc100" >Q1</th>
	<th class="vc100" >Q2</th>
	<th class="vc100" >Q3</th>
	<th class="vc100" >Q4</th>
<?php else: ?>
	<th class="vc100" >Q<?php echo $data['qtr']; ?> Submitted </th>
	<th class="vc100" > Action </th>
	<th class="vc100" > Locking </th>	
<?php endif; ?>

</tr>

<?php for($i=0;$i<$num_children;$i++): ?> 	<!-- loop thru number of courses -->
	<tr>
		<td><?php echo $i+1; ?></td>
		<td class="hd" >
			<span id="<?php echo $children[$i]['subject_id']; ?>" ondblclick="xname('dbm','subjects',this.id);" >
				<?php echo $children[$i]['subject_id']; ?>
			</span>
		</td>				
		<td class="hd" >
			<span id="<?php echo $children[$i]['course_id']; ?>" ondblclick="xname('dbm','courses',this.id);" >
				<?php echo $children[$i]['course_id']; ?>
			</span>
		</td>		
		<td class="hd" ><?php echo $children[$i]['is_aggregate']; ?></td>
		<td class="hd" ><?php echo $children[$i]['weight']; ?></td>
		<td class="hd" >
			<span id="<?php echo $children[$i]['supsubject_id']; ?>" ondblclick="xname('dbm','subjects',this.id);" >
				<?php echo $children[$i]['supsubject_id']; ?>
			</span>
		</td>
		<td class="hd" ><?php echo $children[$i]['is_acad']; ?></td>
		<td class="hd" ><?php echo $children[$i]['account']; ?></td>		
		<td class="hd" ><?php echo $children[$i]['tcid']; ?></td>		
		
		<td id="<?php echo 'Sub#'.$children[$i]['subject_id'].'. Crs#'.$children[$i]['course_id'].'. SupSub#'.$children[$i]['supsubject_id'].'. Wt#'.$children[$i]['weight'].'. TCID#'.$children[$i]['tcid'].'. Code#'.$children[$i]['code']; ?>"  ondblclick="alert(this.id);" ><?php echo $children[$i]['teacher']; ?></td>
				
		<td class="vc120" ><a href='<?php echo URL."averages/course/".$children[$i]['course_id']."/$sy/$qtr"; ?>' >
			<?php echo $children[$i]['label']; ?></a></td>
		

	<?php if($qtr > 4): ?>
		<td class="<?php echo (!$children[$i]['is_finalized_q1'])? 'bg-red' : null; ?>" ><?php if($children[$i]['is_finalized_q1']){ echo !is_null($children[$i]['finalized_date_q1'])? date('M-d-y',strtotime($children[$i]['finalized_date_q1'])) : 'Submitted';  } else { echo 'Pending'; } ?></td>
		<td class="<?php echo (!$children[$i]['is_finalized_q2'])? 'bg-red' : null; ?>" ><?php if($children[$i]['is_finalized_q2']){ echo !is_null($children[$i]['finalized_date_q2'])? date('M-d-y',strtotime($children[$i]['finalized_date_q2'])) : 'Submitted';  } else { echo 'Pending'; } ?></td>
		<td class="<?php echo (!$children[$i]['is_finalized_q3'])? 'bg-red' : null; ?>" ><?php if($children[$i]['is_finalized_q3']){ echo !is_null($children[$i]['finalized_date_q3'])? date('M-d-y',strtotime($children[$i]['finalized_date_q3'])) : 'Submitted';  } else { echo 'Pending'; } ?></td>
		<td class="<?php echo (!$children[$i]['is_finalized_q4'])? 'bg-red' : null; ?>" ><?php if($children[$i]['is_finalized_q4']){ echo !is_null($children[$i]['finalized_date_q4'])? date('M-d-y',strtotime($children[$i]['finalized_date_q4'])) : 'Submitted';  } else { echo 'Pending'; } ?></td>
	<?php else: ?>
		<td class="<?php echo (!$children[$i]['is_finalized_q'.$qtr])? 'bg-red' : null; ?>" >
		<?php 		
			if($children[$i]['is_finalized_q'.$qtr]){
				echo !is_null($children[$i]['finalized_date_q'.$qtr])? date('M-d-y',strtotime($children[$i]['finalized_date_q'.$qtr])) : 'Submitted';  			
			} else {
				echo 'Pending'; $num_pending++;
			}
		?>
		</td>
		<td>	&nbsp;

		</td>
		<td class="" > 
		<?php if(!$adv_switch): ?>
			<?php if($children[$i]['is_finalized_q'.$qtr]): ?>
				<a href="<?php echo URL.'finalizers/openCourse/'.$cr['crid'].DS.$children[$i]['course_id'].DS.$sy.DS.$qtr; ?>" 
					onclick="return confirm('Sure');" > Unlock </a>
			<?php else: ?>
				<a href="<?php echo URL.'finalizers/closeCourse/'.$cr['crid'].DS.$children[$i]['course_id'].DS.$sy.DS.$qtr; ?>" 
					onclick="return confirm('Sure');" > Lock </a>			
			<?php endif; ?>
		<?php endif; ?>	<!-- adv_switch -->			
		</td>		
	<?php endif; ?>	
	
		<td class="hd">
			<input value="<?php echo $children[$i]['finalized_date_q'.$qtr]; ?>" onchange="xupdateSubmitted(<?php echo $children[$i]['course_id']; ?>,this.value);return false;"  />		
		</td>
	
	
	</tr>
<?php endfor; ?>								
		
</table>


<!-- ================== Conducts or Traits Below ======================================================================== -->


<br />
<h5 class="darkgray" > Conducts | Traits </h5>

<table class='gis-table-bordered table-fx table-altrow'>
<tr class='bg-blue2'>
	<th>#</th>
	<th class="vc50 hd" >-SubID</th>
	<th class="vc50 hd" >-CrsID</th>
	<th class="vc50 hd" >-Agg</th>
	<th class="vc50 hd" >-Wt</th>
	<th class="vc50 hd" >-SupSub <br />ID</th>
	<th class="vc50 hd" >-Acad</th>
	<th class="vc50 hd" >-Account</th>
	<th class="vc50 hd" >-TCID</th>
	<th class="vc200" >Teacher</th>
	<th class="vc100" >Average</th>	
	
<?php if($qtr > 4): ?>
	<th class="vc100" >Q1</th>
	<th class="vc100" >Q2</th>
	<th class="vc100" >Q3</th>
	<th class="vc100" >Q4</th>
<?php else: ?>
	<th class="vc100" >Q<?php echo $data['qtr']; ?> Submitted </th>
	<th class="vc100" > Action </th>
	<th class="vc100" > Locking </th>	
<?php endif; ?>

</tr>

<?php for($i=0;$i<$num_conducts;$i++): ?> 	<!-- loop thru number of courses -->
	<tr>
		<td><?php echo $i+1; ?></td>
		<td class="hd" >
			<span id="<?php echo $conducts[$i]['subject_id']; ?>" ondblclick="xname('dbm','subjects',this.id);" >
				<?php echo $conducts[$i]['subject_id']; ?>
			</span>
		</td>						
		<td class="hd" >
			<span id="<?php echo $conducts[$i]['course_id']; ?>" ondblclick="xname('dbm','courses',this.id);" >
				<?php echo $conducts[$i]['course_id']; ?>
			</span>
		</td>		
		<td class="hd" ><?php echo $conducts[$i]['is_aggregate']; ?></td>
		<td class="hd" ><?php echo $conducts[$i]['weight']; ?></td>
		<td class="hd" ><?php echo $conducts[$i]['supsubject_id']; ?></td>
		<td class="hd" ><?php echo $conducts[$i]['is_acad']; ?></td>
		<td class="hd" ><?php echo $conducts[$i]['account']; ?></td>		
		<td class="hd" ><span id="<?php echo $conducts[$i]['tcid']; ?>" ondblclick="xname('dbo','00_contacts',this.id);" >
			<?php echo $conducts[$i]['tcid']; ?></span></td>		
		<td id="<?php echo 'Sub#'.$conducts[$i]['subject_id'].'. Crs#'.$conducts[$i]['course_id'].'. TCID#'.$conducts[$i]['tcid'].'. Code#'.$conducts[$i]['code']; ?>"  ondblclick="alert(this.id);" ><?php echo $conducts[$i]['teacher']; ?></td>
		
		<td class="vc120" >
			<?php $condcourse_id = $conducts[$i]['course_id']; ?>
			<?php $conduct = $conducts[$i]['label']; ?>
			<a href='<?php echo URL."conducts/fg/$condcourse_id/$sy/$qtr"; ?>' ><?php echo $conduct; ?></a>									
		</td>

	<?php if($qtr > 4): ?>
		<td class="<?php echo (!$conducts[$i]['is_finalized_q1'])? 'bg-red' : null; ?>" ><?php if($conducts[$i]['is_finalized_q1']){ echo !is_null($conducts[$i]['finalized_date_q1'])? date('M-d-y',strtotime($conducts[$i]['finalized_date_q1'])) : 'Submitted';  } else { echo 'Pending'; } ?></td>
		<td class="<?php echo (!$conducts[$i]['is_finalized_q2'])? 'bg-red' : null; ?>" ><?php if($conducts[$i]['is_finalized_q2']){ echo !is_null($conducts[$i]['finalized_date_q2'])? date('M-d-y',strtotime($conducts[$i]['finalized_date_q2'])) : 'Submitted';  } else { echo 'Pending'; } ?></td>
		<td class="<?php echo (!$conducts[$i]['is_finalized_q3'])? 'bg-red' : null; ?>" ><?php if($conducts[$i]['is_finalized_q3']){ echo !is_null($conducts[$i]['finalized_date_q3'])? date('M-d-y',strtotime($conducts[$i]['finalized_date_q3'])) : 'Submitted';  } else { echo 'Pending'; } ?></td>
		<td class="<?php echo (!$conducts[$i]['is_finalized_q4'])? 'bg-red' : null; ?>" ><?php if($conducts[$i]['is_finalized_q4']){ echo !is_null($conducts[$i]['finalized_date_q4'])? date('M-d-y',strtotime($conducts[$i]['finalized_date_q4'])) : 'Submitted';  } else { echo 'Pending'; } ?></td>
	<?php else: ?>
		<td class="<?php echo (!$conducts[$i]['is_finalized_q'.$qtr])? 'bg-red' : null; ?>" >
		<?php 		
			if($conducts[$i]['is_finalized_q'.$qtr]){
				echo !is_null($conducts[$i]['finalized_date_q'.$qtr])? date('M-d-y',strtotime($conducts[$i]['finalized_date_q'.$qtr])) : 'Submitted';  			
			} else {
				echo 'Pending'; $num_pending++;
			}
		?>
		</td>
		<td>	
			<?php $page = ($conducts[$i]['crstype_id']==CTYPETRAIT)? 'cav/traits':'conducts/records'; ?>		
			<a href='<?php echo URL.$page.DS.$conducts[$i]['course_id']."/$sy/$qtr"; ?>'>Go</a>
		</td>
		<td class="" > 
		<?php if(!$adv_switch): ?>		
			<?php if($conducts[$i]['is_finalized_q'.$qtr]): ?>
				<a href="<?php echo URL.'finalizers/openCourse/'.$cr['crid'].DS.$conducts[$i]['course_id'].DS.$sy.DS.$qtr; ?>" 
					onclick="return confirm('Sure');" > Unlock </a>
			<?php else: ?>
				<a href="<?php echo URL.'finalizers/closeCourse/'.$cr['crid'].DS.$conducts[$i]['course_id'].DS.$sy.DS.$qtr; ?>" 
					onclick="return confirm('Sure');" > Lock </a>			
			<?php endif; ?>
		<?php endif; ?>	<!-- adv_switch -->
		</td>		
		
	<?php endif; ?>	
		<td class="hd">
			<input value="<?php echo $conducts[$i]['finalized_date_q'.$qtr]; ?>" onchange="xupdateSubmitted(<?php echo $conducts[$i]['course_id']; ?>,this.value);return false;"  />		
		</td>
	
	
	</tr>
<?php endfor; ?>								
		
</table>




<!-- ================== GENAVE for Summarizer ======================================================================== -->


<h4># Pending Submission : <?php echo $num_pending; ?></h4>

<?php 


if(!$num_pending && !$is_locked): 	
	$crid = $cr['crid'];

?>


<?php $j = ($qtr<5)? $qtr:'4'; ?>

<?php if($classroom['attendance_q'.$j]==1): ?>
	<a onclick="return confirm('REMINDER: Are you sure?');"  
		href='<?php echo URL."summarizers/genave/".$cr['crid']."/$sy/$qtr"; ?>' ><button>Summarizer</button></a>
<?php else: ?>
	<p><a class="b txt-red" href='<?php echo URL."attendance/monthly/$crid/$sy/$qtr"; ?>' >Pending - Finalize Attendance</a></p>
<?php endif; ?>
 

<?php	
else:
	$tcid = $_SESSION['user']['ucid'];
	$crid = $cr['crid'];
endif; 



?>

<div class="ht100" > &nbsp; </div>


	



<!-- ===================================================================================================
	echo " <p class='hd' ><a href='".URL."teachers/genave/".$cr['id'].DS.$qtr.DS.$sy."' >2nd Class Ranks</a> </p> ";

====================================================================================================  -->

<!------------------------------------------------------------------------------------------------------------>
<script>

var hdpass 	= '<?php echo HDPASS; ?>';
var gurl 	= 'http://<?php echo GURL; ?>';
var qtr 	= '<?php echo $qtr; ?>';
var home 	= '<?php echo $home; ?>';

$(function(){
	$('#hdpdiv').hide();
	hd();
	
})

function xupdateSubmitted(crsid,date){	
	var vurl 	= gurl + '/'+home+'/xupdateSubmitted/'+crsid;	
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'date='+date+'&qtr='+qtr,				
		async: true,
		success: function() { }		  
    });				

}




</script>


