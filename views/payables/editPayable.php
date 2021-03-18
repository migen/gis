<h3>
	Edit Payable | 
	<?php $this->shovel('homelinks'); ?> 
	| <a href="<?php echo URL.'enrollment/ledger/'.$row['scid']; ?>" >Ledger</a>
	| <a href="<?php echo URL.'payables/delete/'.$row['pkid']; ?>" onclick="return confirm('Dangerous! Proceed?');" >Delete</a>
	
	
</h3>

<?php 

	// pr($data);
	// pr($row);

?>



<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>ID</th><td><?php echo $row['pkid']; ?></td></tr>
<tr><th>ID No.</th><td><?php echo $row['studcode']; ?></td></tr>
<tr><th>Student</th><td><?php echo $row['studname']; ?></td></tr>
<tr><th>Feetype</th><td><?php echo $row['feetype']; ?></td></tr>
<tr><th>Is Discount</th><td><?php echo ($row['is_discount']==1)? 'Yes':'No'; ?></td></tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php $key=$rows[$i]; ?>
<?php if($key=='feetype_id'){ continue; } ?>
<tr>
	<th><?php echo $key; ?></th>
	<td><input name="post[<?php echo $key; ?>]" value="<?php echo $row[$key]; ?>" ></td>
</tr>
<?php endfor; ?>

<tr><th>Feetype</th>
<td>
	<select name="post[feetype_id]" >
		<?php foreach($feetypes AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" 
				<?php echo ($sel['id']==$row['feetype_id'])? 'selected':NULL; ?> >
				<?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select>
</td>

</tr>

<tr><td colspan=2><input type="submit" name="submit" value="Save" ></td></tr>
<input type="hidden" name="scid" value="<?php echo $row['scid']; ?>" >
<input type="hidden" name="studname" value="<?php echo $row['studname']; ?>" >
<input type="hidden" name="amount" value="<?php echo $row['amount']; ?>" >
<input type="hidden" name="feetype" value="<?php echo $row['feetype']; ?>" >
</table>
</form>