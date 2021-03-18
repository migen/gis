<?php 

	// pr($data);


?>

<!------------------------------------------------------------------------------------------------------------------------>


<h5>
	Multi-Users | 
	<a href="<?php echo URL; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>						
	| <a href="<?php echo URL.'mis/multis'; ?>" >Multis</a>	
	| <a href="<?php echo URL.'mgt/users'; ?>" >Users</a>	
	
</h5>

<!------------------------------------------------------------------>

<table class="table-fx gis-table-bordered">
<tr class='headrow'>
	<th>#</th>	
	<th class="vc20" > Actv </th>
	<th class="vc50" > PCID </th>
	<th class="vc50" > UCID </th>
	<th class="vc50" > Name </th>
	<th class="vc50" > Code </th>
	<th class="vc50" > Title </th>
	<th class="vc50" > Role </th>
	<th class="vc50" > Manage </th>
</tr>

<?php for($i=0;$i<$num_multiusers;$i++): ?>
<tr class="rc" >
	<td> <?php echo $i+1; ?> </td>
	<td><?php echo ($users[$i]['is_active']==1)?'1':'-'; ?></td>
	<td><?php echo $users[$i]['pcid']; ?></td>
	<td><?php echo $users[$i]['ucid']; ?></td>
	<td><?php echo $users[$i]['name']; ?></td>
	<td><?php echo $users[$i]['code']; ?></td>
	<td><?php echo $users[$i]['title']; ?></td>
	<td><?php echo $users[$i]['role']; ?></td>
	<td>
		<a href="<?php echo URL.'mgt/users/'.$users[$i]['pcid']; ?>">Users</a>
		| <a href="<?php echo URL.'contacts/ucis/'.$users[$i]['pcid']; ?>">Edit</a>
	</td>
</tr>

<?php endfor; ?>

</table>



<!------------------------------------------------------------------------------------------------------------------------>

