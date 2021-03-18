<!--
ranking - mcs
anne	- 92	- 1.5
beth	- 92	- 1.5
cath	- 91	- 3


path: views/registrars/QLR.php

-->


<?php 
// pr($data);
// pr($level);


$decigrades = $_SESSION['settings']['decigrades'];
$decigenave = $_SESSION['settings']['decigenave'];
$deciranks  = $_SESSION['settings']['deciranks'];



?>

<?php if($qtr<5 && $num_open): ?>
<h4 class="red" >Cannot print due to Unfinalized classrooms below.</h4>
<table class="gis-table-bordered table-fx" >
<tr class="" ><th>ID</th><th><span class="" >Not Yet Finalized</span></th></tr>
<?php for($i=0;$i<$num_open;$i++): ?>
<tr><td><?php echo $open_crids[$i]['crid']; ?></td><td><?php echo $open_crids[$i]['cr']; ?></td></tr>
<?php endfor; ?>
</table>		
<?php else: ?>
<h4 class=" screen red" >All Classroom Sections Finalized.</h4>
<?php endif; ?>

<!---------------------------------------------------------------------------------------------------------------------------------->


<h5>
	<span class="" ><?php echo $level['level']; ?> Honors Ranking - <?php echo ucfirst($qf); ?></span>
	| <a href="<?php echo URL; ?>registrars">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	<?php if($qf=='q4'): ?>
		| <a href="<?php echo URL.'registrars/qlr/'.$level_id.DS.$sy.'/5'; ?>">Final</a>	
	<?php endif; ?>
	| <a href="<?php echo URL.'registrars/qlra/'.$level_id.DS.$sy.DS.$qtr; ?>">Batch Ranking</a>	
	<?php if($continuous): ?>
		| <a href='<?php echo URL."registrars/qlr/$level_id/$sy/$qtr"; ?>'  >Tie</a>
	<?php else: ?>
		| <a href='<?php echo URL."registrars/qlr/$level_id/$sy/$qtr&continuous"; ?>'  >Continuous</a>
	<?php endif; ?>	
</h5>


<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
<p><?php $this->shovel('hdpdiv'); ?></p>


<?php 


// pr($data);
// pr($curr_qtr);
// pr($students[0]);
// pr($regulars[0]);


$aveq = ($qtr ==5)? 'ave_q5' : 'ave_q'.$qtr;

// pr($aveq);

// ================= DEFINE VARS ==========================================	
	
	
$is_tied 	= false;
$dqval	  	= '0';


	
?>


<form method="POST" >

<!-- ============================= HONORS  ==================================================================== -->

<h5> With Honors </h5>

<table class='gis-table-bordered table-fx'>
<thead>
	<!-- row 1 data subjects iterator -->
	<tr class='bg-blue2'>
	<th class="vc30" >#</th>
	<th class="sort" >Sum#</th>
	<th class="vc120" >Code</th>
	<th class="vc400" >Student</th>
	<th class="vc100 center" >Classroom</th>
	<th class="vc50 center"><?php echo ucfirst($qf); ?></th>
	<th class="vc50 center" >Rank</th>
	<th class="vc50 sort center" >Sort</th>
	<th class="vc30" >Tie</th>
	<th class="hd" >SCID</th>
	<th class="hd center" >Sumid</th>
	<th class="hd" >CrR</th>
	</tr>
</thead>

<tbody>

<!-- row 1 grades iterator,$s for students,$g for grades -->

<?php $rank = 1; ?>
<?php for($s=0;$s<$num_students;$s++): ?>
<?php $t = $s+1; ?>
<?php $qualified = true; ?>

		<tr>
			<td><?php echo $t; ?></td>
			<td class="sort" ><?php echo $students[$s]['sumid']; ?></td>			
			<td><?php echo $students[$s]['student_code']; ?></td>
			<td><?php echo $students[$s]['student']; ?></td>			
			<td><?php echo $students[$s]['classroom']; ?></td>			

						
			<!-- db summaries ave_qqtr -->
					
			<td class="center <?php echo ($ties)? 'bg-blue2 b':null; ?>" ><?php echo number_format($students[$s][$aveq],$decigenave); ?></td>	
			<td class="center" ><?php echo number_format($students[$s]['rank_level_'.$qf],$deciranks); ?></td>	

			<!-- rank -->
			<td class="sort <?php echo ($is_tied)? 'bg-red' : null; ?>" >
						
				<input class="vc50 center <?php echo ($is_tied)? 'red':null; ?>" name="rank[<?php echo $s; ?>][qtr]" 
					value="<?php echo $rank; ?>"  />
					<?php $is_tied = false; ?>
				<input class="vc50 center" type="hidden" name="rank[<?php echo $s; ?>][sumid]" value="<?php echo $students[$s]['sumid']; ?>"  />											
			</td>
			
			<?php 

/* 				
				$t = $s+1;
				$same = $students[$s]['ave_'.$qf]==@$students[$t]['ave_'.$qf];					
				if($continuous){
					$rank++;				
				} else {
					if(!$same){ $rank++; }				
				}
 */				
 
				// $same = false;
				$t = $s+1;
				$mine = $students[$s]['ave_'.$qf];
				$his  = @$students[$t]['ave_'.$qf];
				$same = ($mine == $his)? true:false;					
				if($continuous){
					$rank++;				
				} else {
					if(!$same){ $rank++; }				
				}
 
 
 
 
			?>				

			<td class="<?php echo ($same)? 'red':NULL; ?>" ><?php echo ($same)? 'Tie':NULL; ; ?></td>			
			<td class="hd" ><?php echo $students[$s]['scid']; ?></td>
			<td class="hd" > <?php echo $students[$s]['sumid']; ?> </td>
			<td class="hd" > <?php echo $students[$s]['rank_classroom_'.$qf]; ?> </td>
		</tr>

		
		
