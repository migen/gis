<form id="form" >	<!-- with id for js clear -->
<table class="gis-table-bordered table-fx" >
<tr>
<th>
	Prid <input readonly id="prid" class="pdl05 vc60" value="0" />
	Cost <input id="cost" value="0" class="vc80 right" >
	<input type="hidden" id="barcode" class="vc60" readonly />
</th>
</tr>
<tr>
<td>		
	<input class="pdl05 pdl05 vc100" id="part" autofocus placeholder="Search" />	
	<input type="submit" name="auto" value="Product" onclick="xgetProductsByPart();return false;" />
	<input type="submit" name="auto" value="Supplier" onclick="xgetContactsByPart();return false;" />				
	<input id="btn" type="submit" value="Add" onclick="xassignPS();return false;"  />	
</td>
</tr>
</table>
</form>
<br />

<script>



</script>
