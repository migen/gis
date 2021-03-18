<?php 



/* @gcontroller-course */

$_SESSION['stats'] = NULL;
$decicard=isset($_GET['decicard'])?$_GET['decicard']:$_SESSION['settings']['decicard'];
$deptdeci=($course['department_id']==3)? $_SESSION['settings']['deciave_hs']:$_SESSION['settings']['deciave_gs'];
$deciave=$_SESSION['settings']['deciave'];
$deciave=isset($_GET['deciave'])?$_GET['deciave']:$deciave;

$dgids = buildArray($ratings,'dgid');	
$_SESSION['stats'] = initStats($dgids);
$aggregate = $course['is_aggregate'];
$decifg   = $_SESSION['settings']['decifg'];
$pg 	  = $_SESSION['settings']['passing_grade'];

$quarters=array();


?>


<?php if($num_students !== $num_grades): ?>
<p><?php 
	echo "Number of Grades: $num_grades <br />";
	echo "Number of Students: $num_students <br />";
?></p>
<p><a onclick="return confirm('For beginning of SY only,OK?');" class="button" href="<?php echo URL.'utils/cleanCourseGrades/'.$course['crid'].DS.$course['id'].DS.$sy; ?>" style="font-size:14px;"   >Sync Grades</a></p>	
<?php endif; ?>



<h5>
	Averages - Std (<?=$num_students;?>) | 
	<a href="<?php echo URL.$home; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a class="u" id="btnExport" >Excel</a> 
	
<?php if($course['with_scores']==1): ?>
	| <a href='<?php echo URL."teachers/scores/$course_id/$sy/$qtr"; ?>' >Scores</a>
<?php else: ?>	
	<?php if($course['is_num']!=1): ?>
		| <a href='<?php echo URL."grades/dg/$course_id/$sy/$qtr"; ?>' >Grades (DG)</a>		
	<?php endif; ?>	
<?php endif; ?>	

	| <a href='<?php echo URL."classlists/master/$crid"; ?>' >MasterList</a>	
	| <a href='<?php echo URL."teachers/grades/$course_id/$sy/$qtr"; ?>' >Grades</a>	
	| <a href='<?php echo URL."lookups/equivalents?ctype=$ctype";  ?>' >Equivalents</a>				
	| <a href="<?php echo URL.'averages/courseRanks/'.$course['course_id'].DS.$sy.DS.$qtr; ?>">Ranks</a> 
	
<?php if(isset($_GET['sort'])): ?>	
	| <a href='<?php echo URL."averages/course/$course_id/$sy/$qtr"; ?>' >Alphabetical</a> 		
<?php else: ?>
	| <a href='<?php echo URL."averages/course/$course_id/$sy/$qtr?order=c.position"; ?>' >Position</a> 		
<?php endif; ?>

	
	<?php if($has_stats): ?>
		| <a href="<?php echo URL.'averages/courseStats/'.$course_id.DS.$sy.DS.$qtr; ?>">Stats</a> 
	<?php else: ?>
		&nbsp;&nbsp;&nbsp; 
		<input type="submit" name="add_stats" value="Add Stats"  >
	<?php endif; ?>
	


<?php if($aggregate): ?>
	| <a href='<?php echo URL."aggregates/tally/$crid/$course_id/$subject_id/$sy/$qtr"; ?>' >Aggregate</a> 
<?php endif; ?>

	| <a href='<?php echo URL."averages/course/$course_id/$sy/1"; ?>' >Q1</a> 
	| <a href='<?php echo URL."averages/course/$course_id/$sy/2"; ?>' >Q2</a> 
	| <a href='<?php echo URL."averages/course/$course_id/$sy/3"; ?>' >Q3</a> 
	| <a href='<?php echo URL."averages/course/$course_id/$sy/4"; ?>' >Q4</a> 	
	| <a class="u" onclick="ilabas('sum');" >Sum<a>
	
	&nbsp;&nbsp;&nbsp;  <span class="brown" id="display" ></span>	
</h5>


<h4>
<?php 
	$sems = array(0,1,2); 
	$sem=isset($_GET['sem'])? $_GET['sem']:$course['semester'];

?>
<form method="GET" >
	Decicard <input value="<?php echo (isset($_GET['decicard']))? $_GET['decicard']:$_SESSION['settings']['decicard']; ?>" 
		class="vc50 pdl05" name="decicard" type="number" />
	Deciave <input value="<?php echo (isset($_GET['deciave']))? $_GET['deciave']:$deciave; ?>"
		class="vc50 pdl05" name="deciave" type="number" />
	Sem <select name="sem" id="semval" class="vc50"  >
		<?php foreach($sems AS $sv): ?>
			<option <?php echo ($sv==$sem)?'selected':NULL; ?> ><?php echo $sv; ?></option>
			<?php endforeach; ?>
		</select>
		<input type="submit" name="parameters" value="Parameters"  />
