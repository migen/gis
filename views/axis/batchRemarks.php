<h5>
	Batch Remarks (Group Remarks)
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a href="<?php echo URL.'axis/batchRemarks'; ?>">Refresh</a> 
	

</h5>




<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr><th>Level</th><td>
<select id="level" name="post[level]" class="vc300" >
	<option value="0" >Choose</option>
	<?php foreach($levels AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" 
			<?php echo (isset($get['level']) && ($get['level']==$sel['id']))? 'selected':NULL; ?>		
		><?php echo $sel['name'].' #'.$sel['id']; ?></option>
	<?php endforeach; ?>
</select>
</td>
<td><a class="u txt-blue" onclick="jsredirect('axis/batchRemarks?level='+$('#level').val());"  >Load Students</a></td>

</tr>

<tr><th>Classroom</th><td>
<select id="classroom" name="post[classroom]" class="vc300" >
	<option value="0" >Choose</option>
	<?php foreach($classrooms AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" 
			<?php echo (isset($get['classroom']) && ($get['classroom']==$sel['id']))? 'selected':NULL; ?>
		><?php echo $sel['name'].' #'.$sel['id']; ?></option>
	<?php endforeach; ?>
</select>
</td>
<td><a class="u txt-blue" onclick="jsredirect('axis/batchRemarks?classroom='+$('#classroom').val());" >Load Students</a></td>
</tr>



<tr><th>Remarks</th>
<td><input class="pdl05 vc500" id="remarks" name="post[remarks]" value="" /></td>

<td></td>

</tr>

</table>

<?php 
if($count>0){
	include_once('incs/batch_students.php');
} 


$incs = "incs/batchRemarks_notes.php";
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