<?php endfor; ?>

</tbody>
</table>

<div class="clear"></div><hr />

<!-- for non final qtr -->

<!-- ============================= REGULARS  ==================================================================== -->


<h5> No Honors </h5>

<table class='gis-table-bordered table-fx'>
<thead>
	<!-- row 1 data subjects iterator -->
	<tr class='bg-blue2'>
		<th class="vc30" >#</th>
		<th class="sort" >Sum#</th>
		<th class="vc120" >Code</th>
		<th class="vc400" >Student</th>
	<th class="vc100 center" >Classroom</th>
	<th class="vc50 center"><?php echo ucfirst($qf); ?></th>
	<th class="vc50 center" >Rank</th>
	<th class="sort vc50 center" >Sort</th>
	<th class="vc30" >Tie</th>
	<th class="hd" >SCID</th>
	<th class="hd center" >Sumid</th>
	<th class="hd" >CrR</th>	
	</tr>
</thead>

<tbody>

<!-- row 1 grades iterator,$u for students,$g for grades -->

<?php $w = $num_students; ?>
<?php for($u=0;$u<$num_regulars;$u++): ?>
<?php $v = $u+1; ?>
<?php $qualified = true; ?>

		<tr>
			<td><?php echo $v; ?></td>
			<td class="sort" > <?php echo $regulars[$u]['sumid']; ?></td>											
			<td><?php echo $regulars[$u]['student_code']; ?></td>
			<td><?php echo $regulars[$u]['student']; ?></td>			
			<td><?php echo $regulars[$u]['classroom']; ?></td>			

			<?php 
				// if($qualified){
					// $mine 	= $regulars[$u]['ave_'.$qf];				
					// $his 	= @$regulars[$v]['ave_'.$qf];
					// if($mine == $his){ $is_tied = true; } 
					// $val	= $rank;
					// $rank++;						
				// } else { $val = '$dqval'; }								
			?>				
			
						
			
			<!-- db summaries ave_qqtr -->
			<td class="center <?php echo ($is_tied)? 'bg-blue2 b':null; ?>" ><?php echo $regulars[$u][$aveq]; ?></td>	
			<td class="center" ><?php echo $regulars[$u]['rank_level_'.$qf]; ?></td>				
			
			<!-- rank -->
			<td class="sort <?php echo ($is_tied)? 'bg-red' : null; ?>" >
				<input class="vc50 center <?php echo ($is_tied)? 'red':null; ?>" name="nh[<?php echo $w; ?>][qtr]" value="<?php echo $rank; ?>"  />
				<?php $is_tied = false; ?>
				<input class="vc50 center" type="hidden" name="nh[<?php echo $w; ?>][sumid]" 
					value="<?php echo $regulars[$u]['sumid']; ?>"  />														
			</td>
			<?php 

/* 				
				$v = $u+1;
				$same = $regulars[$u]['ave_'.$qf]==@$regulars[$v]['ave_'.$qf];					
				if($continuous){
					$rank++;				
				} else {
					if(!$same){ $rank++; }				
				}
 */				

/*  
				$v = $u+1;
				$mine = $regulars[$u]['ave_'.$qf];
				$his  = @$regulars[$v]['ave_'.$qf];
				$same = ($mine == $his)? true:false;					
				if($continuous){
					$rank++;				
				} else {
					if(!$same){ $rank++; }				
				}
 
 */ 
				$v = $u+1;
				$mine = $regulars[$u]['ave_'.$qf];
				$his  = @$regulars[$v]['ave_'.$qf];
				$same = ($mine == $his)? true:false;					
				if($continuous){
					$rank++;				
				} else {
					if(!$same){ $rank++; }				
				}
 

			?>				
									
			<td class="<?php echo ($same)? 'red':NULL; ?>" ><?php echo ($same)? 'Tie'.$mine.'-'.$his:NULL; ?></td>			
						
			<td class="hd" ><?php echo $regulars[$u]['scid']; ?></td>
			<td class="hd" > <?php echo $regulars[$u]['sumid']; ?> </td>			
			<td class="hd" > <?php echo $regulars[$u]['rank_classroom_'.$qf]; ?> </td>
		</tr>

<?php $w++; ?>
<?php endfor; ?>

</tbody>
</table>



<br />


<!-- ============================= SUBMIT ==================================================================== -->

	<button id="sortBtn" onclick="editRanks();return false;">Sort On</button>
	<input class="sort" type="submit" name="submit" value="Update On"  >


<?php if($qtr<5 && !$num_open): ?>
	<button id="sortBtn" onclick="editRanks();return false;">Sort</button>
	<input class="sort" type="submit" name="submit" value="Update"  >
	<button id="cancelBtn" onclick="editRanks();return false;">Cancel</button>
<?php endif; ?>

<?php if($qtr=='5'): ?>
	<button id="sortBtn" onclick="editRanks();return false;">Sort</button>
	<input class="sort" type="submit" name="submit" value="Update"  >
	<button id="cancelBtn" onclick="editRanks();return false;">Cancel</button>
<?php endif; ?>
	
	
</form>

<!---------------------------------------------------------------------------------------------------------------------------------->

<script>

var hdpass = '<?php echo HDPASS; ?>';


	$(function(){		
		columnHighlighting();			
		hd();
		$('#hdpdiv').hide();
		nextViaEnter();
		selectFocused();
		$('.sort').hide();
		$('#cancelBtn').hide();	
				
	}) 
	
	function editRanks(){
		$('#sortBtn').toggle();	
		$('#cancelBtn').toggle();	
		$('.sort').toggle();	
	}
	
	
</script>