</form>		
</h4>



<?php 
	// $d['ctype']=$ctype;
	// $d['dept']=$dept_id;
	// $d['ratings'] = $ratings;
	// $this->shovel('filter_ctypes',$d); 
?>



<!---------------------------------------------------------------------------------->

<?php if(empty($grades)): ?>
	<p><a class="button" style="font-size:14px;" href="<?php echo URL.'matrix/grades/'.$course['crid'].DS.$sy.DS.$qtr; ?>"> Get Student List </a></p>			
<?php endif; ?>	



<?php 



function fgOK($row,$qtr,$sem=0,$decicard){
	$fg = 0;
	if($sem==1){
		if($qtr%2){ 		
			$fg  = number_format($row['q1'],$decicard);
			$ave = $fg; 
		} else { 
			$fg = number_format($row['q1'],$decicard) + number_format($row['q2'],$decicard);		
			$ave = $fg/2; }		
	} elseif($sem==2){
		if($qtr%2){ 		
			$fg  = number_format($row['q3'],$decicard);
			$ave = $fg; 
		} else { 
			$fg = number_format($row['q3'],$decicard) + number_format($row['q4'],$decicard);		
			$ave = $fg/2; }		
	} else {	
		$numqtr = 0;
		for($i=1;$i<=$qtr;$i++){
			/* $numqtr = ($row['q'.$i]>0)? $numqtr+1:$numqtr; */
			$numqtr += 1;
			$fg += number_format($row['q'.$i],$decicard);
		}
		$ave = $fg / $numqtr;			
	}
	$x['sum'] = $fg;
	$x['ave'] = $ave;
	return $x;

}


if($sem==0){
	function fg($row,$qtr,$sem=0,$decicard){
		$fg=0;
		$numqtr = 0;
		for($i=1;$i<=$qtr;$i++){
			/* $numqtr = ($row['q'.$i]>0)? $numqtr+1:$numqtr; */
			$numqtr += 1;
			$fg += number_format($row['q'.$i],$decicard);
		}
		$ave = $fg / $numqtr;					
		$x['sum'] = $fg;
		$x['ave'] = $ave;
		return $x;		
	}
	
} else if($sem==1){
	function fg($row,$qtr,$sem=0,$decicard){
		$fg=0;
		if($qtr%2){ 		
			$fg  = number_format($row['q1'],$decicard);
			$ave = $fg; 
		} else { 
			$fg = number_format($row['q1'],$decicard) + number_format($row['q2'],$decicard);		
			$ave = $fg/2; }
		$x['sum'] = $fg;
		$x['ave'] = $ave;
		return $x;	
	}
} else if($sem==2) {
	function fg($row,$qtr,$sem=0,$decicard){
		$fg=0;
		if($qtr%2){ 		
			$fg  = number_format($row['q3'],$decicard);
			$ave = $fg; 
		} else { 
			$fg = number_format($row['q3'],$decicard) + number_format($row['q4'],$decicard);		
			$ave = $fg/2; }
		$x['sum'] = $fg;
		$x['ave'] = $ave;
		return $x;			
	}	
	
}




$this->shovel('ratings',$ratings);
$flrgr = $_SESSION['settings']['floor_grade_ftnv'];

	
?>

<p><?php $this->shovel('hdpdiv'); ?></p>



<p>
<table class='table-fx gis-table-bordered'>
<tr class="hd" ><th class="bg-blue2" >Locking</th><td>
			<?php if($is_locked): ?>
				<a href="<?php echo URL.'finalizers/openCourse/'.$course['crid'].DS.$course_id.DS.$sy.DS.$qtr; ?>" > Unlock </a>
			<?php else: ?>
				<a href="<?php echo URL.'finalizers/closeCourse/'.$course['crid'].DS.$course_id.DS.$sy.DS.$qtr; ?>" > Lock </a>			
			<?php endif; ?>
</td></tr>
<?php if($admin): ?>
	<tr><th class="bg-blue2" >Teacher <span class="hd" >(<?php echo $course['tcid']; ?>)</span></th>
		<td class="" id="<?php echo $course['teacher_code']; ?>" 
		ondblclick="xgetidByCode('dbo','00_contacts',this.id);" ><?php echo $course['teacher']; ?>
		| <?php echo $course['teacher_code']; ?>
	</td></tr>
