

<div class="third" >
<table class="gis-table-bordered table-altrow" >
	<tr><th>CCID</th><td><?php echo $contact['id']; ?></td></tr>
	<tr><th>ID #</th><td><?php echo $contact['code']; ?></td></tr>
	<tr><th>Name</th><td><?php echo $contact['name']; ?></td></tr>
</table>
</div>


<div class="third" >
<table class="gis-table-bordered table-fx" >
<tr><th>Barcode</th><td><input id="posbarcode" onchange="addPosItem();return false;" /></td></tr>
<tr><th>Find</th><td>
	<input class="pdl05" id="pospart"  />		
	<input type="submit" name="auto" value="Filter" onclick="xfindProductsByPart();return false;" />
</td></tr>
</table>
</div>

