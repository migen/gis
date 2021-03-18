<div class="screen" id="smartlinks">
<table><tr>
	<td class="" >&nbsp;</td>
	<?php $user = $_SESSION['user'];  ?>
	<td>
		We<a class="no-underline " href="<?php echo URL.'index/session'; ?>">l</a>come,<span class='bold' ><?php echo $user['fullname']; ?> </span> &nbsp; &nbsp; &nbsp; 
		<a href="<?php echo URL.'users/logout'; ?>"  >Logout</a> 			
	</td>
	
	
	<td>
		<a href='<?php echo URL; ?>' >Home</a>
		| <a href='<?php echo URL."rfid/attendance.php"; ?>' >Attendance</a>
		| <a href='<?php echo URL."rfid/pos.php"; ?>' >POS</a>
		| <a href='<?php echo URL."rfid/pos.php"; ?>' >Loading</a>
		| <a href='<?php echo URL."rfid/pos.php"; ?>' >Writer</a>
	</td>

	<td>
	<?php 

	?>	
	<?php $ssy = (isset($_SESSION['sy']))? '| SY '.$_SESSION['sy'] : NULL; echo $ssy; ?>
	<?php $sqtr = (isset($_SESSION['qtr']))? '- Q'.$_SESSION['qtr'] : NULL; echo $sqtr; ?>
	
	</td>
	
	
</tr></table>
</div>
