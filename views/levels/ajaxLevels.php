<h5>
	Ajax Loaded Levels
	| <?php $this->shovel('homelinks'); ?>
	| <span onclick="xloadLevels();" >Levels</span>
	| <span onclick="xloadLevelsTable();" >Table</span>
		
</h5>

<?php 

	// if(isset($_SESSION['q'])){ pr($_SESSION['q']); }
	
	
?>

<div id="names" >names</div>
<ol id="olLevels" >Ordered List</ol>

<div class="shd" >
<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Name</th>
</tr>
<tbody id="tblLevels" ></tbody>
</table>

</div>

<div class="ht50" ></div>

<script>

$(function(){
	// xloadLevels();
	xloadLevelsOL();
	xloadLevelsTable();
}) 



var gurl="http://<?php echo GURL; ?>";

function xloadLevelsOL(){
	$("#names").hide();
	var vurl='../ajax/xlevels.php';	
	var task="xgetLevels";	
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',data: 'task='+task,async: true,
		success: function(s) { 
			var cs=s.length;content = '';
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
			for (var i=0;i<cs;i++) {			
				content+='<li>'+s[i].name+'</li>';
			}
			$('#olLevels').append(content).show();content = '';
		}		  
    });					
}	/* fxn */


function xloadLevelsTable(){
	$("#names").hide();
	var vurl='../ajax/xlevels.php';	
	var task="xgetLevels";	
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',data: 'task='+task,async: true,
		success: function(s) { 
			var cs=s.length;content = '';
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
			for (var i=0;i<cs;i++) {			
				content+='<tr><td>'+(i+1)+'</td><td>'+s[i].id+'</td><td>'+s[i].name+'</td></tr>';
			}
			$('#tblLevels').append(content).show();content = '';
		}		  
    });					
}	/* fxn */

function xloadLevels(){
	var vurl='../ajax/xlevels.php';	
	var task="xgetLevels";	
	$.ajax({
		url: vurl,dataType: "json",type: 'POST',data: 'task='+task,async: true,
		success: function(s) { 
			var cs=s.length;content = '';
			$('#names').html('<h4 class="txt-blue u" onclick="closeFilter();return false;" >Close (X) </h4>');
			if(!s) { content += '<h2 class="red" >No record found!</h2>'; }
			for (var i=0;i<cs;i++) {			
				content += '<p><span id="'+s[i].id+'" class="u" >'+s[i].name+' #'+s[i].id+'</span></p>';
			}
			$('#names').append(content).show();content = '';
		}		  
    });					
}	/* fxn */

function redirLookup(id){ alert(id); }


</script>
