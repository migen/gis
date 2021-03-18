<?php

$code_len = isset($_SESSION['settings']['code_length'])? $_SESSION['settings']['code_length']:4;
$code=isset($_GET['code'])? $_GET['code']:NULL;


?>

<p>
<table id="tbl-1" class="gis-table-bordered " >

	<tr>
		<th>ID No. | Name</th>
		<td>
			<input class="pdl05" id="part" value="<?php echo $code; ?>"  />
			<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart(limits);return false;" />		
		</td>
	</tr>	




</table></p>


<script>


</script>