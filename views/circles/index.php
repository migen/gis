<?php 

$urooms = $_SESSION['urooms'];
$numrows = count($urooms);
$user	= $_SESSION['user'];

// pr($urooms[0]);

?>

<h5>My Circles
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
</h5>



<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<td>#</td>
	<td class="vc200" >Members</td>
	<td>Action</td>
</tr>

<?php for($i=0;$i<$numrows;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><a href="<?php echo URL.'circles/members/'.$urooms[$i]['room_id']; ?>" ><?php echo $urooms[$i]['room']; ?></a></td>
	<td>
		<?php if($user['role_id']==RMIS): ?>
			<a href="<?php echo URL.'circles/edit/'.$urooms[$i]['room_id']; ?>" >Edit</a>
		<?php else: ?> &nbsp; 
		<?php endif; ?>
	</td>
</tr>
<?php endfor; ?>



</table>
