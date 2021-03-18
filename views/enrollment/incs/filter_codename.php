

<p>
<table id="tbl-1" class="gis-table-bordered " >

	<tr>
		<th>ID No. | Name</th>
		<td>
			<input class="pdl05" id="part" placeholder="name" />
			<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart(limits);return false;" />		
		</td>
		<td class="" ><button onclick="registerStudent();" >Register</button></td>
	</tr>	




</table></p>


<script>

var GURL="http://<?php echo GURL; ?>";

function registerStudent(){
	var code=$('#part').val();
	var url=GURL+'/registration/one?code='+code;
	window.open(url, '_blank');	
}

</script>