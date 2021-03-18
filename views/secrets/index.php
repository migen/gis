

<h5>
	Secrets
	<a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'mis/addSecret'; ?>">Add</a>	

</h5>

<form method="POST" >
<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th>Name</th>
	<th>Value</th>
	<th>Clear</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['value']; ?></td>
	<td><?php echo $rows[$i]['clear']; ?></td>
	<td><a href='<?php echo URL."mis/editSecret/".$rows[$i]['id']; ?>' >Edit</a></td>
</tr>
<?php endfor; ?>
</table>
</form>
