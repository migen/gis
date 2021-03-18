<h5>
	Calendar of Events
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>

	<?php if(isset($_GET['all'])): ?>
		| <a href='<?php echo URL."events/".$_SESSION['moid']; ?>' ><?php echo $_SESSION['month']; ?></a>
	<?php else: ?>
		| <a href='<?php echo URL."events?all"; ?>' >All</a>	
	<?php endif; ?>

	<?php if(!isset($_GET['future'])): ?>
			| <a href='<?php echo URL."events?all&future"; ?>' >Future</a>	
	<?php else: ?>		
			| <a href='<?php echo URL."events?all"; ?>' >All</a>		
	<?php endif; ?>		
	
	| <a href='<?php echo $_SERVER['REQUEST_URI'].'&window'; ?>' >Window</a>	
	
	| <a href='<?php echo URL."events/add"; ?>' >New</a>		
	
</h5>



<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th>Date</th>
	<th>Event</th>
	<th>By</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo date('M-d',strtotime($events[$i]['date'])); ?></td>
	<td class="vc400" ><?php echo $events[$i]['event']; ?></td>
	<td class="vc150" ><?php echo $events[$i]['contact']; ?></td>
	<?php if($admin): ?>
		<td>
			<a href='<?php echo URL."events/edit/".$events[$i]['id']; ?>' >Edit</a>
			| <a onclick="return confirm('Proceed?');" href='<?php echo URL."events/delete/".$events[$i]['id']; ?>' >Delete</a>

		</td>
	<?php endif; ?>
</tr>
<?php endfor; ?>
</table>

