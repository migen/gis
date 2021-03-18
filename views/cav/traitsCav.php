<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>

<?php 


$deciconducts  = $_SESSION['settings']['deciconducts'];
$decifconducts = $_SESSION['settings']['decifconducts'];


$qtr = $qtr;
$qqtr		= 'q'.$qtr;
$dgqtr = 'dg'.$qtr;
$is_locked;
$crsid 		 = $course['course_id']; 
$num_criteria 	= count($criteria);
$this->shovel('ratings',$ratings);

// $num_students=2;


function getFloorGrade($course,$settings){
	return $settings['floor_conduct'];
}

$flrgr = getFloorGrade($course,$_SESSION['settings']);

$is_expired=isset($_SESSION['settings']['is_expired']) && ($_SESSION['settings']['is_expired']==1)? true:false;



?>

<?php if($is_expired): ?>
<h5>
	Traits | <?php $this->shovel('homelinks'); ?>	
</h5>
<?php else: ?>
<h5>
	Traits (<?php echo (isset($_GET['sort']) && $_GET['sort']=='c.position')? 'Position':'Alphabetical'; ?>)
	(<?=$num_students;?>)
	| <?php echo "CRID#$crid"; ?>
	| <a href="<?php echo URL.$home; ?>">Home</a> 	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		

<?php if($is_locked): ?>
	| <a class="u" id="btnExport" >Excel</a> 
<?php endif; ?>
		
<?php if(isset($_GET['sort'])): ?>	
	| <a href='<?php echo URL."cav/traits/$course_id/$sy/$qtr?ctype=$ctype&dept=$dept_id"; ?>' >Alphabetical</a> 		
<?php else: ?>
	| <a href='<?php echo URL."cav/traits/$course_id/$sy/$qtr?ctype=$ctype&dept=$dept_id&sort=c.position"; ?>'>Position</a>
<?php endif; ?>
		
	| <a href='<?php echo URL."legends/traits"; ?>' >Legends</a> 	
	| <a href='<?php echo URL."matrix/grades/$crid/$sy/$qtr"; ?>' >Matrix</a> 	
	| <a href='<?php echo URL."cav/mcr/$crid/$sy/$qtr"; ?>' >MCR (Multirows)</a> 	
	<?php if($_SESSION['settings']['traits_value_dg']==1): ?>
		| <a href='<?php echo URL."cav/matrix/$crid/$sy/$qtr?value=1"; ?>' >CavMatrix</a> 		
	<?php else: ?>
		| <a href='<?php echo URL."cav/matrix/$crid/$sy/$qtr"; ?>' >CavMatrix</a> 	
	<?php endif; ?>
	| <a href='<?php echo URL."submissions/view/$crid/$sy/$qtr"; ?>' >Submissions</a> 	
	
	<?php if($is_locked): ?>
		| <a href='<?php echo URL."conducts/sortRanks/$sy/$qtr/$crid/".$course['id']; ?>' >Ranks</a> 		
	<?php endif; ?>
	| <a class="" href='<?php echo URL."conducts/fg/$course_id/$sy/$qtr"; ?>' >Ave</a>	
	
	| <a href='<?php echo URL."cav/genave/$course_id/$sy/$qtr"; ?>' >Genave</a> 	

	<?php if(($qtr>3) && ($_SESSION['user']['privilege_id']==0)): ?>
		| <a href='<?php echo URL."cav/summary/$course_id/$sy/$qtr"; ?>' >Summary</a>
		| <a href='<?php echo URL."conso/traits/$course_id/$sy/$qtr"; ?>' >Conso</a>
	<?php endif; ?>
	

<span class="hd" >&nbsp; <a class="button" style="font-size:14px;" 
href='<?php echo URL."utils/cleanTPG/".$course['level_id'].DS.$course['crid'].DS.$course['id']."/$sy/$qtr"; ?>' >Wipe All Records </a>	
	&nbsp; 
	<a class="button" style="font-size:14px;"
	href='<?php echo URL."utils/syncTPG/".$course['level_id'].DS.$course['crid'].DS.$course['id']."/$sy/$qtr"; ?>' > Sync Records </a> 
</span>

| <a href='<?php echo URL."cav/dg/$course_id/$sy/$qtr?{$sortcond}"; ?>' >DG Only</a>

