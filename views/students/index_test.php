<h5>

</h5>


<?php

// pr($_SESSION['user']);
// pr($_SESSION['student']['profile']['remarks']);


?>



<h5 class="brown">
	<?php echo (isset($_SESSION['student']['profile']['remarks']) && ($_SESSION['student']['profile']['remarks'] != ''))? $_SESSION['student']['profile']['remarks'] : 'Have a good one!' ; ?>
</h5>

<!------------------------------------------------------------------------------->

<h5>
	Home
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	
</h5>

<!------------------------------------------------------------------------------->


<!-- attendance,ajax redirect not post -->
<table class="gis-table-bordered table-fx table-altrow" >
<tr><th class="headrow white vc200" > Menu </th></tr>
<tr>
	<td>
		<select onchange="redirAttendanceLogs(this.value);" class="vc200" >
			<option>Attendance</value>
			<?php foreach($months AS $sel): ?>
				<option value="<?php echo $sel['index']; ?>" ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	Go </td>
</tr>

<tr><td class="vc200" ><a href="<?php echo URL.'students/reportCard'; ?>" > Report Card </a></td></tr>
<tr><td class="vc200" ><a href="<?php echo URL.'students/guidance'; ?>" > Guidance </a></td></tr>
<tr><td class="vc200" ><a href="<?php echo URL.'students/pos'; ?>" > POS </a></td></tr>
<tr><td class="vc200" ><a href="<?php echo URL.'students/accounts'; ?>" > Accounts </a></td></tr>
<tr><td class="vc200" ><a href="<?php echo URL.'students/load'; ?>" > BitCash </a></td></tr>
<tr><td class="vc200" ><a href="<?php echo URL.'students/library'; ?>" > Library </a></td></tr>
<tr><td class="vc200" ><a href="<?php echo URL.'users/securePassword/'.$_SESSION['user']['code']; ?>" > Secure Password </a></td></tr>

<tr><td class="vc200" >

<?php
	if($_SESSION['student']['profile']['is_finalized']){
		echo "<p><a href='".URL."profiles/student'>Profle</a></p>";  				
	} else {
		echo "<p><a href='".URL."students/editContact/".$_SESSION['user']['ucid']."'>Accomplish Profle</a></p>";  				
	}			
?>
</td></tr>


</table>




<!------------------------------------------------------------------------------------------------>

<script>

var gurl = 'http://<?php echo GURL; ?>';	
var ssy 	 = '<?php echo $sy; ?>';

function redirAttendanceLogs(month){
	var url 	= gurl + '/students/attendanceLogs/'+ssy+'/'+month; 
	window.location = url;		
}



</script>