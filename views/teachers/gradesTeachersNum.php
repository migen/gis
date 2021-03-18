<style>

#status{ color:brown;font-size:1.2em;font-weight:bold; }

</style>
<?php 

// echo "hdpass - ".HDPASS." <br />";
// echo "crsid - $crsid <br />";
// echo "sy - $sy <br />";
// echo "qtr - $qtr <br />";
// echo "dgonly - $dgonly <br />";
// echo "num_students - $num_students <br />";


// pr($_SESSION['q']);	
	
$aggregate = $course['is_aggregate'];
$decigrades = $_SESSION['settings']['decigrades'];

$qx="q{$qtr}";
		
		
// pr($grades[0]);		
	
?>


<?php if($num_students !== $num_grades): ?>
<p><?php 
	echo "Number of Grades: $num_grades <br />";
	echo "Number of Students: $num_students <br />";
?></p>

<a onclick="return confirm('Confirm?');" class="button" href='<?php echo URL."utils/cleanCourseGrades/$crid/$course_id/$sy"; ?>' >Sync Grades</a>
<a class="button" href='<?php echo URL."averages/course/$course_id/$sy/$qtr"; ?>' >Manage</a>
<a class="button" href='<?php echo URL."syncs/syncSummext"; ?>' >Summext</a>
<a class="button" href='<?php echo URL."purge/outcastCrsGrades/$course_id"; ?>' >PurgeOutCrsGrades</a>

<?php endif; ?>

<!---------------------------------------------------------------------------------------->

<h5>
	<span class='u' id="<?php echo $course['label']; ?>" ondblclick="xgetid('dbm','subjects',this.id);"  >
	<?php echo $course['label']; ?> </span> Numeric (<?php echo $num_grades; ?>)
	<span class="hd" >HD</span>	
	| <a href="<?php echo URL.$home; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	
	
	<?php if($srid==RMIS): ?>
		| <a href="<?php echo URL.'mgt/pass/'.$course['tcid']; ?>" >Pass</a>
	<?php endif; ?>
	
	| <a href='<?php echo URL."classlists/classroom/$crid/$sy?simple"; ?>' >Classlist</a>


<?php if($admin && $is_locked): ?>
	| <a href="<?php echo URL.'finalizers/openCourse/'.$course['crid'].DS.$course_id.DS.$sy.DS.$qtr; ?>" >Unlock</a>
<?php elseif($admin && !$is_locked): ?>
	| <a href="<?php echo URL.'finalizers/closeCourse/'.$course['crid'].DS.$course_id.DS.$sy.DS.$qtr; ?>" >Lock</a>			
<?php endif; ?>		

	
	| <a href='<?php echo URL."teachers/scores/".$course['id']."/$sy/$qtr";  ?>' >Scores</a>			
	| <a href='<?php echo URL."averages/course/".$course['id']."/$sy/$qtr";  ?>' >Averages</a>			
	| <a href='<?php echo URL."averages/courseRanks/".$course['id']."/$sy/$qtr";  ?>' >Ranks</a>			
	| <a href='<?php echo URL."teachers/grades/".$course['id']."/$sy/4";  ?>' >Q4</a>			
	| <a href='<?php echo URL."lookups/equivalents";  ?>' >EQ</a>	
<?php if($aggregate): ?>
	| <a href='<?php echo URL."aggregates/tally/$crid/$course_id/$subject_id/$sy/$qtr"; ?>' >Aggregate</a> 
<?php endif; ?>



	| <a href='<?php echo URL."grades/dg/$course_id/$sy/$qtr"; ?>' >DG Only</a>
	| <a href='<?php echo URL."matrix/grades/$crid/$sy/$qtr"; ?>' >Matrix</a> 
	| <span class="u" onclick="randomize('grades');" >Randomizer</span>	
	| <span class="blue u" onclick="ilabas('inrank');" >In Rank</span>
	
<?php if($_SESSION['srid']==RMIS): ?>
	| <a href='<?php echo URL."purge/outcastCourseGrades/$course_id"; ?>' >xOutCrsGrades</a>
<?php endif; ?>	
	
	| <span class="blue u" onclick="ilabas('clipboard');" >Smartboard</span>	
	| <a href='<?php echo URL."copier/crs/$course_id"; ?>' >Copier</a>
	
</h5>


<h5 class="brown" >1) "DG Only" to override. 2) Save > Finalize 3) Save 2x if red box appears.</h5>

<?php if($course['crstype_id']==CTYPECONDUCT): ?>
	<h5><a class="red" href='<?php echo URL."conducts/records/$course_id/$sy/$qtr"; ?>' >*Process Conducts here*</a></h5>
	<h4 class="brown" >&show</h4>
	<?php if(!isset($_GET['show'])){ exit; } ?>
<?php endif; ?>


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
<tr><th class="bg-blue2 white" >Teacher</th><td><?php echo $course['teacher'].' #'.$course['tcid']; ?>
	(<?php echo $course['teacher_code']; ?>)
</td></tr>
<?php endif; ?>
<tr><th class="vc100 bg-blue2 white" >Course</th><td>
	<?php echo $course['name']; echo ' #'.$course['course_id']; echo ' ('.$course['code'].')'; ?>

<span class="b" > | Status</span>	
Q<?php echo $qtr.' - '; echo ($is_locked)? 'Closed':'Open'; ?>	
	</td>
</tr>
</table><br />

