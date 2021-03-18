

<p>
<table id="tbl-1" class="gis-table-bordered " >

<tr>
	<th> ID No</th>
	<td><input class="pdl05" id="code"  /></td>
	<td><input type="submit" name="auto" value="Go" onclick="gotoPage();return false;" /></td>
</tr>

<tr>
	<th>ID No | Name</th>
	<td><input class="pdl05" id="part"   /></td>
	<td><input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart(limits);return false;" /></td>
</tr>	




</table></p>



<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>
