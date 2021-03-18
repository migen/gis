<link type='text/css' rel='stylesheet' href="<?php echo URL.'public/css/style_long.css'; ?>" />    
<!-- GController-summarizer -->

<?php 

$deci=($classroom['department_id']==3)? $_SESSION['settings']['deciave_hs']:$_SESSION['settings']['deciave_gs'];
$decicard   = $_SESSION['settings']['decicard'];
$decigrades = $_SESSION['settings']['decigrades'];
$deciave = $_SESSION['settings']['deciave'];
$decigenave = $_SESSION['settings']['decigenave'];
$decifgenave = $_SESSION['settings']['decifgenave'];

// echo "deciave: $deciave<br />";


echo ($num_subjects==0)? '<h5 class="brown" >ZERO courses In Genave!</h5>':NULL;

?>


<?php $this->shovel('hdpdiv'); ?>


<h5>
	LSM Summarizer - General Average (<?=$num_students;?>)
	| <a href="<?php echo URL; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	<?php if($_SESSION['srid']!=RTEAC): ?>
		| <a href="<?php echo URL."rcards/crid/".$classroom['crid']."/$sy/$qtr"; ?>">Rpt Card</a> 	
	<?php endif; ?>	
	
	<?php $sqtr 	= $_SESSION['qtr']; ?>
	<?php $derivsem = ($sqtr<3)? 1:2; ?>
	<?php if($classroom['is_sem']): ?>
			| <a href='<?php echo URL."summarizers/genave/$crid/$sy/$sqtr/$derivsem"; ?>'><?php echo ($derivsem==1)? '1st':'2nd'; ?> Sem</a> 
			| <a href='<?php echo URL."summarizers/genave/$crid/$sy/$sqtr"; ?>'>Annual</a> 	
	<?php else: ?>
		<?php for($j=1;$j<$sqtr;$j++): ?>
			| <a href='<?php echo URL."summarizers/genave/$crid/$sy/$j/0"; ?>'>Q<?php echo $j; ?></a> 		
		<?php endfor; ?>
	<?php endif; ?>

<?php if(isset($_GET['alpha'])): ?>
		| <a href='<?php echo URL."summarizers/genave/$crid/$sy/$sqtr"; ?>'>By Genave</a> 	
<?php else: ?>
		| <a href='<?php echo URL."summarizers/genave/$crid/$sy/$sqtr?alpha"; ?>'>Alphabetical</a> 	
<?php endif; ?>


	
<?php $sems = array(0,1,2); ?>
	| <select id="semval" class="vc50" >
		<?php foreach($sems AS $sv): ?>
			<option><?php echo $sv; ?></option>
			<?php endforeach; ?>
		</select>
		<a class="button" onclick="jsredirect('summarizers/genave/'+crid+ds+sy+ds+qtr+'?sem='+$('#semval').val());" >Semestral</a>		
	
</h5>

<p>Please follow the sequence 1) Summarize  2) Ranking </p>



<?php 

$pcid 	= $_SESSION['user']['parent_id'];


?>


<div class="third" >
<table class='gis-table-bordered table-fx'>
	<tr class="hd" ><th class='white headrow'>CrID</th><td><?php echo $cr['crid']; ?></td></tr>

	<tr class="hd" ><th class='white bg-blue2' >Locking</th> 
		<th>
			<?php if($is_locked): ?>
				<a href='<?php echo URL."finalizers/openClassroom/$crid/$sy/$iqtr"; ?>' > Unlock </a>
			<?php else: ?>
				<a href='<?php echo URL."finalizers/closeClassroom/$crid/$sy/$iqtr"; ?>' > Unlock </a>			
			<?php endif; ?>				
		</th>
	</tr>	
	<tr><th class='white headrow'>Adviser</th><td><?php echo $cr['adviser']; ?></td></tr>
	<tr><th class='white headrow'>Classroom</th><td><?php echo $cr['level'].'-'.$cr['section']; ?></td></tr>
	<tr><th class='white headrow'>Status</th><td><?php echo 'Q'.$qtr.' - '; echo ($is_locked)? 'Closed' : 'Open' ; ?></td></tr> 

</table>
</div>

<div class="third" >
<table class='gis-table-bordered table-fx'>
	<tr><th class='white headrow'>Finalized Date</th>
		<td class="vc150" ><?php echo date('M-d, Y D',strtotime($classroom['finalized_date_q'.$qtr])); ?></td></tr> 
	<tr><th class='white headrow'>Printed Date</th>
		<td><?php echo date('M-d, Y D',strtotime($_SESSION['today'])); ?></td></tr> 
</table>
</div>


<div class="clear" ></div>

<p class="screen" > 

1) AG = Average stored in Database; TG = Computed Tallied Grades (based on data displayed on screen). 
<br /> > <span class="red" >Red</span> indicates mismatch in tally grades vs stored DB grades.
<br /> 2) Press <span class="underline" >Summarize</span> to update Average in Database. 

</p>




<?php 	if(empty($students)){ exit; }  ?>




