<h5>
	Teachers (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'gset'; ?>" >Gset</a>	
	| <a href="<?php echo URL.'gset/setupTeachers'; ?>" >Setup</a>
	| <?php $this->shovel('links_gset'); ?>



</h5>

<table class="gis-table-bordered table-altrow" >
<tr><th>ID</th><th>Actv</th><th>ID No | <br />Code</th><th>Login<br />Account</th><th>Pwd</th><th>Name</th><th>Edit</th></tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo ($rows[$i]['is_active']==1)? 'Y':'-'; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['account']; ?></td>
	<td><?php echo $rows[$i]['ctp']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td>
		<a href="<?php echo WURL.'gis/codename/one/'.$rows[$i]['id']; ?>" >ID</a>
		| <a href="<?php echo WURL.'gis/mgt/pass/'.$rows[$i]['id']; ?>" >Pass</a>	
	</td>
</tr>
<?php endfor; ?>
</table>
