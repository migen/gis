
<form method="GET" >
<table class="gis-table-bordered" >
<tr>
<td>Date:<input type="date" name="date" value="<?php echo $_SESSION['today']; ?>" ></td>
<td>Start:<input type="start" name="start" value="" ></td>
<td>End:<input type="end" name="end" value="" ></td>
<td>Orno:<input type="text" name="orno" value="<?php echo ''; ?>" ></td>
<td><input type="submit" name="submit" value="Filter"  /></td>
</tr>


</table>
</form>