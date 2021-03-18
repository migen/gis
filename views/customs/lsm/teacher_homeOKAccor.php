<?php 
	$_SESSION['accor'] = isset($_SESSION['accor'])? $_SESSION['accor'] : 'pen';
	
	// pr($pending[0]);
	// pr($_SESSION['teacher']['clubs']);
	// pr($_SESSION['teacher']);
	// pr($_SESSION['teacher']['clubs']);
	
?>




<h5>
	<span ondblclick="tracepass();" >LSM Home</span>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href="<?php echo URL.'loads/teacher/'.$user['ucid'].DS.$sy; ?>" />Loads</a>	
	| <a href="<?php echo URL.'files/read/grading'; ?>" />Grading</a>		
	| <a href="<?php echo URL.'files/read/teacher'; ?>" />Teacher</a>		
	| <a href="<?php echo URL.'tickets/add'; ?>" />Ticket</a>		

	<?php if($_SESSION['settings']['trsgrades']==1): ?>
		<?php $trs = $_SESSION['settings']['trs']; ?>
		| <a href="<?php echo URL.'trs/classrooms/'.$_SESSION['ucid'].DS.$sy.DS.$qtr; ?>" /><?php echo $trs; ?></a>		
	<?php endif; ?>		
	
	
	
	<?php if(isset($_SESSION['teacher']['clubs'])): ?>
		<?php $clubs = $_SESSION['teacher']['clubs']; ?>
		<?php foreach($clubs AS $club): ?>
			| <a href="<?php echo URL.'clubs/scores/'.$club['id']; ?>" ><?php echo ucfirst($club['code']); ?></a>
		<?php endforeach; ?>
	<?php endif; ?>		

	
	
</h5>


<!--- tracelogin --->
<?php $this->shovel('hdpdiv'); ?>

<div style="float:right;width:30%;"  >
	<?php 
		$incs = SITE.'views/teachers/includes/reminder_teacher.php';
		include_once($incs);		
	?>
</div>




<!-- ========================  page info / user info =================================-->
<div class="left" >	<!-- left -->
<table class='gis-table-bordered table-fx'>
<tr class="hd" ><th class="bg-blue2" >UCID</th><td><?php echo $user['ucid']; ?></td></tr>
<tr class="hd" ><th class="bg-blue2" >ACL</th><td>
<?php echo $user['role_id'].'-'.$user['privilege_id'].'-'.$user['title_id'].' ('.$user['title'].')'; ?></td></tr>
<tr class="hd" ><th class="bg-blue2" >ID #</th><td class="vc250" ><?php echo $user['code']; ?></td></tr>
</table>


<!--  =================== Pending Classes ========================  -->

<div class='accordParent' >
<button onclick="accorToggle('pending')" style="width:274px;" class="bg-blue2" > <p class="b f16" >Pending Academic Report (PAR)</p> </button>  	


<?php if($num_pending>0): ?>
<table id="pending" class='gis-table-bordered table-fx table-altrow' >
<tr>
	<td colspan="4">
	<?php 	
		$deadline 	  = date('M-d',strtotime($_SESSION['settings']['date_lockdown_q'.$qtr]));
		echo " <h4>Deadline: <u>".$deadline."</u>. Days left: <u> ".$days_left." </u> </h4>";
	?>
	</td>
</tr>
<tr class='black bg-blue2'>
	<th>#</th><th>Classroom</th><th> Averages</th><th class="center">Class Records</th> 
</tr>

<?php for($i=0;$i<$num_pending;$i++): ?>
	<?php $row = $pending[$i]; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $row['classroom']; ?></td>	
	<td>
		<a href="<?php echo URL.'averages/course/'.$row['course_id'].DS.$sy.DS.$qtr; ?>" > <?php echo $row['label']; ?></a>
	</td>		
	
<td>	
<?php if($row['is_aggregate']): ?>
		&nbsp;
<?php else: ?>
	<?php if($row['with_scores']): ?>
		<?php for($a=1;$a<=$qtr;$a++): ?>
			<a class="<?php echo ($a == $qtr)? "b bg-black2":null; ?>" href="<?php echo URL.'teachers/scores/'.$row['course_id'].DS.$sy.DS.$a; ?>">Q<?php echo $a; ?></a> 
			<?php echo ($a != $qtr)? " &nbsp; | &nbsp; " : null; ?>
		<?php endfor; ?>														
	<?php else: ?>
		<?php // pr($row); ?>
		<?php $gmod=($row['is_num'])? 'teachers/grades':'grades/dg'; ?>
		<?php for($a=1;$a<=$qtr;$a++): ?>
			<a class="<?php echo ($a == $qtr)? "b bg-black2":null; ?>" href="<?php echo URL.$gmod.'/'.$row['course_id'].DS.$sy.DS.$a; ?>">Q<?php echo $a; ?></a> 
			<?php echo ($a != $qtr)? " &nbsp; | &nbsp; " : null; ?>
		<?php endfor; ?>										
		 - G
	<?php endif; ?>
