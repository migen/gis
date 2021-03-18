
<?php 


	// pr($data);
	// pr($course);
	// pr($grades[0]);

// pr($ratings);
	
$is_num = $course['is_num'];	
$aggregate = $course['is_aggregate'];
$decigrades = $_SESSION['settings']['decigrades'];

		
	
?>


<?php if($num_students !== $num_grades): ?>
<p><?php 
	echo "Number of Grades: $num_grades <br />";
	echo "Number of Students: $num_students <br />";
?></p>

<a onclick="return confirm('Confirm?');" class="button" href='<?php echo URL."utils/cleanCourseGrades/$crid/$course_id/$sy"; ?>' >Sync Grades</a>
<a class="button" href='<?php echo URL."averages/course/$course_id/$sy/$qtr"; ?>' >Manage</a>

<?php endif; ?>

<!---------------------------------------------------------------------------------------->

<h5>
	<span class='u' id="<?php echo $course['label']; ?>" ondblclick="xgetid('dbm','subjects',this.id);"  >
	<?php echo $course['label']; ?> </span> Grades
	<span class="hd" >HD</span>	
	| <a href="<?php echo URL.$home; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>

	| <a href='<?php echo URL."classlists/classroom/$crid/$sy?simple"; ?>' >Classlist</a> 			

	
	| <a href='<?php echo URL."averages/course/".$course['id']."/$sy/$qtr";  ?>' >Averages</a>			
<?php if($aggregate): ?>
	| <a href='<?php echo URL."aggregates/tally/$crid/$course_id/$subject_id/$sy/$qtr"; ?>' >Aggregate</a> 
<?php endif; ?>

	| Qtr <select onchange="goto(this.value);" >
		<?php for($i=1;$i<7;$i++): ?>
			<option value="<?php echo $i; ?>" <?php echo ($i==$qtr)? 'selected':NULL; ?> >
				<?php echo $i; ?></option>
		<?php endfor; ?>
	</select>

	| <a href='<?php echo URL."teachers/grades/$course_id/$sy/$qtr"; ?>' >Numeric</a>
	| <span class="u" onclick="randomizeLetter('grades');" >Randomize DG</span>	
	| <span class="blue u" onclick="ilabas('inrank');" >In Rank</span>
	| <span class="blue u" onclick="ilabas('clipboard');" >Smartboard</span>
	
	&nbsp;&nbsp;&nbsp;  <span class="brown" id="display" ></span>
	
</h5>



<p><?php $this->shovel('hdpdiv'); ?></p>



<table class='table-fx gis-table-bordered'>
<tr class="hd" ><th>Locking</th><td>
	<?php if($is_locked): ?>
		<a href="<?php echo URL.'finalizers/openCourse/'.$course['crid'].DS.$course_id.DS.$sy.DS.$qtr; ?>" > Unlock </a>
	<?php else: ?>
		<a href="<?php echo URL.'finalizers/closeCourse/'.$course['crid'].DS.$course_id.DS.$sy.DS.$qtr; ?>" > Lock </a>			
	<?php endif; ?>		
</td></tr>

<?php if($admin): ?>
<tr><th class="bg-blue2 white" >Teacher</th><td><?php echo $course['teacher']; ?>
	| User - <span class="" ><?php echo $course['teacher_code']; ?></span>
</td></tr>
<?php endif; ?>
<tr><th class="vc100 bg-blue2 white" >Course<span class="hd" >(<?php echo $course['subject_id']; ?>)</span></th><td>
	<?php
		echo $course['level'].' - '.$data['course']['section'].' - ';	
		echo $course['label']; echo ' ('.$course['code'].')';
	?>
	
	| <span class="u" >Status</span>
		Q<?php echo $qtr." - "; echo ($is_locked)? "Closed":"Open <span class='brown' >Please Finalize.</span>"; ?>
	</td>
</tr>
</table>

<br />

<div class="half" >	<!-- halfgrades -->

