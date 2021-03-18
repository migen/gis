<h5>
	View OR
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a href="<?php echo URL.'ornos/edit/'.$id; ?>">Edit</a>


</h5>


<form method="POST"  >
<table class="gis-table-bordered table-fx" >
<tr><th>ID</th><td><?php echo $row['id']; ?></td></tr>
<tr><th>Date</th><td><?php echo $row['date']; ?></td></tr>
<tr><th>Void</th><td><?php echo ($row['is_void']==1)? 'Y':NULL; ?></td></tr>
<tr><th>Orno</th><td><?php echo $row['orno']; ?></td></tr>
<tr><th>Remarks</th><td><?php echo $row['remarks']; ?></td></tr>


</table>
</form>