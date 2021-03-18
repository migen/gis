<h5>
	Lot Edit
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>	
	| <a href="<?php echo URL.'shrinkages/filter'; ?>">Filter</a>
	| <a href="<?php echo URL.'shrinkages/batch'; ?>">Batch</a>
	| <a href="<?php echo URL.'shrinkages/add'; ?>">Add</a>

</h5>

<?php // pr($rows[0]); ?>


<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr>
<th>#</th>
<th>Product</th>

<th>Date<br />
	<input class="pdl05" type="date" id="idate" value="<?php echo $today; ?>" /><br />	
	<input type="button" value="All" onclick="populateColumn('date');" >					
</th>

<th>Terminal<br />
	<input class="pdl05 vc50" id="itml" /><br />	
	<input type="button" value="All" onclick="populateColumn('tml');" >					
</th>
<th>Qty</th>

<th>Reference<br />
	<input class="pdl05" id="iref" /><br />	
	<input type="button" value="All" onclick="populateColumn('ref');" >					
</th>
<th>Remarks<br />
	<input class="pdl05" id="irmks" /><br />	
	<input type="button" value="All" onclick="populateColumn('rmks');" >					
</th>
<th>Invty <br />TQ | Lvl</th>
<th>Edit</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['product'].' #'.$rows[$i]['prid']; ?></td>
	<td><input class="date" type="date" name="ps[<?php echo $i; ?>][post][date]" value="<?php echo $rows[$i]['date']; ?>" /></td>
	<td><input class="vc50 tml" name="ps[<?php echo $i; ?>][post][terminal]" value="<?php echo $rows[$i]['terminal']; ?>" /></td>
	<td><input class="vc50" name="ps[<?php echo $i; ?>][post][qty]" value="<?php echo $rows[$i]['qty']; ?>" /></td>
	<td><input class="vc150 ref" name="ps[<?php echo $i; ?>][post][reference]" value="<?php echo $rows[$i]['reference']; ?>" /></td>
	<td><input class="vc150 rmks" name="ps[<?php echo $i; ?>][post][remarks]" value="<?php echo $rows[$i]['remarks']; ?>" /></td>
	<?php $t=$rows[$i]['terminal']; ?>
	<td><?php echo $rows[$i]['t'.$t]; ?> | <?php echo $rows[$i]['level']; ?></td>
	
	<td><a href="<?php echo URL.'shrinkages/edit/'.$rows[$i]['skid']; ?>" ><?php echo $rows[$i]['skid']; ?></a></td>
	
<input type="hidden" name="ps[<?php echo $i; ?>][post][skid]" value="<?php echo $rows[$i]['skid']; ?>" />
<input type="hidden" name="ps[<?php echo $i; ?>][orig][qty]" value="<?php echo $rows[$i]['qty']; ?>" />
<input type="hidden" name="ps[<?php echo $i; ?>][orig][terminal]" value="<?php echo $rows[$i]['terminal']; ?>" />
<input type="hidden" name="ps[<?php echo $i; ?>][orig][prid]" value="<?php echo $rows[$i]['prid']; ?>" />	

<input type="hidden" name="ps[<?php echo $i; ?>][post][prid]" value="<?php echo $rows[$i]['prid']; ?>" />
<input type="hidden" name="ps[<?php echo $i; ?>][post][price]" value="<?php echo $rows[$i]['price']; ?>" />
<input type="hidden" name="ps[<?php echo $i; ?>][post][cost]" value="<?php echo $rows[$i]['cost']; ?>" />
<input type="hidden" name="ps[<?php echo $i; ?>][post][sktype_id]" value="<?php echo $rows[$i]['sktype_id']; ?>" />

	
</tr>
<?php endfor; ?>

<tr><th colspan="9" ><input type="submit" name="submit" value="Update" /></th></tr>


</table>
</form>