<br />

<form method="POST" >

<table class='gis-table-bordered table-fx'>
<!-- row 1 data subjects iterator -->
<tr class='bg-blue2'>
		<th>#</th>
		<th>Scid</th>
		<th>Student</th>
		<th>Qtr</th>
	<!-- iterate subjects for headrow subject columns -->
	<?php foreach($subjects AS $row): ?>
		<th class="center <?php echo ($row['is_finalized_q'.$qtr]==0)? 'bg-red':NULL; ?>" >
			<?php if(($row['tcid'] == $pcid) || $admin): ?> 
				<a href='<?php echo URL."averages/course/".$row['course_id']."/$sy/$qtr"; ?>' ><?php echo $row['course_code']; ?></a>
			<?php else: ?>
				<?php echo $row['course_code']; ?>
			<?php endif; ?>
			<span class="hd"><br /> <?php echo $row['course_id']; ?></span>
		</th>	
	<?php endforeach; ?>
	<th class="center" >AG</th>
	<th class="center" >TG</th>
	<th class="hd" >SCID</th>
	<th class="hd center" >Sumid</th>
</tr>


<!-- ========================= grades iterator ================================= -->

<?php $num_diff = 0; ?>
<?php $g = 0; ?>
<?php foreach($grades AS $row): ?>

<?php 
	$q1t = 0; $q2t = 0; $q3t = 0; $q4t = 0; $q5t = 0; $q6t = 0; $ftg = 0; 
?>
		
	<?php for($j=1;$j<=$iqtr;$j++): ?>
	<?php $qqtr = 'q'.$j; ?>
		<tr>
			<?php if($j==1): ?>
				<td> <?php echo $g+1; ?> </td>
				<td> <?php echo $students[$g]['scid']; ?> </td>
				<td id="<?php echo $students[$g]['scid'].' : '; ?><?php echo $students[$g]['student_code']; ?>" ondblclick="alert(this.id);" > <?php echo $students[$g]['student']; ?> </td>
			<?php else: ?>
				<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
			<?php endif; ?>
			
			
			<td  class='colshading' >Q<?php echo $j; ?></td>
		<?php for($i=0;$i<$num_subjects;$i++): ?>		<!-- subject iterator per row -->
				<td  class='colshading' > <?php 
							$score  = (isset($row[$i][$qqtr]))? $row[$i][$qqtr] : 0;
							echo number_format($score,$decicard); 	
							$uscore = number_format($score,$decicard)*$row[$i]['units'] ;
							${'q'.$j.'t'} += $uscore;
														
					?>
				</td>								
		<?php endfor; ?>
			<?php 
			
			?>

			<!-- db.05_summaries.ave_q$qtr-->
			<td class="fg"> 
				<?php echo number_format($students[$g]['ave_q'.$j],$decigenave); ?> 
				<?php if($cr['is_k12']): ?>
					| <?php echo $students[$g]['ave_dg'.$j]; ?>
				<?php endif; ?>			
			</td>

		
			<!-- TG tally grades / q$jt or qtr$j  -->							
			<?php @${'q'.$j.'t'} = ${'q'.$j.'t'}/$total_units; $tg = number_format(${'q'.$j.'t'},$decigenave); ?>
				
			<td class="final <?php echo (number_format($students[$g]['ave_q'.$j],$decigenave) != $tg)? 'bg-salmon':null; ?>">
				<input class="vc50 center" name="sum[<?php echo $g; ?>][ave_q<?php echo $j; ?>]" value="<?php echo $tg; ?>"  readonly />
				<!-- add q1t to fgt -->
				<?php if(!$sem): ?>
					<?php $ftg += number_format(${'q'.$j.'t'},$decigenave); ?>				
				<?php else: ?>
					<?php 
						if($qtr<3){
							$ftg += number_format(${'q'.$j.'t'},$decigenave);							
						} else {
							$ftg = number_format(${'q3t'},$decigenave) + number_format(${'q4t'},$decigenave);
						}				
					?>				
				<?php endif; ?>					
				<?php if($cr['is_k12']): ?>
				<?php ${'rq'.$j.'t'} = ($is_k12)? round(${'q'.$j.'t'}) : ${'q'.$j.'t'}; ${'rq'.$j.'t'} = rating(${'rq'.$j.'t'},$ratings); ?>
				<?php $intype = ($is_k12)? 'text' : 'hidden'; ?>
				<input class="vc25 center" type="<?php echo $intype; ?>" name="sum[<?php echo $g; ?>][ave_dg<?php echo $j; ?>]"  
						value="<?php echo ${'rq'.$j.'t'}; ?>" readonly />			
				<?php endif; ?>					
			</td>								
		
			<td class="hd" > <?php echo $students[$g]['scid']; ?> </td>
			<td class="hd vc50 center vcenter"> <?php echo $students[$g]['sumid']; ?> </td>
			
			<td class="hd vc50 center vcenter"> <a href="<?php echo URL.$home.'/deleteSummaryScid/'.$sy.DS.$students[$g]['scid']; ?>" > Delete <?php echo $students[$g]['scid']; ?></a> </td>
						

			<!--  num_diff -->		
			<?php if($students[$g]['ave_q'.$j] != $tg){ $num_diff++; } ?>					
			
		</tr>
	<?php endfor; ?>	<!-- end for qtr iterator per row -->


