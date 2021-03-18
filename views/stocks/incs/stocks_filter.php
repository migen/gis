<form method="GET" >
<table>

<tr>
<?php if($_SESSION['user']['privilege_id']==0): ?>
	<th>Trml</th>
<?php endif; ?>
	<th>TQ-L</th>
	<th>TQ-U</th>
	<th>Name</th>
	<th>Bar|Code</th>
	<th>Supp</th>
	<th>Disp</th>
	<th>Signed</th>
	<th></th>
</tr>
<tr>
<?php if($_SESSION['user']['privilege_id']==0): ?>
	<td><input class="vc50" type="number" name="terminal" value="<?php echo $terminal; ?>"  /></td>
<?php endif; ?>
	<td><input type="number" class="vc50" name="qty" value="<?php echo (!empty($_GET['qty']))? $_GET['qty']:-1; ?>"  /></td>
	<td><input type="number" class="vc50" name="tqupper" 
		value="<?php echo (!empty($_GET['tqupper']))? $_GET['tqupper']:1000; ?>"  /></td>
	<td><input class="vc100" name="product" value="<?php echo (!empty($_GET['product']))? $_GET['product']:NULL; ?>"  /></td>
	<td><input class="vc100" name="code" value="<?php echo (!empty($_GET['code']))? $_GET['code']:NULL; ?>"  /></td>
	<td>
		<select name="suppid" class="vc200"  >
		<option value="0" >All Suppliers</option>
		<?php foreach($suppliers AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" 
				<?php echo (isset($_GET['suppid']) && ($_GET['suppid']==$sel['id']))? 'selected':NULL; ?>
			><?php echo $sel['name'].' #'.$sel['id']; ?></option>
		<?php endforeach; ?>
		</select>	
	</td>	
	
	<td><input class="vc50" type="number" min=0 max=1 name="display" 
		value="<?php echo (isset($_GET['display']))? $_GET['display']:1; ?>"  /></td>
			
	<td><input class="vc50" type="number" min=0 max=1 name="signed" 
		value="<?php echo (isset($_GET['signed']))? $_GET['signed']:1; ?>"  /></td>
		
	<td><input type="submit" name="submit" value="Filter"  /></td>
</tr>


</table></form>