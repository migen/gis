<?php 

// pr($_SESSION['q']);

?>

<h5>
DG Academics Form
	| <a href="<?php echo URL.'mis'; ?>" > Home </a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'setup/grading'; ?>" > Setup </a>
	| <a href="<?php echo URL.'mis/dgconductsForm'; ?>" > DG Conducts </a>
	| <a href="<?php echo URL.'mis/dgtraitsForm'; ?>" > DG Traits </a>

</h5>

<?php  $this->shovel('offset'); ?>


<form method="POST" >
<table class="gis-table-bordered table-altrow" >



<tr>
<th class="bg-blue2" >SUBJECT</th>
<td> 
<select class="full" name="subjid" id="subjid" >
	<option value="0"> Choose One </option>
	<?php foreach($subjects AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select> 
</td></tr>

<tr>
	<th class="bg-blue2" >DEPT</th>
	<td><select class="full" name="dept" id="dept" >
		<option>Choose One</option>
		<option value="1">PS</option>
		<option value="2">GS</option>
		<option value="3">HS</option>
	</select>
	
	<button onclick="xgetCountCourseGradesByDept();return false;" >Count</button>
	</td>
</tr>

<tr>
	<th class="bg-blue2" >SY</th>
	<td><input class="pdl05 full" name="sy" value="<?php echo $sy; ?>" ></td>
</tr>

<tr>
	<th class="bg-blue2" >Qtr</th>
	<td><input class="pdl05 full" name="qtr" value="<?php echo $qtr; ?>" ></td>
</tr>

<tr>
	<th class="bg-blue2" >LIMIT</th>
	<td><input class="pdl05 full" type="number" name="limit" value="<?php echo 100; ?>" ></td>
</tr>

<tr>
	<th class="bg-blue2" >OFFSET</th>
	<td><input class="pdl05 full" name="offset" value="0" ></td>
</tr>

<tr><td colspan="2" ><input type="submit" name="submit" value="Submit"   /></td></tr>

</table>
</form>




<!------------------------------------------------------------------->


<script>


var gurl = 'http://<?php echo GURL; ?>';
var sy	 = '<?php echo $sy; ?>';


function xgetCountCourseGradesByDept(){
	
	var dept 	= $('#dept').val();
	var subjid 	= $('#subjid').val();
	
	var vurl 	= gurl + '/mis/xgetCountCourseGradesByDept/'+dept+'/'+subjid+'/'+sy;		
	
	// alert(vurl);
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		async: true,
		success: function(s) { 	
			alert(s.count+' records.');		
		}		  
    });				
	

}





</script>
