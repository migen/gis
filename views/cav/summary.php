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
	| <a href="<?php echo URL.$home; ?>">Home</a> 	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	
<?php if(isset($_GET['sort'])): ?>	
	| <a href='<?php echo URL."cav/traits/$course_id/$sy/$qtr?ctype=$ctype&dept=$dept_id"; ?>' >Alphabetical</a> 		
<?php else: ?>
	| <a href='<?php echo URL."cav/traits/$course_id/$sy/$qtr?ctype=$ctype&dept=$dept_id&sort=c.position"; ?>'>Position</a>
<?php endif; ?>
		
	| <a href='<?php echo URL."legends/traits"; ?>' >Legends</a> 	
	| <a href='<?php echo URL."matrix/grades/$crid/$sy/$qtr"; ?>' >Matrix</a> 	
	| <a href='<?php echo URL."submissions/view/$crid/$sy/$qtr"; ?>' >Submissions</a> 	
	
	<?php if($is_locked): ?>
		| <a href='<?php echo URL."conducts/sortRanks/$sy/$qtr/$crid/".$course['id']; ?>' >Ranks</a> 		
	<?php endif; ?>
	| <a class="" href='<?php echo URL."conducts/fg/$course_id/$sy/$qtr"; ?>' >Ave</a>	
	
	| <a href='<?php echo URL."cav/genave/$course_id/$sy/$qtr"; ?>' >Genave</a> 	
	

<span class="hd" >&nbsp; <a class="button" style="font-size:14px;" 
href='<?php echo URL."utils/cleanTPG/".$course['level_id'].DS.$course['crid'].DS.$course['id']."/$sy/$qtr"; ?>' >Wipe All Records </a>	
	&nbsp; 
	<a class="button" style="font-size:14px;"
	href='<?php echo URL."utils/syncTPG/".$course['level_id'].DS.$course['crid'].DS.$course['id']."/$sy/$qtr"; ?>' > Sync Records </a> 
</span>

| <a href='<?php echo URL."cav/dg/$course_id/$sy/$qtr?{$sortcond}"; ?>' >DG Only</a>


</h5>

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

<?php if($qtr>3): ?>
<h4 class="brown" >1) Process EACH indicator by Edit > Save. 2) Save 3) Average</h4>
<?php endif; ?>



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
	<td class="vc30">Qtr</td>
	<?php for($j=0;$j<$num_criteria;$j++): ?>
		<?php $cri_id = $criteria[$j]['criteria_id']; ?>
		<td class="center" >
		<span class="u" onclick="alert(this.id);" id="<?php echo $criteria[$j]['criteria_id'].'-'.$criteria[$j]['criteria']; ?>" >
			<?php echo $criteria[$j]['code']; ?><br />
			<?php echo $criteria[$j]['weight'].'%'; ?>
			</span>
		</td>
	<?php endfor; ?>
	<th>Genave</th>

</tr>
</thead>

<?php 
	@$eqwt = 1 / $num_criteria;
?>

<?php $k=0; ?>
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
<?php endif; ?>			
	<td>Q1<br />Q2<br />Q3<br />Q4<br />Ave</td>
	<?php $rowave=0; ?>
	<?php for($j=0;$j<$num_criteria;$j++): ?>
		<?php 			
			$k++;
			$gid = $scores[$i][$j]['gid'];
			$q1 = $scores[$i][$j]['q1'];$dg1 = $scores[$i][$j]['dg1']; 
			$q2 = $scores[$i][$j]['q2'];$dg2 = $scores[$i][$j]['dg2']; 
			$q3 = $scores[$i][$j]['q3'];$dg3 = $scores[$i][$j]['dg3']; 
			$q4 = $scores[$i][$j]['q4'];$dg4 = $scores[$i][$j]['dg4']; 						
			$q5 = $scores[$i][$j]['q5'];$dg5 = $scores[$i][$j]['dg5']; 						
		?>
		
		<td class="center">
<input type="hidden" id="gid-<?= $k; ?>" value="<?= $gid; ?>" >
<input onchange="xeditCav(<?= $k; ?>,'q1',this.value);" class="vc30" value="<?= $q1; ?>" >
<input onchange="xeditCav(<?= $k; ?>,'dg1',this.value);" class="vc30" value="<?= $dg1; ?>" ><br />

<input onchange="xeditCav(<?= $k; ?>,'q2',this.value);" class="vc30" value="<?= $q2; ?>" >
<input onchange="xeditCav(<?= $k; ?>,'dg2',this.value);" class="vc30" value="<?= $dg2; ?>" ><br />

<input onchange="xeditCav(<?= $k; ?>,'q3',this.value);" class="vc30" value="<?= $q3; ?>" >
<input onchange="xeditCav(<?= $k; ?>,'dg3',this.value);" class="vc30" value="<?= $dg3; ?>" ><br />

<input onchange="xeditCav(<?= $k; ?>,'q4',this.value);" class="vc30" value="<?= $q4; ?>" >
<input onchange="xeditCav(<?= $k; ?>,'dg4',this.value);" class="vc30" value="<?= $dg4; ?>" ><br />

