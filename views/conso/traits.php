<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>


<?php 

// pr($data);

// pr($students[0]);
// pr($scores[0]);

$deciconducts  = $_SESSION['settings']['deciconducts'];
$decifconducts = $_SESSION['settings']['decifconducts'];


$qtr = $qtr;
$qqtr		= 'q'.$qtr;
$dgqtr = 'dg'.$qtr;
$is_locked;
$crsid 		 = $course['course_id']; 
$num_criteria 	= count($criteria);
$this->shovel('ratings',$ratings);


function getFloorGrade($course,$settings){
	return $settings['floor_conduct'];
}

$flrgr = getFloorGrade($course,$_SESSION['settings']);




?>


<h5>
	Traits (<?php echo (isset($_GET['sort']) && $_GET['sort']=='c.position')? 'Position':'Alphabetical'; ?>)
	(<?=$num_students;?>)
	| <?php echo "CRID#$crid"; ?>
	| <a href="<?php echo URL.$home; ?>">Home</a> 	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		

	| <a class="u" id="btnExport" >Excel</a> 
		
	

</h5>

<?php if(isset($_GET['debug'])){ pr($q); } ?>

<?php $this->shovel('hdpdiv'); ?>


<?php 
	$d['ctype']=$ctype;
	$d['dept']=$dept_id;
	$d['ratings'] = $ratings;
	$this->shovel('filter_ctypes',$d); 
?>
<script>

	
function redirCtype(){
	var url = gurl+"/cav/traits/"+crs+ds+sy+ds+qtr+'?ctype='+$('#ctype').val()+'&dept='+$('#dept').val();	
	window.location = url;		
}	/* fxn */
	
</script>



<p><table class='gis-table-bordered table-fx'>
	<tr class="hd" ><th class='white headrow'>Locking</th><td>
			<?php if($is_locked): ?>
				<a href="<?php echo URL.'finalizers/openCourse/'.$course['crid'].DS.$crsid.DS.$sy.DS.$qtr; ?>" > Unlock </a>
			<?php else: ?>
				<a href="<?php echo URL.'finalizers/closeCourse/'.$course['crid'].DS.$crsid.DS.$sy.DS.$qtr; ?>" > Lock </a>			
			<?php endif; ?>		
	</td></tr>

	<tr class="hd" ><th class='white headrow'>CrsID</th><td><?php echo $course['course_id']; ?></td></tr>
	<tr><th class='white headrow'>Course | Status</th>
	<td><?php echo $course['name'].' | Q'.$data['qtr'].' - '; echo ($is_locked)? 'Closed' : 'Open' ; ?></td></tr>
	
</table>
</p>

<?php // pr($ix); ?>
	


	
	


<!----------------------------------------------------------------------->




<?php $sync=false; ?>

<form method="POST" > <!-- for finalize use,cell edtiting is using ajax -->
<table id="tblExport"  class="gis-table-bordered table-fx" >
<thead class="frozen" >
<tr class="bg-blue2" >
	<td>#</td>
	<td class="">Scid</td>
	<td class="vc200">Student</td>
	<td class="">Q</td>
	<?php for($j=0;$j<$num_criteria;$j++): ?>
		<?php $cri_id = $criteria[$j]['criteria_id']; ?>
		<td class="center" >
		<span class="u" onclick="alert(this.id);" id="<?php echo $criteria[$j]['criteria_id'].'-'.$criteria[$j]['criteria']; ?>" >
			<?php echo $criteria[$j]['code']; ?><br />
			<?php echo $criteria[$j]['weight'].'%'; ?>
			</span>
		<?php if(!$is_locked): ?>			
				<br /><a href='<?php echo URL."trs/tally/$course_id/$cri_id/$sy/$qtr"; ?>' >Tally</a>
				<br /><a href='<?php echo URL."cav/editColumn/$course_id/$cri_id/$sy/$qtr"; ?>' >Edit</a>
				<span class="hd" ><br /><a href='<?php echo URL."utils/deleteTraitsRow/$course_id/$cri_id/$sy/$qtr"; ?>' 
					onclick="return confirm('Sure?');" >Delete</a></span>
				<span class="" ><br /><a href='<?php echo URL."utils/syncTraitsColumn/$course_id/$cri_id/$sy/$qtr"; ?>' 
					onclick="return confirm('Sure?');" >Sync</a></span>
		<?php endif; ?>
		</td>
	<?php endfor; ?>
<?php if($course['is_trait']==1): ?>
	<td class="center vc80">DB<br />Ave</td>	
	
<?php endif; ?>	
	<td class="vc200">Student</td>	
</tr>
</thead>

<?php 
	@$eqwt = 1 / $num_criteria;
?>

<?php for($i=0;$i<$num_students;$i++): ?>

<?php 
	$scid = $students[$i]['scid'];
	$ns = count($scores[$i]); 
?>
<?php 
	if($ns == $num_criteria): 
?>	<!-- index matching -->

<?php 

?>

