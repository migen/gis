
<!--
ranking - mcs
anne	- 92	- 1.5
beth	- 92	- 1.5
cath	- 91	- 3


path: views/registrars/QLR.php

-->

<!---------------------------------------------------------------------------------------------------------------------------------->


<h5>
	<a href="<?php echo URL; ?>registrars">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			

</h5>

<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
<p><?php $this->shovel('hdpdiv'); ?></p>



<?php 

// pr($data);
// pr($students[0]);


$aveq = ($qtr ==5)? 'ave_q5' : 'ave_q'.$qtr;

// pr($aveq);

// ================= DEFINE VARS ==========================================	
	
	
$has_ties = false;
$ties	  = false; 	
$dqval	  = '0';


	
?>



<h5><?php echo $level['level']; ?> Ranking - <?php echo ucfirst($qf); ?></h5>


<form method="POST" >

<!-- ============================= HONORS  ==================================================================== -->

<?php $heading = ($qtr == 5)? " All " : " With Honors "; ?>
<h5> <?php echo $heading; ?> </h5>

<table class='gis-table-bordered table-fx'>
<thead>
	<!-- row 1 data subjects iterator -->
	<tr class='bg-blue2'>
	<th class="vc30" >#</th>
	<th class="sort" >Sum#</th>
	<th class="vc120" >Code</th>
	<th class="vc400" >Student</th>
	<th class="vc50 center"><?php echo ($qtr == 5)? 'FG' :  'Q'.$qtr; ?></th>
	<th class="vc50 center" >Rank</th>
	<th class="vc50 sort center" >Sort</th>
	<th class="vc50 center" >Tie</th>
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
			<td class="sort" ><?php echo $students[$s]['sumid']; ?>
				<input class="vc50 center" type="hidden" name="rank[<?php echo $s; ?>][sumid]" 
					value="<?php echo $students[$s]['sumid']; ?>" readonly /></td>			
			<td><?php echo $students[$s]['student_code']; ?></td>
			<td><?php echo $students[$s]['student']; ?></td>			

			<!-- db summaries ave_qqtr -->
			<td class="center" ><?php echo $students[$s][$aveq]; ?></td>	

			<td class="center" ><?php echo $students[$s]['rank_level_q'.$qtr]; ?><?php // echo $rank; ?></td>	
			
			<!-- rank -->
			<td class="sort" >
				<input class="vc50 center" type="text" name="rank[<?php echo $s; ?>][qtr]" value="<?php echo $rank; ?>"  />
				<?php 
					$t = $s+1;
					$same = $students[$s]['ave_'.$qf]==@$students[$t]['ave_'.$qf];
					if(!$same){ $rank++; }
				?>						
															
			</td>
			<td class="<?php echo ($same)? 'red':NULL; ?>" ><?php echo ($same)? 'Tie':NULL; ?></td>			
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
	<th class="vc50 center">Q<?php echo $qtr; ?></th>
	<th class="vc50 center" >Rank</th>
	<th class="sort vc50 center" >Sort</th>
	<th class="vc50 center" >Tie</th>
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
			<td class="sort" > <?php echo $regulars[$u]['sumid']; ?>
				<input class="vc50 center" type="hidden" name="nh[<?php echo $w; ?>][sumid]" 
					value="<?php echo $regulars[$u]['sumid']; ?>" readonly /></td>								
			<td><?php echo $regulars[$u]['student_code']; ?></td>
			<td><?php echo $regulars[$u]['student']; ?></td>			

			<!-- db summaries ave_qqtr -->			
			<td class="center <?php echo ($is_tied)? 'bg-blue2 b':null; ?>" ><?php echo $regulars[$u][$aveq]; ?></td>	
			<td class="center" ><?php echo $regulars[$u]['rank_level_'.$qf]; ?></td>				

			
			<!-- rank -->
			<td class="sort" >
				<input class="vc50 center <?php echo ($is_tied)? 'red':null; ?>" name="nh[<?php echo $w; ?>][qtr]" value="<?php echo $rank; ?>"  />
				<?php $is_tied = false; ?>														
			</td>
			<?php 
				$v = $u+1;
				$same = $regulars[$u]['ave_'.$qf]==@$regulars[$v]['ave_'.$qf];
				if(!$same){ $rank++; }
			?>						
			
			<td class="<?php echo ($same)? 'red':NULL; ?>" ><?php echo ($same)? 'Tie':NULL; ?></td>			

			<td class="hd" ><?php echo $regulars[$u]['scid']; ?></td>	
			<td class="hd" ><?php echo $regulars[$u]['sumid']; ?></td>	
			<td class="hd" > <?php echo $regulars[$u]['rank_classroom_'.$qf]; ?> </td>
		</tr>
<?php $w++; ?>
<?php endfor; ?>

</tbody>
</table>



<br />


<!-- ============================= SUBMIT ==================================================================== -->

<?php if(!$num_open): ?>
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
