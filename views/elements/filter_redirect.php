<?php 

	// pr($_SESSION['q']);
		
	

?>

<table class="gis-table-bordered " >
	<tr>
		<th>Name</th>
		<td>
			<input class="pdl05" id="part" autofocus  />
			<input type="submit" name="auto" value="Filter" onclick="xgetDataByPart(limits);return false;" />		
		</td>
	</tr>	
</table>

<div id="names">names</div>

<script>




function xgetDataByPart(limits=3){
	var part = $('#part').val();	
	var vurl = gurl+'/ajax/xgetData.php';	
	var task = "xgetDataByPart";
	// alert(part+vurl+task);
	
	$.ajax({
		url: vurl,dataType:"json",type:"POST",async: true,
		data: 'task='+task+'&part='+part+'&dbtable='+dbtable+'&limits='+limits,						
		success: function(s) {
			var cs = s.length;
			content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
			console.log(s);
for (var i = 0; i < cs; i++) {			
	content+='<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="axnFilter('+s[i].id+');return false;" >'+s[i].code+' - '+s[i].name+'</span> - #'+s[i].id+'</p>';
}
			$('#names').append(content).show();
			content = '';

		}		  
    });				
	
}




</script>