<?php endif; ?>
<tr><th class="vc100 bg-blue2" >Course<span class="hd" >(<?php echo $course['subject_id']; ?>)</span></th><td>
	<?php
		echo $course['level'].' - '.$data['course']['section'].' - ';	
		echo $course['label']; echo ($sem)? " <span class='f11' >(Sem - $sem)</span>":NULL; 
		echo ' ('.$course['code'].')';
	?>
	| <span class="b" >Status </span><?php echo ucfirst('Q'.$qtr); ?> - 
		<?php echo ($is_locked)? "Closed":"<span class='brown'>Open</span>"; ?>
	</td>
</tr>
</table>
</p>

<?php if($is_locked): ?>
	<?php if($qtr==$sqtr): ?>
		<h5 class="brown" ><span class="" >*Update if any red box Ave (column) exists.</span></h5>	
	<?php endif; ?>
<?php endif; ?>


<!-- --------------  grades below --------------- -->

<form method='post' > <!-- for batch edit/delete -->

<table id="tblExport" class='table-fx gis-table-bordered'>
<tr class='headrow'>
<th>#</th>
<th >Scid</th>
<th >Student</th>
<?php 
	$quarters[5]['passed']=0; 
	$quarters[5]['failed']=0; 

?>
<?php for($a=1;$a<=$qtr;$a++): ?>	
<?php 
	$quarters[$a]['passed']=0; 
	$quarters[$a]['failed']=0; 
?>
	<th class="tqg center" > Q<?php echo $a; ?> </a> </th>
<?php endfor; ?>
	<th class="sum right" >Sum</th>
	<th>DB<br />Ave</th>

	<th class="tqg center" > Ave
		<?php if($sem==1): ?>
			<br />
			<?php echo ($qtr%2)? 'Q1':'Q1-Q2'; ?>
		<?php elseif($sem==2): ?>
			<br />
			<?php echo ($qtr%2)? 'Q3':'Q3-Q4'; ?>			
		<?php else: ?>
		<?php endif; ?>
	</th>
</tr>

<?php $i=0; ?>
<?php $updated=true; ?>
<?php foreach($grades as $row): ?>
<?php 
	$scid = $row['scid']; 
	$gid = $row['gid']; 

?>
<?php $fg = 0; ?>
<tr id="trow<?php echo $i; ?>" class="<?php echo (even($i))? 'even':'odd'?>">
<td id="<?php echo 'Gid: '.$row['gid'].' | DBFG: '.$row['q5'].' | SCID: '.$row['scid'].' : '.$row['student_code']; ?>" 
		ondblclick="alert(this.id);" ><?php echo $i+1; ?></td>
<td><?php echo $scid; ?></td>
<td>
<?php if($is_locked): ?>
	<?php echo $row['student']; ?>	
<?php else: ?>
	<a href='<?php echo URL."grades/edit/$course_id/$scid/$gid"; ?>' ><?php echo $row['student']; ?></a>
<?php endif; ?>	
</td>
<?php for($a=1;$a<=$qtr;$a++): ?>
		<?php 
			${'qb'.$a} = $row['q'.$a]; 
			
			if(${'qb'.$a}<$pg){
				$quarters[$a]['failed']++;				
			} else {
				$quarters[$a]['passed']++;							
			}
			
			
		?>
	<td class="center <?php echo (${'qb'.$a}<$pg)? 'bg-red':NULL; ?>" >
			<?php echo number_format(${'qb'.$a},$decicard); ?>
	</td>	
<?php endfor; ?>



<!--------------- fg ------------------->	
<?php 
	$x = fg($row,$qtr,$sem,$decicard); 
	$fg = $x['ave'];
	$sum = $x['sum'];
	
	$fg = ($fg < $flrgr)? $flrgr : $fg; 	
	$rdfg = number_format($fg,$deciave); 	
	$rdbfg=number_format($row[$qf],$deciave);	
	
	
?>


<td class="sum right" ><?php echo $sum; ?></td>
<?php 
	if($row[$qf]<$pg){
		$quarters[5]['failed']++;				
	} else {
		$quarters[5]['passed']++;							
	}

?>

<td class="center <?php echo ($rdbfg<$pg)? 'bg-red':NULL; ?> " >
<?php echo number_format($row[$qf],$deciave); ?>
<br /><?php echo $row[$dgf]; ?>
</td>

	
	<?php 
		$same=($rdbfg==$rdfg)? true:false;  
		if(!$same){ $updated = false; }	
	?>
	
