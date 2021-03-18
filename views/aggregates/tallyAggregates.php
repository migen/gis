<?php 
	// pr($students[0]); 
	// pr($grades[0]); 
	// pr($data); exit;

	
?>

<?php  if($num_subcourses==0): ?>
	<h5 class='brown' >No component subjects. Division by zero. Not an aggregate. <br />
	<a href="<?php echo URL.'averages/course/'.$course_id; ?>" >Course Average</a></h5>
<?php exit; endif; ?>

<?php 

if(isset($ix)){ pr($ix); }

$colspan=5+$num_subcourses;
$updated=true;

$qtr 	= $qtr;
$qqtr	= 'q'.$qtr;
$dgqtr	= 'dg'.$qtr;
$is_k12	= $course['is_k12'];
$with_rating=&$with_dg;


$disabled = false;
foreach($subcourses AS $row){
	if($row['is_locked']!=1){
		$disabled = true;
		break;	
	}
}



?>


<h5>
	Tally Aggregates | Components (<?php echo $num_students; ?>)
	| <a href="<?php echo URL.$home; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href='<?php echo URL."averages/course/$course_id/$sy/$qtr"; ?>' >Averages</a>	
	<?php if(!isset($_GET['deci'])): ?>
		| <a href='<?php echo URL."aggregates/tally/$crid/$course_id/$supsubject_id/$sy/$qtr?deci=2"; ?>' >Decimal</a>	
	<?php else: ?>
		| <a href='<?php echo URL."aggregates/tally/$crid/$course_id/$supsubject_id/$sy/$qtr"; ?>' >Integer</a>		
	<?php endif; ?>
	| <a href='<?php echo URL."spiral/crid/$crid"; ?>' >Spiral</a>	
	
</h5>
<p><?php $this->shovel('hdpdiv'); ?></p>
	
<div>


<table class='gis-table-bordered table-fx'>
	<tr class="hd" ><th class='white headrow'>Locking</th><td>
			<?php if($is_locked): ?>
				<a href="<?php echo URL.'finalizers/openCourse/'.$course['crid'].DS.$course_id.DS.$sy.DS.$qtr; ?>" >Unlock</a>
			<?php else: ?>
				<a href="<?php echo URL.'finalizers/closeCourse/'.$course['crid'].DS.$course_id.DS.$sy.DS.$qtr; ?>" > Lock </a>			
			<?php endif; ?>		
	</td></tr>
	<tr class="hd" ><th class='white bg-blue2'>CrsID</th><td><?php echo $course['id']; ?></td></tr>
	<tr><th class='vc100 white bg-blue2'>Course</th><td><?php echo $course['level'].'-'.$course['section'].'-'.$course['label']; echo ' ('.$course['code'].')'; ?></td></tr>

<?php if($admin): ?>
	<tr><th class='white bg-blue2'>Adviser #<?php echo $course['tcid']; ?></th><td><?php echo $course['teacher']; ?></td></tr>
<?php endif; ?>
	
<tr><th class='white bg-blue2'>Status</th><td><?php echo 'Q'.$data['qtr'].' - '; echo ($is_locked)? 'Closed' : 'Open' ; ?></td></tr> 
</table>

	
<br />	

<form method="POST" >
<table class="gis-table-bordered table-fx"  >

<tr class="bg-blue2" >
<th>#</th>
<th class="" >SCID</th>
<th>Student</th>
	<?php for($j=0;$j<$num_subcourses;$j++): ?>
		<td class="center <?php echo ($subcourses[$j]['is_locked']!=1)? 'bg-red':NULL; ?>" >
			<?php echo $subcourses[$j]['label'].'<br />'.$subcourses[$j]['weight'].'%';?>
			<span class="hd" ><?php echo '<br />SubcrsID: '.$subcourses[$j]['subcourse_id']; ?></span>
		</td>
	<?php endfor; ?>
