<!-- GController/qcr  -->
<?php
	// echo 'qcrall';
	
	
	$condar 	= $classroom['conduct_affects_ranking'];
	$lrdomino 	= $_SESSION['settings']['lrdomino'];	 
	
	$deciscores = $_SESSION['settings']['deciscores'];
	$decigrades = $_SESSION['settings']['decigrades'];
	$decipnv 	= $_SESSION['settings']['decipnv'];
	$decitnv 	= $_SESSION['settings']['decitnv'];
	$deciftnv 	= $_SESSION['settings']['deciftnv'];
	$deciranks 	= $_SESSION['settings']['deciranks'];
	$decifconducts 	= $_SESSION['settings']['decifconducts'];
	$decigenave 	= $_SESSION['settings']['decigenave'];
	$decifgenave 	= $_SESSION['settings']['decifgenave'];
	$tqtr		= ($qtr<5)? $qtr:4; 	/* true qtr */
	
	
?>



<h5>
	<?php echo ucfirst($qf); ?>
	Class Ranking | <?php $this->shovel('homelinks'); ?>

<span class="screen" >	
	| <a href="<?php echo URL.'submissions/view/'.$classroom['id'].DS.$sy.DS.$qtr; ?>">Submissions</a>
	| <a href='<?php echo URL."matrix/grades/".$classroom['id']."/$sy/$qtr"; ?>'>Matrix</a>
	| <a href='<?php echo URL."mcr/view/".$classroom['id']."/$sy/$qtr"; ?>'>MCR</a>
	| <a href='<?php echo URL."reports/ccr/".$classroom['id']."/$sy/$qtr"; ?>'>CCR</a>
	| <a href="<?php echo URL.'summarizers/genave/'.$classroom['id'].DS.$sy.DS.$qtr; ?>">Summarizer</a>
	<?php if($qtr==7): ?>
		| <a href="<?php echo URL.'summarizers/genave/'.$classroom['id'].DS.$sy.DS.$qtr; ?>">Retally Oave</a>
	<?php endif; ?>
	
	<?php if($by_rank): ?>
		| <a href="<?php echo URL.'qcr/qcr/'.$classroom['id'].DS.$sy.DS.$qtr.DS.'0'; ?>">By Gender</a>
	<?php else: ?>
		| <a href="<?php echo URL.'qcr/qcr/'.$classroom['id'].DS.$sy.DS.$qtr.DS.'1'; ?>">By Average</a>	
	<?php endif; ?>
	
	<?php 
		if($qtr == 4 && $is_locked){	/* finals */
			echo "| <a href=' ".URL."qcr/qcr/".$classroom['crid'].DS.$sy."/5' > Final Report  </a>";	
		}
	?>
	
	| <a href='<?php echo URL."qcr/qcrsplit/".$classroom['id']."/$sy/$qtr"; ?>'>Split</a>	
	| <a href='<?php echo URL."qcr/qcr/".$classroom['id']."/$sy/$qtr"; ?>'>Qualified</a>
	
</span>
	

</h5>


<?php $this->shovel('hdpdiv'); ?>



<?php 

$cr  		= $classroom;
$sgs 		= $_SESSION['settings'];
$is_k12		= $classroom['is_k12'];	// $is_bedk12
$birt_k12 	= ($is_k12)? '_k12' : '';

$is_tied 	= false;
$qualified	=	true;
$dqval      = '0';

$num_diff	= '0';


/* ----------------------------------------------------------------------------------------------- */

	$rflrgr 	= $sgs['rank_grade'];
	$rgaflrgr 	= $sgs['rank_genave'];
	$rctflrgr 	= $sgs['rank_conduct'];		

?>

<!-- =============================================  page details ============================================= -->

