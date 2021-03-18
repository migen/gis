<tr rel="<?php echo $row['id']; ?>" class="<?php echo (even($i))? 'even1':'odd1'?>">
<?php if(Session::get('user_id') == 1): ?>
	<td><input type="checkbox" name="rows[<?php echo $row['id'];?>]" value="<?php echo $row['id']; ?>" /></td>
	<td class='center'><a href="<?php echo URL.'webpages/edit/'.$row['alias']; ?>">edit</a></td>	
	<td><?php echo $row['id']; ?></td>	
	<td><a href="<?php echo URL; ?>webpages/read/<?php echo $row['alias']; ?>"><?php echo $row['alias']; ?></a></td>	
	<td><a href="<?php echo URL; ?>groups/view/<?php echo $row['share_id']; ?>"><?php echo $row['share']; ?></a></td>	
	<td><a href="<?php echo URL; ?>users/view/<?php echo $row['user_id']; ?>"><?php echo $row['user']; ?></a></td>
	<td><?php echo ymd($row['modified']); ?></td>
	<td><?php echo $row['status']; ?></td>
	<td><?php echo $row['tag']; ?></td>
<?php endif; ?>
	
<td class='vc300'><a href="<?php echo URL; ?>webpages/read/<?php echo $row['alias']; ?>"><?php echo $row['name']; ?></a></td>
</tr>