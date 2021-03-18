<?php 

// echo "pcid: ".$_SESSION['pcid']; 

?>

<h5>View Event
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'schedules/index'; ?>" >Schedules</a>

</h5>

<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr><th>Date</th><td><input class="pdl05 full" type="date" name="date" value="<?php echo $row['date']; ?>"  /></td></tr>
<tr><th>Event</th><td><input class="pdl05" name="event" value="<?php echo $row['event']; ?>" /></td></tr>
<tr><th>Room</th><td>
<select name="room_id" class="full"  >
	<?php foreach($_SESSION['urooms'] AS $sel): ?>
		<option value="<?php echo $sel['room_id']; ?>" <?php echo ($sel['room_id']==$row['room_id'])? 'selected':NULL; ?> >
			<?php echo $sel['room']; ?></option>
	<?php endforeach; ?>
</select>
</td></tr>
<tr><th colspan="2" >More</td></tr>
<tr><th>Time</th><td><input class="pdl05" name="time" placeholder="HH:mm:ss" value="<?php echo $row['time']; ?>" /></td></tr>
<tr><th>Is Active</th><td><input type="number" min=0 max=1 class="pdl05" name="is_active" value="<?php echo $row['is_active']; ?>" /></td></tr>
<tr><th>Is Impt</th><td><input type="number" min=0 max=1 class="pdl05" name="is_impt" value="<?php echo $row['is_impt']; ?>" /></td></tr>
<tr><th>Is Recurring</th><td><input type="number" min=0 max=1 class="pdl05" name="is_recursive" value="<?php echo $row['is_active']; ?>" /></td></tr>



<input type="hidden" name="owner_pcid" value="<?php echo $_SESSION['pcid']; ?>"  />
<input type="hidden" name="id" value="<?php echo $row['id']; ?>"  />

</table>
</form>
