
<?php 


// data=>ratings,qtr,curr_qtr,is_locked,students,qg => q4,activities,scores,criteria,course


$subcri_totalmax   =  0;

for($i=0;$i<$num_students;$i++){
	$data['students'][$i]['average'] = 0;
}


/* ===================== FORMULAS : transmute,rating ===================== */

$this->shovel("grading");



function getFloorGrade($course,$sgs){
	return $sgs['floor_grade'];
}

$flrgr = getFloorGrade($course,$_SESSION['settings']);





?>



<h5>
	Criteria Ranks
	<span class="screen" >
		| <?php $this->shovel('homelinks',$home); ?>
	</span>
</h5>



<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
	<?php $this->shovel('hdpdiv'); ?>


<div id='printable' >

<!---------------------------------------------------------------------------------->


<div class='clear'></div>



<div class="hd" >	
<h5>Process</h5>	
<table class='clear gis-table-bordered table-fx table-scores'>
<tr class="headrow" >
<th>#</th>
<th>ID Number</th>
<th>Student</th>
<?php foreach($activities AS $row): ?>
	<th><?php echo $row['activity']; ?></th>
<?php endforeach; ?>
<th>Max</th>
<th>Total</th>
<th>Ave</th>
</tr>
	
<!--------------- process ------------------------------------------------------>
<?php $i=0; ?>
<?php foreach($scores AS $row): ?>
<?php $ranks[$i]['student']			= $students[$i]['student']; ?>
<?php $ranks[$i]['student_code']	= $students[$i]['student_code']; ?>
<?php $ranks[$i]['max']		= 0; ?>
<?php $ranks[$i]['total']	= 0; ?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $students[$i]['student_code']; ?></td>
	<td><?php echo $students[$i]['student']; ?></td>
	<?php for($j=0;$j<$num_activities;$j++): ?>
		<td><?php echo $row[$j]['score']; ?></td>
		<?php 
			if($row[$j]['is_valid']){
				$ranks[$i]['max'] 	  += $row[$j]['max_score'];
				$ranks[$i]['total']   += $row[$j]['score'];
			}		
		?>		
	<?php endfor; ?>	
	<td><?php echo $ranks[$i]['max']; ?></td>
	<td><?php echo $ranks[$i]['total']; ?></td>
	<td><?php $ranks[$i]['ave'] = transmute($ranks[$i]['total'],$ranks[$i]['max']); echo $ranks[$i]['ave']; ?></td>
</tr>

<?php $i++; ?>
<?php endforeach; ?>

</table>   
</div>

<!--------------- display ------------------------------------------------------>

<?php 

$assoc = array();
foreach($ranks AS $row){
	$k = $row['student'];
	$v = $row['ave'];
	$assoc[$k] = $v;
	
}


function sorter($a){
    arsort($a);
	return $a;
}

$sorted = sorter($assoc);


?>

<h5>Display</h5>	

<table class="gis-table-bordered table-fx"  >
<tr class="headrow" >
	<th>#</th>
	<th>Student</th>
	<th>Ave</th>
	<th>Rank</th>
</tr>

<!------------------------------------------------------------------------------------------>

<?php $i=1; ?>
<?php $scores=array(); ?>
<?php $rank=0; ?>
<?php foreach($sorted AS $k => $v): ?>
<?php $j=$i-1; ?>
<?php $scores[$i] = $v; ?>
<tr>
	<td><?php echo $i; ?></td>
	<td><?php echo $k; ?></td>
	<td><?php echo $v; ?></td>	
	
	<?php if($scores[$i]>@$scores[$j]){ $rank++; }  ?>
	<td><?php echo $rank; ?></td>
</tr>

<?php $i++; ?>
<?php endforeach; ?>



</table>   




</div> 	<!--  printable	-->
<!--------------------------------------------------------------------->



<?php 


// pr($ranks);
	
	
	
?>

<!--------------------------------------------------------------------->

<script> 

var gurl = 'http://<?php echo GURL; ?>';var hdpass = '<?php echo HDPASS; ?>';


$(function(){ 
	// $('#hdpdiv').hide();
	// hd();
	columnHighlighting();	
}) 	



</script>

