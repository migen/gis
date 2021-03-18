<h5>
	Staff (<?php echo $count; ?>)
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		


</h5>

<table class="gis-table-bordered table-altrow table-fx" >

<tr>
	<th>ID</th>
	<th>Login</th>
	<th>Name</th>
	<th>Pass</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['ctp']; ?></td>
</tr>
<?php endfor; ?>
</table>
