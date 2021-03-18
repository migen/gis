<h5> Duplicates Attendance Employees Logs </h5>


<table class="gis-table-bordered table-fx" >
<tr>
	<th>Del</th>
	<th>AttID</th>
	<th>UCID</th>
	<th>Date</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><a onclick="deleteAtte(<?php echo $duplicates[$i]['attid']; ?>)" >Del</a></td>
	<td><?php echo $duplicates[$i]['attid']; ?></td>
	<td><?php echo $duplicates[$i]['ucid']; ?></td>
	<td><?php echo $duplicates[$i]['date']; ?></td>
</tr>
<?php endfor; ?>
</table>



<script>

var gurl     = 'http://<?php echo GURL; ?>';

$(function(){

})

function deleteAtte(attid){


	var vurl 	= gurl + '/ajax/xattd.php';	
	var task	= "deleteAtte";
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&attid='+attid,				
		async: true,
		success: function() { }		  
    });				


}


</script>