<div class="third" > 
<table class='gis-table-bordered table-fx'>
	<tr class="hd" ><th class='white headrow'>-type</th><td><?php echo '123 Editable'; ?></td></tr>
	<tr class="hd" ><th class='white headrow'>-crid</th><td><?php echo $cr['id']; ?></td></tr>
	<tr><th class='white headrow'>Classroom</th><td><?php echo $cr['level'].' - '.$cr['section']; ?></td></tr>
	<tr><th class='white headrow'>Adviser</th><td><?php echo $cr['adviser']; ?></td></tr>
	<tr><th class='white headrow'>Quarter</th><td><?php echo ($qtr<5)?'Q'.$qtr:'FG'; { echo " - "; 
			echo ($is_locked)? 'Closed' : 'Open'; } ?></td></tr> 
		
	<tr class="hd" ><th class='white headrow' >Locking</th> 
		<th>		
			<?php if($is_locked): ?>
				<a href="<?php echo URL.'finalizers/openClassroom/'.$cr['id'].DS.$sy.DS.$qtr; ?>" > Unlock </a>
			<?php else: ?>
				<a href="<?php echo URL.'finalizers/closeClassroom/'.$cr['id'].DS.$sy.DS.$qtr; ?>" > Lock </a>			
			<?php endif; ?>				
		</th>
	</tr>			
</table>


</div>


<div class="third" >
<table class="f12 gis-table-bordered table-fx">
	<tr class="headrow" >
		<th>#</th>
		<th>Legends:</th>
	</tr>
	<tr> <td>1</td><td>AG - Average Grade</td> </tr>
	<tr> <td>2</td><td>DG - Descriptive Grade</td> </tr>
	<tr> <td>3</td><td>CG - Conduct Grade / Traits </td> </tr>
	<tr> <td>4</td><td>CDG - Conduct / Traits Descriptive Grade  </td> </tr>
	<tr> <td>5</td><td>Red Subject - Pending submission </td> </tr>
</table>
</div>


<div class='clear'></div>


<br />

<h4 class="sort" >Remove Number and <span class="red" >Leave Blank</span> 
if <span class="red" >No Rank</span> and Adjust Others accordingly.</h4>

<!-- =============================================  end of page details ============================================= -->


		

<form method="POST" >

<table class='gis-table-bordered table-fx'>
<!-- ------------- headrow / subjects iterator -->
	<tr class='bg-blue2'>
		<th>#</th>
		<th>Qfd</th>
		<th>Scid</th>
		<th>Student</th>

		
<!-- iterate subjects for headrow subject columns -->
	
	<?php foreach($data['subjects'] AS $row): ?>
		<th class="center <?php echo (!$row['is_finalized_q'.$tqtr])? 'bg-red' : null; ?> " >
			<?php echo $row['course_code']; ?>		
			<span class="hd"><br /> <?php echo $row['course_id']; ?> </span>
			<?php // echo $row['is_finalized_q'.$qtr]; ?>
		</th>	
	<?php endforeach; ?>	
<!-- end of subjects iterator -->	
	
	<th class="center">CG
		<?php if($is_k12): ?> CDG <?php endif; ?>
	</th>	
	
	<th class="center">AG
		<?php if($is_k12): ?> DG <?php endif; ?>
	</th>
		
	<th class="center underline" ><?php echo ($qtr<5)?"Q$qtr":'FG'; ?></th>
	
	<?php if($lrdomino): ?>
		<?php for($qr=1;$qr<$qtr;$qr++): ?>
			<th class="center" ><?php echo "Q$qr"; ?></th>			
		<?php endfor; ?>
	<?php endif; ?>

	<!-- tdsort -->
	<th class="sort center" >Sort</th>

		
	<th class="hd center" >SCID</th>	
	<th class="hd center" >Sumid</th>
</tr>

<!---------------------- data --------------------------------------------------------------->


<!-- grades iterator,$s for students,$i for grades -->

<?php $s = 0; ?>
<?php $rank 	= 1; ?>
<?php $cspan 	= $num_subjects+10; ?>
<?php foreach($grades AS $row): ?>
<?php $t = $s+1; ?>


<?php $num_grades = count($row); ?>
	
<?php if($num_grades != $num_subjects): ?>
		<tr>				
			<td colspan="<?php echo $cspan; ?>" > 
				<?php echo $num_grades.' vs '.$num_subjects; ?> - 
				Incomplete Records of <?php echo $students[$s]['student_code'].' - '.$students[$s]['student']; ?> 
			</td>	
		</tr>	
