<?php 

// pr($_SESSION['q']);

?>


<h5>
	Edit Student Grades |
	<a href="<?php echo URL; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?> |
	| <a href="<?php echo URL.'grades/scid/'.$scid.DS.$sy; ?>" >One-Grade</a> | 
<?php if(isset($_GET['all'])): ?>
	<a href='<?php echo URL."grades/student/$scid/$sy/$qtr"; ?>' >Acad</a>
<?php else: ?>
	<a href='<?php echo URL."grades/student/$scid/$sy/$qtr?all"; ?>' >All</a>
<?php endif; ?>

| <?php if(isset($_GET['rating'])): ?>
	<a href='<?php echo URL."grades/student/$scid/$sy/$qtr"; ?>' >Manual DG</a>
<?php else: ?>
	<a href='<?php echo URL."grades/student/$scid/$sy/$qtr?rating"; ?>' >Auto DG</a>
<?php endif; ?>

	| <a href='<?php echo URL."gtools/msg/$crid/$scid"; ?>' >MSG</a>

<?php 
	$d['sy']=$sy;$d['repage']="grades/student/$scid";
	$this->shovel('sy_selector',$d); 
?>	
	
	
</h5>

<?php if(isset($_GET['debug'])){ pr($q); } ?>


<?php 

// pr($grades[16]);


$decifg 	= $_SESSION['settings']['decifg'];
$decigrades = $_SESSION['settings']['decigrades'];
$isk12 = $student['is_k12'];	// from levels table to show DG
$this->shovel('ratings',$ratings);


?>

<?php $readonly = ($home=='teachers')? 'readonly':NULL; ?>


<h4>Details</h4>
<table class='gis-table-bordered table-fx'>

<tr><th class='bg-blue2'>CRID</th><td><?php echo $crid; ?></td></tr>
<tr><th class='bg-blue2'>Classroom</th><td><?php echo $cr['classroom']; ?></td></tr>
<tr><th class='bg-blue2'>SCID</th><td><?php echo $scid; ?></td></tr>
<tr><th class='bg-blue2'>ID</th><td><?php echo $student['student_code']; ?></td></tr>
<tr><th class='bg-blue2'>Student</th><td><?php echo $student['student']; ?></td></tr>
<tr><th class='bg-blue2'>Status</th><td><?php echo 'Q'.$qtr.' - '; echo ($is_locked)? 'Closed' : 'Open' ; ?></td></tr>

</table>


<h4> Please manually update parents / children if you change the other. <br />
<span class="brown" >* Adjust "credit" too if grades are changed accordingly.</span>
</h4>




<?php if($num_grades>0): ?>

<form method="POST" >

<input type="hidden" name="isk12" value="<?php echo $isk12; ?>"  />

