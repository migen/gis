<?php 

?>

<h5>
	Club Scores
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'clubs/addScores/'.$club_id.DS.$sy.DS.$qtr; ?>" >Add Scores<a>
	| <span class="u" onclick="randomize('grades');" >Randomizer</span>	
	
	
</h5>

<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th><th>SCID</th>
	<th>Classroom</th>
	<th>Student</th>
	
	<?php $k=0; ?>		
	<?php $crimaxsum=array(); ?>		
	<?php $criwt=array(); ?>		
	<?php for($j=0;$j<$num_acts;$j++): ?>
			<?php $criwt[$k]=$activities[$j]['weight']; ?>
			<?php @$crimaxsum[$k]+=$activities[$j]['max_score']; ?>			
			<?php $fdate=DATE('M-d',strtotime($activities[$j]['date'])); ?>
			<th><?php echo $activities[$j]['name'].'<br />'.$fdate; ?>
				<br /><a href="<?php echo URL.'clubs/deleteColumnScores/'.$activities[$j]['act_id']; ?>" >Del</a>
				<br /><a href="<?php echo URL.'clubs/syncScoresByColumn/'.$activities[$j]['act_id']; ?>" >Sync</a>
			</th>				
			<?php if($activities[$j]['criteria_id']!=@$activities[$j+1]['criteria_id']): ?>
				<th>Sum<br /><?php echo $crimaxsum[$k]; $k++; $crimaxsum[$k]=0; ?></th>
				<th>PNV<br /><?php echo $activities[$j]['weight']; ?></th>
			<?php endif; ?>			
	<?php endfor; ?>
	<th>TNV</th>
	<th>DB<br />Grade</th>
	<th>Grade</th>
	<th>Edit</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $students[$i]['scid']; ?></td>
	<td><?php echo $students[$i]['classroom']; ?></td>
	<td><?php echo $students[$i]['student']; ?></td>


<?php $k=0; ?>	
<?php $crisum=0; ?>	
<?php $tnv=0; ?>	
<?php for($j=0;$j<$num_acts;$j++): ?>
<?php 

	$score=$colscores[$j][$i]['score'];
	$crisum+=$score;

?>
	<td class="right" ><?php echo $score;?></td>
	<?php if($activities[$j]['criteria_id']!=@$activities[$j+1]['criteria_id']): ?>
		<td><?php echo $crisum; ?></td>
		<td class="right" >
			<?php // $wt=$crisum
				// echo "$crisum <br />"; echo $crimaxsum[$k];
				$pct=$crisum/$crimaxsum[$k];
				$pnv=$pct*$criwt[$k];
				echo $pnv;
				$tnv+=$pnv;
			?>
		</td>
		<?php 
			$k++;	
			$crisum=0; 
		?>
		
	<?php endif; ?>
	
<?php endfor; ?>	
<th class="right" ><?php echo $tnv; ?></th>
<th class="right" ><?php echo $students[$i]['grade']; ?></th>
<td>
	<input class="vc50 right <?php echo ($tnv!=$students[$i]['grade'])? 'red':NULL; ?> " id="scores<?php echo $i; ?>"
		type="text" name="posts[<?php echo $i; ?>][tnv]" value="<?php echo $tnv; ?>" />
		
	<input class="vc50" type="hidden" name="posts[<?php echo $i; ?>][scid]" 
		value="<?php echo $students[$i]['scid']; ?>" />
	<input class="vc50" type="hidden" name="posts[<?php echo $i; ?>][course_id]" 
		value="<?php echo $students[$i]['course_id']; ?>" />		
</td>

<td><a href="<?php echo URL.'clubs/editStudentScores/'.$students[$i]['scid'].DS.$qtr; ?>" >Edit</a></td>
	
</tr>
<?php endfor; ?>
</table>

<p><input type="submit" name="submit" value="Save"  /></p>

</form>



