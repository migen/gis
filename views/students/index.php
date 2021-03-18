<h5>

</h5>


<?php

// pr($data);




?>



<h5 class="gray">
	<?php echo (isset($_SESSION['student']['profile']['remarks']) && ($_SESSION['student']['profile']['remarks'] != ''))? $_SESSION['student']['profile']['remarks'] : NULL ; ?>
</h5>

<!------------------------------------------------------------------------------->

<h5>
	Home
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	
</h5>

<!------------------------------------------------------------------------------->


<!-- attendance,ajax redirect not post -->
<table class="gis-table-bordered table-fx table-altrow" >

<tr><th class="headrow vc200" > Menu </th></tr>

<?php if($_SESSION['user']['is_cleared']): ?>


	<tr><td class="vc200" ><a href="<?php echo URL.'profiles/student'; ?>" >Profile</a></td></tr>
	<tr><td class="vc200" ><a href="<?php echo URL.'rcards/scid'; ?>" >Report Card</a></td></tr>
	<tr><td class="vc200" ><a href="<?php echo URL.'extra/securePassword/'.$_SESSION['user']['code']; ?>" > Change Password </a></td></tr>	
	<tr><td class="vc200" ><a href="<?php echo URL.'students/reportcard'; ?>" >Student Report Card</a></td></tr>	
<?php else: ?>
	<tr><td class="red" >Not Cleared</td></tr>
<?php endif; ?>	

	
</table>


<!--
<tr>
	<td>
		<select onchange="redirAttendanceLogs(this.value);" class="vc200" >
			<option>Attendance</value>
			<?php foreach($months AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	Go </td>
</tr>

	<tr><td class="vc200" ><a href='<?php echo URL."attendance/attd/$ucid/$today"; ?>' >Attendance Daily</a>
	 | <a href='<?php echo URL."attdlogs/person/$sy/$moid/$ucid"; ?>' >Monthly</a></td></tr>
	<tr><td class="vc200" ><a href="<?php echo URL.'contacts/ucis/'.$_SESSION['user']['ucid']; ?>" > Profile </a></td></tr>

-->

<!------------------------------------------------------------------------------------------------>

<script>

var gurl 	= 'http://<?php echo GURL; ?>';	
var ssy 	= '<?php echo $ssy; ?>';
var scid 	= '<?php echo $scid; ?>';

$(function(){


})


function redirAttendanceLogs(month){
	var url 	= gurl + '/students/attendanceLogs/'+ssy+'/'+month+'/'+scid; 
	window.location = url;		
}



</script>