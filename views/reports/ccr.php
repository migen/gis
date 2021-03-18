<!--------- SCRIPT ON TOP COZ there is an exit condition ---------------------------------------------------------->
<script> 

var gurl = 'http://<?php echo GURL; ?>';
var sy	 = '<?php echo $sy; ?>';
var home = 'reports';

$(function(){ 
	columnHighlighting();	
	excel();
}) 	


function excel(){
	$("#btnExport").click(function () {
		$("#tblExport").btechco_excelexport({
			containerid: "tblExport"
		   ,datatype: $datatype.Table
		});
	});

}



</script>

<!---------------------------------------------------------------------------------------------->

<!------- at GController ---->
<?php 


// pr($students[0]);
// pr($grades[1]);
// pr($classroom);

$is_k12 = ($classroom['is_k12'] && !$classroom['is_ps']);
$k12 = ($is_k12)? '_k12' : '';


	$deciscores = $_SESSION['settings']['deciscores'];
	$decigrades = $_SESSION['settings']['decigrades'];
	$decipnv 	= $_SESSION['settings']['decipnv'];
	$decitnv 	= $_SESSION['settings']['decitnv'];
	$deciftnv 	= $_SESSION['settings']['deciftnv'];
	$deciranks 	= $_SESSION['settings']['deciranks'];
	$deciconducts 	= $_SESSION['settings']['deciconducts'];
	$decigenave 	= $_SESSION['settings']['decigenave'];


function getmcr($classroom){
	if($classroom['is_k12'] && !$classroom['is_ps']){
		return '_k12';
	} else {
		return '';
	}
}	



// pr($classroom);

?>


<h5>
	Academic Report
<span class="screen" >		
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>	
	| <a href='<?php echo URL."matrix/grades/".$classroom['id']."/$sy/$qtr"; ?>' >Matrix</a> 	
	| <a href='<?php echo URL."reports/rcr/".$classroom['id']."/$sy/$qtr"; ?>' >RCR</a> 	
	| <a href='<?php echo URL."qcr/qcr/".$classroom['id']."/$sy/$qtr"; ?>' >QCR</a> 	
	| <a href='<?php echo URL."mcr/view/".$classroom['id']."/$sy/$qtr"; ?>' >MCR</a>
	
	<?php if($_SESSION['srid']==RMIS): ?>
		| <a href='<?php echo URL."reports/ecr/".$data['classroom']['id']."/$sy/$qtr"; ?>' />ECR</a>	
				
	<?php endif; ?>	

	
<?php $sems = array(0,1,2); ?>
	| <select id="semval" class="vc50" >
		<?php foreach($sems AS $sv): ?>
			<option><?php echo $sv; ?></option>
			<?php endforeach; ?>
		</select>
		<a class="button" onclick="jsredirect('reports/ccr/'+crid+ds+sy+ds+qtr+'?sem='+$('#semval').val());" >Semestral</a>		
	
	
</span>



	
</h5>

<!--------------------------------------------------------------------------------------------------------------->
<div class="third" >
<table class='gis-table-bordered table-fx'>
	<tr><th class='white headrow'>Classroom</th><td><?php echo $classroom['level'].' - '.$classroom['section']; ?>
		<span class="hd f10 screen" >(CRID<?php echo $classroom['id']; ?>)</span>
	</td></tr>
	<tr><th class='white headrow'>Adviser</th><td><?php echo $classroom['adviser']; ?><br />
		<span class="hd f10 screen" >(<?php echo $classroom['acid'].'-'.$classroom['teacher_code']; ?>)</span>
	</td></tr>	
	<tr><th class='white headrow'>Conduct</th>
	<td>
		<?php if($classroom['conduct_ctype_id']==CTYPETRAIT): ?>
			<a href='<?php echo URL."cav/traits/$conduct_course_id/$sy/$qtr"; ?>' >Edit Traits</a>
		<?php else: ?>
			<a href='<?php echo URL."conducts/records/$conduct_course_id/$sy/$qtr"; ?>' >Edit Conducts</a>		
		<?php endif; ?>
	</td></tr>	
			
</table>
</div>

<div class="third">
<table class="gis-table-bordered " >
	<?php if($qtr<5): ?>
		<tr><th class='white headrow'>Status</th><td><?php echo 'Q'.$qtr.' - '; echo ($is_locked)? 'Closed' : 'Open' ; ?></td></tr> 
	<?php endif; ?>
	
<?php 
	if($user['role_id']!=RTEAC){
		$d['classrooms'] = $classrooms;
		$d['sy']		 = $sy;
		$d['axn']		 = 'ccr';
		$this->shovel('redirect_classroom',$d); 	
	}
?>

