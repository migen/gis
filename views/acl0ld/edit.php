<h5>
	Edit ACL
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		


</h5>



<form method="POST" >

<table class="gis-table-bordered table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th>ID</th>
	<th>WURL</th>
	<th>Title</th>
</tr>

<?php for($i=0;$i<$numrows;$i++): ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td><?php echo $rows[$i]['id']; ?></td>
		<td><input class="pdl05" name="posts[<?php echo $i; ?>][wurl]" value="<?php echo $rows[$i]['wurl']; ?>" /></td>
		
		<td><select name="posts[<?php echo $i; ?>][title_id]" />
			<?php foreach($titles AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" <?php echo ($rows[$i]['title_id']==$sel['id'])? 'selected':NULL; ?> >
					<?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</td>
		
		<td><input class="pdl05" name="posts[<?php echo $i; ?>][id]" value="<?php echo $rows[$i]['id']; ?>" /></td>

	</tr>
<?php endfor; ?>

</table>

<p>
	<input onclick="return confirm('Sure?');" type="submit" name="submit" value="Save" />
</p>

</form>