



<?php 


// pr($data);

// ================= DEFINE VARS ==========================================	
$this->shovel('ratings',$ratings);
$cr 	= $data['classroom'];
$qtr = $qtr = $data['qtr'];



$is_ps	= $classroom['is_ps'];
$is_k12	= $classroom['is_k12'];

$is_bedk12 	= ($is_k12 && !$is_ps);
// echo ($is_bedk12)? 'yes bedk12' : 'not bedk12';


	
// ================= DEBUG ==========================================	



?>




<h5> Summarizer 
	| <a href="<?php echo URL; ?>registrars">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
</h5>


<table class='gis-table-bordered table-fx'>
	<tr class="hd" ><th class='white headrow'>CrID</th><td><?php echo $cr['crid']; ?></td></tr>
	<tr><th class='white headrow'>Level</th><td><?php echo $cr['level']; ?></td></tr>
	<tr><th class='white headrow'>Section</th><td><?php echo $cr['section']; ?></td></tr>
</table>

<br />

<form method="POST" >

<table class='gis-table-bordered table-fx'>
<thead>
	<!-- row 1 data subjects iterator -->
	<tr class='bg-blue2'>
		<th>#</th>
		<th class="hd" >CID</th>
		<th>Code</th>
		<th>Student</th>
		<th>Qtr</th>
	<!-- iterate subjects for headrow subject columns -->
	<?php foreach($data['subjects'] AS $row): ?>
		<th class="center" >
			<a href="<?php echo URL; ?>registrars/course/<?php echo $row['course_id'].DS.$sy; ?>" ><?php echo $row['subject_code']; ?></a>
			<span class="hd"><br /> <?php echo $row['course_id']; ?> </span>
		</th>	
	<?php endforeach; ?>
	<th class="center" >FG</th>
	</tr>
</thead>

<tbody>


<!-- row 1 data grades iterator -->

<?php $ig = 0; ?>
<?php foreach($data['grades'] AS $row): ?>
<?php 
	$q1t = 0; $q2t = 0; $q3t = 0; $q4t = 0; $fgt = 0; 
?>

		<tr>
			<td><?php echo $ig+1; ?></td>
			<td class="hd" ><?php echo $row[0]['scid']; ?></td>
			<td><?php echo $row[0]['student_code']; ?></td>
			<td><?php echo $row[0]['student']; ?></td>			
	<!-- mcr not qcr -->
			<td class='colshading' >Q1</td>
			

<!-- ========= repeat 4x for 4 qtrs =============  -->						
	<?php for($i=0;$i<$num_subjects;$i++): ?>	<!-- subjects iterator -->	
			<td class='colshading' ><?php 
					$score  = (isset($row[$i]['q1']))? $row[$i]['q1'] : 0;
					$score += (isset($row[$i]['bonus_q1']))? $row[$i]['bonus_q1'] : 0;					
					echo dashify($score);					
					$q1t += $score;
				?>
				<?php ?>
			</td>
	<?php endfor; ?>	<!-- subjects iterator -->	
	
			<!-- q1t or qtr1 tally -->				
			<td class="final">
				<input class="vc50 center" name="sum[<?php echo $ig; ?>][ave_q1]" type="text" value="<?php $q1t = $q1t/$num_subjects; echo number_format($q1t,2); ?>"  readonly />
				<!-- add q1t to fgt -->
				<?php $fgt += $q1t; ?>				
				<?php if(!$cr['is_ps']): ?>
					<?php $rq1t = ($is_bedk12)? round($q1t) : $q1t; $rq1t = rating($rq1t,$ratings); ?>
					<input class="vc25 center" type="text" name="sum[<?php echo $ig; ?>][ave_dg1]"  value="<?php echo $rq1t; ?>" readonly />			
				<?php endif; ?>			
		
			</td>
	
		</tr>
		
	<?php for($j=2;$j<5;$j++): ?>
	<?php $qqtr = 'q'.$j; ?>
		<tr>
			<td class="hd" >&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td  class='colshading' >Q<?php echo $j; ?></td>
		<?php for($i=0;$i<$num_subjects;$i++): ?>		<!-- subject iterator per row -->
				<td  class='colshading' ><?php 
							$score  = (isset($row[$i][$qqtr]))? $row[$i][$qqtr] : 0;
							$score += (isset($row[$i]['bonus_'.$qqtr]))? $row[$i]['bonus_'.$qqtr] : 0;
							echo dashify($score); 	
							${'q'.$j.'t'} += $score;														
					?>
				</td>								
		<?php endfor; ?>

			<!-- q$jt or qtr$j tally -->				
			<td class="final">
				<input class="vc50 center" name="sum[<?php echo $ig; ?>][ave_q<?php echo $j; ?>]" type="text" value="<?php ${'q'.$j.'t'} = ${'q'.$j.'t'}/$num_subjects; echo number_format(${'q'.$j.'t'},2); ?>"  readonly />
				<!-- add q1t to fgt -->
				<?php $fgt += ${'q'.$j.'t'}; ?>				
				<?php if(!$cr['is_ps']): ?>
					<?php ${'rq'.$j.'t'} = ($is_bedk12)? round(${'q'.$j.'t'}) : ${'q'.$j.'t'}; ${'rq'.$j.'t'} = rating(${'rq'.$j.'t'},$ratings); ?>
					<input class="vc25 center" type="text" name="sum[<?php echo $ig; ?>][ave_dg<?php echo $j; ?>]"  value="<?php echo ${'rq'.$j.'t'}; ?>" readonly />			
				<?php endif; ?>					
			</td>								
		

		
		</tr>
	<?php endfor; ?>	<!-- subject iterator per row -->



		<tr>
			<!-- no colspan for columnHighlighting td column index -->
			<td class="hd" >&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td class='colshading' >FG</td>
	<?php for($i=0;$i<$num_subjects;$i++): ?> <!-- subject iterator -->		
			<td class='colshading' > <?php echo (isset($row[$i]['q5']))? $row[$i]['q5'] : 0; ?> </td>
	<?php endfor; ?>		<!-- subject iterator -->
				
			<td>
				<input class="vc50 center" name="sum[<?php echo $ig; ?>][ave_q5]" type="text" value="<?php $fgt = $fgt/4; echo number_format($fgt,2);  ?>"  readonly />
				<?php if(!$cr['is_ps']): ?>
					<?php $rfgt = ($is_bedk12)? round($fgt) : $fgt; $rfgt = rating($rfgt,$ratings); ?>
					<input class="vc25 center" type="text" name="sum[<?php echo $ig; ?>][ave_dg5]"  value="<?php echo $rfgt; ?>" readonly />			
				<?php endif; ?>		
				
			<!-- hidden,for summaries need 2 params,1) scid,2) sy - no need to post  -->
			<input type="hidden" name="sum[<?php echo $ig; ?>][scid]" value="<?php echo $row[0]['scid']; ?>" ></td>
		</tr>	

		
<?php $ig++; ?>

	

<?php endforeach; ?>

</tbody>
</table>



<br />

<input type="hidden" name="isps" value="<?php echo $classroom['is_ps']; ?>"  />
<input type="submit" name="submit" value="Summarize"  />


</form>


<!--  ========================================================================  -->

<script>

	$(function(){		
		columnHighlighting();			
		hd();
	}) 
	
</script>
