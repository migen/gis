
<?php 

// pr($students[0]);
// pr($grades[0]);

$decicard 	= $_SESSION['settings']['decicard'];
$decigenave = $_SESSION['settings']['decigenave'];


if(isset($ix)){ pr($ix); }


$qtr 	= $qtr;
$qqtr	= 'q'.$qtr;
$dgqtr	= 'dg'.$qtr;
$is_k12	= $course['is_k12'];

$is_k12 			= $is_k12;
$with_rating 	= $is_k12;


/* ================= FUNCTIONS ========================================== */
$this->shovel('ratings',$ratings);




?>


<h5>
	Chinese Grades
	| <a href="<?php echo URL.$home; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href="<?php echo URL."alien/ChineseIndex"; ?>">Chinese Home</a>
	| <a href='<?php echo URL."alien/sumoRanking/".$course['crid']."/$sy/$qtr"; ?>'>Rank</a>
	
	| <a href='<?php echo URL."averages/course/$course_id/$sy/$qtr?deci=2"; ?>'>Ave-FG</a>
	
</h5>


<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
	<p><?php $this->shovel('hdpdiv'); ?></p>

<div>
<table class='gis-table-bordered table-fx'>
	<tr class="hd" ><th class='white headrow'>Locking</th><td>
			<?php if($is_locked): ?>
				<a href="<?php echo URL.$home.'/unlockCourse/'.$course['crid'].DS.$course_id.DS.$sy.DS.$qtr; ?>" > Unlock </a>
			<?php else: ?>
				<a href="<?php echo URL.$home.'/lockCourse/'.$course['crid'].DS.$course_id.DS.$sy.DS.$qtr; ?>" > Lock </a>			
			<?php endif; ?>		
	</td></tr>
	<tr><th class='vc100 white bg-blue2'>Course</th><td><?php echo $course['level'].'-'.$course['section'].'-'.$course['label']; ?></td></tr>

<?php if($admin): ?>
	<tr><th class='white bg-blue2'>Adviser #<?php echo $course['tcid']; ?></th><td><?php echo $course['teacher']; ?></td></tr>
<?php endif; ?>
	
<tr><th class='white bg-blue2'>Status</th><td><?php echo 'Q'.$data['qtr'].' - '; echo ($is_locked)? 'Closed' : 'Open' ; ?></td></tr> 
</table>

	
<br />	

<form method="POST" >
<table class="gis-table-bordered table-fx"  >

<tr class="bg-blue2" >
<td>#</td>
<td class="hd" >SCID</td>
<td class="hd" >GID</td>
<td>Student</td>
	<?php for($j=0;$j<$num_subcourses;$j++): ?>
		<td class="center" >
			<?php echo $subcourses[$j]['label'].'<br />'.$subcourses[$j]['weight'].'%';?>
			<span class="hd" ><?php echo '<br />SubcrsID: '.$subcourses[$j]['subcourse_id']; ?></span>
		</td>
	<?php endfor; ?>

<td>
<?php print($course['subject_code']); ?>
<br />TG<br />TDG</td>		<!-- total or tally grade for agcrs ; TDG tally descriptive grade -->
	
</tr>

<!-- partial cumulative grade for TG -->
<?php for($i=0;$i<$num_students;$i++): ?>
<?php 
	$pg = 0;	
	$eqwt = 1 / $num_subcourses;
	
?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td class="hd" ><?php echo $students[$i]['scid']; ?></td>
	<td class="hd" ><?php echo $students[$i]['gid']; ?></td>
	<td><?php echo $students[$i]['student']; ?></td>
	<?php for($j=0;$j<$num_subcourses;$j++): ?>
		<?php if($grades[$i][$j]['weight'] < 100): ?>
			<?php $aq = number_format($grades[$i][$j]['q'.$qtr],$decicard); $wg = $aq * $grades[$i][$j]['weight'] / 100; $pg += $wg;  ?>
		<?php else: ?>
			<?php $aq = $grades[$i][$j]['q'.$qtr]; $wg = $aq * $eqwt; $pg += $wg;  ?>		
		<?php endif; ?>
		<td><?php echo number_format($aq,$decigenave);?></td>
	<?php endfor; ?>	
<td>
	<input class="vc50 center" type="text" name="data[aggregate][<?php echo $i; ?>][<?php echo $qqtr; ?>]" 
		value="<?php echo number_format($pg,$decigenave); ?>"  readonly /> <br />
	<?php if($with_rating): ?>	
		<input class="vc50 center" type="text" name="data[aggregate][<?php echo $i; ?>][<?php echo $dgqtr; ?>]" value="<?php $rpg = ($is_k12)? round($pg) : $pg; echo rating($rpg,$ratings); ?>"  readonly /> 		
	<?php endif; ?>
</td>

	<input type="hidden" name="data[aggregate][<?php echo $i; ?>][scid]" value="<?php echo $students[$i]['scid']; ?>"  />	
	<input type="hidden" name="data[aggregate][<?php echo $i; ?>][gid]" value="<?php echo $students[$i]['gid']; ?>"  />	
</tr>

<?php endfor; ?>
</table>

<br />


<p>

<input type="submit" name="submit" value="Finalize On" />
	
<?php if($with_rating): ?>
	<input type="hidden" name="with_rating" value="1" />
<?php endif; ?>

<?php if(!$is_locked && $_SESSION['srid']==RTEAC): ?>
	<input type="submit" name="submit" value="Finalize" />
<?php endif; ?>

</p>




<br />


</form>

<script>
var hdpass = '<?php echo HDPASS; ?>';

$(function(){
	$('#hdpdiv').hide();
	hd();
})

</script>