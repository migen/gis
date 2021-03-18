<?php 

?>


<!---------------------------------------------------------------------------------->


<h5>
	<a href="<?php echo URL.'mis'; ?>" > Home </a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'setup/grading'; ?>" > Setup </a>
	| <a href="<?php echo URL.'dashboard/mis'; ?>" > Dashboard </a>
</h5>



<!---------------------------------------------------------------------------------->


<table class="gis-table-bordered table-fx table-altrow"  >
<tr class="headrow" >
<td>#</td>
<td>UC</td>
<td>PC</td>
<td>Name</td>
<td>Account</td>
<td>Role</td>
<td>Title</td>
<td>Pass</td>
<td>Manage</td>
</tr>

<?php for($i=0;$i<$num_ctp;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $ctp[$i]['ucid']; ?></td>
	<td><?php echo $ctp[$i]['pcid']; ?></td>
	<td><?php echo $ctp[$i]['name']; ?></td>
	<td><?php echo $ctp[$i]['account']; ?></td>
	<td><?php echo $ctp[$i]['role']; ?></td>
	<td><?php echo $ctp[$i]['title']; ?></td>
	<td><?php echo $ctp[$i]['ctp']; ?></td>
	<td><a href="<?php echo URL.'mgt/pass/'.$ctp[$i]['contact_id']; ?>" > Change Pass </a></td>
</tr>
<?php endfor; ?>
</table>