<?php else: ?>
	
		
	<?php 	$qualified = $students[$s]['is_qualified_q'.$qtr]; ?>
	<?php 	$qqtr = 'q'.$qtr; ?>
	
		
<tr>		
	<td><?php echo $t; ?>
		<?php // echo "qualfd: ".$students[$s]['is_qualified_q'.$qtr]; ?>
	</td>
	<td><?php echo ($qualified)? 'Y':'-'; ?></td>
	<td><?php echo $students[$s]['scid']; ?></td>
	<td id="<?php echo $students[$s]['scid'].' : '.$students[$s]['student_code']; ?>" 
		ondblclick="alert(this.id);" ><?php echo $students[$s]['student']; ?></td>						

<!--------------------------------------------------------------------------------------------------------->
<!-- if qcr NOT fcr / final classroom ranking -->
<?php if($qf != 'q5'): ?>	
		
	<?php for($i=0;$i<$num_subjects;$i++): ?>	<!-- subjects iterator -->	
			<td class='colshading center' ><?php 
					$grade  = (isset($row[$i]['q'.$qtr]))? $row[$i]['q'.$qtr] : 0;
					echo number_format($grade,$decigrades);			
				?>
				<br />
		<!-- ============ dg =============== -->
			<?php if($is_k12): ?>
					<?php echo @$row[$i]['dg'.$qtr]; ?>			
			<?php endif; ?>
				
				<?php 
					if(($row[$i]['affects_ranking']) && (number_format($grade,$decigrades) < $rflrgr)) { $qualified = false; }
				?>
			</td>
	<?php endfor; ?>	<!-- subjects iterator -->


<!------------------------------------------------------------------------------------------------------------------------------->	
	
			<!-- CG / db.sum conduct_qqtr -->	
			<td class="center vcenter" >
				<?php $cg = $students[$s]['conduct_q'.$qtr]; echo number_format($cg,$decigrades); ?>	
				<?php if($condar): ?>
					<?php	if($cg < $rctflrgr) { $qualified = false; }  ?>							
				<?php endif; ?>
				<?php if($is_k12): ?><?php $cdg = $students[$s]['conduct_dg'.$qtr]; echo $cdg; ?>							 
				<?php endif; ?>						
			</td>	
	
			<!-- AG / db summaries ave_qqtr -->
			<td class="center vcenter <?php echo ($is_tied)? 'bg-blue2 b':null; ?>" > 
				<?php $fg = $students[$s]['ave_q'.$qtr]; echo number_format($fg,$decigenave);  ?>	
				<?php $is_tied = false; ?>
				<?php	if($fg < $rgaflrgr) { $qualified = false; }  ?>							
				<?php if($is_k12): ?><?php $dg = $students[$s]['ave_dg'.$qtr]; echo $dg; ?><?php endif; ?>		
			</td>

<!------------------------------------------------------------------------------------------------------------------------------->
			
	<!-- rank -->
			<td class="center vcenter" > <?php echo ($students[$s]['rank_classroom_q'.$qtr] != 0)? 
				number_format($students[$s]['rank_classroom_q'.$qtr],$deciranks) : '-'; ?> 
				<?php // echo $students[$s]['rank_classroom_q'.$qtr]; echo $qtr; ?>
			</td>
			
<?php if($lrdomino): ?>
	<?php for($qr=1;$qr<$qtr;$qr++): ?>
		<?php if($students[$s]['rank_classroom_q'.$qr] == '0'){ $qualified=false; } ?>		
		<td class="center vcenter" ><?php $rqr = $students[$s]['rank_classroom_q'.$qr]; 
			echo ($rqr=='0')? '-':$students[$s]['rank_classroom_q'.$qr] ?>			
		</td>
	<?php endfor; ?>	
<?php endif; ?>
			
