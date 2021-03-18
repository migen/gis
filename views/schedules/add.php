<?php 

// echo "pcid: ".$_SESSION['pcid']; 

?>

<h5>Add Event
	| <a href="<?php echo URL.$_SESSION['home']; ?>" >Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'schedules/index'; ?>" >Schedules</a>

</h5>

<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr><th>Date</th><td><input class="pdl05 full" type="date" name="date" value="<?php echo $_SESSION['today']; ?>"  /></td></tr>
<tr><th>Event</th><td><input class="pdl05" name="event" /></td></tr>
<tr><th>Room</th><td>
<select name="room_id" class="full"  >
	<option value="0" >Private</option>
	<?php foreach($_SESSION['urooms'] AS $sel): ?>
		<option value="<?php echo $sel['room_id']; ?>" ><?php echo $sel['room']; ?></option>
	<?php endforeach; ?>
</select>
</td></tr>
<tr><th colspan="2" >More</td></tr>
<tr><th>Time</th><td><input class="pdl05" name="time" value="" placeholder="HH:mm:ss"/></td></tr>
<tr><th>Is Active</th><td><input type="number" min=0 max=1 class="pdl05" name="is_active" value="1" /></td></tr>
<tr><th>Is Impt</th><td><input type="number" min=0 max=1 class="pdl05" name="is_impt" value="0" /></td></tr>
<tr><th>Is Recurring</th><td><input type="number" min=0 max=1 class="pdl05" name="is_recursive" value="0" /></td></tr>

<tr><th colspan="2" >
	<input type="submit" name="submit" value="Add" />	
	<input type="submit" name="cancel" value="Clear" />						
</td></tr>


<input type="hidden" name="owner_pcid" value="<?php echo $_SESSION['pcid']; ?>"  />

</table>
</form>