<table class="gis-table-bordered table-fx" >
	<tr class="headrow" >
		<th>#</th>	
		<th class="hd" >GID</th>
		<th class="hd" >CrsID</th>
		<th>Ctype</th>
		<th>Course</th>
		<th>SubID</th>
		<th>Parent</th>
		<th>Wt</th>
		<?php for($i=1;$i<5;$i++): ?>
			<th class="center <?php echo ($i<=$qtr)? 'bg-blue':NULL; ?> " >Q<?php echo $i; ?><br />Credit</th>		
		<?php endfor; ?>
		<th class="center" >FG</th>
		<th class="center" >FG<br />Sem2</th>
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
	<td class="hd" ><?php echo $grades[$i]['ctype']; ?></td>
	<td><?php echo ($grades[$i]['ctype']==CTYPETRAIT)? '#'.$grades[$i]['criteria_id'].' - '.$grades[$i]['criteria']:$grades[$i]['subject_code']; ?>
		<?php if($grades[$i]['ctype']!=CTYPETRAIT): ?>
		<br /><a href="<?php echo URL.'grades/edit/'.$grades[$i]['course_id'].DS.$scid.DS.$grades[$i]['gid']; ?>" >
			Edit</a>		
		<?php endif; ?>
	</td>
	<td><?php echo $grades[$i]['subject_id']; ?></td>
	<td><?php echo $grades[$i]['supsubject_id']; ?></td>
	<td><?php echo $grades[$i]['course_weight']; ?></td>
	<td class="<?php echo (1<=$qtr)? 'bg-blue':NULL; ?>"  >
		<input id="q1-<?php echo $i; ?>" onchange="tallyFg(<?php echo $i; ?>);return false;" class="vc50 center" 
			name="grades[<?php echo $i; ?>][q1]" value="<?php echo number_format($grades[$i]['q1'],$decigrades); ?>"  
			<?php  echo $readonly; ?> tabindex="2" /><br />
		<input id="bonus1-<?php echo $i; ?>" class="vc50 center" 
			name="grades[<?php echo $i; ?>][bonus_q1]" value="<?php echo number_format($grades[$i]['bonus_q1'],$decigrades); ?>"  <?php  echo $readonly; ?> tabindex="3" />					
	</td>
	<td class="<?php echo (2<=$qtr)? 'bg-blue':NULL; ?>" >
		<input id="q2-<?php echo $i; ?>" onchange="tallyFg(<?php echo $i; ?>);return false;" class="vc50 center"  
		name="grades[<?php echo $i; ?>][q2]" value="<?php echo number_format($grades[$i]['q2'],$decigrades); ?>"  <?php  echo $readonly; ?> tabindex="4" /><br />
		<input id="bonus2-<?php echo $i; ?>" class="vc50 center" 
			name="grades[<?php echo $i; ?>][bonus_q2]" value="<?php echo number_format($grades[$i]['bonus_q2'],$decigrades); ?>"  <?php  echo $readonly; ?> tabindex="3" />
		<input type="hidden" id="orig2-<?php echo $i; ?>" value="<?php echo number_format($grades[$i]['q2'],2); ?>" />
			
	</td>
	<td class="<?php echo (3<=$qtr)? 'bg-blue':NULL; ?>" >
		<input id="q3-<?php echo $i; ?>" onchange="tallyFg(<?php echo $i; ?>);return false;" class="vc50 center" 
		name="grades[<?php echo $i; ?>][q3]" value="<?php echo number_format($grades[$i]['q3'],$decigrades); ?>"  
		<?php  echo $readonly; ?> tabindex="6" /><br />
		<input id="bonus3-<?php echo $i; ?>" class="vc50 center" 
			name="grades[<?php echo $i; ?>][bonus_q3]" value="<?php echo number_format($grades[$i]['bonus_q3'],$decigrades); ?>"  <?php  echo $readonly; ?> tabindex="3" />							
	</td>
	<td class="<?php echo (4<=$qtr)? 'bg-blue':NULL; ?>" >
		<input id="q4-<?php echo $i; ?>" onchange="tallyFg(<?php echo $i; ?>);return false;" class="vc50 center"  
		name="grades[<?php echo $i; ?>][q4]" value="<?php echo number_format($grades[$i]['q4'],$decigrades); ?>"  <?php  echo $readonly; ?> tabindex="8" /><br />
		<input id="bonus4-<?php echo $i; ?>" class="vc50 center" 
			name="grades[<?php echo $i; ?>][bonus_q4]" value="<?php echo number_format($grades[$i]['bonus_q4'],$decigrades); ?>"  <?php  echo $readonly; ?> tabindex="4" />
	</td>
	<td><input id="fg-<?php echo $i; ?>" class="vc50 center" type="text" name="grades[<?php echo $i; ?>][q5]" 
		value="<?php echo $grades[$i]['q5']; ?>"  <?php  echo $readonly; ?> tabindex="10" /></td>

	<td><input id="fg2-<?php echo $i; ?>" class="vc50 center" type="text" name="grades[<?php echo $i; ?>][q6]" 
		value="<?php echo $grades[$i]['q6']; ?>"  <?php  echo $readonly; ?> tabindex="12" /></td>
		
	<?php $rg1 = number_format($grades[$i]['q1'],$decigrades); ?>
	<?php $rg2 = number_format($grades[$i]['q2'],$decigrades); ?>
	<?php $rg3 = number_format($grades[$i]['q3'],$decigrades); ?>
	<?php $rg4 = number_format($grades[$i]['q4'],$decigrades); ?>
	<?php $rg5 = number_format($grades[$i]['q5'],$decigrades); ?>
	<?php $rg6 = number_format($grades[$i]['q6'],$decigrades); ?>

