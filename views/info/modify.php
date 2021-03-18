<h5>
	Edit Task
	| <a href="<?php echo URL.$_SESSION['home']; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a href="<?php echo URL.'tasks/add'; ?>" />Add</a>  
	| <a href="<?php echo URL.'tasks'; ?>" />Filter</a>  
	
</h5>

<?php if($id): ?>
<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr><th>ID</th><td><?php echo $id; ?></td></tr>
<tr><th>Date</th><td><?php echo $row['date']; ?></td></tr>
<tr><th>User</th><td><?php echo $row['user']; ?></td></tr>
<tr><th>Is Done</th><td><input name="post[is_done]" value="<?php echo $row['is_done']; ?>" 
type="number" min=0 max=1 /></td></tr>
<tr><th>Item</th><td><textarea name="post[item]" ><?php echo $row['item']; ?></textarea></td></tr>
<tr><th>Remarks</th><td><textarea name="post[remarks]" ><?php echo $row['remarks']; ?></textarea></td></tr>
<tr><td colspan="2"><input type="submit" name="submit" value="Save" /></td></tr>

</table>

</form>

<?php endif; ?>