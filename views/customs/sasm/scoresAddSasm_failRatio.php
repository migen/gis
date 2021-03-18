
<?php  


	$cutoff_array = array(
		1 => 30,
		2 => 50,
		3 => 50,
		4 => 60,
	);
	
	

	$pct = $cutoff_array[$qtr];

 ?>



<form method="GET" >

<h5>
	SASM Add Scores (Q<?php echo $qtr; ?>, Cutoff Pct: <?php echo $pct.'%'; ?>)
	<?php 	$controller = 'teachers'; $this->shovel('homelinks'); ?>	
<?php if(isset($_GET['sort'])): ?>	
	| <a href='<?php echo URL."scores/add/$course_id/$qtr"; ?>' >Alphabetical</a> 		
<?php else: ?>
	| <a href='<?php echo URL."scores/add/$course_id/$qtr?sort=c.position"; ?>' >Position</a> 		
<?php endif; ?>
	| <span class="u" onclick="traceshd();" >SHD</span>
	| <a href="<?php echo URL.'teachers/scores/'.$course_id.DS.$sy.DS.$qtr; ?>">Scores</a>
	| <a href="<?php echo URL.'teachers/grades/'.$course_id.DS.$sy.DS.$qtr; ?>">Grades</a>
	| <span class="blue u" onclick="ilabas('clipboard');" >Smartboard</span>

   Size <input class="center vc50" id="size" name="size" value="<?php echo (isset($_GET['size']))? $_GET['size']:1; ?>"  />
<input type="submit" name="submit" value="Go" >	
	
</h5>
</form>		

<?php 
	$srid=$_SESSION['srid'];
	$min=isset($_GET['min'])? $_GET['min']:70;
	$max=isset($_GET['max'])? $_GET['max']:100;

?>

<h4 class="<?php echo ($srid!=RMIS)? 'shd':NULL; ?>" >
<table class="gis-table-bordered" >
<tr>
<td>Min<input id="min" class="vc50" value="<?php echo (isset($_GET['min']))? $_GET['min']:$min; ?>" ></td>
<td>Max<input id="max" class="vc50" value="<?php echo (isset($_GET['max']))? $_GET['max']:100; ?>" ></td>
<td><span class="u" onclick="randomize('aim');" >Randomize</span></td>
<td><span class="u" onclick="gotoUrl();" >RandomizeUrl</span></td>
</tr>
</table>
</h4>
<?php // endif; ?>



<?php 

// pr($data);


$size=isset($_GET['size'])? $_GET['size']:1;

$is_ps	= $course['is_ps'];
$is_k12	= $course['is_k12'];
$is_k12 	= ($is_k12 && !$is_ps);


// pr($selects['criteria']);

// pr($course);

?>



<form id="form" method='post'>

<!-- activity -->
<table class='gis-table-bordered table-fx'>

<tr>
	<th class='bg-blue2'>Course</th>
	<td colspan=2><?php echo $course['level'].' - '.$course['name']; ?></td>
</tr>

<tr>	
	<th class='bg-blue2'>Criteria</th>
	<td>
		<select type='text' id="criteria" name='data[Activity][component_id]' class='vc200'  >
			<option value="0" >Choose Criteria</op1tion>
				<?php foreach($selects['criteria'] as $sel): ?>
				<?php 
					if($sel['is_raw']==0){ $prtcode='Pct'; }
					else if($sel['is_raw']==2){ $prtcode='Trns'; }
					else { $prtcode='Raw'; }
				?>
				<option class="<?php echo ($sel['is_raw']!=1)? 'red':NULL; ?>" 
					value="<?php echo $sel['component_id']; ?>"  <?php echo ($sel['criteria_id']==$data['criteria_id'])? 'selected' : null; ?> >
				<?php echo $sel['criteria'].' ('.$sel['weight'].'%)';  echo " - $prtcode "; ?></option>
				<?php endforeach; ?>				
		</select>		
	</td>
	<td>
		<span class="b" >Date</span>
		<input type='date' class="juice pdl05" name='data[Activity][date]' style='width:150px;' value="<?php echo date('Y-m-d'); ?>" >			
	</td>
</tr>

<tr>
	<th class='bg-blue2'>Activity</th>
	<td><input id='activity' type='text' name='data[Activity][name]' style='width:150px;' maxlength="6" value="" ></td>
	<td>
		<span class="b" >Max<span class="white" >i</span></span>	
		<input onchange="setMax(this.value);return false;"  id="max_score" type="text" name="data[Activity][max_score]" maxlength='3' 
				class="vc50 pdl05" placeholder="max" value="<?php echo isset($_GET['max'])? $_GET['max']:100; ?>" />		
	
	</td>
</tr>




