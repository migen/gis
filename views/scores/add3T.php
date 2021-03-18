

<h5>
	Add Activity Scores |
	<?php 	$controller = 'teachers'; $this->shovel('homelinks',$controller); ?>	
	| <a href="<?php echo URL.'teachers/scores/'.$course_id.DS.$sy.DS.$qtr; ?>">Scores</a>
	| <span class="blue u" onclick="ilabas('clipboard');" >Smartboard</span>
<?php if(isset($_GET['sort'])): ?>	
	| <a href='<?php echo URL."scores/add/$course_id/$qtr"; ?>' >Alphabetical</a> 		
<?php else: ?>
	| <a href='<?php echo URL."scores/add/$course_id/$qtr?sort=c.position"; ?>' >Position</a> 		
<?php endif; ?>

</h5>


<?php 



// pr($data);

$is_ps		= $course['is_ps'];
$is_k12	= $course['is_k12'];
$is_k12 	= ($is_k12 && !$is_ps);

$kpup	= $course['is_kpup'];



// echo ($is_k12)? 'yes bedk12' : 'not bedk12';


?>


<form id="form" method='post'>

<!-- activity -->
<table class='gis-table-bordered table-fx'>

<tr>
	<th class='bg-blue2'>Class</th>
	<td><?php echo $course['level'].' - '.$course['section']; ?></td>
</tr>
<tr>
	<th class='bg-blue2'>Subject</th>
	<td><?php echo $course['subject']; ?></td>
</tr>


<tr>
	<th class='bg-blue2'>Date (YYYY-MM-DD)</th>
	<td><input type='date' class='juice pdl05' name='data[Activity][date]' style='width:200px;' value="<?php echo date('Y-m-d'); ?>" ></td>
</tr>

<tr>	
	<th class='bg-blue2'>Criteria</th>
	<td>
		<select type='text' id="criteria" name='data[Activity][component_id]' class='vc200' onchange='prefixActivity("Qz");return false;' >
			<option value="0" >Choose Criteria</option>
			<?php	foreach($data['selects']['criteria'] as $sel): ?><option value="<?php echo $sel['component_id']; ?>"  <?php echo ($sel['criteria_id'] == $data['criteria_id'])? 'selected' : null; ?> ><?php echo $sel['criteria']; ?></option><?php	endforeach; ?>				
		</select>		
	</td>
</tr>

<?php if($kpup): ?>
	<tr>	
		<th class='bg-blue2'>Subcriteria</th>
		<td>
			<select type='text' id="subcriteria" name='data[Activity][subcomponent_id]' class='vc200' >
				<option value="0" >Choose Subcriteria</option>
				<?php	foreach($selects['subcriteria'] as $sel): ?><option class="<?php echo ($sel['is_raw']!=1)? 'red':NULL; ?>" value="<?php echo $sel['subcriteria_id']; ?>"  <?php echo ($sel['subcriteria_id'] == $data['subcriteria_id'])? 'selected' : null; ?>  ><?php echo $sel['subcriteria']; echo ($sel['is_raw']!=1)? ' - Pct':NULL; ?></option><?php	endforeach; ?>								
			</select>		
		</td>
	</tr>
<?php endif; ?>

	<tr>
		<th class='bg-blue2'>Activity</th>
		<td>
				<input id='activity' type='text' name='data[Activity][name]' class="vc200 pdl05" maxlength="6" >
				
		</td>
	</tr>

<tr>
	<th class='bg-blue2'>Max Score</th>	
	<td>
		<input onchange="setMax(this.value);return false;"  id="max" type="text" name="data[Activity][max_score]" maxlength='3' 
			class="center vc50" placeholder="max" value="100" />
		<input class="center vc50" type="text" id="iscore" placeholder="All" />
		<button onclick="populateColumn('score');return false;">All</button>
		
	</td>
</tr>


</table>


<!-- scores -->

<br />
<div class="half" >
<table class='gis-table-bordered table-fx'>

<tr class='bg-blue1 white bold'>
	<td>#</td>
	<td>ID Number</td>
	<td>Student</td>
	<td>Score</td>
</tr>

<?php $student = $data['students']; ?>
<?php $num_students = count($data['students']); ?>
<?php for($i=0;$i<$num_students;$i++): ?>
<tr>
	<td><?php echo $i+1;  ?></td>
	<td><?php echo $student[$i]['student_code'];  ?></td>
	<td><?php echo $student[$i]['student'];  ?></td>
	<td><input id="aim<?php echo $i; ?>" onchange="validateScore(this.value);" class="score center" type='text' 
		name='data[Score][<?php echo $i; ?>][score]' size='2' ></td>
	
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
	<input onclick="failRatio();return false;" type='submit' name='submit' value='Submit'> &nbsp; 
	<button><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="no-underline" >Cancel</a></button>
</p>

</form> <!-- addScoresForm -->

</div>

<?php $this->shovel('clipboard'); ?>

<!--------------------------------------------------------------------------------------------------------------------------->


<script>


var gurl 	= 'http://<?php echo HOST.'/'.DOMAIN; ?>';
var sfratio = '<?php echo $_SESSION['settings']['fail_ratio']; ?>';

var pass 	= 0;
var fratio 	= 0;	
var num 	= $('.score').size();
var max;

$(function(){
	nextViaEnter();		
	selectFocused();
	itago('clipboard');
	

})



function failRatio(){
	var passed=0;
	var failed=0;
	$('.score').each(function(){
		if(this.value < pass) failed+=1;		
	});
	
	passed = num - failed;
	fratio = failed / num * 100;
		
	// 1 - alert('fratio: '+fratio+' vs sfratio: '+sfratio);
	if(fratio>sfratio){
		alert('Too many failures. Pass: '+passed+',Fail: '+failed+',Total: '+num); return false;
	}
	
	// 2 - criteria and subcriteria not empty
	var cri 	= $('#criteria').val();
	var subcri 	= $('#subcriteria').val();
	if((cri==0) || (subcri==0)){
		alert('Criteria or subcriteria cannot be empty!'); return false;
	} 
		
	$('#form').submit();	
	
}

function setMax(maxVal){
	pass = maxVal/2;
	max  = parseInt(maxVal); 
}

// if(Math.floor(id) == id && $.isNumeric(id)) 
function validateScore(val){
	if(!$.isNumeric(val) || val>max){
		alert('Invalid score!');
	}

}

</script>



