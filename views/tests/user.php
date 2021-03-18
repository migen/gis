<?php 

pr($_SESSION['q']);

?>

<h5>
	JS Test - User

</h5>




<p>
<table class="gis-table-bordered " >
	<tr>
		<th>ID Num | Name</th>
		<td>
			<input class="pdl05" id="part" autofocus  />
			<input type="submit" name="auto" value="Filter" onclick="xgetPersonsByPart(limits);return false;" />		
		</td>
	</tr>	
</table></p>

<div id="names" ></div>

<script>
var gurl = 'http://<?php echo GURL; ?>';
var limits='20';


$(function(){
	$('html').live('click',function(){ $('#names').hide(); });


})


function redirPerson(ucid){
	var url=gurl+'/students/sectioner/'+ucid;	
	alert(url);
	// window.location = url;		
}



</script>


<script type="text/javascript" src='<?php echo URL."views/js/testlookups.js"; ?>' ></script>
