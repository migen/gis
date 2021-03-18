
<?php 
	$dbo=PDBO;
	$dbcontacts="{$dbo}.00_contacts";
	$decifg = $_SESSION['settings']['decifg'];
	$decigrades = $_SESSION['settings']['decigrades'];
	


?>

<p><table id="tbl-1" class="gis-table-bordered " >
	<tr>
		<th>ID / Name</th>
		<td>
		<input class="pdl05" id="part" autofocus placeholder="name" />
		<input type="submit" name="auto" value="Filter" onclick='getDataByTable(dbcontacts,30);return false;' />		
	</td></tr>
	
</table></p>

<div id="names" >names</div>



<?php if($scid): ?> 

<h5>
	Edit Student Grades SY<?php echo $sy; ?> (<?php echo $student['student'].' #'.$student['scid']; ?>) 
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'summarizers/student/'.$scid.DS.$sy.DS.$qtr; ?>" >Summarizer</a>
| <?php if(isset($_GET['all'])): ?>
	<a href='<?php echo URL."registrars/editStudentGrades/$scid/$sy/$qtr"; ?>' >Acad</a>
<?php else: ?>
	<a href='<?php echo URL."registrars/editStudentGrades/$scid/$sy/$qtr?all"; ?>' >All</a>
<?php endif; ?>
	| <a href='<?php echo URL."conducts/editOne/$scid/$sy/$qtr"; ?>' >Conduct</a>

</h5>


<?php 


$isk12 = $student['is_k12'];	// from levels table to show DG
$this->shovel('ratings',$ratings);


?>

<?php $readonly = ($home=='teachers')? 'readonly':NULL; ?>

<?php // pr($cr); 
// pr($cr);
$this->shovel('classroom_details',$cr);
?>


<h4> Please manually update parents / children if you change the other. </h4>

<!---------------------------------------------------------------->


<?php if($num_grades>0): ?>

<form method="POST" >

<input type="hidden" name="isk12" value="<?php echo $isk12; ?>"  />

<table class="gis-table-bordered table-fx" >
	<tr class="headrow" >
		<th>#</th>	
		<th class="hd" >GID</th>
		<th class="hd" >CrsID</th>
		<th>Course</th>
		<th>SubID</th>
		<th>Parent</th>
		<th>Wt</th>
		<?php for($i=1;$i<5;$i++): ?>
			<th class="center <?php echo ($i<=$qtr)? 'bg-blue':NULL; ?> " >Q<?php echo $i; ?>
				<br /><input class="vc50" id="iq<?php echo $i; ?>" />
				<br /><button onclick="populateColumn('q<?php echo $i; ?>');return false;" >All</button>
			</th>		
		<?php endfor; ?>
		<th class="center" >FG
			<br /><input class="vc50" id="iq5" />
			<br /><button onclick="populateColumn('q5');return false;" >All</button>		
		</th>
		<th class="center" >FG<br />Sem2
			<br /><input class="vc50" id="iq6" />
			<br /><button onclick="populateColumn('q6');return false;" >All</button>				
		</th>
		<th class="center" >DG1</th>
		<th class="center" >DG2</th>
		<th class="center" >DG3</th>
		<th class="center" >DG4</th>
		<th class="center" >DG</th>
		<th class="center" >DG<br />Sem2</th>
		<th class="center" >Label</th>
	</tr>
