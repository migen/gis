<table class="gis-table-bordered" >
<tr><th>Supplier</th>
<td>
<select id="suppid" >
<?php foreach($suppliers AS $sel): ?>
	<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name'].' #'.$sel['id']; ?></option>
<?php endforeach; ?>
</select>
</td>
<td>
<button onclick="redirUrl();" >GO</button>
</td>
</tr>
</table>