</table>



<!-- scores -->

<br />
<div class="half" >


<table class='gis-table-bordered table-fx' style="font-size:<?php echo $size; ?>em;">

<tr class='bg-blue2 bold'>
	<td>#</td>
	<td>ID Number</td>
	<td>Student</td>
	<td>Score		
		<br /><input class="vc30 center" type="text" id="iscore" placeholder="All" />
		<button onclick="populateColumn('score');return false;">All</button>							
	</td>
	<th colspan=2></th>
</tr>

<?php $student = $data['students']; ?>
<?php $num_students = count($data['students']); ?>
<?php for($i=0;$i<$num_students;$i++): ?>
<tr>
	<td><?php echo $i+1;  ?></td>
	<td><?php echo $student[$i]['student_code'];  ?></td>
	<td><?php echo $student[$i]['student'];  ?></td>
	<td><input id="aim<?php echo $i; ?>" onchange="validateScore(this.value);" class="score center" value=0
		type='text' name='data[Score][<?php echo $i; ?>][score]' size='2' style="font-size:<?php echo $size; ?>em;"  ></td>
	
	<!-- if absent,0 score not included in the grade TNV computation -->
	<?php if($_SESSION['settings']['show_valid_radio'] == 1): ?>
		<td><input type='radio' name='data[Score][<?php echo $i; ?>][is_valid]' value='1' checked >Present</td>
		<td><input type='radio' name='data[Score][<?php echo $i; ?>][is_valid]' value='0'  		  >Excused</td>		
	<?php endif; ?>
	
		<input type='hidden' name='data[Score][<?php echo $i; ?>][scid]' value="<?php echo $student[$i]['scid']; ?>" >
</tr>
<?php endfor; ?>

</table>




<p>
	<input onclick="failRatio(<?php echo $pct; ?>);" type='submit' name='submit' value='Submit'> &nbsp; 
	<button><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="no-underline" >Cancel</a></button>
</p>

</form> <!-- addScoresForm -->

</div> 	<!-- scores -->


<!----->
<?php $this->shovel('clipboard'); ?>




<script>


var gurl = 'http://<?php echo HOST.'/'.DOMAIN; ?>';
var sfratio = '<?php echo $_SESSION['settings']['fail_ratio']; ?>';

var pass 	= 0;
var fratio 	= 0;	
var num 	= $('.score').size();

var min=<?php echo isset($_GET['min'])? $_GET['min']:$min; ?>;
var max=<?php echo isset($_GET['max'])? $_GET['max']:100; ?>;
var count=<?php echo $num_students; ?>;

var crs="<?php echo $course_id; ?>";
var qtr="<?php echo $qtr; ?>";


$(function(){
	hd();
	shd();
	itago('clipboard');
	nextViaEnter();		
	selectFocused();
	
})

function failRatio(){
	var passed=0;
	var failed=0;
	$('.score').each(function(){
		if(this.value < pass) failed+=1;		
	});
	passed = num - failed;
	fratio = failed / num * 100;

	if(fratio>sfratio){
		alert('Too many failures. Pass: '+passed+',Fail: '+failed+',Total: '+num); return false;
	}	
	// 2 - criteria and subcriteria not empty
	var cri 	= $('#criteria').val();
	if(cri==0){
		alert('Criteria cannot be empty!'); return false;
	} 

	$('#form').submit();	
	
}


function jsSubmit(pct){
	var max = $('#max_score').val();	
	var pass_score = parseInt(max)/2;	
	var cutoff_count = parseInt(count)*(parseInt(pct)/100);
	var val;
	var num_pass=0;
	var num_fail=0;
	
	
	// 1 - fail ratio
	$.each($('.score'),function(){
		val = $(this).val();
		if(parseInt(val) < pass_score){ num_fail++;
		} else { num_pass++; }
		
	})

	alert("count: "+cutoff_count);
	alert("num_fail: "+num_fail);

	
	if(num_fail > cutoff_count){
		alert("Too many failures.");
		return false;
	} else {		
		// 2 - criteria set
		var cri = $('#criteria').val();
		if(cri==0){
			alert('Criteria cannot be empty!'); return false;
		} 
		return true;
		// $('#form').submit();			
		
	}


}	/* fxn */



function setMax(maxVal){
	pass = maxVal/2;
	max  = parseInt(maxVal); 
	
}

function validateScore(val){
	if(!$.isNumeric(val) || val>max){
		alert('Invalid score!');		
	}

}	/* fxn */


function gotoUrl(){
	var min=$('#min').val();var max=$('#max').val();
	var url=gurl+"/scores/add/"+crs+"/"+qtr+"?min="+min+"&max="+max;
	window.location=url;
}	/* fxn */





</script>