<?php 
	// $mine 	= $students[$s]['ave_q'.$qtr];				
	// $his 	= @$students[$t]['ave_q'.$qtr];
	// if($mine == $his){ $is_tied = true; } 
	// $val	= $rank;
	// $qualified = true;
	// if(!$qualified){ $val = $dqval; } else { $rank++; }
	
	$mine 	= $students[$s]['ave_q'.$qtr];				
	$his 	= @$students[$t]['ave_q'.$qtr];
	if($mine == $his){ $is_tied = true; } 
	$val	= $rank;
	if($mine == $his){ $is_tied = true; } else { $rank++; } 

	
	
?>				
		
	
	<!-- sort tdclass -->
	<td class="sort center vcenter " >			
		<?php $intype = ($val!='0')? 'text' : 'text'; ?>	
		<input type="<?php echo $intype; ?>" class="vc50 center <?php echo ($rank=='0')? 'white': null; ?>" 
			name="rank[<?php echo $s; ?>][val]" value="<?php echo $val; ?>"  />
		<?php if($students[$s]['rank_classroom_q'.$qtr] != $val){ $num_diff++; } ?>								
		
	</td>
			


<?php else: ?>		<!-- fcr below -->
<!-- ======================================= for FG ROW / FCR  ($qf == final) ================================================== -->

	<?php for($i=0;$i<$num_subjects;$i++): ?>	<!-- subjects iterator -->	
		<td class='colshading center' ><?php 
				$grade  = (isset($row[$i]['q5']))? $row[$i]['q5'] : 0;
				echo number_format($grade,$decigenave);										
			?>
			<!-- dg -->
			<?php if($is_k12): ?><br /><?php echo $row[$i]['dg5']; ?><?php endif; ?>	
			<?php 
				if($grade < $rflrgr) { $qualified = false; }
				if($students[$s]['conduct_q5'] < $rctflrgr) { $qualified = false;  }			
			?>
		</td>
	<?php endfor; ?>	<!-- subjects iterator -->
	
<!------------------------------------------------------------------------------------------------------------------------------->
			<?php 
				// $mine 	= $students[$s]['ave_q5'];				
				// $his 	= @$students[$t]['ave_q5'];
				// if($mine == $his){ $is_tied = true; } 
				// $val	= $rank;
				// if(!$qualified){ $val = $dqval; } else { $rank++; }
				
		// $mine 	= $ranks[$i]['grade'];				
		// @$his 	= $ranks[$j]['grade'];	
		// $val	= $rank;				
		// if($mine == $his){ $is_tied = true; } else { $rank++; } 
				
				$mine 	= $students[$s]['ave_q5'];				
				$his 	= @$students[$t]['ave_q5'];
				if($mine == $his){ $is_tied = true; } 
				$val	= $rank;
				if($mine == $his){ $is_tied = true; } else { $rank++; } 
								
			?>				

<!------------------------------------------------------------------------------------------------------------------------------->	
	

	<!-- CGF db.sum conduct_qqtr -->	
	<?php $cg = $students[$s]['conduct_q5']; ?>
	<td class="center vcenter" > <?php echo number_format($cg,$decifconducts);  ?>	
		<?php	if($cg < $rctflrgr) { $qualified = false; }  ?>							
		<?php if($is_k12): ?><br /><?php $cdg = $students[$s]['conduct_dg5']; echo $cdg; ?><?php endif; ?>						
	</td>	

	<!-- AGF / db summaries ave_qqtr -->
	<?php $fg = $students[$s]['ave_q5']; ?>
	<td class="center vcenter <?php echo ($is_tied)? 'bg-blue2 b':null; ?> " > <?php echo number_format($fg,$decifgenave);  ?>	
		<?php $is_tied = false; ?>
		<?php	if($fg < $rgaflrgr) { $qualified = false; }  ?>							
		<?php if($is_k12): ?><br /><?php $dg = $students[$s]['ave_dg5']; echo $dg; ?> <?php endif; ?>		
	</td>
	
	
	<!-- rank -->
	<td class="center vcenter" ><?php echo ($students[$s]['rank_classroom_q5'] != 0)? number_format($students[$s]['rank_classroom_q5'],$deciranks) : '-'; ?></td>
	