<input onchange="xeditCav(<?= $k; ?>,'q5',this.value);" class="vc30" value="<?= $q5; ?>" >
<input onchange="xeditCav(<?= $k; ?>,'dg5',this.value);" class="vc30" value="<?= $dg5; ?>" >
						
		</td>		
		
	<?php endfor; ?>	

	<td>
	<?php 
	$ga1=$students[$i]['conduct_q1'];$ga2=$students[$i]['conduct_q2'];
	$ga3=$students[$i]['conduct_q3'];$ga4=$students[$i]['conduct_q4'];$ga5=$students[$i]['conduct_q5'];
	
	$dga1=$students[$i]['conduct_dg1'];$dga2=$students[$i]['conduct_dg2'];
	$dga3=$students[$i]['conduct_dg3'];$dga4=$students[$i]['conduct_dg4'];$dga5=$students[$i]['conduct_dg5'];
	

	?>
	
<input type="hidden" id="scid-<?= $i; ?>" value="<?= $scid; ?>" >
<input onchange="xeditGenave(<?= $i; ?>,'conduct_q1',this.value);" class="vc30" value="<?= $ga1; ?>" >
<input onchange="xeditGenave(<?= $i; ?>,'conduct_dg1',this.value);" class="vc30" value="<?= $dga1; ?>" ><br />

<input onchange="xeditGenave(<?= $i; ?>,'conduct_q2',this.value);" class="vc30" value="<?= $ga2; ?>" >
<input onchange="xeditGenave(<?= $i; ?>,'conduct_dg2',this.value);" class="vc30" value="<?= $dga2; ?>" ><br />

<input onchange="xeditGenave(<?= $i; ?>,'conduct_q3',this.value);" class="vc30" value="<?= $ga3; ?>" >
<input onchange="xeditGenave(<?= $i; ?>,'conduct_dg3',this.value);" class="vc30" value="<?= $dga3; ?>" ><br />

<input onchange="xeditGenave(<?= $i; ?>,'conduct_q4',this.value);" class="vc30" value="<?= $ga4; ?>" >
<input onchange="xeditGenave(<?= $i; ?>,'conduct_dg4',this.value);" class="vc30" value="<?= $dga4; ?>" ><br />

<input onchange="xeditGenave(<?= $i; ?>,'conduct_q5',this.value);" class="vc30" value="<?= $ga5; ?>" >
<input onchange="xeditGenave(<?= $i; ?>,'conduct_dg5',this.value);" class="vc30" value="<?= $dga5; ?>" >
		
	</td>
	
	
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
	</td>
</tr>

<?php endif; ?>  <!-- index matching -->

<?php endfor; ?>
</table> 

<br />

<h4 class="brown" >Always press 1) <span class="u" >Save</span> button first before 2) <span class="u" >Average</span>.</h4>



<p id="btns" >
	<?php if(($_SESSION['srid']==RMIS) || $_SESSION['srid']==RREG): ?>
		<input onclick="return confirm('Sure?');" type="submit" name="save" value="1) Save On" />
		<button><a class="no-underline txt-black" 
			href='<?php echo URL."conducts/fg/$course_id/$sy/$qtr"; ?>' >2) Average On</a></button>
	<?php endif; ?>

	<?php if(($_SESSION['user']['role_id']==RTEAC) && (!$is_locked)): ?>
		<input onclick="return confirm('Sure?');" type="submit" name="save" value="1) Save*" />	
		<button><a class="no-underline txt-black" 
			href='<?php echo URL."conducts/fg/$course_id/$sy/$qtr"; ?>' >2) Average</a></button>				
	<?php endif; ?>
</p>


<?php if($sync): ?>
	<a class="button" style="font-size:14px;"
	href='<?php echo URL."utils/syncTPG/".$course['level_id'].DS.$course['crid'].DS.$course['id']."/$sy/$qtr"; ?>' >
	Sync Records </a> 
<?php endif; ?>

<input type='hidden' name='data[numcri]' value="<?php echo $num_criteria; ?>">	
<input type="hidden" name="data[flrgr]" value="<?php echo $flrgr; ?>"  />	

</form>


<?php 
	// include_once('incs/notes_traits.php');
?>



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
	nextViaEnter();	  
	
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



function xeditCav(k,key,val){	
	var vurl 	= gurl + '/ajax/xcav.php';	
	var task	= "updateCav";	
	var gid = $('#gid-'+k).val();	
	var pdata = "task="+task+"&key="+key+"&val="+val+"&gid="+gid;
	$.ajax({ type: 'POST',url: vurl,data: pdata,success:function(){} });				
		
}	/* fxn */


function xeditGenave(i,key,val){	
	var vurl 	= gurl + '/ajax/xcav.php';	
	var task	= "updateGenave";	
	var scid = $('#scid-'+i).val();	
	// alert(scid);
	var pdata = "task="+task+"&key="+key+"&val="+val+"&scid="+scid;
	$.ajax({ type: 'POST',url: vurl,data: pdata,success:function(){} });				
		
}	/* fxn */


</script>


