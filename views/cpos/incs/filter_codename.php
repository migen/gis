<?php 

// pr($_SESSION['q']);

?>

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



<script>


// js.str.replace
function gotoPage(){	
	var ocode = $('#code').val();		
	var code=ocode.replace(/-/g,"");
	
	var vurl = gurl+'/ajax/xgetContacts.php';	
	var task = "xgetContactByCode";
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&code='+code,				
		async: true,
		success: function(s) { 	
			if(s){
				var rurl = gurl+'/'+page+'/'+s.id;
				window.location = rurl;
			} else {
				alert('No record found.');
			}
			
		}		  
    });				
	
}	


function redirContact(ucid){
	var url = gurl+'/cpos/add/'+ucid;	
	window.location = url;		
}



</script>

<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>