<?php for($i=0;$i<$num_grades;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="hd" ><a href='<?php echo URL."grades/delete/".$grades[$i]['gid'].DS.$sy; ?>' 
		onclick="return confirm('Are you sure?');" >Del</a></td>
	<td class="hd" ><?php echo $grades[$i]['course_id']; ?></td>
	<td><?php echo $grades[$i]['subject_code']; ?></td>
	<td><?php echo $grades[$i]['subject_id']; ?></td>
	<td><?php echo $grades[$i]['supsubject_id']; ?></td>
	<td><?php echo $grades[$i]['course_weight']; ?></td>
	<td class="<?php echo (1<=$qtr)? 'bg-blue':NULL; ?>"  ><input id="q1-<?php echo $i; ?>" onchange="tallyFg(<?php echo $i; ?>);return false;" class="vc50 center q1" type="text" name="grades[<?php echo $i; ?>][q1]" value="<?php echo number_format($grades[$i]['q1'],$decigrades); ?>"  <?php  echo $readonly; ?> tabindex="2" /></td>
	<td class="<?php echo (2<=$qtr)? 'bg-blue':NULL; ?>" ><input id="q2-<?php echo $i; ?>" onchange="tallyFg(<?php echo $i; ?>);return false;" class="vc50 center q2" type="text" name="grades[<?php echo $i; ?>][q2]" value="<?php echo number_format($grades[$i]['q2'],$decigrades); ?>"  <?php  echo $readonly; ?> tabindex="4" /></td>
	<td class="<?php echo (3<=$qtr)? 'bg-blue':NULL; ?>" ><input id="q3-<?php echo $i; ?>" onchange="tallyFg(<?php echo $i; ?>);return false;" class="vc50 center q3" type="text" name="grades[<?php echo $i; ?>][q3]" value="<?php echo number_format($grades[$i]['q3'],$decigrades); ?>"  <?php  echo $readonly; ?> tabindex="6" /></td>
	<td class="<?php echo (4<=$qtr)? 'bg-blue':NULL; ?>" ><input id="q4-<?php echo $i; ?>" onchange="tallyFg(<?php echo $i; ?>);return false;" class="vc50 center q4" type="text" name="grades[<?php echo $i; ?>][q4]" value="<?php echo number_format($grades[$i]['q4'],$decigrades); ?>"  <?php  echo $readonly; ?> tabindex="8" /></td>
	<td><input id="fg-<?php echo $i; ?>" class="vc50 center q5" type="text" name="grades[<?php echo $i; ?>][q5]" 
		value="<?php echo $grades[$i]['q5']; ?>"  <?php  echo $readonly; ?> tabindex="10" /></td>

	<td><input id="fg2-<?php echo $i; ?>" class="vc50 center q6" type="text" name="grades[<?php echo $i; ?>][q6]" 
		value="<?php echo $grades[$i]['q6']; ?>"  <?php  echo $readonly; ?> tabindex="12" /></td>
		
	<?php $rg1 = number_format($grades[$i]['q1'],$decigrades); ?>
	<?php $rg2 = number_format($grades[$i]['q2'],$decigrades); ?>
	<?php $rg3 = number_format($grades[$i]['q3'],$decigrades); ?>
	<?php $rg4 = number_format($grades[$i]['q4'],$decigrades); ?>
	<?php $rg5 = number_format($grades[$i]['q5'],$decigrades); ?>
	<?php $rg6 = number_format($grades[$i]['q6'],$decigrades); ?>
	<td><input class="vc50 center" type="text" name="grades[<?php echo $i; ?>][dg1]" 
		value="<?php echo rating($rg1,$ratings); ?>"  <?php  echo $readonly; ?> tabindex="14" /></td>
	<td><input class="vc50 center" type="text" name="grades[<?php echo $i; ?>][dg2]" 
		value="<?php echo rating($rg2,$ratings); ?>"  <?php  echo $readonly; ?> tabindex="16" /></td>
	<td><input class="vc50 center" type="text" name="grades[<?php echo $i; ?>][dg3]" 
		value="<?php echo rating($rg3,$ratings); ?>"  <?php  echo $readonly; ?> tabindex="18" /></td>
	<td><input class="vc50 center" type="text" name="grades[<?php echo $i; ?>][dg4]" 
		value="<?php echo rating($rg4,$ratings); ?>"  <?php  echo $readonly; ?> tabindex="20" /></td>
	<td><input class="vc50 center" type="text" name="grades[<?php echo $i; ?>][dg5]" 
		value="<?php echo rating($rg5,$ratings); ?>"  <?php  echo $readonly; ?> tabindex="22" /></td>
	<td><input class="vc50 center" type="text" name="grades[<?php echo $i; ?>][dg6]" 
		value="<?php echo rating($rg6,$ratings); ?>"  <?php  echo $readonly; ?> tabindex="24" /></td>
	<td class="vc150" ><?php echo $grades[$i]['label']; ?></td>
		
	
	<input type="hidden" name="grades[<?php echo $i; ?>][gid]" value="<?php echo $grades[$i]['gid']; ?>"   />

</tr>

<?php endfor; ?>


</table>
<?php if(!$readonly): ?>
	<p>
		<input type="submit" name="tally" value="Tally" />
		<input type="submit" name="edit" value="Update" />
	</p>
<?php endif; ?>
</form>

<?php endif; ?>	<!-- if with grades -->


<div class="ht100" >
<p class="brown b" >1) Tally - save numeric values <br />2) Update - save DG</p>
</div>

