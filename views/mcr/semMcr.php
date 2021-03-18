<?php 



?>


<!--------- SCRIPT ON TOP COZ there is an exit condition ---------------------------------------------------------->


<script> 

var gurl = 'http://<?php echo GURL; ?>';
var sy	 = '<?php echo $sy; ?>';
var home = 'reports';

$(function(){ 
	excel();
}) 	





</script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>



<!---------------------------------------------------------------------------------------------->

<?php 
/* @gcontroller-mcr */


	$deciscores = $_SESSION['settings']['deciscores'];
	$decigrades = $_SESSION['settings']['decigrades'];
	$decipnv 	= $_SESSION['settings']['decipnv'];
	$decitnv 	= $_SESSION['settings']['decitnv'];
	$deciftnv 	= $_SESSION['settings']['deciftnv'];
	$deciranks 	= $_SESSION['settings']['deciranks'];
	$deciconducts 	= $_SESSION['settings']['deciconducts'];
	$decigenave 	= $_SESSION['settings']['decigenave'];
	$get=sages($_GET);
	


$is_k12 = $classroom['is_k12'];
$k12 	= ($is_k12)? '_k12' : '';


function getmcr($classroom){
	if($classroom['is_k12'] && !$classroom['is_ps']){
		return '_k12';
	} else {
		return '';
	}
}	

$seq=array(2,5,3,4,6);



?>


<h5 class="screen" >
	Academic Report
<span class="screen" >		
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>	
	| <a href='<?php echo URL."matrix/grades/$crid/$sy/$qtr"; ?>' >Matrix</a>
	| <a href='<?php echo URL."reports/rcr/$crid/$sy/$qtr"; ?>' >RCR</a> 	
	| <a href='<?php echo URL."qcr/qcr/$crid/$sy/$qtr"; ?>' >QCR</a>
	| <a class="u" id="btnExport" >Excel</a> 
	
	<?php if($is_admin): ?>
		| <a href='<?php echo URL."reports/ecr/$crid/$sy/$qtr"; ?>' >ECR</a> 		
	<?php endif; ?>
	
	<?php if($classroom['level_id']>13): ?>
		<?php $get=str_replace('sem=','',$get); ?>
		| <a href='<?php echo URL."mcr/view/$crid/$sy/6?sem=0"; ?>' >All</a> 		
		| <a href='<?php echo URL."mcr/view/$crid/$sy/$qtr?sem=1"; ?>' >Grid-S1</a> 		
		| <a href='<?php echo URL."mcr/view/$crid/$sy/$qtr?sem=2"; ?>' >Grid-S2</a> 				
		<!-- matrix -->
		| <a href='<?php echo URL."matrix/grades/$crid/$sy/$qtr?$get&sem=1"; ?>' >Sem1</a>
		| <a href='<?php echo URL."matrix/grades/$crid/$sy/$qtr?$get&sem=2"; ?>' >Sem2</a>			

		| <a href='<?php echo URL."matrix/view/".$data['classroom']['id']."/$sy/5?sem=1&deci=2"; ?>' />Q5</a>	
		| <a href='<?php echo URL."matrix/view/".$data['classroom']['id']."/$sy/6?sem=2&deci=2"; ?>' />Q6</a>					
	<?php endif; ?>
	

<?php // pr($classroom); ?>	
	
	
</span>



	
</h5>

<!--------------------------------------------------------------------------------------------------------------->

<div class="clear" >	<!-- classroom info -->

<table class="gis-table-bordered" >
<tr>
	<td>&nbsp;</td>
	<td>
		<?php echo $classroom['level'].' - '.$classroom['section']; ?>
		| <?php echo $sy.' - Q'.$qtr.' - '; echo ($is_locked)? 'Closed' : 'Open' ; ?>
		| <?php echo 'Printed: '; $td = date('M-d, Y D',strtotime($_SESSION['today'])); echo $td; ?>
	</td>
</tr>
</table>

</div>	<!-- classroom info -->



<p class="screen" >Do <span class="red" >NOT</span> Print if Status is OPEN because NOT yet Finalized. </p>


<!--------------------------------------------------------------------------------------------------------------->


<?php 	
// pr($data);
if(empty($students)){ exit; }  ?>

<!--------------------------------------------------------------------------------------------------------------->


