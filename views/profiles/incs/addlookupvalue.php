<?php 

$tables=array('nationalities','religions');

// pr($tables);

?>


<div class="third" >
<table class="gis-table-bordered" >
<tr><th><input id="newValue"  /></th>
<td>
<select id="tbl" >
<option value="" >Lookup</option>
<?php foreach($tables AS $sel): ?>
	<option><?php echo $sel; ?></option>
<?php endforeach; ?>
</select>
</td>
<td><button onclick="xsaveNewValue();" >Add</button></td>
</tr>

</table>
</div>


<script>

function xsaveNewValue(){
	var val=$('#newValue').val();
	var tbl = document.getElementById("tbl").value;
	// alert(val+', table: '+tbl);
	if(tbl==""){ alert('No lookup table selected.'); } else {
		
		var vurl = gurl+'/ajax/xnewlookups.php';		
		var task = "addlookupvalue";		
		$.ajax({
			url: vurl,dataType: "json",type: 'POST',async: true,
			data: 'task='+task+'&val='+val+'&tbl='+tbl,
			success: function() { location.reload(); }		  
		});					
	
	}
	
}



</script>