<!-- ============================== for FG ROW not column ============================== -->
		<tr class="bg-gray3" >
			<!-- no colspan for columnHighlighting td column index -->
			<td>&nbsp;</td>
			<td>&nbsp;</td>			
			<td>&nbsp;</td>			
			<td class='colshading' >FG</td>

	<?php $total_fg = 0; ?>
	<?php for($i=0;$i<$num_subjects;$i++): ?> <!-- subject iterator -->			
			<?php 
				$uscore=isset($row[$i]['q'.$intfqtr])? $row[$i]['q'.$intfqtr]:0;
				$total_fg+=number_format($uscore,$deci);
				$units=$row[$i]['units'];
				
			?>
			<td class='colshading' > <?php echo number_format($uscore,$deci); ?></td>
	<?php endfor; ?>		<!-- subject iterator -->


			<!-- db.05_summaries.ave_q1-->
			<td> 
				<?php echo number_format($students[$g]['ave_q'.$intfqtr],$decifgenave); ?> 
				<?php if($cr['is_k12']): ?>
					| <?php echo $students[$g]['ave_dg'.$intfqtr]; ?>				
				<?php endif; ?>				
			</td>				
	
			<?php 
				$ftg /= $idiv; 
				$ftg=$total_fg/$num_subjects;
				
				
			?>
	
	<td> 
	<?php 	
			// echo 'tfg: '.$total_fg.'<br />'; 
			// echo 'numsub: '.$num_subjects.'<br />';
			// echo 'uscore: '.$uscore.'<br />';
	?>
	<input class="vc50 center" name="sum[<?php echo $g; ?>][ave]" 
		value="<?php echo number_format($ftg,$decigenave); ?>"  readonly />
				<?php if($cr['is_k12']): ?>
					<?php $rftg = ($is_k12)? round($ftg) : $ftg; $rftg = rating($rftg,$ratings); ?>
					<input class="vc25 center" type="<?php echo $intype; ?>" name="sum[<?php echo $g; ?>][ave_dg]"  
						value="<?php echo $rftg; ?>" readonly />			
				<?php endif; ?>		
		
	</td>
			<td class="hd" > <?php echo $students[$g]['scid']; ?> </td>			
			<td class="hd vc50 center vcenter"> <?php echo $students[$g]['sumid']; ?> </td>
			<td class="hd" ></td>
			
			
			<!--  num_diff -->		
			<?php if($students[$g]['ave_q5'] != $ftg){ $num_diff++; } ?>									
			<!-- hidden,for summaries need 2 params,1) scid,2) sy - no need to post  -->
			<input type="hidden" name="sum[<?php echo $g; ?>][sumid]" value="<?php echo $students[$g]['sumid']; ?>" >
	</tr>	
		
		
<?php $g++; ?>
<?php endforeach; ?>	<!-- end of grades iterator -->

</table> <br />

<input type="hidden" name="isk12" value="<?php echo $classroom['is_k12']; ?>"  />

<p>Please follow the sequence 1) Summarize  2) Ranking </p>

<?php if(($_SESSION['srid']==RMIS) || $_SESSION['srid']==RREG): ?>
	<input type="submit" name="summarize" value="1 - Summarize On"  />	
	<button><a class='txt-black no-underline' href='<?php echo URL."qcr/qcr/".$cr['crid']."/$sy/$qtr"; ?>' > 2 - Rank On </a></button> 
<?php endif; ?>


<?php 

$allowed = array(RMIS,RTEAC,RREG,RACAD);
$srid 	 = $_SESSION['user']['role_id'];

if(in_array($srid,$allowed)){ 
	if(!$is_locked){ echo '<input type="submit" name="summarize" value="1 - Summarize"  />'; echo " &nbsp;"; 
	} else {
		echo '<input type="submit" name="summarize" value="1 - Summarize On"  />'; echo " &nbsp;";		
	}	
	echo "<button><a class='txt-black no-underline' href=' ".URL."qcr/qcr/".$cr['crid'].DS.$sy.DS.$qtr."' > 2 - Ranking </a></button>"; 
} 

?>


</form>

<div class="ht100" ></div>


<?php 

?>


<!------------------------------------------------->

	

<script>

	var hdpass = '<?php echo HDPASS; ?>';
	var gurl 	= 'http://<?php echo GURL; ?>';
	var crid 	= '<?php echo $crid; ?>';
	var sy	 	= '<?php echo $sy; ?>';
	var qtr 	= '<?php echo $qtr; ?>';
	var ds 		= '/';
	


	$(function(){		
		// alert(crid+ds+sy+ds+qtr);
		$('#hdpdiv').hide();
		columnHighlighting();			
		hd();
	}) 
	
</script>



