<?php 
/* @gcontroller-course */

$qtr=($qtr>4)? 4:$qtr;
$_SESSION['stats'] = NULL;
$dgids = buildArray($ratings,'dgid');	
$_SESSION['stats'] = initStats($dgids);

$aggregate = $course['is_aggregate'];

// $decifg   = ;
$decifg	= isset($_GET['deciave'])? $_GET['deciave']:$_SESSION['settings']['decifg'];
$pg 	  = $_SESSION['settings']['passing_grade'];

$updated=true;
// pr($course);



?>


<p class="screen" >&deci=<?php echo $decicard; ?> | &deciave=<?php echo $decifg; ?> </p>

<form method='post' > <!-- for batch edit/delete -->

<h5 class="screen" >
	Conduct Averages (<?=$num_students;?>) | 
	<a href="<?php echo URL.$home; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			

	<?php if($course['crstype_id']==CTYPETRAIT): ?>
		| <a href='<?php echo URL."cav/traits/".$course['course_id']."/$sy/$qtr"; ?>' />Traits</a>		
	<?php endif; ?>	
	
	<?php $clsrec = ($course['with_scores']==1)? 'scores':'grades'; ?>
	| <a href='<?php echo URL."conducts/sortRanks/$sy/$qtr/$crid/$course_id"; ?>'>Ranks</a> 
	| <a href='<?php echo URL."conducts/fg/".$course['course_id']."/$sy/$qtr/$sem?deci=2"; ?>'>Decimal</a> 

		
	<?php if($has_stats): ?>
		| <a href="<?php echo URL.'averages/courseStats/'.$course_id.DS.$sy.DS.$qtr; ?>">Stats</a> 
	<?php else: ?>
		&nbsp; 
		&nbsp; 
		&nbsp; 
		<input type="submit" name="add_stats" value="Add Stats"  >
	<?php endif; ?>

<?php $sems = array(0,1,2); ?>
	| <select id="semval" class="vc50" >
		<?php foreach($sems AS $sv): ?>
			<option><?php echo $sv; ?></option>
			<?php endforeach; ?>
		</select>
		<a class="button" onclick="jsredirect('conducts/fg/'+crs+ds+sy+ds+qtr+'?sem='+$('#semval').val());" >Semestral</a>
	
<?php if($aggregate): ?>
	| <a href='<?php echo URL."aggregates/tally/$crid/$course_id/$subject_id/$sy/$qtr"; ?>' >Aggregate</a> 
<?php endif; ?>

<?php if($dgonly): ?>
| <a href='<?php echo URL."conducts/fg/$course_id/$sy/$qtr?ctype=$ctype&dept=$dept_id{$sortcond}"; ?>' >Default</a>
<?php else: ?>
| <a href='<?php echo URL."conducts/fg/$course_id/$sy/$qtr?ctype=$ctype&dept=$dept_id&dgonly{$sortcond}"; ?>' >DG Only</a>
<?php endif; ?>


	&nbsp;&nbsp;&nbsp;  <span class="brown" id="display" ></span>
	
</h5>

<?php 
	$d['ctype']=$ctype;
	$d['dept']=$dept_id;
	$d['ratings'] = $ratings;
	$this->shovel('filter_ctypes',$d); 
?>
<script>
	
function redirCtype(){
	var url = gurl+"/conducts/fg/"+crs+ds+sy+ds+qtr+'?ctype='+$('#ctype').val()+'&dept='+$('#dept').val()+getdg;
	window.location = url;		
}	/* fxn */
	
</script>


<?php if($course['semester']>0): ?>
	<p>URL Params: conducts/fg/course/sy/qtr/semester</p>
<?php endif; ?>

<!---------------------------------------------------------------------------------->

<?php if(empty($grades)): ?>
	<p><a class="button" style="font-size:14px;" href="<?php echo URL.'matrix/grades/'.$course['crid'].DS.$sy.DS.$qtr; ?>"> Get Student List </a></p>			
<?php endif; ?>	



<?php 


function computeFg($row,$qtr,$sem=0,$decicard){
	$fg 	= 0;
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
			$numqtr+=1;
			$fg += number_format($row['q'.$i],$decicard);
		}
		@$ave = $fg / $numqtr;			
		// echo "qtr: $qtr, fg $fg, numqtr: $numqtr<br />";		
	}
	return $ave;	

}	/* fxn */



$this->shovel('ratings',$ratings);
$flrgr = $_SESSION['settings']['floor_grade_ftnv'];

// pr($flrgr);

	
?>

<p><?php $this->shovel('hdpdiv'); ?></p>



<p class="screen" >
<table class='table-fx gis-table-bordered'>
<tr class="hd" ><th class="bg-blue2" >Locking</th><td>
			<?php if($is_locked): ?>
				<a href="<?php echo URL.'finalizers/openCourse/'.$course['crid'].DS.$course_id.DS.$sy.DS.$qtr; ?>" > Unlock </a>
			<?php else: ?>
				<a href="<?php echo URL.'finalizers/closeCourse/'.$course['crid'].DS.$course_id.DS.$sy.DS.$qtr; ?>" > Lock </a>			
			<?php endif; ?>
