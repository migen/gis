<?php 

$dbo=PDBO;
$dbcontacts="{$dbo}.`00_contacts`";

?>

<h5>
	College Student | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'uniregister/add'; ?>" >Add</a>
	
	
</h5>




<div class="third" >
<table class="accordion menu gis-table-bordered table-altrow" >
	<tr><th class="center headrow vc300" onclick="accordionTable('menu');" >Menu</th></tr>
	<tr><td class="" ><a href="<?php echo URL.'uniregister/student'; ?>" >Register</a></td></tr>
	<tr><td class="" ><a href="<?php echo URL.'unistudents/courses'; ?>" >Student Courses</a></td></tr>

</table>
<br />
</div>

<div class="third" >
<table class="gis-table-bordered table-altrow" >
<tr><th class="headrow center" >Student Finder</th></tr>
<tr><th><span class="b" >ID</span> <input id="id" class="center pdl05 vc60" value=0  readonly >
	<button onclick="jsredirect('unistudents/scid/'+$('#id').val());" >Go</button>
</th></tr>
<tr><th><input class="pdl05" id="part" value="" autofocus /> </th></tr>
<tr><td><input type="submit" class="vc150" value="Filter" onclick="xgetDataByTable('<?php echo $dbcontacts; ?>');return false;" /></td></tr>
</table>
</div>

<div class="hd" id="names" >names</div>


<script>

var gurl="http://<?php echo GURL; ?>";
var limits=30;


$(function(){
	$("#names").hide();	
	$('html').live('click',function(){ $('#names').hide(); });

	
})


function axnFilter(id){
	$("#id").val(id);
	
}	/* fxn */


function redirContact(ucid){
	var url = gurl+'/uniregister/student/'+ucid;	
	window.location = url;		
}



</script>


<script type="text/javascript" src='<?php echo URL."views/js/filters_general.js"; ?>' ></script>

