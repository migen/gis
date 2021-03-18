<h5>
	OR Booklets
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	| <a href='<?php echo URL."invoices/orno/".$_SESSION['ucid']; ?>' >My OR No</a>

</h5>

<table class="gis-table-bordered table-fx table-altrow" >
<tr>
	<th>#</th>
	<th>Ecid</th>
	<th>Employee</th>
	<th>OR No.</th>
	<th>Edit</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['ecid']; ?></td>
	<td><?php echo $rows[$i]['employee']; ?></td>
	<td><?php echo $rows[$i]['orno']; ?></td>
	<td>
		<?php if($rows[$i]['ecid']==$_SESSION['ucid']): ?>
			<?php $ucid=$_SESSION['ucid']; ?>
			<a href='<?php echo URL."invoices/orno/$ucid"; ?>' >Edit</a>
		<?php endif; ?>
	</td>
</tr>
<?php endfor; ?>
</table>