<div class="clear" >	<!-- grades -->

<div id="status" ></div>

<table class='gis-table-bordered table-fx'>
<tr class="" >
<th>#</th>
<th class="inrank" >In<br />Rank</th>
<th class="" >ID</th>
<th class="" >ID No.</th>
<th class="" >Student</th>
<?php for($j=1;$j<=$qtr;$j++): ?>
	<th class="center" >Q<?php echo $j; ?>
		<?php if($j==$qtr): ?>
			<br /><input class="vc50 center" type="text" id="igrade" placeholder="All" />
			<br /><button class="vc50" onclick="populateColumn('grade');return false;">All</button>					
		<?php endif; ?>
	</th>
<?php endfor; ?>
<?php if(!$is_locked): ?><th>Save</th><?php endif; ?>
</tr>

<form id="form" method='post' > <!-- for batch edit/delete -->
<?php $i=0; ?>
<?php foreach($grades as $row): ?>

<input type="hidden" name="grades[<?php echo $i; ?>][scid]" value="<?php echo $row['scid']; ?>" />


<tr class="<?php echo (even($i))? 'even':'odd'?>">
<!---------------------------------------------------------------------------------->

<td><?php echo $i+1; ?></td>
<td class="inrank" >
	<?php echo $row['in_rank']; ?>
	<br /><a href="<?php echo URL.'grades/inRank/'.$course_id.DS.$row['scid']; ?>" >Edit</a>
</td>
<td><?php echo $row['scid']; ?></td>
<td><?php echo $row['student_code']; ?></td>
<td class="left" id="<?php echo 'GID: '.$row['gid'].' | SCID: '.$row['scid'].' : '.$row['student_code']; ?>" 
	ondblclick="alert(this.id);" >
<?php echo $row['student']; ?>
</td>


<!---------------------------------------------------------------------------------->

	<?php for($j=1;$j<=$qtr;$j++): ?>
	<?php 
		$grade = $row['q'.$j];
	?>
	<td>
	<?php if($qtr!=$j): ?>
		<?php echo number_format($grade,$decigrades); ?>	

	<?php else: ?>	
		<input id="grades<?php echo $i; ?>" class="vc50 center grade" name="grades[<?php echo $i; ?>][grade]" 
			value="<?php $grade = number_format($grade,$decigrades); echo $grade; ?>" tabindex="1" />
		<br />
	<?php endif; ?>
	</td>
	<?php endfor; ?>


<?php if(!$is_locked): ?>
	<td><button onclick="xsaveRow(<?php echo $i; ?>);return false;" >Save</button></td>
	<input type="hidden" name="grades[<?php echo $i; ?>][student]" value="<?php echo $row['student']; ?>" >
<?php endif; ?>
	
	<input type="hidden"  name="grades[<?php echo $i; ?>][gid]" value="<?php echo $row['gid']; ?>"  />


</tr>
<?php $i++; ?>
<?php endforeach; ?>
</table>
</div>	<!-- grades -->

<?php if(!$is_locked): ?>
<p>
	<input type="submit" name="submit" value="Save"  />	
	<input type='submit' name='submit' value="Finalize" onclick="return confirm('Sure?');" />	
</p>
<?php endif; ?>

<?php if(($is_locked) && ($_SESSION['srid']==RMIS)): ?>
	<p><input type="submit" name="submit" value="Save On"  /></p>	
<?php endif; ?>

</form> <!-- for batch -->



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
var getdg = "<?php echo ($dgonly)? '&dgonly':NULL; ?>";
var min=<?php echo isset($_GET['min'])? $_GET['min']:70; ?>;
var max=<?php echo isset($_GET['max'])? $_GET['max']:99; ?>;
var count=<?php echo isset($num_students)? $num_students:10; ?>;
var qx="<?php echo $qx; ?>";

$(function(){	
	$('#hdpdiv').hide();
	hd();		
	shd();		
	$('.inrank').hide();
	itago('clipboard');
	itago('inrank');
	nextViaEnter();		
	selectFocused();
	
	// alert('min'+min+'max'+max+'count'+count);
	
});
	

function randomize(aim){ for(var i=0;i<count;i++){ var x=getRandomInt(min,max);document.getElementById(aim+i).value=x; }	}	/* fxn */
function getRandomInt(min,max) { return Math.floor(Math.random()*(max-min+1))+min; }
	
	
function redirectCourse(){			
	var vurl 	= gurl + '/averages/course/'+crsid+'/'+sy+'/'+qtr;		
	window.location = vurl;

}

function customRedirect(crstype){
	var vurl 	= gurl + '/teachers/grades/'+crsid+'/'+sy+'/'+qtr+'&crstype='+crstype;		
	// alert(vurl);
	window.location = vurl;

}	/* fxn */

function xsaveRow(i){
	var vurl=gurl+"/ajax/xgrades.php";
	var task="saveGrade";
	var student=$('input[name="grades['+i+'][student]"').val();
	var grade=$('input[name="grades['+i+'][grade]"').val();
	var gid=$('input[name="grades['+i+'][gid]"').val();	
	var pdata="task="+task+"&"+qx+"="+grade+"&id="+gid+"&sy="+sy;

	$.ajax({
		url:vurl,type:"POST",data:pdata,
		success:(function(){ $('#status').html(student+" grade changed to "+grade+" - Success. "); })
		
	})

	
	
}	/* fxn */
		
	
</script>
