<h5>
	MD Five 
	
</h5>



<form method="GET" >
<table class="gis-table-bordered" >
<tr><th>Clear</th><td><input class="pdl05" name="clear" /></td></tr>
<?php if(isset($_GET['clear'])): ?>
	<tr><th>MD Five</th><td><?php echo md5($clear); ?></td></tr>
<?php endif; ?>
</table>

<p><input type="submit" name="submit" value="Submit" /></p>
</form>