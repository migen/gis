<h5>
	Flowchart - <?php echo $major['name'].' #'.$major['id']; ?> | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'uniflowcharts/batch/'.$major_id; ?>" >Create</a>
	| <a href="<?php echo URL.'uniflowcharts'; ?>" >Flowcharts</a>
	| <a href="<?php echo URL.'uniflowcharts/reset'; ?>" >Reset</a>
	| <a href="<?php echo URL.'uniflowcharts/sync/'.$major_id; ?>" >Sync</a>
	
</h5>

<p>
Sxns: <?php foreach($crids_array AS $row): ?>
	<a href="<?php echo URL.'uniclassrooms/courses/'.$row['crid']; ?>" ><?php echo $row['sxncode']; ?></a>&nbsp;
<?php endforeach; ?>
| Majors: 
<?php foreach($majors AS $row): ?>
	<a href="<?php echo URL.'uniflowcharts/major/'.$row['id']; ?>" ><?php echo $row['code']; ?></a>&nbsp;
<?php endforeach; ?>

</p>


<?php 

// pr($data);

?>

<?php // for($i=0;$i<$count;$i++): ?>
<?php 

/* 
	$h=$i-1; 
	$id=$rows[$i]['fid'];
	$lvl=$rows[$i]['level_id'];
	$prevlvl=@$rows[$h]['level_id'];
	$prevsem=@$rows[$h]['semester'];
	$mjr=$rows[$i]['major_id'];
	$subject=$rows[$i]['subject'];
	$sub=$rows[$i]['subject_id'];
	$sem=$rows[$i]['semester'];
	$preq=$rows[$i]['prerequisites'];
 */	
	
?>

<?php // endfor; ?>