<td class="<?php echo ($same)? NULL:'bg-red'; ?>" >
<?php if(!$same): ?>
	<input class="vc50 center" type="text" name="grades[<?php echo $i; ?>][fg]" 
		value="<?php echo $rdfg; ?>" readonly />					  
	<?php  $_SESSION['stats'] = countStats($rdfg,$ratings,$_SESSION['stats']); ?>				  
		  <?php $intype = ($is_k12)? "text":"hidden"; ?>	
<input type="hidden" name="grades[<?php echo $i; ?>][gid]" value="<?php echo $row['gid']; ?>" readonly />
<input type="hidden" name="grades[<?php echo $i; ?>][scid]" value="<?php echo $row['scid']; ?>" readonly />
<?php endif; ?>

</td>
	
	
<td class="hd <?php echo ($fg != $row['q5'])? 'red': null; ?>"  > <?php echo $row['q5']; ?> </td>
<td class="hd" ><?php echo $row['gid']; ?></td>
<td class="hd" ><?php echo $row['scid']; ?></td>
<td class="hd" >
	<a class="txt-blue u" onclick="xdeleteGrade(<?php echo $row['gid'].','.$i; ?>);"  >xDEL</a>
</td>


</tr>
<?php $i++; ?>
<?php endforeach; ?>
<!-- statistics stats -->
<tr>
	<th colspan="3" >Passed / Failed</th>
	<?php for($a=1;$a<=$qtr;$a++): ?>
		<th>
			P: <?php echo $quarters[$a]['passed']; ?><br />
			<span class="red" >F: <?php echo $quarters[$a]['failed']; ?></span>
		</th>
	<?php endfor; ?>
		<th class="sum" ></th>	
		<th>
			P: <?php echo $quarters[5]['passed']; ?><br />
			<span class="red" >F: <?php echo $quarters[5]['failed']; ?></span>
		</th>	
	<td colspan="" ></td>
</tr>

</table>


<br />


<?php 

//	echo "num-diff: $num_diff <br />";
?>

<!--------------------------------->

<?php if($admin): ?>
	<p><input type="submit" name="submit" value="Save"  />
	<input type="submit" name="submit" value="Update"  /></p>
<?php endif; ?>

<?php if($qtr==$_SESSION['qtr']): ?>
	<?php if($_SESSION['user']['role_id']==RTEAC): ?>
		<?php if(!$is_locked): ?>			
			<br /><input type="submit" name="submit" value="Update"  />
		<?php else: ?>
			<?php if(!$updated): ?>		
				<p>	<input type="submit" name="submit" value="Update"  /></p>
			<?php endif; ?>	
		<?php endif; ?>
	<?php endif; ?>
<?php else: ?>
	<?php if(!$is_locked): ?>
		<br /><input type="submit" name="submit" value="Save"  />
		<br /><h4 class="brown" >Not present quarter!</h4><input type="submit" name="submit" value="Update"  />
	<?php endif; ?>

<?php endif; ?>

<?php foreach($ratings AS $row): ?>
<?php $dgid = $row['dgid'];  

?>
<input type="hidden" name="stats[<?php echo $dgid; ?>]" value="<?php echo $_SESSION['stats'][$dgid]; ?>"  >

<?php endforeach; ?>

</form> <!-- for batch -->



<br /><div class="clear ht50" >*Update if any red values on the AVE column exist.</div>



<script>
var gurl = "http://<?php echo GURL; ?>";
var hdpass = "<?php echo HDPASS; ?>";
var crs = "<?php echo $course_id; ?>";
var sy	= "<?php echo $sy; ?>";
var qtr = "<?php echo $qtr; ?>";
var ds 	= "/";
var updated = "<?php echo $updated; ?>";

$(function(){ 
	hd(); 
	$('#hdpdiv').hide();
	itago('sum');
	excel();
	if(!updated){ alert("Submit to Update Averages."); }
	
})


function redirSem(){ jsredirect('averages/course/'+crs+ds+sy+ds+qtr+'?sem='+$('#semval').val()); }


function xdeleteGrade(gid,i){
	var vurl 	= gurl + '/ajax/xgrades.php';	
	var task	= "xdeleteGrade";	
	$.ajax({
		url: vurl,
		type: 'POST',
		data: 'task='+task+'&gid='+gid,				
		async: true,
		success: function() {
			deltrow(i);
		}		  
	});				
		
}	/* fxn */
	
	
</script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>
