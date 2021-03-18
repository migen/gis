<form method="GET" >

<div style="width:30%;float:left"  >	<!--  left -->
<table class="gis-table-bordered table-fx" >


<tr>
<th>Supplier</th>
<td>
	<select class="vc200" name="suppid" >
		<option value="0" >Choose</option>
		<?php foreach($suppliers AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" 
			<?php echo ((isset($_GET['suppid'])) && ($sel['id']==$_GET['suppid']))? 'selected':NULL; ?> >
			<?php echo $sel['name'].' - '.$sel['id']; ?></option>
		<?php endforeach; ?>
	</select>
</td>
</tr>


<tr>
<th>Terminal</th>
<td>
	<select class="vc200" name="terminal" >
		<?php foreach($terminals AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" 
			<?php echo ((isset($_GET['terminal'])) && ($sel['id']==$_GET['terminal']))? 'selected':NULL; ?> >
			<?php echo ucfirst($sel['code']).' - '.ucfirst($sel['name']); ?></option>
		<?php endforeach; ?>
	</select>
</td>
</tr>


<tr><td colspan="2" ><input type="submit" name="filter" value="Filter"  /></td></tr>

</table>
</div>


</form>