<th><?php print($course['subject_code']); ?><br />(DB)</th>
<th>
<br /><?php if($with_dg): ?>TDG<br /><?php endif; ?>
<span class="red" >-x-</span></th>		<!-- total or tally grade for agcrs ; TDG tally descriptive grade -->
	
</tr>

<tr><th colspan="<?php echo $colspan; ?>" >BOYS</th></tr>

<!-- partial cumulative grade for TG -->
<?php $k=0; ?>
<?php for($i=0;$i<$num_students;$i++): ?>
<?php 
	$k=$i+1;
	$pg = 0;	
	$eqwt = 1 / $num_subcourses;
			
?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td class="" ><?php echo $students[$i]['scid']; ?></td>
	<td><?php echo $students[$i]['student']; ?></td>
	<?php for($j=0;$j<$num_subcourses;$j++): ?>
		<?php if($grades[$i][$j]['weight'] < 100): ?>
		<?php $aq = number_format($grades[$i][$j]['q'.$qtr],$decicard); $wg = $aq * $grades[$i][$j]['weight'] / 100; $pg += $wg;  ?>
		<?php else: ?>
			<?php $aq = $grades[$i][$j]['q'.$qtr]; $wg = $aq * $eqwt; $pg += $wg;  ?>		
		<?php endif; ?>
		<td><?php echo number_format($aq,$decicard);?></td>
	<?php endfor; ?>	
	<?php 
		$pg=number_format($pg,$decicard); 
		$dbgr=number_format($students[$i]['q'.$qtr],$decicard); 
		$same=($pg==$dbgr)? true:false;
		
		
	?>
<td><?php echo $dbgr; ?></td>	
<td>
	<?php if(!$same): ?>
		<?php $updated=false; ?>
		<input type="hidden" name="data[aggregate][<?php echo $i; ?>][scid]" value="<?php echo $students[$i]['scid']; ?>"  />	
		<input type="hidden" name="data[aggregate][<?php echo $i; ?>][gid]" value="<?php echo $students[$i]['gid']; ?>"  />		
		<input class="vc50 center red" type="text" name="data[aggregate][<?php echo $i; ?>][<?php echo $qqtr; ?>]" 
			value="<?php echo $pg; ?>"  readonly /> <br />
		<?php if($with_rating): ?>	
			<input class="vc50 center" type="text" name="data[aggregate][<?php echo $i; ?>][<?php echo $dgqtr; ?>]" 
			value="<?php $rpg = ($is_k12)? round($pg) : $pg; echo rating($rpg,$ratings); ?>"  readonly /> 		
		<?php else: ?>
			<input type="hidden" name="data[aggregate][<?php echo $i; ?>][<?php echo $dgqtr; ?>]" 
			value=""   /> 		
		<?php endif; ?>
	<?php endif; ?>	<!-- same -->
</td>
<td class="hd" ><a href='<?php echo URL."teachers/deleteGrade/".$students[$i]["gid"]; ?>'>Del</a></td>
</tr>

<?php if(isset($students[$k]['scid']) && ($students[$i]['is_male']!=$students[$k]['is_male'])): ?>
	<tr><th colspan="<?php echo $colspan; ?>" >GIRLS</th></tr>
<?php endif; ?>	


<?php endfor; ?>
</table>

<br />


<p>
<?php if($with_rating): ?>
	<input type="hidden" name="with_rating" value="1" />
<?php endif; ?>


<?php 
	echo ($disabled)? "<h5 class='red' >Has un-finalized components.</h5>":NULL;
	
	
?>

<?php if(!$disabled): ?>
	<?php if(!$is_locked && $_SESSION['srid']==RTEAC): ?>
		<input type="submit" name="submit" value="Average" />
	<?php endif; ?>
<?php endif; ?>

<?php if($admin || !$updated): ?>
	<input type="submit" name="submit" value="Average On" />
<?php endif; ?>


<?php 

// echo "updated: $updated <br />";
?>

	
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