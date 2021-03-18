<table id="tbl-1" class="gis-table-bordered " >

<tr>
<th class="bg-gray3" > ID Number</th>
<td><input class="pdl05" id="code"  /></td>
<td><input type="submit" name="auto" value="Go" onclick="gotoPage();return false;" /></td>
</tr>

<tr><th class="bg-gray3" >Name | Surname</th>
<td><input class="pdl05" id="part" /></td>
<td><input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart();return false;" /></td>
</tr>


<tr>
<th class="bg-gray3" > ID <span class="hd" >HD</span></th>
<td><input class="pdl05" id="codes"  /></td>
<td><input type="submit" name="auto" value="Filter" onclick="xgetContactsByCode();return false;" /></td>
</tr>


</table>





<script>
var gurl = 'http://<?php echo GURL; ?>';




function gotoPage(){
	var code = $('#code').val();		
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



</script>

<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>

