

<h5>
	Add Club Scores |
	<?php 	$this->shovel('homelinks','Teachers'); ?>		
	| <span class="blue u" onclick="ilabas('clipboard');" >Smartboard</span>

	
</h5>




<form id="form" method='post'>

<table class='gis-table-bordered table-fx'>

<tr><th class='bg-blue2'>Club</th><td><?php echo $club['name']; ?></td></tr>


<tr>
	<th class='bg-blue2'>Date (YYYY-MM-DD)</th>
	<td><input type='date' class='juice pdl05' name='activity[date]' style='width:200px;' 
		value="<?php echo date('Y-m-d'); ?>" ></td>
</tr>

<tr>	
	<th class='bg-blue2'>Criteria</th>
	<td>
		<select type='text' id="criteria" name='activity[criteria_id]' class='vc200'  >
			<option value="0" >Choose Criteria</option>
			<?php foreach($criteria as $sel): ?>
				<option value="<?php echo $sel['criteria_id']; ?>" >
				<?php echo $sel['criteria'].' - '.$sel['weight'].'%';?></option>
			<?php endforeach; ?>				
		</select>		
	</td>
</tr>

<tr>
	<th class='bg-blue2'>Activity</th>
	<td>
			<input id='activity' type='text' name='activity[name]' style='width:200px;' maxlength="6" >
			
	</td>
</tr>


<tr>
	<th class='bg-blue2'>Max Score</th>	
	<td>
		<input onchange="setMax(this.value);return false;"  id="max" type="text" name="activity[max_score]" 
			maxlength='3' class="vc50" placeholder="max" value="100" />
		<input class="vc50" type="text" id="iscore" placeholder="All" />
		<button onclick="populateColumn('score');return false;">All</button>		
	</td>
</tr>


</table>



<!-- scores -->

<br />
<div class="half" >


<table class='gis-table-bordered table-fx' style="font-size:<?php echo $size; ?>em;">

<tr class='bg-blue1 white bold'>
	<td>#</td>
	<td>ID Number</td>
	<td>Student</td>
	<td>Score</td>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1;  ?></td>
	<td><?php echo $rows[$i]['student_code'];  ?></td>
	<td><?php echo $rows[$i]['student'];  ?></td>
	<td><input id="aim<?php echo $i; ?>" onchange="validateScore(this.value);" class="score" 
		type='text' name='posts[<?php echo $i; ?>][score]' size='2' style="font-size:<?php echo $size; ?>em;"  ></td>
		
	<input type='hidden' name='posts[<?php echo $i; ?>][scid]' value="<?php echo $rows[$i]['scid']; ?>" >
</tr>
<?php endfor; ?>

</table>

<p>
	<input onclick="failRatio();return false;" type='submit' name='submit' value='Submit'> &nbsp; 
	<button><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="no-underline" >Cancel</a></button>
</p>

</form> <!-- addScoresForm -->

</div> 	<!-- scores -->


<!----->
<?php $this->shovel('clipboard'); ?>




<script>


var gurl 	= 'http://<?php echo HOST.'/'.DOMAIN; ?>';
var sfratio = '<?php echo $_SESSION['settings']['fail_ratio']; ?>';

var pass 	= 0;
var fratio 	= 0;	
var num 	= $('.score').size();
var max;

$(function(){
	hd();
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

function setMax(maxVal){
	pass = maxVal/2;
	max  = parseInt(maxVal); 
	
}

function validateScore(val){
	if(!$.isNumeric(val) || val>max){
		alert('Invalid score!');
	}

}





</script>



