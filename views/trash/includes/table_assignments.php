
<?php 

	// pr($_GET['suppid']); 
	// pr($terminals);
	
?>


<?php $sync = false; ?>
<table class="gis-table-bordered" >
<tr class="headrow" >
	<th><input type="checkbox" id="chkAlla"  /></th>
	<th>#</th>
	<th>Cat</th>
	<th>Type</th>
	<th>Group</th>
	<th>PID</th>
	<th>Product</th>
	<th colspan="" class="center" > 
		<select id="isupp" class='vc120'>	
			<option>-Supplier-</option>
			<?php foreach($suppliers as $sel): ?>
				<option value="<?php echo $sel['id']; ?>"> <?php echo $sel['name']; ?> </option>
			<?php endforeach; ?>
		</select>				
		<br /> <input type="button" value="All" onclick="populateColumn('supp');" >	
	</th>	
	<th class="vc50 right" >Cost</th>
	<th class="vc50 right" >Price</th>
	<th class="right" >Min</th>
	<th class="right" >Lvl</th>
	<th class="vc50 right" >RO<br />Qty</th>
	<th></th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<?php if(empty($rows[$i]['psid'])){ $sync = true; } ?>
<?php $critical = ($rows[$i]['level']<$rows[$i]['rolevel'])? true:false; ?>
<tr class="<?php echo ($critical)? 'red':NULL; ?>" >
	<td class="screen" ><input class="chka" type="checkbox" name="posts[<?php echo $i; ?>][is_selected]" value="1" /></td>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['prodtag']; ?></td>
	<td><?php echo $rows[$i]['prodtype']; ?></td>
	<td><?php echo $rows[$i]['group']; ?></td>
	

		
	<td><input class="pdl05 vc50" id="prod<?php echo $i; ?>" name="posts[<?php echo $i; ?>][product_id]"
		value="<?php echo $rows[$i]['product_id']; ?>" readonly /></td>
	
	<input type="hidden" name="posts[<?php echo $i; ?>][product]" value="<?php echo $rows[$i]['product']; ?>" />		
		
	<td><?php echo $rows[$i]['product']; ?></td>	
	<td>
		<select class="supp" id="supp<?php echo $i; ?>" name="posts[<?php echo $i; ?>][suppid]" >
			<option value="0" >Supplier</option>
			<?php foreach($suppliers AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$rows[$i]['suppid'])? 'selected':NULL; ?> >
					<?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>	
	</td>
	<td><input id="cost<?php echo $i; ?>"  class="vc80 right pdr05" name="posts[<?php echo $i; ?>][cost]" 
		value="<?php echo $rows[$i]['cost']; ?>" ></td>
	<td class="right" ><?php echo $rows[$i]['price']; ?></td>	
	<td class="right" ><?php echo $rows[$i]['rolevel']; ?></td>
	<td class="right" ><?php echo $rows[$i]['level']; ?></td>
		
	<td><input id="roqty<?php echo $i; ?>" class="vc70 right pdr05" name="posts[<?php echo $i; ?>][roqty]" 
		value="<?php echo $rows[$i]['roqty']; ?>" ></td>
		
	<td>
	<button id="btn<?php echo $i; ?>" 
		onclick="xeditAssignment(<?php echo $i.','.$rows[$i]['psid']; ?>);return false;" >Save</button>	&nbsp;	
	<button><a onclick="return confirm('Sure?');" href='<?php echo URL."products/delAssign/".$rows[$i]['psid']; ?>' 
		class="no-underline txt-black" >Delete</a></button>
	</td>
	<input type="hidden" name="posts[<?php echo $i; ?>][psid]" value="<?php echo $rows[$i]['psid']; ?>" >	
</tr>

<?php endfor; ?>
</table>

<p>
	<?php if($sync): ?>
		<button><a href='<?php echo URL."products/syncProductsAssignments"; ?>' >Sync</a></button>
	<?php else: ?>	
		<input onclick="return confirm('Sure?');" type="submit" name="update" value="Update" />	
	<?php endif; ?>	

	<?php if(isset($_GET['suppid'])): ?>
		<?php $suppid = $_GET['suppid']; ?>
			<input type="hidden" name="suppid" value="<?php echo $suppid; ?>"  /><br />
			<input type="hidden" name="ecid" value="<?php echo $_SESSION['pcid']; ?>"  /><br />
			<input type="hidden" name="terminal" value="1"  /><br />
			<input onclick="return confirm('Sure?');" type='submit' name='po' value='Create PO' >
		<?php // $this->shovel('boxes'); ?>
	<?php endif; ?>
	
</p>


