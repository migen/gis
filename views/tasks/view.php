<h5>
	View Task
	| <a href="<?php echo URL.$_SESSION['home']; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a href="<?php echo URL.'tasks/add'; ?>" />Add</a>  
	| <a href="<?php echo URL.'tasks'; ?>" />Filter</a>  
	
	
</h5>

<?php if($id): ?>
<table class="gis-table-bordered table-fx" >
<tr><th>ID</th><td><?php echo $id; ?></td></tr>
<tr><th>Date</th><td><?php echo $row['date']; ?></td></tr>
<tr><th>User</th><td><?php echo $row['user']; ?></td></tr>
<tr><th>Is Done</th><td><?php echo $row['is_done']; ?></td></tr>
<tr><th>Item</th><td><?php echo $row['item']; ?></td></tr>
<tr><th>Remarks</th><td><?php echo $row['remarks']; ?></td></tr>
<tr><td colspan="2"><a href='<?php echo URL."tasks/modify/$id"; ?>' >Modify</a></td></tr>

</table>

<?php endif; ?>