</td></tr>
<?php if($admin): ?>
	<tr class="" ><th class="bg-blue2" >-login</th><td><?php echo $course['teacher_code']; ?></td></tr>
	<tr class="" ><th class="bg-blue2" >Teacher <span class="hd" >(<?php echo $course['tcid']; ?>)</span></th>
		<td class="" id="<?php echo $course['teacher_code']; ?>" 
		ondblclick="xgetidByCode('dbo','00_contacts',this.id);" ><?php echo $course['teacher']; ?></td></tr>
<?php endif; ?>
<tr><td>
	<?php
		echo $course['level'].' - '.$data['course']['section'].' - ';	
		echo $course['label']; echo ($sem)? " <span class='f11' >(Sem - $sem)</span>":NULL; ?></td>
<td>Q<?php echo $qtr; ?> - <?php echo ($is_locked)? 'Closed' : 'Open'; ?></td></tr>
</table>
</p>


<!-- -----------------------------------------  grades below ----------------------------------------- -->
<?php 
	
	$intype = ($is_k12)? "text":"hidden"; 
?>



<table class='table-fx gis-table-bordered'>
<tr class='headrow'>
<th>#</th>
<th >Scid</th>
<th >Student</th>

<?php for($a=1;$a<=$qtr;$a++): ?>	
	<th class="tqg center" > Q<?php echo $a; ?> </a> </th>
<?php endfor; ?>
	<th class="center" >DB<br />Ave</th>
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
<?php foreach($grades as $row): ?>
<?php $fg = 0; ?>
<tr class="<?php echo (even($i))? 'even':'odd'?>">
<td><?php echo $i+1; ?></td>
<td><?php echo $row['scid']; ?></td>
<td>
	<?php echo $row['student']; ?>
	<?php echo ($with_chinese==1)? '<br />'.$row['chinese_name']:NULL; ?>
</td>
<?php for($a=1;$a<=$qtr;$a++): ?>
		<?php 
			${'qb'.$a} = $row['q'.$a]; 
		?>
	<td class="center <?php echo (${'qb'.$a}<$pg)? 'bg-red':NULL; ?>" >
			<?php echo number_format(${'qb'.$a},$decicard); ?>
	<?php if($is_k12): ?>
			<br /> <?php echo $row['dg'.$a]; ?>
	<?php endif; ?>
	</td>	
	
	
<?php endfor; ?>


	<td class="center" >
		<?php ?>
		<?php echo $grades[$i][$qf]; ?>
		<br /><?php echo $grades[$i][$dgf]; ?>	
	</td>


	<?php $fg = computeFg($row,$qtr,$sem,$decicard); ?>
	<?php $fg = ($fg < $flrgr)? $flrgr : $fg; ?>	
	<?php $fg = number_format($fg,$decifg); ?>	
	<?php $rfg = ($is_k12)? round($fg) : $fg; ?>
	
<td class="<?php echo ($fg<$pg)? 'bg-red':NULL; ?>" >
	<?php 
		$same = ($fg==$grades[$i][$qf])? true:false; 
		$fgdeci = number_format($fg,$decifg); 
	?>		
	<?php if(!$same): $updated=false; ?>
			
			  <input class="vc50 center <?php echo ($same)? NULL:'bg-red'; ?>" type="text" name="grades[<?php echo $i; ?>][fg]" 
				value="<?php echo $fgdeci; ?>" readonly />					
			  <input class="vc50 center <?php echo ($same)? NULL:'bg-red'; ?>" type="text" name="grades[<?php echo $i; ?>][dg]" 
				value="<?php echo rating($fgdeci,$ratings); ?>" readonly />				
			<input type="hidden" name="grades[<?php echo $i; ?>][sumid]" value="<?php echo $row['sumid']; ?>" readonly />
			<input type="hidden" name="grades[<?php echo $i; ?>][scid]" value="<?php echo $row['scid']; ?>" readonly />
							
	<?php endif; ?>		<!-- same -->
				  
	<?php  $_SESSION['stats'] = countStats($fgdeci,$ratings,$_SESSION['stats']); ?>				  


</td>
	
	
<td class="hd <?php echo ($fg != $row['q'.$intfqtr])? 'red': null; ?>"  > <?php echo $row['q'.$intfqtr]; ?> </td>
<td class="hd" ><?php echo $row['scid']; ?></td>


</tr>
<?php $i++; ?>
<?php endforeach; ?>
</table>


<br />


<?php 

//	echo "num-diff: $num_diff <br />";
?>

<!--------------------------------------------------------->
<?php if(!$updated): ?><br /><input type="submit" name="submit" value="Update"  /><?php endif; ?>

<div class="clear ht100" ></div>

<?php foreach($ratings AS $row): ?>
<?php $dgid = $row['dgid'];  

?>
<input type="hidden" name="stats[<?php echo $dgid; ?>]" value="<?php echo $_SESSION['stats'][$dgid]; ?>"  >

<?php endforeach; ?>




</form> <!-- for batch -->



<script>
	var hdpass  = '<?php echo HDPASS; ?>';
	var gurl 	= 'http://<?php echo GURL; ?>';
	var crs 	= '<?php echo $course_id; ?>';
	var ds 		= '<?php echo "/"; ?>';
	var sy 		= '<?php echo $sy; ?>';
	var qtr 	= '<?php echo $qtr; ?>';
	var getdg = "<?php echo ($dgonly)? '&dgonly':NULL; ?>";
	

	$(function(){ 
		hd(); 
		$('#hdpdiv').hide();
	})
	
	function gotoSem(){
		var sv = $('#semval').val();
		alert(sv);
	
	}
	
</script>