</h5>

<?php if(isset($_GET['debug'])){ pr($q); } ?>

<?php $this->shovel('hdpdiv'); ?>


<?php 
	$d['ctype']=$ctype;
	$d['dept']=$dept_id;
	$d['ratings'] = $ratings;
	$this->shovel('filter_ctypes',$d); 
?>

<?php if($qtr>3): ?>
<h4 class="brown" >1) Process EACH indicator by Edit > Save. 2) Save 3) Average</h4>
<?php endif; ?>


<?php endif; ?>	<!-- !expired -->




<script>

var hdpass 	= "<?php echo HDPASS; ?>";
var crid 	= "<?php echo $crid; ?>";
var gurl 	= 'http://<?php echo GURL; ?>';

$(function(){
	$('#hdpdiv').hide();
	hd();
	excel();
	
})



	
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
	<tr>
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
	<?php for($j=0;$j<$num_criteria;$j++): ?>
		<?php $cri_id = $criteria[$j]['criteria_id']; ?>
		<td class="center" >
		<span class="u" onclick="alert(this.id);" id="<?php echo $criteria[$j]['criteria_id'].'-'.$criteria[$j]['criteria']; ?>" >
			<?php echo $criteria[$j]['code']; ?><br />
			<?php echo $criteria[$j]['weight'].'%'; ?>
			</span>
		<?php if((!$is_locked) && (!$is_expired)): ?>			
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
	<?php if(!$is_locked): ?>
		<td class="center vc50"><span class="brown b" >Weighted</span><br />Running<br />Ave</td>		
	<?php endif; ?>
	
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
<?php endif; ?>			
	<?php $rowave=0; ?>
	<?php for($j=0;$j<$num_criteria;$j++): ?>
		<?php 
			$ts = $scores[$i][$j]['q'.$qtr]; 
			$dg = $scores[$i][$j]['dg'.$qtr]; 
			$wt = $scores[$i][$j]['weight']; 
		?>
		
		<?php 
			if($wt==100 || $wt==0){
			// if($wt==100){
				$pnv = $ts*$eqwt;							
			} else {
				$pnv = $ts * $wt / 100;							
			}
			$rowave += $pnv;
		?>
		
		<td class="center"><?php echo $ts.'<br />'.$dg; ?></td>		
	<?php endfor; ?>	

<?php if($course['is_trait']==1): ?>
	<td class="center" >
		<?php echo $students[$i]['conduct_q'.$qtr]; ?>
		<br /><?php echo $students[$i]['conduct_dg'.$qtr]; ?>			
	</td>

	
<?php if(!$is_locked): ?>
	<?php 
		$rowave=number_format($rowave,$decifconducts);?>
	<?php $same = ($rowave==$students[$i]['conduct_q'.$qtr])? true:false; ?>
	
	<td class="center <?php echo ($same)? NULL:'bg-red'; ?> " >
		<input class="center vc50" name="rows[<?php echo $i; ?>][ave]" 
			value="<?php echo $rowave; ?>" tabindex="2" />

		<?php // $dg = rating($rowave,$ratings); pr($students[$i]); ?>		
		<?php $dg = ($dgonly)? $students[$i]['conduct_dg'.$qtr]: rating($rowave,$ratings); ?>		
		<br /><input class="center vc50" name="rows[<?php echo $i; ?>][dg]" value="<?php echo $dg; ?>" tabindex="4" />	
		<input type="hidden" class="center vc50" name="rows[<?php echo $i; ?>][sumid]" 
			value="<?php echo $students[$i]['sumid']; ?>" />				
	</td>
<?php endif; ?>		

<?php endif; ?>

<?php if(!$is_locked && ($sy==$ssy) && (!$is_expired)): ?>		
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



<?php if(!$is_expired): ?>
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
<?php endif; ?>	<!--  !expired -->


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


<?php if(!$is_locked): ?>	<!-- locking -->

	<button><a href="<?php echo URL.'finalizers/closeCourse/'.$crid.DS.$course_id.DS.$sy.DS.$qtr; ?>" >Lock</a></button>

<?php else: ?>	<!-- locking -->



<?php endif; ?>	<!-- locking -->




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


</script>


