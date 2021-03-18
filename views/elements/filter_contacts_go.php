<?php 


$contacts = $data['contacts'];
$new_customer = $data['new_customer'];
$autofocus = isset($data['nofocus'])? NULL:'autofocus';
// pr($data);

// echo "nofocus: ".$data['nofocus']." <br />";
// echo "autofocus: $autofocus <br />";

?>

<table id="tbl-1" class="gis-table-bordered " >

<tr><th class="bg-gray3" >Name | Surname</th>
<td><input class="pdl05" id="part" <?php  echo $autofocus; ?>  /></td>
<td><input type="submit" name="auto" value="Filter" onclick="xgetContactsByPart();return false;" /></td>
</tr>

<tr>
<th class="bg-gray3" > ID <span class="hd" >HD</span></th>
<td><input class="pdl05" id="codes"  /></td>
<td><input type="submit" name="auto" value="Filter" onclick="xgetContactsByCode();return false;" /></td>
</tr>





</table></p>





<script>
var gurl = 'http://<?php echo GURL; ?>';


function xaddContact(fullname,roleid){
var vurl 	= gurl + '/ajax/xcontacts.php';	
var task	= "xaddContact";
	
$.ajax({
	url: vurl,dataType: "json",type: 'POST',async: true,
	data: 'task='+task+'&roleid='+roleid+'&fullname='+fullname,						
	success: function() { location.reload(); }		  
});				
	
}	/* fxn */



</script>

<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>

