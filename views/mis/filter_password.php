<?php 

	$srid=$_SESSION['srid'];

?>

<p>
<table id="tbl-1" class="gis-table-bordered " >

<tr>
	<th>Module</th>
	<td colspan="2" >		
	<select name="module" class="vc150" >
		<option value="1" >Password</option>
<?php if(($srid==RMIS) || ($srid==RREG)): ?>

<?php endif; ?>		
	</select>
	</td>
</tr>


<tr>
	<th> ID No</th>
	<td><input class="pdl05" id="code" value="" /></td>
	<td><input type="submit" name="auto" value="Go" onclick="gotoPage();return false;" /></td>
</tr>

<tr>
	<th>ID No | Name</th>
	<td><input class="pdl05" id="part"   /></td>
	<td><input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart(limits);return false;" /></td>
</tr>	


</table></p>



<script>
var gurl = 'http://<?php echo GURL; ?>';
var page = 'rcards/scid';
var limits = '20';
var module;




function getPage(){	
	module = $('select[name="module"]').val();	
	switch (module)
	{
	   case "1":
			page = "rcards/scid"; break;
			
			
	   default: 
			page = "rcards/scid"; break; 
	}		
	return page;
}



function gotoPage(){
	var code = $('#code').val();		
	var vurl = gurl+'/ajax/xgetContacts.php';	
	var task = "xgetContactByCode";
	page=getPage();
			
	$.ajax({
		url: vurl,
		dataType: "json",
		type: 'POST',
		data: 'task='+task+'&code='+code,				
		async: true,
		success: function(s) { 	
			if(s){
				var rurl = gurl+'/'+page+'/'+s.id;
				window.open(rurl);
			} else {
				alert('No record found.');
			}
			
		}		  
    });				
	
}	




function redirContact(ucid){
	page=getPage();
	var url = gurl+'/'+page+'/'+ucid;	
	window.open(url);		
}





</script>

<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>
