<?php 
	// pr($data);
	pr($rows);

?>

<h5>
	Club Scores
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'clubs/addScores/'.$club_id.DS.$sy.DS.$qtr; ?>" >Add Scores<a>
	
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


<?php endfor; ?>
</table>

<p><input type="submit" name="submit" value="Save"  /></p>

</form>