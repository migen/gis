<h3>
	
</h3>

<form method="POST" >
	<table class="gis-table-bordered" >
		<tr>
			<th>#</th>
			<th>ID</th>
			<th>Code</th>
			<th>Name</th>
			<th>Label</th>
			<th><?php echo ucfirst($field); ?></th>
		</tr>
		<?php for($i=0;$i<$count;$i++): ?>
			<tr>
				<td><?php echo $i+1; ?></td>
				<td><?php echo $rows[$i]['id']; ?></td>
				<td><?php echo $rows[$i]['code']; ?></td>
				<td><?php echo $rows[$i]['name']; ?></td>
				<td><?php echo $rows[$i]['label']; ?></td>
				<td>
					<input type="hidden" name="posts[<?php echo $i; ?>][id]" value="<?php echo $rows[$i]['id']; ?>" >
					<input name="posts[<?php echo $i; ?>][<?php echo $field; ?>]" value="<?php echo $rows[$i][$field]; ?>" >
				</td>
			</tr>		
		<?php endfor; ?>
	</table>
	<p><input type="submit" name="submit" value="Save" ></p>	
</form>

<div class="ht100" ></div>
