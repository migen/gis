<h5>
	Conduct Genave <?php echo 'Q'.$qtr; echo ' ('.$count; ?>)
	| <?php echo $course['level'].' - '.$course['section']; ?>
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>	
	
	
</h5>


<form method="POST" >
<table class="gis-table-bordered table-fx table-altrow" >
<tr><th>#</th><th>ID Num</th><th>Student</th><th>Grade</th><th>DG</th></tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td><input class="vc50" name="posts[<?php echo $i; ?>][grade]" value="<?php echo $rows[$i]['grade']; ?>" ></td>
	<td><input class="vc50" name="posts[<?php echo $i; ?>][dg]" value="<?php echo $rows[$i]['dg']; ?>" ></td>
	<input type="hidden" class="vc50" name="posts[<?php echo $i; ?>][scid]" value="<?php echo $rows[$i]['scid']; ?>" >	
</tr>
<?php endfor; ?>
<tr><td colspan="5" ><input type="submit" name="submit" value="Save" onclick="return confirm('Sure?');" /></td></tr>
</table>
</form>