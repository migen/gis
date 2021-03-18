<?php 

	$home = $_SESSION['home'];
	$user = $_SESSION['user'];
	// pr($contacts);
	
?>

<h5>
	<?php echo $room['name'].' - '.$room['topic']; ?> 
	| <a href="<?php echo URL; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				

</h5>


<table class="gis-table-bordered table-fx table-altrow"  >
<tr class="headrow" >
	<th>#</th>
	<th class="vc200" >Member</th>
</tr>

<?php for($i=0;$i<$numrows;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $members[$i]['member']; ?></td>	
	<?php if($user['role_id']==RMIS): ?>
		<td><a href="<?php echo URL.'rooms/removeMember/'.$room['id'].DS.$members[$i]['rcid']; ?>" >Remove</a></td>
	<?php endif; ?>
</tr>
<?php endfor; ?>
</table>

<!----------------------------------------------------------------------------->

<?php 
	$d['contacts'] = $contacts;
	$d['room_id']  = $room['id']; 
	
	
?>

<?php if($user['role_id']==RMIS): ?>
	<?php $this->shovel('add_members',$d); ?>
<?php endif; ?>