<?php if($lrdomino): ?>
	<?php for($qr=1;$qr<$qtr;$qr++): ?>
		<?php if($students[$s]['rank_classroom_q'.$qr] == '0'){ $qualified=false; } ?>		
		<td class="center vcenter" ><?php $rqr = $students[$s]['rank_classroom_q'.$qr]; 
			echo ($rqr=='0')? '-':$students[$s]['rank_classroom_q'.$qr] ?>			
		</td>
	<?php endfor; ?>	
<?php endif; ?>
	
	<!-- sort tdclass="sort"-->
	<?php $intype = ($val!='0')? 'text' : 'text'; ?>		
	<td class="sort" ><input type="<?php echo $intype; ?>" class="center vc50" name="rank[<?php echo $s; ?>][val]" 
		value="<?php echo $val; ?>"  /></td>
	<?php if($students[$s]['rank_classroom_q5'] != $val){ $num_diff++; } ?>								
			

<!-- ========================  end of FG Row / $qf=='final' ===================================== -->
<?php endif; ?>	<!-- fcr -->

	<input class="vc50 center" type="hidden" name="rank[<?php echo $s; ?>][sumid]" value="<?php echo $students[$s]['sumid']; ?>" readonly />	
	<td class="hd vc50 vcenter"><?php echo $students[$s]['scid']; ?></td>			
	<td class="hd vc50 center vcenter"> <?php echo $students[$s]['sumid']; ?> </td>		
	<td class="hd vc50 center vcenter"><input class="center vc30" id="qfd<?php echo $s; ?>" 
		value="<?php echo $students[$s]['is_qualified_q'.$qtr]; ?>" ></td>		
			<input type="hidden" id="scid<?php echo $s; ?>" value="<?php echo $students[$s]['scid']; ?>"  >		
	<td class="hd vc50 center vcenter"><button onclick="xeditQualified(<?php echo $s; ?>);" >
		Update Qfd</button></td>		
	
</tr>


<?php endif; ?>	<!-- if complete grades -->



<?php $s++; ?>
<?php endforeach; ?>	<!-- end of students / $grades iterator -->

</table>

<br />

<!------------------ buttons ----------------------------------------------------------------->

<div class="screen" >

<?php if(($_SESSION['srid']==RMIS) || $_SESSION['srid']==RREG): ?>
	<button id="sortBtn" onclick="editRanks();return false;">Sort On</button>
	<input onclick="return confirm('Are you sure?');" class="sort" type="submit" name="submit" value="Update On"  >
<?php endif; ?>

<?php if(!$is_locked): ?>
	<button id="sortBtn" onclick="editRanks();return false;">Sort</button>
	<input onclick="return confirm('Are you sure?');" class="sort" type="submit" name="submit" value="Update"  >
	<button id="cancelBtn" onclick="editRanks();return false;">Cancel</button>
<?php endif; ?>

</div>


</form>



<!-- ====================== legends ================================================ -->


<!------------------------------------------------------------------------------------------------------------------------------->



<script>
	var gurl     = 'http://<?php echo GURL; ?>';
	var hdpass = '<?php echo HDPASS; ?>';
	var qtr = "<?php echo $qtr; ?>";

	$(function(){	
		columnHighlighting();	
		nextViaEnter();	
		selectFocused();
		$('#hdpdiv').hide();
		hd();
		$('.sort').hide();
		$('#cancelBtn').hide();	
		
		
	});
	
	function editRanks(){
		$('#sortBtn').toggle();	
		$('#cancelBtn').toggle();	
		$('.sort').toggle();	
	}
	

	function xeditQualified(i){
		var vurl 	= gurl + '/ajax/xstudents.php';	
		var task	= "xeditQualified";
		
		var scid	  = $('#scid'+i).val();
		var qualified = $('#qfd'+i).val();
		// alert(scid+','+i+','+qualified);
	
		$.ajax({
			url: vurl,
			type: 'POST',
			data: 'task='+task+'&scid='+scid+'&qualified='+qualified+'&qtr='+qtr,				
			async: true,
			success: function() {}		  
		});				
	
	}
	
	
</script>
