<?php
	// pr($event);
?>

<h5>
	View Event

</h5>

<table class="gis-table-bordered table-fx" >
<tr><th>Date</th><td><?php echo $event['date']; ?></td></tr>
<tr><th>Event</th><td class="vc500" ><?php echo $event['event']; ?></td></tr>

</table>

<p>
	<?php if(isset($_SERVER['HTTP_REFERER'])): ?>
		<button><a class="txt-black no-underline" href="<?php echo $_SERVER['HTTP_REFERER']; ?>" >Cancel</a></button>
	<?php else: ?>
		<button><a class="txt-black no-underline" href='<?php echo URL."events"; ?>' >Cancel</a></button>
	<?php endif; ?>	
</p>

