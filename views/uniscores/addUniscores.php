<h5>
	Add Scores - <?php echo $course['name']; ?> | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'uniscores/crs/'.$crs; ?>" >Scores</a>
	


</h5>


<?php 
// $incs="randomizer_uniscores.php";include_once($incs);

$size=isset($size)? $size:1;
$min=0;



?>


<form id="form" method='post'>
<table class='gis-table-bordered table-fx'>
<tr>	
	<th class='bg-blue2'>Criteria</th>
	<td>
		<select type='text' id="criteria" name="activity[component_id]" class='vc200'  >
			<option value="0" >Choose Criteria</option>
				<?php foreach($criteria as $sel): ?>
				<option value="<?php echo $sel['component_id']; ?>" <?php echo ($sel['id'])==$cri? 'selected':NULL; ?> >
					<?php echo $sel['criteria'].' ('.$sel['weight'].'%)';   ?></option>
				<?php endforeach; ?>				
		</select>		
	</td>
	<td>
		<span class="b" >Date</span>
		<input type='date' class="juice pdl05" name="activity[date]" style='width:150px;' value="<?php echo date('Y-m-d'); ?>" >			
	</td>
</tr>

<tr>
	<th class='bg-blue2'>Activity</th>
	<td><input id='activity' type='text' name="activity[name]" style='width:150px;' maxlength=6 tabIndex=2 ></td>
	<td>
		<span class="b" >Max<span class="white" >i</span></span>	
		<input onchange="setMax(this.value);return false;"  id="max" type="text" name="activity[max_score]" maxlength='3' 
				tabIndex=2 class="vc50 pdl05" placeholder="max" value="<?php echo isset($_GET['max'])? $_GET['max']:100; ?>" />		
	
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
		<br /><input class="vc30 center" type="text" id="iscore" placeholder="All" tabIndex=2 />
		<button onclick="populateColumn('score');return false;">All</button>							
	</td>
	<th colspan=2></th>
</tr>

<?php // $student = $data['students']; ?>
<?php // $num_students = count($data['students']); ?>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1;  ?></td>
	<td><?php echo $rows[$i]['studcode'];  ?></td>
	<td><?php echo $rows[$i]['student'];  ?></td>
	<td><input id="score-<?php echo $i; ?>" onchange="validateScore(this.value);" class="score center" tabIndex=2
		type='text' name='scores[<?php echo $i; ?>][score]' size='2' style="font-size:<?php echo $size; ?>em;"   ></td>
	
	<!-- if absent,0 score not included in the grade TNV computation -->
	<?php if($_SESSION['settings']['show_valid_radio']==1): ?>
		<td><input type='radio' name="scores[<?php echo $i; ?>][is_valid]" value='1' checked tabIndex=4 >Present</td>
		<td><input type='radio' name="scores[<?php echo $i; ?>][is_valid]" value='0' tabIndex=4  >Excused</td>		
	<?php endif; ?>
	
		<input type='hidden' name="scores[<?php echo $i; ?>][scid]" value="<?php echo $rows[$i]['scid']; ?>" >
</tr>
<?php endfor; ?>

</table>

<p><input onclick="failRatio();return false;" type='submit' name='submit' value='Submit'> &nbsp; </p>

</form> <!-- addScoresForm -->

</div> 	<!-- scores -->


<!----->
<div class="smartboard " style="width:200px;float:left;"  >
<p>
<select id="classbox" >
	<option value="score-" >Score</option>
</select>
</p>
<?php $d['width']=10; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>



<script>


var gurl = 'http://<?php echo HOST.'/'.DOMAIN; ?>';
var sfratio = '<?php echo $_SESSION['settings']['fail_ratio']; ?>';
var pass 	= 0;
var fratio 	= 0;	
var num 	= $('.score').size();
var min=<?php echo isset($_GET['min'])? $_GET['min']:$min; ?>;
var max=<?php echo isset($_GET['max'])? $_GET['max']:100; ?>;
var count=<?php echo $count; ?>;
var crs="<?php echo $crs; ?>";


$(function(){
	hd();
	shd();
	itago('smartboard');
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

function setMax(maxVal){
	pass = maxVal/2;
	max  = parseInt(maxVal); 
	
}

function validateScore(val){
	if(!$.isNumeric(val) || val>max){
		alert('Invalid score!');		
	}

}


function gotoUrl(){
	var min=$('#min').val();var max=$('#max').val();
	var url=gurl+"/scores/add/"+crs+"/"+qtr+"?min="+min+"&max="+max;
	window.location=url;
}	/* fxn */



</script>
