<?php
	// pr($event);
?>

<h5>
	Add Event
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a href='<?php echo URL."events/".$_SESSION['moid']; ?>' ><?php echo $_SESSION['month']; ?></a>
	
	
	
</h5>

<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr><th>Date</th><td><input class="" type="date" name="date" value="<?php echo $date; ?>" /></td></tr>
<tr><th>Event</th><td><textarea name="event" rows="8" cols="50"  maxlength="240" autofocus  >

</textarea></td></tr>

</table>

<p>
	<input type="submit" name="submit" value="Save"  />
	<?php if(isset($_SERVER['HTTP_REFERER'])): ?>
		<button><a class="txt-black no-underline" href="<?php echo $_SERVER['HTTP_REFERER']; ?>" >Cancel</a></button>
	<?php else: ?>
		<button><a class="txt-black no-underline" href='<?php echo URL."events"; ?>' >Cancel</a></button>
	<?php endif; ?>
	
</p>

</form>