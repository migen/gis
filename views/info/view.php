<h5>
	View Info
	| <a href="<?php echo URL.$_SESSION['home']; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	| <a href="<?php echo URL.'info/add'; ?>" />Add</a>  
	| <a href="<?php echo URL.'info'; ?>" />Filter</a>  
	
	
</h5>

<?php if($id): ?>
<table class="gis-table-bordered table-fx" >
<tr><th>ID</th><td><?php echo $id; ?></td></tr>
<tr><th>Type</th><td><?php echo $row['infotype']; ?></td></tr>
<tr><th>Date</th><td><?php echo $row['date']; ?></td></tr>
<tr><th>Amount</th><td class="" ><?php echo number_format($row['amount'],2); ?></td></tr>
<tr><th>User</th><td><?php echo $row['user']; ?></td></tr>
<tr><th>Info</th><td><?php echo $row['info']; ?></td></tr>
<tr><td colspan="2"><a href='<?php echo URL."info/modify/$id"; ?>' >Modify</a></td></tr>

</table>

<?php endif; ?>