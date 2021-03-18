<?php 

$dbg=PDBG;
$dbcourses="{$dbg}.01_courses";

?>

<h5>
	Courses | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'unicourses/create'; ?>" >Create+</a>
	| <a href="<?php echo URL.'unilocks'; ?>" >Locks</a>
	| <a href="<?php echo URL.'unicourses/upname'; ?>" >Upname</a>
		
</h5>




<div class="third" >
<table class="accordion menu gis-table-bordered table-altrow" >
	<tr><th class="center headrow vc300" onclick="accordionTable('menu');" >Menu</th></tr>
	<tr><td class="" ><a href="<?php echo URL.'uniclassrooms'; ?>" >Classrooms</a></td></tr>
	<tr><td class="" ><a href="<?php echo URL.'unicourses/set'; ?>" >All Courses</a></td></tr>

</table>
<br />
</div>

<div class="third" >
<table class="gis-table-bordered table-altrow" >
<tr><th class="headrow center" >Course Finder</th></tr>
<tr><th><span class="b" >ID</span> <input id="id" class="center pdl05 vc60" value=0  readonly >
	<button onclick="jsredirect('unicourses/edit/'+$('#id').val());" >Go</button>
</th></tr>
<tr><th><input class="pdl05" id="part" value=""  /> </th></tr>
<tr><td><input type="submit" class="vc150" value="Filter" onclick="xgetDataByTable('<?php echo $dbcourses; ?>');return false;" /></td></tr>
</table>
</div>

<div class="hd" id="names" >names</div>


<script>

var gurl="http://<?php echo GURL; ?>";
var limits=30;
var crs=$("#id").val();

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

