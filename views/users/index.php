<h5>
	<?php echo $this->shovel('breadlinks'); ?> <br />
	Users
</h5>

<?php 

	// pr($data);
?>

<form method='post'>

<input type='text' name='user' placeholder='Search Contacts'/>
<select name='initial' class='vc50'>
	<option value=''>All</option>
<?php 
	$letters = array(
		'a','b','c','d','e','f','g','h','i','j','k','l','m',
		'n','o','p','q','r','s','t','u','v','w','x','y','z'
		);
	foreach($letters AS $v):
?>
<option value="<?php echo $v; ?>"><?php echo $v; ?></option>
<?php endforeach; ?>
</select>
<input type='submit' name='submit_search' value='Submit' />




</form>


<?php if($data): ?>
<table class='gis-table-bordered table-fx'>

<tr class='headrow'>
	<th>#</th>
	<th class='vc100'>Code</th>
	<th class='vc100'>Role</th>
	<th class='center'>Actions</th>
</tr>

<?php $c = count($data['users']); ?>
<?php $i = 1; ?>
<?php foreach($data['users'] AS $row): ?>
<tr>
	<td><?php echo $i; ?></td>
	<td><?php echo isset($row['code'])? $row['code'] : null; ?></td>
	<td><?php echo $row['role']; ?></td>
	<td>
		<a href="<?php echo URL.'users/view/'.$row['id']; ?>">View</a> ||
		<a href="<?php echo URL.'users/edit/'.$row['id']; ?>">Edit</a> ||
		<a href="<?php echo URL.'users/delete/'.$row['id']; ?>">Delete</a>
	</td>
	
</tr>
<?php $i++; ?>
<?php endforeach; ?>
</table>

<?php endif; ?>

<!-- pagination -->
<?php echo $data['pages']; ?>