<!-------------------------------------------------------------------->

<?php if($num_grades != $num_courses): ?>	<!-- mismatch grades-courses -->

<h4>Courses</h4>

<form method="POST" >

<table class="gis-table-bordered table-fx" >
<tr class="headrow" >
	<th>#</th>
	<th class="" >CrsID</th>
	<th>Course</th>
	<th>Label</th>
	<th>Grade</th>
</tr>
<?php for($i=0;$i<$num_courses;$i++): ?>
	<?php if(!in_array($courses[$i]['course_id'],$gids)): ?> 
		<tr>
			<td><?php echo $i+1; ?></td>
			<td class="" ><?php echo $courses[$i]['course_id']; ?></td>
			<td><?php echo $courses[$i]['subject_code']; ?></td>
			<td><?php echo $courses[$i]['label']; ?></td>
			<td>	
				<input class="center vc50" type="text" name="grades[<?php echo $i; ?>][grade]" value="0" <?php  echo $readonly; ?> />
				<input type="hidden" name="grades[<?php echo $i; ?>][crsid]" value="<?php echo $courses[$i]['course_id']; ?>" />
			</td>			
		</tr>
	<?php endif; ?>
<?php endfor; ?>
  
</table>


<p><input type="submit" name="add" value="Add"  /></p>
</form>


<?php endif; ?>	<!-- mismatch grades-courses -->

<?php endif; ?>	<!-- student -->



<!-------------------------------------------------------------------->

<script>

var qtr = "<?php echo $qtr; ?>";
var rcardgdeci = "<?php echo $decigrades; ?>";
var fgdeci = "<?php echo $decifg; ?>";

const gurl = "http://<?php echo GURL; ?>";
const dbcontacts = "<?php echo $dbcontacts; ?>";


$(function(){
	nextViaEnter();
	selectFocused();
	$('html').live('click',function(){ $('#names').hide(); });
	$('#names').hide();

})

function axnFilter(id){
	var url=gurl+"/registrars/editStudentGrades/"+id;
	window.location=url;
}


function tallyFg(x){
	// var fg = ( parseFloat($('#q1-'+i).val()) + parseFloat($('#q2-'+i).val()) + parseFloat($('#q3-'+i).val()) + parseFloat($('#q4-'+i).val()) ) / qtr;
	var total = 0;
	for(i=1,total,qtr;i<=qtr;i++){
		if(rcardgdeci==0){
			var y = Math.round($('#q'+i+'-'+x).val());				
		} else if(rcardgdeci==1){
			var y = Math.round($('#q'+i+'-'+x).val()*10)/10;				
		} else if(rcardgdeci==2){
			var y = Math.round($('#q'+i+'-'+x).val()*100)/100;
		}
		
		total += y;
	}
	// alert(total);
	var fg = total / qtr;	
	// alert('rcardgdeci: '+rcardgdeci+','+fg.toFixed(fgdeci));
	$('#fg-'+x).val(fg.toFixed(fgdeci));	
}


</script>

<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>
