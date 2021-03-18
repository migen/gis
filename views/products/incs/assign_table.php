
<div style="float:left;width:35%" >
<table id="tblExport" class="gis-table-bordered table-fx table-altrow" >
<tr>
	<th>Prid</th>
	<th>Barcode</th>
	<th>Product</th>
	<th>Cost</th>
	<th>Price</th>
	<th>Axn</th>
</tr>


<?php for($i=0;$i<$count;$i++): ?>
<tr id="tr<?php echo $i; ?>" >
	<?php $psid = $rows[$i]['psid']; ?>
	<td><?php echo $rows[$i]['prid']; ?></td>
	<td><?php echo $rows[$i]['barcode']; ?></td>
	<td><?php echo $rows[$i]['product']; ?></td>
	<td class="right" ><?php echo $rows[$i]['cost']; ?></td>
	<td class="right" ><?php echo $rows[$i]['price']; ?></td>
	<td><?php if($rows[$i]['psid']): ?>	
		<a class="u" onclick="xdeleteSupplier(<?php echo $psid.','.$i; ?>);return false;"  />Del</a>		
		<?php endif; ?>
	</td>
</tr>
<?php endfor; ?>
</table>
</div>	<!-- left -->

<!---------------------------------------------------------------------------------->

<div class="left" >&nbsp;</div>

<div class="left batch" style="width:50%;float:left;" >	<!-- rosterBatch -->
<form method="POST" >	<!-- form add -->

<div class="addrows" style="width:60%;float:left;"  >

<table class="gis-table-bordered" >
<tr class='headrow'>
	<th>#</th>	
	<th class="" >Barcode</th>
	<th class="" >Product</th>
	<th class="" >Cost</th>
	<th class="" >Price</th>
</tr>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<tr >
	<td class="vc20" ><?php echo $i+1; ?></td>
	<td><input id="barcode<?php echo $i; ?>" class="vc120" name="posts[<?php echo $i; ?>][barcode]" /></td>		
	<td><input id="name<?php echo $i; ?>" class="vc120" name="posts[<?php echo $i; ?>][name]" /></td>		
	<td><input id="cost<?php echo $i; ?>" class="vc60 right" name="posts[<?php echo $i; ?>][cost]" /></td>				
	<td><input id="price<?php echo $i; ?>" class="vc60 right" name="posts[<?php echo $i; ?>][price]" /></td>				
</tr>

<?php endfor; ?>			
</table>

<p>
	<br /><input type="submit" name="add" value="Add" /> &nbsp; 
	<button><a href="<?php echo URL.$_SESSION['home']; ?>" class="no-underline" >Cancel</a></button>
</p>

</form> <!-- add -->


<p><?php $this->shovel('numrows'); ?></p>
</div>

<div class="clipboard" style="width:200px;float:left;"  >
<p>
<select id="classbox" >
	<option value="barcode" >Barcode</option>
	<option value="name" >Name</option>
	<option value="cost" >Cost</option>
	<option value="price" >Price</option>
</select>
</p>
<?php $d['width'] = '20'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>

</div>	<!--  rosterBatch -->



<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>