<?php if(isset($_GET['rating'])): ?>	
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
<?php else: ?>		
	<td><input class="vc50 center" type="text" name="grades[<?php echo $i; ?>][dg1]" 
		value="<?php echo $grades[$i]['dg1']; ?>"  <?php  echo $readonly; ?> tabindex="14" /></td>
	<td><input class="vc50 center" type="text" name="grades[<?php echo $i; ?>][dg2]" 
		value="<?php echo $grades[$i]['dg2']; ?>"  <?php  echo $readonly; ?> tabindex="16" /></td>
	<td><input class="vc50 center" type="text" name="grades[<?php echo $i; ?>][dg3]" 
		value="<?php echo $grades[$i]['dg3']; ?>" <?php  echo $readonly; ?> tabindex="18" /></td>
	<td><input class="vc50 center" type="text" name="grades[<?php echo $i; ?>][dg4]" 
		value="<?php echo $grades[$i]['dg4']; ?>" <?php  echo $readonly; ?> tabindex="20" /></td>
	<td><input class="vc50 center" type="text" name="grades[<?php echo $i; ?>][dg5]" 
		value="<?php echo $grades[$i]['dg5']; ?>"  <?php  echo $readonly; ?> tabindex="22" /></td>
	<td><input class="vc50 center" type="text" name="grades[<?php echo $i; ?>][dg6]" 
		value="<?php echo $grades[$i]['dg6']; ?>" <?php  echo $readonly; ?> tabindex="24" /></td>		
<?php endif; ?>		
	<td class="vc150" ><?php echo $grades[$i]['label']; ?></td>
	
	<td><a id="btn<?php echo $i; ?>" class="u" onclick="saveGrade(<?php echo $i; ?>);" >Save</a></td>
		
	
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


<!-------------------------------------------------------------------->

<script>

var gurl = "http://<?php echo GURL; ?>";
var qtr = "<?php echo $qtr; ?>";
var rcardgdeci = "<?php echo $decigrades; ?>";
var fgdeci = "<?php echo $decifg; ?>";
var sy   = "<?php echo $sy; ?>";

$(function(){
	// hd();
	nextViaEnter();
	selectFocused();

})


function tallyFg(x){
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
	var fg = total / qtr;	
	// var dv = parseFloat($('#orig2-'+x).val())-parseFloat($('#q2-'+x).val());
	// var bq2=parseFloat($('#bonus2-'+x).val())-parseFloat(dv);
	// $('#bonus2-'+x).val(bq2);
	
	$('#fg-'+x).val(fg.toFixed(fgdeci));	
}


function saveGrade(i){
	$('#btn'+i).hide();
	var id = $('input[name="grades['+i+'][gid]"]').val();
	var q1 = $('input[name="grades['+i+'][q1]"]').val();
	var q2 = $('input[name="grades['+i+'][q2]"]').val();	
	var q3 = $('input[name="grades['+i+'][q3]"]').val();
	var q4 = $('input[name="grades['+i+'][q4]"]').val();

	var bonus1 = $('input[name="grades['+i+'][bonus_q1]"]').val();
	var bonus2 = $('input[name="grades['+i+'][bonus_q2]"]').val();
	var bonus3 = $('input[name="grades['+i+'][bonus_q3]"]').val();
	var bonus4 = $('input[name="grades['+i+'][bonus_q4]"]').val();
		
	var q5 = $('input[name="grades['+i+'][q5]"]').val();
	var q6 = $('input[name="grades['+i+'][q6]"]').val();
	
	var dg1 = $('input[name="grades['+i+'][dg1]"]').val();
	var dg2 = $('input[name="grades['+i+'][dg2]"]').val();
	var dg3 = $('input[name="grades['+i+'][dg3]"]').val();
	var dg4 = $('input[name="grades['+i+'][dg4]"]').val();
	var dg5 = $('input[name="grades['+i+'][dg5]"]').val();
	var dg6 = $('input[name="grades['+i+'][dg6]"]').val();
	
	var vurl 	= gurl + '/ajax/xgrades.php';	
	var task	= "saveGrade";	
	var pdata = "task="+task+"&id="+id+"&q1="+q1+"&q2="+q2+"&q3="+q3+"&q4="+q4+"&q5="+q5+"&q6="+q6;
	pdata += "&bonus_q1="+bonus1+"&bonus_q2="+bonus2+"&bonus_q3="+bonus3+"&bonus_q4="+bonus4;
	pdata += "&dg1="+dg1+"&dg2="+dg2+"&dg3="+dg3+"&dg4="+dg4+"&dg5="+dg5+"&dg6="+dg6+"&sy="+sy;
	// alert(pdata);

	$.ajax({ type: 'POST',url: vurl,data: pdata,success:function(){} });				

	
	
}

</script>
