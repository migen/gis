<!-- GController/qcr  -->
<?php

	
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
	
	// pr($students[0]);

	
?>



<!------------------------------------------------------------------------------------------------------------------------------->


<h5>
	<?php echo ($qtr<5)? "Q$qtr":"FG"; ?>
	Class Ranking

<span class="screen" >	
	| <a href="<?php echo URL.$home; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <span class="u" onclick="pclass('idno');" >ID No.</span>
	| <a href='<?php echo URL."summext/syncCrid/$crid"; ?>'>Sync SX</a>		

	
	<?php if($by_rank): ?>
		| <a href='<?php echo URL."qcr/qcr/".$classroom['id']."/$sy/$qtr/0"; ?>'>By Gender</a>
	<?php else: ?>
		| <a href='<?php echo URL."qcr/qcr/".$classroom['id']."/$sy/$qtr/1"; ?>'>By Ave</a>	
	<?php endif; ?>
	
	| <a href='<?php echo URL."qcr/qcrall/".$classroom['id']."/$sy/$qtr"; ?>'>Rank All</a>
	
	<?php for($j=1;$j<$sqtr;$j++): ?>
		| <a href='<?php echo URL."qcr/qcrdomino/$crid/$sy/$j"; ?>'>Q<?php echo $j; ?></a>	
	<?php endfor; ?>
		| <a href='<?php echo URL."qcr/qcrdomino/$crid/$sy/$intfqtr"; ?>'>FG</a>
	
</span>
	
</h5>

<h4>
	<?php 
		$d['crid'] 	= $crid;
		$d['sy'] 	= $sy;
		$d['qtr'] 	= $qtr;
		$d['sem'] 	= isset($sem)? $sem:0;
		$d['admin'] = isset($admin)? $admin:false;
		$this->shovel('cir',$d); 
	?>
</h4>




<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
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


$rgrade 	= $sgs['rank_grade'];
$rgenave 	= $sgs['rank_genave'];
$rconduct 	= $sgs['rank_conduct'];	

 

?>

<!-- =============================================  page details ============================================= -->

<div class="third" > 
<table class='gis-table-bordered table-fx'>
	<tr class="hd" ><th class='white headrow'>-type</th><td><?php echo '123 Editable'; ?></td></tr>
	<tr class="hd" ><th class='white headrow'>-crid</th><td><?php echo $cr['id']; ?></td></tr>
	<tr><th class='white headrow'>Classroom</th><td><?php echo $cr['level'].' - '.$cr['section']; ?></td></tr>
	<tr><th class='white headrow'>Adviser</th><td><?php echo $cr['adviser']; ?></td></tr>
	<tr><th class='white headrow'>Status</th>
		<td><?php 	
				echo ($qtr>4)?"FG":"Q$qtr"; echo ($qtr==6)? ' (2nd Sem)':NULL;
				echo " - "; 
				echo ($is_locked)? 'Closed' : 'Open'; 
			?>
		</td></tr> 
		
	<tr class="hd" ><th class='white headrow' >Locking</th> 
		<th>		
			<?php if($is_locked): ?>
				<a href='<?php echo URL."finalizers/openClassroom/$crid/$sy/$qtr"; ?>' > Unlock </a>
			<?php else: ?>
				<a href='<?php echo URL."finalizers/closeClassroom/$crid/$sy/$qtr"; ?>' > Lock </a>
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
		<th class="idno" >Scid</th>
		<th class="idno" >ID No.</th>
		<th>Student</th>

		
<!-- iterate subjects for headrow subject columns -->
	
	<?php foreach($data['subjects'] AS $row): ?>
		<th class="center <?php echo (!$row['is_finalized_q'.$iqtr])? 'bg-red' : null; ?> " >
			<?php echo $row['course_code']; ?>		
			<span class="hd"><br /> <?php echo $row['course_id']; ?> </span>
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
	<th class="center" >Tie</th>

		
	<th class="hd center" >SCID</th>	
	<th class="hd center" >Sumid</th>
