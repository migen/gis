<?php 

$dbcontacts=PDBO.".`00_contacts`";
?>

<h5>
	Register New | <?php $this->shovel('homelinks'); ?>
	
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr><td><input class="pdl05" id="part" value=""  />
<input type="submit" class="vc100" value="Filter" onclick="xgetDataByTable('<?php echo $dbcontacts; ?>');return false;" /></td></tr>

</table>
<br />

<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>ID No.</th><td><input name="contact[code]" class="vc200" ></td></tr>
<tr><th>Last Name</th><td><input name="profile[last_name]" class="vc200" ></td></tr>
<tr><th>First Name</th><td><input name="profile[first_name]" class="vc200" ></td></tr>
<tr><th>Middle Name</th><td><input name="profile[middle_name]" class="vc200" ></td></tr>
<tr><th>Gender</th>
	<td><select name="contact[is_male]" value="<?php echo $row['is_male']; ?>" class="vc80" min=0 max=1 type="number" />
	<option value=1 >Boy</option>
	<option value=0 >Girl</option>
	</select></td>
</tr>		




</table>

<p><input type="submit" name="submit" value="Create"  /></p>

</form>


<div class="hd" id="names" >names</div>


<script>

var gurl="http://<?php echo GURL; ?>";
var limits=30;

$(function(){
	$("#names").hide();	
	$('html').live('click',function(){ $('#names').hide(); });

	
})


function axnFilter(id){
	var url = gurl+'/uniregister/student/'+id;	
	window.location = url;		
	
}	/* fxn */



</script>


<script type="text/javascript" src='<?php echo URL."views/js/filters_general.js"; ?>' ></script>

