<?php 

// pr($_SESSION['q']);


?>

<script>

var gurl     = 'http://<?php echo GURL; ?>';

window.onload = function() {
    if (!window.jQuery) { alert("Jquery NOT Loaded!"); }
}

$(function(){

})



function xgetValOK(tbl){
	var vurl 	= gurl + '/ajax/ajax.php';	/* fast basic - procedural */
	var id = $('#id').val();
	// alert(vurl+',id: '+id+', tbl: '+tbl);
	$.post(vurl,{task:tbl,id:id},function(s){
		$("#code").val(s.code);
		$("#bname").val(s.name);
		alert(s);
		console.log(s);
	},"json")


}	/* fxn */


function xgetVal(tbl){
	var vurl 	= gurl + '/ajax/ajax.php';	/* fast basic - procedural */
	var id = $('#id').val();
	// alert(vurl+',id: '+id+', tbl: '+tbl);

	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+tbl+'&id='+id,				
		async: true,
		success: function(s) { 
			alert('xval2');
			$("#code").val(s.code);
			$("#bname").val(s.name);
		}		  
	});			

	
	
	
}	/* fxn */



function xgetContact(){
	var ucid = $('#ucid').val();
	// var vurl 	= gurl + '/ajax/xgetContact';	/* load library load - mvc */
	var vurl 	= gurl + '/ajax/xgetContact.php';	/* fast basic - procedural */
	alert(vurl);
	
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'ucid='+ucid,				
		async: true,
		success: function(s) { 
			alert(s);
			$('#pcid').val(s.parent_id);
			$('#name').val(s.name);
		}		  
	});			


	
	
}


</script>

<h5>
	Ajax Lab
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 	

</h5>

<table class="gis-table-bordered"  >
	<tr><td>UCID</td><td><input id="ucid" value="127"  /></td></tr>
	<tr><td>PCID</td><td><input id="pcid"  /></td></tr>
	<tr><td>Name</td><td><input id="name"  /></td></tr>
	<tr><td colspan="2" ><input type="submit" onclick="xgetContact();"  ></td></tr>
</table>


<hr />

<table class="gis-table-bordered" >

<tr><td>ID</td><td><input id="id" value="5" /></td></tr>
<tr><td>Code</td><td><input id="code"  /></td></tr>
<tr><td>Name</td><td><input id="bname"  /></td></tr>

</table>

<p>
 	  <input type="submit" onclick="xgetVal('contact');" value="Contact"  >
	| <input type="submit" onclick="xgetVal('level');" value="Level"  >
	| <input type="submit" onclick="xgetVal('role');" value="Role"  >	
</p>