<?php endif; ?>		


</td>			

<?php endfor; ?>

</table>

<?php else: ?>	
	<table id="cls" class='gis-table-bordered table-fx table-altrow' > <tr><td> Great job! You have no pending class reports. </td></tr> </table>
<?php endif; ?>	<!-- if($num_pending) -->

</div>

<br />


<!--  =================== Submitted Courses ========================  -->

<div class='accordParent' >

<button onclick="accorToggle('submitted')" style="width:274px;" class="bg-blue2" > <p class="b f16" >Submitted Academic Report (SAR)</p> </button>  	

<?php if($num_submitted): ?>

<table id="submitted" class='gis-table-bordered table-fx table-altrow'>
<tr class='black bg-blue2'>
	<th>#</th><th>Classroom</th><th> Averages </th><th class="center">Class Records</th> 
</tr>

<?php for($i=0;$i<$num_submitted;$i++): ?>
	<?php $row = $submitted[$i]; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $row['classroom']; ?></td>
	<td>
		<a href="<?php echo URL.'averages/course/'.$row['course_id'].DS.$sy.DS.$qtr; ?>" > <?php echo $row['label']; ?> </a>
	</td>		

	<td>
<?php if($row['is_aggregate']): ?>
		&nbsp;
<?php else: ?>
	<?php if($row['with_scores']): ?>
		<?php for($a=1;$a<=$qtr;$a++): ?>
			<a class="<?php echo ($a == $qtr)? "b bg-black2":null; ?>" href="<?php echo URL.'teachers/scores/'.$row['course_id'].DS.$sy.DS.$a; ?>">Q<?php echo $a; ?></a> 
			<?php echo ($a != $qtr)? " &nbsp; | &nbsp; " : null; ?>
		<?php endfor; ?>														
	<?php else: ?>
		<?php for($a=1;$a<=$qtr;$a++): ?>
			<a class="<?php echo ($a == $qtr)? "b bg-black2":null; ?>" href="<?php echo URL.'averages/course/'.$row['course_id'].DS.$sy.DS.$a; ?>">Q<?php echo $a; ?></a> 
			<?php echo ($a != $qtr)? " &nbsp; | &nbsp; " : null; ?>
		<?php endfor; ?>										
	<?php endif; ?>
<?php endif; ?>				
	</td>
	
<?php endfor; ?>

</table>

<?php endif; ?>	<!-- if($num_submitted) -->

</div>

<br />


<!--  ================= ADVISORY ==========================================	 -->

<div class='accordParent' >

<?php if($data['num_advisories'] > 0): ?>
<button onclick="accorToggle('mac')" style="width:274px;" class="bg-blue2" > <p class="b f16" >Manage Advisory Class (MAC)</p> </button>  	

<table id="mac" class='gis-table-bordered table-fx table-altrow'>
<tr class='black bg-blue2'>
	<th>#</th>
	<th>Classlist</th>
	<th class="center" >Matrix</th>
	<th class="center" >Attendance</th>
	<th class="center" >Submissions</th>
	<th class="center" >Ranks</th>


		
