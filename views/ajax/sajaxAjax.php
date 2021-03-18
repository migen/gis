<?php 

// pr($data);
// $bs=2015;
pr($_SESSION['q1']);



?>





<h5>
	Contact Ajax | <?php $this->shovel('homelinks'); ?>


	
</h5>

<form method="POST" >
<p>
<table id="tbl-1" class="gis-table-bordered " >

	<tr>
		<th>ID No. | Name</th>
		<td>
			<input class="pdl05" id="part" autofocus placeholder="name" />
			<input type="submit" name="auto" value="Filter" onclick="getRowsByPart(limits);return false;" />		
			<input type="submit" name="auto" value="Sajax" onclick="sajaxFilter(limits);return false;" />		
			<input type="submit" name="auto" value="Edit" onclick="sajaxFilterEdit(limits);return false;" />		
		</td>
		<td>
			Code: <input id="code" name="code"  /> 		
		</td>
	</tr>	
</table></p>



</form>


<div id="names" >names</div>






<script>
var gurl = "http://<?php echo GURL; ?>";
var limits='20';


$(function(){
	// $('#names').hide();
	// $('html').live('click',function(){ $('#names').hide(); });
	
})

function axnSelected(code){
	$("#code").val(code);

}


function getRowsByPart(limits=20){
	var part = $('#part').val();	
	var vurl = gurl+'/ajax/sajax.php';	
	var task = "xgetRowsByPart";	
	// alert(vurl+part+task);
	$.ajax({
		url: vurl,dataType: "json",type: "POST",
		data: 'task='+task+'&part='+part+'&limits='+limits,async: true,
		success: function(s) {  // console.log(s);
			var cs = s.length;
			content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
for (var i = 0; i < cs; i++) {			
	content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="axnSelected('+s[i].code+');return false;" >'+s[i].name+' Code: '+s[i].code+'</span></p>';
}
			$('#names').append(content).show();content = '';

		}		  
    });					
}	/* fxn */


function sajaxFilter(limits=20){
	var part = $('#part').val();	
	var vurl = gurl+'/ajax/sajax.php';	
	var task = "sajaxFilter";	
	// alert(vurl+part+task);
	$.ajax({
		url: vurl,dataType: "json",type: "POST",
		data: 'task='+task+'&part='+part+'&limits='+limits,async: true,
		success: function(s) {  // console.log(s);
			var cs = s.length;
			content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
for (var i = 0; i < cs; i++) {			
	content += '<p> <span id="'+s[i].id+'" class="txt-blue b u" onclick="axnSelected('+s[i].code+');return false;" >'+s[i].name+' Code: '+s[i].code+'</span></p>';
}
			$('#names').append(content).show();content = '';

		}		  
    });					
}	/* fxn */


function sajaxFilterEdit(limits=20){
	var part = $('#part').val();	
	var vurl = gurl+'/ajax/sajax.php';	
	var task = "sajaxFilter";	
	// alert(vurl+part+task);
	$.ajax({
		url: vurl,dataType: "json",type: "POST",
		data: 'task='+task+'&part='+part+'&limits='+limits,async: true,
		success: function(s) {  // console.log(s);
			var cs = s.length;
			content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
for (var i = 0; i < cs; i++) {			
	content += '<a href="'+gurl+'/contacts/ucis/'+s[i].id+'" target="_blank" id="'+s[i].id+'" class="txt-blue b u" >'+s[i].name+' Code: '+s[i].code+'</a><br />';
}
			$('#names').append(content).show();content = '';

		}		  
    });					
}	/* fxn */



</script>


