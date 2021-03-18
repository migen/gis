<h5>
	Batch Fees (Group Addons)
	| <a href="<?php echo URL.'mis'; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a href="<?php echo URL.'axis/batchFees'; ?>">Refresh</a> 
	

</h5>




<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr><th>Level</th><td>
<select id="level" name="fee[level]" class="vc300" >
	<option value="0" >Choose</option>
	<?php foreach($levels AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" 
			<?php echo (isset($get['level']) && ($get['level']==$sel['id']))? 'selected':NULL; ?>		
		><?php echo $sel['name'].' #'.$sel['id']; ?></option>
	<?php endforeach; ?>
</select>
</td>
<td><a class="u txt-blue" onclick="jsredirect('axis/batchFees?level='+$('#level').val());"  >Load Students</a></td>

</tr>

<tr><th>Classroom</th><td>
<select id="classroom" name="fee[classroom]" class="vc300" >
	<option value="0" >Choose</option>
	<?php foreach($classrooms AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" 
			<?php echo (isset($get['classroom']) && ($get['classroom']==$sel['id']))? 'selected':NULL; ?>
		><?php echo $sel['name'].' #'.$sel['id']; ?></option>
	<?php endforeach; ?>
</select>
</td>
<td><a class="u txt-blue" onclick="jsredirect('axis/batchFees?classroom='+$('#classroom').val());" >Load Students</a></td>
</tr>

<tr><th>Feetype</th><td>
<select name="fee[feetype_id]" class="vc300" onchange="xgetFeeAmount(this.value);" >
	<option value="0" >Choose</option>
	<?php foreach($feetypes AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name'].' #'.$sel['id']; ?></option>
	<?php endforeach; ?>
</select>
</td>
<td></td>
</tr>

<tr><th>Amount | Num (1) </th>
<td>
	<input class="pdl05 vc100" id="amount" name="fee[amount]" value="0.00" />
	<input class="vc20" id="num" name="fee[num]" value="1" />
</td>
<td></td>
</tr>

<tr><th>Due</th>
<td><input class="pdl05 vc150" id="due" name="fee[due]" value="<?php echo $today; ?>" /></td>

<td></td>

</tr>

</table>

<?php 
if($count>0){
	include_once('incs/batch_students.php');
} 


$incs = "incs/batchfees_notes.php";
include_once($incs);



?>
<p><input type="submit" name="submit" value="Submit" onclick="return confirm('Sure?');"  /></p>

</form>



<script>
var gurl="http://<?php echo GURL; ?>";
var today="<?php echo $today; ?>";


$(function(){
	chkAllvar('a');
	tickWithDue();
})


function xgetFeeAmount(feeid){
	var vurl 	= gurl + '/ajax/xaccounts.php';	
	var task	= "xgetFeeAmount";		
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',async: true,
		data: 'task='+task+'&feeid='+feeid,						
		success: function(s) { 
			$('#amount').val(s.amount); 
		}		  
	});				

}	/* fxn */



function tickWithDue(){
	$('#withdue').click(function(event) {
		if(this.checked) {
			$('#due').val(today);				
		} else {
			$('#due').val(null);				
		}
	});

	
	
}	/* fxn */


</script>

