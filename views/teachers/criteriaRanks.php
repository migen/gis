
<?php 


// data=>ratings,qtr,curr_qtr,is_locked,students,qg => q4,activities,scores,criteria,course
// pr($data);
// pr($course);



?>



<h5>
	Criteria Ranks
	<span class="screen" >
		| <?php $this->shovel('homelinks',$home); ?>
		| <a class="underline txt-blue " onclick="toggleDetails();return false;" >Details</a>
	</span>
</h5>



<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
	<?php $this->shovel('hdpdiv'); ?>


<div id='printable' >

<!---------------------------------------------------------------------------------->


<div class='clear'></div>

<p>
<table class='gis-table-bordered table-fx'>
	<tr><th class='white headrow'>Classroom</th><td class="vc200" ><?php echo $course['level'].' - '.$course['section']; ?></td></tr>
	<tr><th class='white headrow'>Subject</th><td><?php echo $course['subject']; ?></td></tr>
	<tr><th class='white headrow'>Teacher</th><td><?php echo $course['teacher']; ?></td></tr>
</table>
</p>



<div id="details" >	
<h5>Details</h5>	
<table class='clear gis-table-bordered table-fx table-scores'>
<tr class="headrow" >
<th>#</th>
<th>Student</th>
<?php $colspan=0; ?>
<?php $i=0; ?>
<?php $tmpMax=0; ?>
<?php $max=0; ?>
<?php foreach($activities AS $row): ?>
	<?php $colspan+=1; ?>
	<?php $max 	+= $activities[$i]['max_score']; 	?>			
	<?php if($activities[$i]['criteria_id']==@$activities[$i+1]['criteria_id']): ?>
		<?php ?>
	<?php else: ?>
		<?php
			  $tmpMax = $max;
			  $max = 0;
		?>				
		<th colspan="<?php echo $colspan; ?>">
			<?php echo $activities[$i]['criteria'].'<br />'.$tmpMax.'<br />'.$activities[$i]['weight'].'%'; ?>
			<?php $colspan=0;?>
		</th>		
	<?php endif; ?>
	
<?php $i++; ?>
<?php endforeach; ?>
<th>Total</th>
</tr>

<?php // exit; ?>
	
<!--------------- process ------------------------------------------------------>
<?php $i=0; ?>

<?php foreach($scores AS $row): ?>
<?php $ranks[$i]['student']			= $students[$i]['student']; ?>
<?php $ranks[$i]['student_code']	= $students[$i]['student_code']; ?>
<?php $ranks[$i]['total']		= 0; ?>
<?php $ranks[$i]['max']			= 0; ?>
<?php $ranks[$i]['subtotal']	= 0; ?>
<?php $ranks[$i]['total']	= 0; ?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td id="<?php echo $students[$i]['scid'].':'.$students[$i]['student_code']; ?>" ondblclick="alert(this.id);" ><?php echo $students[$i]['student']; ?></td>
	<?php for($j=0;$j<$num_activities;$j++): ?>
	<?php $k=$j+1; ?>
		
		<?php 
			$colspan+=1; 
			$ranks[$i]['weight']  = $row[$j]['weight'];
			$ranks[$i]['max'] 	 += $row[$j]['max_score'];
			$ranks[$i]['subtotal']  += $row[$j]['score'];			
			
		?>						
		<?php if($scores[$i][$j]['criteria_id']!=@$scores[$i][$k]['criteria_id']): ?>
			<td colspan="<?php echo $colspan; ?>"  >				
				<?php 
					echo $ranks[$i]['subtotal'].' / '.$ranks[$i]['max']; 
					$pct = $ranks[$i]['subtotal'] / $ranks[$i]['max'] * $ranks[$i]['weight'];					
					echo " = "; 
					echo number_format($pct,0);
					$ranks[$i]['total']		+= $pct;
				
				?>
				<?php 
					$colspan=0; 
					$ranks[$i]['max'] 		= 0;
					$ranks[$i]['subtotal'] 	= 0;
				?>
			</td>		
		<?php endif; ?>
			
			
			
	<?php endfor; ?>	
	<td class="right" ><?php echo number_format($ranks[$i]['total'],0).'%'; ?></td>
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
	$v = $row['total'];
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
	<th>Total</th>
	<th>Rank</th>
</tr>

<!------------------------------------------------------------------------------------------>

<?php $i=1; ?>
<?php $scores=array(); ?>
<?php $rank=1; ?>
<?php foreach($sorted AS $k => $v): ?>
<?php $j=$i-1; ?>
<?php $scores[$i] = $v; ?>
<tr>
	<td><?php echo $i; ?></td>
	<td><?php echo $k; ?></td>	
	<td><?php echo number_format($v,0); ?></td>
	
	<?php if($scores[$i]<@$scores[$j]){ $rank++; }  ?>
	<td class="center" >
		<?php  // echo($scores[$i]); echo "-"; echo($scores[$j]);  echo "<br />";  ?>
		<?php echo $rank; ?>
	</td>
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

var gurl = 'http://<?php echo GURL; ?>';
var hdpass = '<?php echo HDPASS; ?>';


$(function(){ 
	$('#hdpdiv').hide();
	hd();
	// $('#details').hide();
	columnHighlighting();	
}) 	

function toggleDetails(){
	$('#details').toggle();
}

</script>