<table id="tblExport" class='gis-table-bordered'>
	<tr class='headrow'>
		<th>#</th>
		<th><?php echo $td; ?><br />Student</th>
		<th>Qtr</th>
	<?php $s=0; ?>
	<?php foreach($data['subjects'] AS $row): ?>
	<?php $s++; ?>		
		<th class="vc50 center" >
			<?php echo $s.'<br />'; ?>
			<?php if($user['role_id'] == RREG):   ?>		
				<a href="<?php echo URL; ?>registrars/course/<?php echo $row['course_id'].DS.$sy.DS.$qtr; ?>" ><?php echo $row['course_code']; ?></a>
			<?php else: ?>
				<?php echo $row['course_code']; ?>			
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


<?php $num_subjects = count($data['subjects']); ?>
<?php $x=0; // students index  ?>
<?php foreach($data['grades'] AS $row): ?>
		<tr> 
			<td><?php echo $x+1; ?></td>
			<td id="<?php echo $students[$x]['scid'].' : '.$students[$x]['student_code']; ?>" ondblclick="alert(this.id);" ><?php echo $students[$x]['student']; ?></td>
			<td class="colshading" >Q1</td>
	<?php for($i=0;$i<$num_subjects;$i++): ?>		
			<td class="colshading center" ><?php 
					$score  = (isset($row[$i]['q1']))? $row[$i]['q1'] : 0;
					echo number_format($score,$decigrades);					
				?>
				<?php if($is_k12): ?> <br /><?php echo (isset($row[$i]['dg1']))? $row[$i]['dg1'] : 'N'; ?> <?php endif; ?>														
			</td>
	<?php endfor; ?>		
			<td class="colshading center" ><?php echo number_format($students[$x]['conduct_q1'],$decigrades); ?>
				<?php if($is_k12): ?> <?php echo $students[$x]['conduct_dg1']; ?> <?php endif; ?>
			</td>	
			<td class="colshading center" ><?php echo number_format($students[$x]['ave_q1'],$decigenave);  ?>
				<?php if($is_k12): ?> <?php echo $students[$x]['ave_dg1']; ?> <?php endif; ?>			
			</td>	
			<td class="colshading center" ><?php echo ($students[$x]['rank_classroom_q1']==0)? '-': number_format($students[$x]['rank_classroom_q1'],$deciranks); ?></td>
		</tr>
		
	<?php 
		// $iqtr = (($sem) || ($param_qtr==6))? 6:6; 
		$iqtr = 6; 
		
	?>	
	
	<?php foreach($seq AS $j): ?>
	<?php $qtr = 'q'.$j; ?>
		<tr class="<?php echo ($j==5 || $j==6)? 'b':NULL; ?>" >
			<td>&nbsp;</td> <td>&nbsp;</td>
			<td class="colshading" >
				<?php 
					if($j<5){ echo "Q{$j}"; }
					if($j==5){ echo "FG1"; }
					if($j==6){ echo "FG2"; }
				?>
			</td>
		<?php for($i=0;$i<$num_subjects;$i++): ?>		
				<td class="colshading center" ><?php 
							$score  = (isset($row[$i][$qtr]))? $row[$i][$qtr] : 0;
							echo number_format($score,$decigrades);					
					?>
				<?php if($is_k12): ?> <br /><?php echo (isset($row[$i]['dg'.$j]))? $row[$i]['dg'.$j] : 'N'; ?> <?php endif; ?>														
				</td>
		<?php endfor; ?>		
			<td class="colshading center" ><?php echo number_format($students[$x]['conduct_q'.$j],$deciconducts); ?>
				<?php if($is_k12): ?> <?php echo $students[$x]['conduct_dg'.$j]; ?> <?php endif; ?>						
			</td>
			<td class="colshading center" ><?php echo number_format($students[$x]['ave_q'.$j],$decigenave);  ?>
				<?php if($is_k12): ?> <?php echo $students[$x]['ave_dg'.$j]; ?> <?php endif; ?>						
			</td>
			<td class="colshading center" ><?php echo ($students[$x]['rank_classroom_q'.$j]==0)? '-':number_format($students[$x]['rank_classroom_q'.$j],$deciranks); ?>
			</td>
		</tr>	
	<?php endforeach; ?>	
		
<?php $x++; // students index ?>
<?php endforeach; ?>

</table>