</tr>
<?php for($i=0;$i<$num_advisories;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><a href="<?php echo URL.'classlists/classroom/'.$advisories[$i]['crid'].DS.$sy; ?>" ><?php echo $advisories[$i]['classroom']; ?></a></td>
	<td>
		<?php for($a=1;$a<=$qtr;$a++): ?>
			<a class="<?php echo ($a == $qtr)? "b bg-black2":null; ?>" 
				href="<?php echo URL.'matrix/grades/'.$advisories[$i]['crid'].DS.$sy.DS.$a; ?>">Q<?php echo $a; ?></a> 
			<?php echo ($a != $qtr)? " | " : null; ?>			
		<?php endfor; ?>		
	</td>
	<td>
		<a href="<?php echo URL.'attendance/monthly/'.$advisories[$i]['crid'].DS.$sy.DS.'5'; ?>">SY</a> |	
		<?php for($a=1;$a<=$qtr;$a++): ?>
			<a class="<?php echo ($a == $qtr)? "b bg-black2":null; ?>" href="<?php echo URL.'attendance/monthly/'.$advisories[$i]['crid'].DS.$sy.DS.$a; ?>">Q<?php echo $a; ?></a>
			<?php echo ($a != $qtr)? " | " : null; ?>			
		<?php endfor; ?>						
	</td>		
	<td>
		<?php for($a=1;$a<=$qtr;$a++): ?>
			<a class="<?php echo ($a == $qtr)? "b bg-black2":null; ?>" 
				href="<?php echo URL.'submissions/view/'.$advisories[$i]['crid'].DS.$sy.DS.$a; ?>">Q<?php echo $a; ?></a>
			<?php echo ($a != $qtr)? " | " : null; ?>
		<?php endfor; ?>
		- <?php echo ($advisories[$i]['is_finalized_q'.$qtr])? "Finalized":"<span class='red'>Open</span>"; ?>
	</td>
	<td>
		<?php for($j=1;$j<=$qtr;$j++): ?>
			<a href='<?php echo URL."qcr/qcr/".$advisories[$i]['crid']."/$sy/{$j}"; ?>' >Q<?php echo $j; ?></a> &nbsp; 
		<?php endfor; ?>	
			
	</td>
	
	
	
<?php if($qtr==4): ?>	
	<td>
		<a href="<?php echo URL.'promotions/sfold/'.$advisories[$i]['crid'].DS.$sy; ?>">SF Old</a> | 		
		<a href="<?php echo URL.'promotions/k12/'.$advisories[$i]['crid'].DS.$sy; ?>">K12 Promotions</a>
	</td>		
<?php endif; ?>

	
</tr>



<?php endfor; ?>
</table>
<?php endif; ?> <!-- if has advisory classes -->

</div>

<br />

<!--  =================== Conduct or Trait Classes ========================  -->

<div class='accordParent' >
<button onclick="accorToggle('conducts')" style="width:274px;" class="bg-blue2" > <p class="b f16" >Conducts / Traits (CAV)</p> </button>  	

<?php if($num_conducts > 0): ?>	

<table id="conducts" class='gis-table-bordered table-fx table-altrow'>
<tr class='black bg-blue2'>
	<th>#</th><th>Classroom<?php echo ($data['num_advisories'] > 1)? "s" : null; ?></th><th>Average</th><th class="center" >Class Records</th>
	
</tr>


<?php for($i=0;$i<$data['num_conducts'];$i++): ?>
	<?php $row = $conducts[$i]; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $row['classroom']; ?></td>
	<td>
		<?php if($row['crstype_id']==CTYPEPSMAPEH): ?>
			<?php echo $row['subject']; ?>
		<?php else: ?>
			<a href='<?php echo URL."conducts/fg/".$row['course_id']."/$sy/$qtr"; ?>' >
				<?php echo $row['subject']; ?></a>
		<?php endif; ?>
	</td>	
	<td>
		<?php $method = ($row['crstype_id']==CTYPECONDUCT)? 'conducts/records' : 'cav/traits'; ?>	
		<?php for($a=1;$a<=$qtr;$a++): ?>
			<a class="<?php echo ($a == $qtr)? "b bg-black2":null; ?>" href="<?php echo URL.$method.DS.$row['course_id'].DS.$sy.DS.$a; ?>"> Q<?php echo $a; ?></a> 
			<?php echo ($a != $qtr)? " | " : null; ?>			
		<?php endfor; ?>	
		- <?php echo ($conducts[$i]['is_finalized_q'.$qtr])? "Finalized":"<span class='red'>Open</span>"; ?>		
	</td>	
	
<?php endfor; ?>

</table>
<?php endif; ?> <!-- if has conduct classes -->

</div>

</div>	<!-- left -->







<!--------------------------------------------------------------------->


<script>

var gurl = 'http://<?php echo GURL; ?>';
var accor = "<?php echo $_SESSION['accor']; ?>";
var hdpass = '<?php echo HDPASS; ?>';


$(function(){
	hd();
	accordionSearch(accor);
	$('#hdpdiv').hide();
		
})


function accordionSearch(accor){
	// $(".accordParent table:not(:first)").hide();	
	$(".accordParent table:not(#"+accor+")").hide();	
	$('.accordParent').click(function(){
		$(".accordParent table").hide();		
		$(this).children('table').show();		
	})	
}

	
function selectTable(i){
	$("#tbl"+i).attr('checked',true);
}
	
		
	
</script>

 
	

