<?php 

?>

<h5>

	Rooms

</h5>

<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th class="vc300" >Agenda</th>
	<th class="vc200" >Topic</th>
	<th>Manage</th>
</tr>

<?php for($i=0;$i<$numrows;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td>
		<a href='<?php echo URL."agenda/add/".$rooms[$i]['id']; ?>' >Add</a>
		| <a href='<?php echo URL."agenda/view/1?room=".$rooms[$i]['room_id']; ?>' ><?php echo $rooms[$i]['room']; ?></a>
	</td>
	<td><?php echo $rooms[$i]['ctc']; ?></td>
	<td>
		<a href='<?php echo URL."rooms/members/".$rooms[$i]['room_id']; ?>' >Members</a>	
		<?php if($is_mis): ?>
			| <a href='<?php echo URL."mis/deleteRoom/".$rooms[$i]['room_id']; ?>' >DEL</a>				
		<?php endif; ?>
	</td>	
</tr>
<?php endfor; ?>

</table>