<table class='table-fx gis-table-bordered table-scores '>
<tr class='headrow'>
<th>#</th>
<th class="left inrank" >In<br />Rank</th>
<th class="left" >Student</th>
<?php for($j=1;$j<=$qtr;$j++): ?>
	<th>Q<?php echo $j; ?>
		<?php if($j==$qtr): ?>
			<br /><input class="vc30 center" type="text" id="idg" placeholder="All" />
			<button onclick="populateColumn('dg');return false;">All</button>					
		<?php endif; ?>
	</th>
<?php endfor; ?>
</tr>

<form id="form" method='post' > <!-- for batch edit/delete -->
<?php $i=0; ?>
<?php foreach($grades as $row): ?>

<input type="hidden" name="grades[<?php echo $i; ?>][scid]" value="<?php echo $row['scid']; ?>" />


<tr class="<?php echo (even($i))? 'even':'odd'?>">
<!---------------------------------------------------------------------------------->

<td><?php echo $i+1; ?></td>
<td class="inrank" ><?php echo $row['in_rank']; ?>
<br /><a href="<?php echo URL.'grades/inRank/'.$course_id.DS.$row['scid']; ?>" >Edit</a>
</td>
<td class="left" id="<?php echo 'GID: '.$row['gid'].' | SCID: '.$row['scid'].' : '.$row['student_code']; ?>" 
	ondblclick="alert(this.id);" >
<?php echo $row['student']; ?>
	<?php echo ($with_chinese==1)? '<br />'.$row['chinese_name']:NULL; ?>
</td>

<!---------------------------------------------------------------------------------->

	<?php for($j=1;$j<=$qtr;$j++): ?>
	<?php 
		$dgdb = $row['dg'.$j];
	?>
	<td>
	<?php if($qtr!=$j): ?>
		<?php echo $dgdb; ?>	
	<?php else: ?>	
		<input id="grades<?php echo $i; ?>" class="vc50 center dg" name="grades[<?php echo $i; ?>][dg]" 
			value="<?php echo $dgdb; ?>" 
			<?php echo ($is_locked)? 'readonly' : NULL; ?> tabindex="1" />
	<?php endif; ?>
	</td>
	<?php endfor; ?>



<input type="hidden"  name="grades[<?php echo $i; ?>][gid]" value="<?php echo $row['gid']; ?>"  />


</tr>
<?php $i++; ?>
<?php endforeach; ?>
</table>

<p>
<?php if(!$is_locked): ?>
	<input type="submit" onclick="return confirm('Sure?');" name="submit" value="Save"  />		
	<input type="submit" name="submit" value="Finalize"  />			
<?php else: ?>
	<?php if($_SESSION['srid']==RMIS): ?>
		<input type="submit" onclick="return confirm('Sure?');" name="submit" value="Save On"  />		
	<?php endif; ?>	
<?php endif; ?>
</p>

</form> <!-- for batch -->

</div>	<!-- halfgrades -->


<div style="width:50px;float:left;height:100px;" ></div>
<div class="clipboard" style="width:200px;float:left;"  >
<p>
<select id="classbox" >
	<option value="grades" >Grades</option>
	<option value="dg" >DG</option>
</select>
</p>
<?php $d['width'] = '20'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>


<div class="clear" style="min-height:30px;" ></div>



<script>

var gurl = 'http://<?php echo GURL; ?>';	
var hdpass 	= '<?php echo HDPASS; ?>';
var crsid	= '<?php echo $crsid; ?>';
var sy   	= '<?php echo $sy; ?>';
var qtr 	= '<?php echo $qtr; ?>';
var ds 		= '/';
var count=<?php echo $num_grades; ?>;


$(function(){	
	// alert(crsid+' - '+sy+'-'+qtr);
	$('#hdpdiv').hide();
	hd();	
	itago('clipboard');
	itago('inrank');
	nextViaEnter();		
	selectFocused();
	
});
	

function goto(qtr){
	// alert('qtr-'+qtr);
	var url=gurl+'/grades/dg/'+crsid+ds+sy+ds+qtr;
	window.location=url;
	
}	
	
// var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";		
function randomizeLetter(aim){ 
	var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";var len=possible.length;
	for(var i=0;i<count;i++){ var x=possible.charAt(Math.floor(Math.random()*len));document.getElementById(aim+i).value=x; }	
}	
	
	
		
	
</script>