</tr>

<!---------------------- data --------------------------------------------------------------->


<!-- grades iterator,$s for students,$i for grades -->

<?php $s=0; ?>
<?php $rank=0; ?>
<?php $cspan=$num_subjects+10; ?>
<?php foreach($grades AS $row): ?>

<?php 
	$t=$s+1; 
	$r=$s-1; 
?>


<?php $num_grades=count($row); ?>
	
<?php if($num_grades!=$num_subjects): ?>
		<tr>				
			<td colspan="<?php echo $cspan; ?>" > 
				<?php echo $num_grades.' vs '.$num_subjects; ?> - 
				Incomplete Records of <?php echo $students[$s]['studcode'].' - '.$students[$s]['student']; ?> 
			</td>	
		</tr>	
<?php else: ?>
	
		
	<?php 	$qualified = $students[$s]['is_qualified_q'.$qtr]; ?>
	<?php 	$qqtr = 'q'.$qtr; ?>
	
		
<tr>		
	<td><?php echo $t; ?>
	</td>
	<td id="qfd-<?php echo $s; ?>" ><?php echo ($qualified)? 'Y':'-'; ?></td>
	<td class="idno" ><?php echo $students[$s]['scid']; ?></td>
	<td class="idno" ><?php echo $students[$s]['studcode']; ?></td>
	<td id="<?php echo $students[$s]['scid'].' : '.$students[$s]['studcode']; ?>" 
		ondblclick="alert(this.id);" ><?php echo $students[$s]['student']; ?></td>						

<!--------------------------------------------------------------------------------------------------------->
		
	<?php for($i=0;$i<$num_subjects;$i++): ?>	<!-- subjects iterator -->	
			<?php 
				$disqfd = false;
				$grade  = (isset($row[$i]['q'.$qtr]))? $row[$i]['q'.$qtr] : 0;				
				if(($row[$i]['affects_ranking']) && (number_format($grade,$decigrades) < $rgrade)) { $qualified = false; $disqfd = true; }
			?>	
			<td class="colshading center <?php echo ($disqfd)? 'red':NULL; ?>" >
				<?php echo number_format($grade,$decigrades); ?>			
				<?php if($is_k12): ?>
						<br /><?php echo @$row[$i]['dg'.$qtr]; ?>			
				<?php endif; ?>				
			</td>
	<?php endfor; ?>	<!-- subjects iterator -->


<!------------------------------------------------------------------------------------------------------------------------------->	
	
			<!-- CG / db.sum conduct_qqtr -->	
			<?php $cg = $students[$s]['conduct_q'.$qtr];  ?>
			<?php $qfd_cond = true; ?>
			<?php if($condar): ?>
				<?php	if($cg < $rconduct) { $qfd_cond = false; $qualified = false; }  ?>							
			<?php endif; ?>
			<td class="center vcenter <?php echo (!$qfd_cond)? 'red':NULL; ?>" >
				<?php echo number_format($cg,$decigrades); ?>
				<?php if($is_k12) { $cdg = $students[$s]['conduct_dg'.$qtr]; echo $cdg; } ?>							 
			</td>	
	
			<!-- AG / db summaries ave_qqtr -->
			<td class="center vcenter <?php echo ($is_tied)? 'bg-blue2 b':null; ?>" > 
				<?php $fg = $students[$s]['ave_q'.$qtr]; echo number_format($fg,$decigenave);  ?>	
				<?php $is_tied = false; ?>
				<?php	if($fg < $rgenave) { $qualified = false; }  ?>							
				<?php if($is_k12): ?><?php $dg = $students[$s]['ave_dg'.$qtr]; echo $dg; ?><?php endif; ?>		
			</td>