</table>
</div>


<div class="third" >
<?php 
	$year_finalized = date('Y',strtotime($classroom['finalized_date_q'.$qtr]));
	$finalized_date = $classroom['finalized_date_q'.$qtr];	
	$finalized_date = ($year_finalized<DBYR)? 'OPEN':date('M-d, Y D',strtotime($finalized_date));
?>
<table class='gis-table-bordered table-fx'>
	<tr><th class='white headrow'>Finalized Date</th>
		<td class="vc150" ><?php echo $finalized_date; ?></td></tr> 
	<tr><th class='white headrow'>Printed Date</th>
		<td><?php echo date('M-d, Y D',strtotime($_SESSION['today'])); ?></td></tr> 
</table>
</div>


<div class="clear" ></div>
<!--------------------------------------------------------------------------------------------------------------->


<?php 	
// pr($data);
if(empty($students)){ exit; }  ?>

<p class="red b" >Please do not edit Conduct or Trait Grades Coz will not UPDATE Summaries.conduct grades </p>

<!--------------------------------------------------------------------------------------------------------------->

<table class='gis-table-bordered table-fx table-altrow'>
<thead>
	<tr class='headrow'>
		<th>#</th>
		<th>Student</th>
	<?php $s=0; ?>
	<?php foreach($data['subjects'] AS $row): ?>
	<?php $s++; ?>
		<th class="vc50 center" >
			<?php echo $s.'<br />'; ?>
			<?php if($user['role_id'] == RREG):   ?>		
				<a href="<?php echo URL; ?>registrars/course/<?php echo $row['course_id'].DS.$sy.DS.$qtr; ?>" ><?php echo $row['course_code']; ?></a>
			<?php else: ?>
				<?php echo $row['course_code']; ?>			
				<?php if($row['supsubject_id']!=0): ?>
					<?php echo $row['course_weight'].'%'; ?>
				<?php endif; ?>
				
			<?php endif; ?>				
		</th>	
	<?php endforeach; ?>
	
		<th class="center">CG
			<?php if($is_k12): ?> CDG <?php endif; ?>
		</th>	
		
		<th class="center">AG
			<?php if($is_k12): ?> DG <?php endif; ?>
		</th>
			
		<th class="center" >Rank</th>
		
	</tr>
</thead>

<tbody>

<?php $num_subjects = count($data['subjects']); ?>
<?php $x=0; // students index  ?>
<?php foreach($data['grades'] AS $row): ?>
		<tr>
			<td><?php echo $x+1; ?></td>
			<td id="<?php echo $students[$x]['scid'].' : '.$students[$x]['student_code']; ?>"  ondblclick="alert(this.id);" ><?php echo $students[$x]['student']; ?></td>
	<?php for($i=0;$i<$num_subjects;$i++): ?>		
			<td class="colshading center" ><?php 
					$score  = (isset($row[$i]['q'.$qtr]))? $row[$i]['q'.$qtr] : 0;		
					echo number_format($score,$decigrades);					
				?>
				<?php if($is_k12): ?> <br /><?php echo (isset($row[$i]['dg'.$qtr]))? $row[$i]['dg'.$qtr] : 'N'; ?> <?php endif; ?>														
			</td>
	<?php endfor; ?>		
			<td class="colshading center" ><?php echo number_format($students[$x]['conduct_q'.$qtr],$decigrades); ?>
				<?php if($is_k12): ?> <?php echo $students[$x]['conduct_dg'.$qtr]; ?> <?php endif; ?>
			</td>	
			<td class="colshading center" ><?php echo number_format($students[$x]['ave_q'.$qtr],$decigenave); ?>
				<?php if($is_k12): ?> <?php echo $students[$x]['ave_dg'.$qtr]; ?> <?php endif; ?>			
			</td>	
			<td class="colshading center" ><?php echo ($students[$x]['rank_classroom_q'.$qtr]==0)? '-':number_format($students[$x]['rank_classroom_q'.$qtr],$deciranks); ?></td>
			<?php if($is_admin): ?>
				<td><a href="<?php echo URL.'registrars/editStudentGrades/'.$students[$x]['scid'].DS.$sy.DS.$qtr; ?>" >Edit Grades</a></td>
			<?php endif; ?>
		</tr>
		
<?php $x++; // students index ?>
<?php endforeach; ?>


</tbody>
</table>



<!--  ====================================================================================================  -->


<script> 


	var crid 	= '<?php echo $crid; ?>';
	var sy	 	= '<?php echo $sy; ?>';
	var qtr 	= '<?php echo $qtr; ?>';
	var ds 		= '/';


$(function(){ 
	// hd(); 
	columnHighlighting();	
}) 	

</script>
