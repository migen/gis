<?php 

// pr($row);

?>

<h5>
	View Supplier Info - <?php echo $row['fullname']; ?>
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				 		
	| <a href="<?php echo URL.'suppliers/edit/'.$suppid; ?>">Edit</a>

	
	
</h5>


<table class="gis-table-bordered " >
<tr><th>Full Name</th><td><?php echo $row['fullname']; ?></td></tr>
<tr><th>Comm Code</th><td><?php echo $row['code']; ?></td></tr>
<tr><th>Contact Person</th><td><?php echo $row['contact_person']; ?></td></tr>
<tr><th>Mobile</th><td><?php echo $row['mobile']; ?></td></tr>
<tr><th>Phone</th><td><?php echo $row['phone']; ?></td></tr>
<tr><th>Email</th><td><?php echo $row['email']; ?></td></tr>
<tr><th>Address</th><td><?php echo $row['address']; ?></td></tr>
</table>
