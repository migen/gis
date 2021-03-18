<h5>
	Edit Dream
	| <?php $this->shovel('homelinks'); ?>	
		
</h5>

<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr><th>ID</th><th><input value="<?php echo $row['id']; ?>" readonly /></th></tr>
<tr><th>Year</th><th><input value="<?php echo $row['year']; ?>" readonly /></th></tr>
<tr><th>Name</th><th><input value="<?php echo $row['name']; ?>" name="name" /></th></tr>
</table>

<h5>Details</h5>

<table class="gis-table-bordered table-altrow" >
<tr><th>#</th><th>Date</th><th>Item</th></tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><input value="<?php echo $rows[$i]['date']; ?>" name="posts[<?php echo $i; ?>][date]" /></td>
	<td>
		<input class="vc500" value="<?php echo $rows[$i]['item']; ?>" name="posts[<?php echo $i; ?>][item]" />
		<input type="hidden" value="<?php echo $rows[$i]['id']; ?>" name="posts[<?php echo $i; ?>][id]" />	
	</td>

</tr>
<?php endfor; ?>
</table>


<p><input type="submit" name="submit" value="Update"  /></p>


</form>



