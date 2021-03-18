<script>

	$(function(){		
		columnHighlighting();			
		hd();
	}) 
	
</script>

<?php
	$parts = rtrim($_GET['url'],'/'); 
	$parts = explode('/',$parts);		
	$home = ($c = array_shift($parts))? $c : 'index'; 			
?>


<h5>
	<a href="<?php echo URL; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href="<?php echo URL.$home.'/mcr/'.$crid.DS.$sy.DS.'4'; ?>"> Class Report </a>
</h5>




<?php 

// pr($data);

$aveq = 'ave_'.$qf;

// pr($aveq);

// ================= DEFINE VARS ==========================================	
	


	
	
		

?>



<h5>Class Ranking Final </h5>

<table class='gis-table-bordered table-fx'>
	<tr class="hd" ><th class='white headrow'>LID</th><td><?php echo $classroom['level_id']; ?></td></tr>
	<tr><th class='white headrow'>Level</th><td><?php echo $classroom['level']; ?></td></tr>
	<tr><th class='white headrow'>Section</th><td><?php echo $classroom['section']; ?></td></tr>
	<tr><th class='white headrow'>Status</th><td><?php echo "Q".$qtr." - "; echo ($is_locked)? 'Closed' : 'Open' ; ?></td></tr> 
</table>

<br />

<form method="POST" >

<?php $num_diff=0; ?>
<!-- ============================= HONORS  ==================================================================== -->

<h5> <?php echo 'Qualified for Honors'; ?> </h5>

<table class='gis-table-bordered table-fx'>
<thead>
	<!-- row 1 data subjects iterator -->
	<tr class='bg-blue2'>
		<th>#</th>
		<th class="hd" >CID</th>
		<th>Code</th>
		<th class="vc300" >Student</th>
	<th class="center"><?php echo ucfirst($qf); ?></th>
	<th class="center" >Rank</th>
	<th class="hd center" >FR</th>
	</tr>
</thead>

<tbody>

<!-- row 1 grades iterator,$s for students,$g for grades -->

<?php $rank = 1; ?>
<?php for($s=0;$s<$num_students;$s++): ?>
<?php $t = $s+1; ?>

		<tr>
			<td><?php echo $t; ?></td>
			<td class="hd" ><?php echo $students[$s]['scid']; ?></td>
			<td><?php echo $students[$s]['student_code']; ?></td>
			<td><?php echo $students[$s]['student']; ?></td>			

			<!-- db summaries ave_qqtr -->
			<td><?php echo $students[$s][$aveq]; ?></td>	
			<!-- rank -->
			<td class="center" >
			<?php 
				$mine 	= $students[$s]['ave_'.$qf];				
				$his 	= @$students[$t]['ave_'.$qf];
				$val = $rank;					
				if($mine != $his){ $rank++; }
	
			?>				
			<?php if(!$is_locked): ?>
				
				<input class="vc50 center" type="text" name="rank[<?php echo $s; ?>][crf]" value="<?php echo $val; ?>" readonly />
				<input class="vc50 center" type="hidden" name="rank[<?php echo $s; ?>][scid]" value="<?php echo $students[$s]['scid']; ?>" readonly />			
				<?php if($students[$s]['rank_classroom_'.$qf] != $val){ $num_diff++; } ?>
				
			<?php else: ?>
				<?php echo $students[$s]['rank_classroom_'.$qf]; ?>
			<?php endif; ?>
			</td>

			<td class="hd" > <?php echo $students[$s]['rank_classroom_'.$qf]; ?> </td>
		</tr>

<?php endfor; ?>

</tbody>
</table>

<!-- 
	<div class="clear"></div>
-->
<p> &nbsp; </p>

<!-- for non final qtr -->

<!-- ============================= REGULAR NON HONORS ==================================================================== -->

<h5> <?php echo 'Non-Qualified'; ?> </h5>

<table class='gis-table-bordered table-fx'>
<thead>
	<!-- row 1 data subjects iterator -->
	<tr class='bg-blue2'>
		<th>#</th>
		<th class="hd" >CID</th>
		<th>Code</th>
		<th class="vc200" >Student</th>
	<th class="center"><?php echo 'FG'; ?></th>
	<th class="center" >Rank</th>
	<th class="hd center" >FR</th>
	</tr>
</thead>

<tbody>

<!-- row 1 grades iterator,$s for students,$g for grades -->

<?php for($u=0;$u<$num_regulars;$u++): ?>
<?php $v = $u+1; ?>

		<tr>
			<td><?php echo $v; ?></td>
			<td class="hd" ><?php echo $regulars[$u]['scid']; ?></td>
			<td><?php echo $regulars[$u]['student_code']; ?></td>
			<td><?php echo $regulars[$u]['student']; ?></td>			

			<!-- db summaries ave_qqtr -->
			<td><?php echo $regulars[$u][$aveq]; ?></td>	
			<!-- rank -->
			<td class="center" >
			<?php 
				$mine 	= $regulars[$u]['q5'];				
				$his 	= @$regulars[$v]['q5'];
				$val = $rank;					
				if($mine != $his){ $rank++; }
	
			?>				
			<?php if(!$is_locked): ?>
				<input class="vc50 center" type="text" name="nh[<?php echo $u; ?>][crf]" value="<?php echo $val; ?>" readonly />
				<input class="vc50 center" type="hidden" name="nh[<?php echo $u; ?>][scid]" value="<?php echo $regulars[$u]['scid']; ?>" readonly />			
				<?php if($regulars[$u]['rank_classroom_q5'] != $val){ $num_diff++; } ?>
				
			<?php else: ?>
				<?php echo $regulars[$u]['rank_classroom_q5']; ?>
			<?php endif; ?>				
			</td>

			<td class="hd" > <?php echo $regulars[$u]['rank_classroom_'.$qf]; ?> </td>
		</tr>

<?php endfor; ?>

</tbody>
</table>

<div class="clear"></div>

<!-- for non final qtr -->

<br />


<!-- ============================= SUBMIT ==================================================================== -->


<?php 
	// echo "num_diff: $num_diff <br />"; 	
?>

<?php if($num_diff): ?>	
	<input type="submit" name="final" value="Final"  />
<?php endif; ?>
	
	
</form>