<tr id="row<?php echo $i; ?>" >
	<?php 
		$scid 	= $students[$i]['scid'];
		$scode 	= $students[$i]['student_code'];
		$sumid 	= $students[$i]['sumid'];
	?>
	<td id='<?php echo "SCID: $scid | Code: $scode | Sumid: $sumid "; ?>' onclick="alert(this.id);" ><?php echo $i+1; ?> </td>
	<td><?php echo $students[$i]['scid']; ?></td>		

<?php if(!$is_locked): ?>		
	<td>
		<?php if($_SESSION['user']['role_id']==RTEAC): ?>
			<a href="<?php echo URL.'cav/student/'.$course['course_id'].DS.$students[$i]['scid'].DS.$sy.DS.$qtr;  ?>"  >
				<?php echo $students[$i]['student']; ?></a>		
		<?php else: ?>
			<?php echo $students[$i]['student']; ?>		
		<?php endif; ?>
	</td>	
<?php else: ?>			
	<td><?php echo $students[$i]['student']; ?></td>		
	<td>Q1<br />Q2<br />Q3<br />Q4</td>		
<?php endif; ?>			
	<?php // $rowsum=0; ?>
	<?php $rowave=0; ?>
	<?php for($j=0;$j<$num_criteria;$j++): ?>
		<?php 
			$q1 = $scores[$i][$j]['q1']; $dg1 = $scores[$i][$j]['dg1']; 
			$q2 = $scores[$i][$j]['q2']; $dg2 = $scores[$i][$j]['dg2']; 
			$q3 = $scores[$i][$j]['q3']; $dg3 = $scores[$i][$j]['dg3']; 
			$q4 = $scores[$i][$j]['q4']; $dg4 = $scores[$i][$j]['dg4']; 
				
		?>
				
		<td class="center">
			<?php echo $q1.' ('.$dg1.')'; ?><br />
			<?php echo $q2.' ('.$dg2.')'; ?><br />
			<?php echo $q3.' ('.$dg3.')'; ?><br />
			<?php echo $q4.' ('.$dg4.')'; ?>
		</td>		
	<?php endfor; ?>	

<?php if($course['is_trait']==1): ?>
	<td class="center" >
		<?php echo $students[$i]['conduct_q1'].' ('.$students[$i]['conduct_dg1'].')'; ?><br />
		<?php echo $students[$i]['conduct_q2'].' ('.$students[$i]['conduct_dg2'].')'; ?><br />
		<?php echo $students[$i]['conduct_q3'].' ('.$students[$i]['conduct_dg3'].')'; ?><br />
		<?php echo $students[$i]['conduct_q4'].' ('.$students[$i]['conduct_dg4'].')'; ?>
	</td>

	

<?php endif; ?>

<?php if(!$is_locked && ($sy==$ssy)): ?>		
	<td> 
		<a href='<?php echo URL."utils/syncStudentTraits/".$course['id'].DS.$scid."/$sy/$qtr"; ?>' >Mgt</a>	
		| <a href='<?php echo URL."cav/student/".$course['course_id'].DS.$students[$i]['scid']."/$sy/$qtr";  ?>'  >
			<?php echo $students[$i]['student']; ?></a>		
	</td>	
<?php else: ?>			
	<td><?php echo $students[$i]['student']; ?></td>		
<?php endif; ?>			
	
	
</tr>

<?php 
	else: 
	$sync = true; 
?>

<tr>
	<td><a href="<?php echo URL.'utils/syncTraitsByStudent/'.$course_id.DS.$scid; ?>" >Sync</a></td>
	<td colspan="<?php echo $num_criteria+5; ?>" > 
	
		<?php 
			echo "num-cri: $num_criteria , num_traits = $ns ";
		?>	

		Please update records of 
		<a href='<?php echo URL."utils/syncTraitsByStudent/".$course['id'].DS.$scid; ?>' >
		<?php echo $students[$i]['student_code'].' - '.$students[$i]['student']; ?></a>

		<a href='<?php echo URL."utils/syncStudentTraits/".$course['id'].DS.$scid."/$sy/$qtr"; ?>' >Mgt</a>	
		| <a href='<?php echo URL."cav/student/".$course['course_id'].DS.$students[$i]['scid']."/$sy/$qtr";  ?>'  >		
		Trait</a>
		
	</td>
</tr>

<?php endif; ?>  <!-- index matching -->

<?php endfor; ?>
</table> 

<br />




</form>





<!---------------------------------------------------------------------------------------------->


<script>

var gurl = 'http://<?php echo GURL; ?>';	
var crs	= '<?php echo $course_id; ?>';
var sy   	= '<?php echo $sy; ?>';
var qtr 	= '<?php echo $qtr; ?>';
var ds 		= '/';

var numcri = <?php echo $num_criteria; ?>;
var hdpass = '<?php echo HDPASS; ?>';


$(function(){	
	$('#hdpdiv').hide();
	hd();
	excel();
	
});


function disableBtns(){
	$('#btns').hide();	
}


function disablethis(bid){
	$('#'+bid).hide();	
}




// IMPT: for update all feature
function populateRow(inRow,inVal){
	var vr = '#'+inRow;
	$(vr+' td input').val(inVal);
}


</script>