<!------------------------------------------------------------------------------------------------------------------------------->
			
	<!-- rank -->
			<td class="center vcenter " > <?php echo ($students[$s]['rank_classroom_q'.$qtr] != 0)? 
				number_format($students[$s]['rank_classroom_q'.$qtr],$deciranks) : '-'; ?> 				
			</td>
			
<?php if($lrdomino): ?>
	<?php for($qr=1;$qr<$qtr;$qr++): ?>
		<?php if($students[$s]['rank_classroom_q'.$qr] < 1){ $qualified=false; } ?>		
		<td class="center vcenter" ><?php $rqr = $students[$s]['rank_classroom_q'.$qr]; 
			echo ($rqr=='0')? '-':$students[$s]['rank_classroom_q'.$qr] ?>			
		</td>
	<?php endfor; ?>	
<?php endif; ?>
			

<!-- trace tdclass -->

	<?php 
		 
		$same = false;
		$prev 	= @$students[$r]['ave_q'.$qtr];				
		$mine 	= $students[$s]['ave_q'.$qtr];				
		if($mine == $prev){  $same = true; }
		if($qualified){ $rank++; $val = $rank; } else { $val = $dqval; }				
 
	?>				

<!--- peek trace --->
	
	<!-- sort tdclass -->
	<td class="sort center vcenter  " >			
		<input class="vc50 center <?php echo (!$qualified)? 'red':NULL; ?>" 
			name="rank[<?php echo $s; ?>][val]" value="<?php echo $val; ?>"  />
		<?php if($students[$s]['rank_classroom_q'.$qtr] != $rank){ $num_diff++; } ?>								
		
	</td>
				
	<td class="<?php echo ($same)? 'red':NULL; ?>" ><?php echo ($same)? 'Tie':NULL; ?></td>			

<!-- ------------- removed qfinal below due to q5 ----------------------- -->

	<input class="vc50 center" type="hidden" name="rank[<?php echo $s; ?>][scid]" value="<?php echo $students[$s]['scid']; ?>" readonly />	
	<td class="hd vc50 vcenter"><?php echo $students[$s]['scid']; ?></td>			
	<td class="hd vc50 center vcenter"> <?php echo $students[$s]['sumid']; ?> </td>		

			<input type="hidden" id="scid<?php echo $s; ?>" value="<?php echo $students[$s]['scid']; ?>"  >		
	<td class="hd vc50 center vcenter">
		<?php if($students[$s]['is_qualified_q'.$qtr]==1): ?>
			<a class='button' id='btn-<?php echo $s; ?>' onclick="disqualifySumscid(<?php echo $s; ?>);return false;" >Disqualify</a>
		<?php else: ?>
			<a class='button' id='btn-<?php echo $s; ?>' onclick="qualifySumscid(<?php echo $s; ?>);return false;" >Qualify</a>		
		<?php endif; ?>
	</td>		
	
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
		nextViaEnter();	
		selectFocused();
		columnHighlighting();	
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
	
	
	function qualifySumscid(i){
		var vurl 	= gurl + '/ajax/xstudents.php';	
		var task	= "qualifySumscid";		
		var scid	= $('#scid'+i).val();
	
		$.ajax({
			url: vurl,
			type: 'POST',
			data: 'task='+task+'&scid='+scid+'&qtr='+qtr,				
			async: true,
			success: function() {
				$('#btn-'+i).hide();
				$('#qfd-'+i).text('Y');
			}		  
		});				
	
	}


	function disqualifySumscid(i){
		var vurl 	= gurl + '/ajax/xstudents.php';	
		var task	= "disqualifySumscid";		
		var scid	= $('#scid'+i).val();
	
		$.ajax({
			url: vurl,
			type: 'POST',
			data: 'task='+task+'&scid='+scid+'&qtr='+qtr,				
			async: true,
			success: function() {
				$('#btn-'+i).hide();			
				$('#qfd-'+i).text('-');			
			}		  
		});				
	
	}
	
	
</script>
