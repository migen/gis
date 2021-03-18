
<table class="gis-table-bordered" >
<tr><th>Product</th><td>	
	<span class="hd" ><input name="prid" id="prid" class="vc50" value="0" type="" /></span>
	<input class="pdl05" id="part" autofocus placeholder="Item" />	
	<input type="submit" name="auto" value="Product" onclick="xgetProductsByPart();return false;" />
	
</td>
</tr>

<tr><th>Start</th><td><input id="start" class="pdl05 " type="date" name="dateone" 
	value="<?php echo $today; ?>" /></td></tr>
<tr><th>End</th><td><input id="end" class="pdl05 " type="date" name="datetwo" 
	value="<?php echo $today; ?>" /></td></tr>			

<?php $sorts = array(
	array('key'=>'p.datetime','value'=>'Date'),
); ?>

	<tr><th>Sort | Order</th><td>
		<select name="sort" >
			<?php $sort_key = (isset($_GET['sort']))? $_GET['sort']:'po.date'; ?>
			<?php foreach($sorts AS $sel): ?>
				<option value="<?php echo $sel['key']; ?>" <?php echo ($sel['key']==$sort_key)? 'selected':NULL; ?> >
					<?php echo $sel['value']; ?></option>
			<?php endforeach; ?>
	
		</select>

		<select name="order" >
			<option value="DESC">DESC</option>
			<option value="ASC" <?php echo (isset($_GET['order']) && $_GET['order']=='ASC')? 'selected':NULL; ?>  >ASC</option>
		</select>		
	</td></tr>

<tr><td colspan="2" ><input type="submit" name="filter" value="Go"  /></td></tr>
</table>