<?php 

// pr($_SESSION['q']);

$dbg=VCPREFIX.$sy.US.DBG;
$dbcourses="{$dbg}.05_courses";

?>

<h5>
	Scores Filter | <?php $this->shovel('homelinks'); ?>
	| <span class="b" >SY</span>: <input id="sy" type="number" class="vc100" value="<?php echo $sy; ?>" >
	<span class="b" >Qtr</span>: <input id="qtr" type="number" class="vc50" value="<?php echo $qtr; ?>" >
	<button onclick="jsredirect('scores/filter/'+$('#sy').val()+'/'+$('#qtr').val());" >Go</button>
		
</h5>



<div class="third" >
<table class="gis-table-bordered table-altrow" >
<tr><th class="headrow center" >Course Finder</th></tr>
<tr><th><input class="pdl05" id="part" value=""  /> </th></tr>
<tr><td><input type="submit" class="vc150" value="Filter" onclick="xgetDataByTable('<?php echo $dbcourses; ?>');return false;" /></td></tr>
</table>
</div>

<div class="" id="names" >names</div>


<script>

var gurl="http://<?php echo GURL; ?>";
var limits=30;
var sy="<?php echo $sy; ?>";
var qtr="<?php echo $qtr; ?>";
var limits=100;
var crs=$("#id").val();

$(function(){
	// alert(sy+'/'+qtr);
	// alert(gurl+'/'+limits+'/'+crs);
	$("#names").hide();	
	$('html').live('click',function(){ $('#names').hide(); });

	
})


function axnFilter(id){
	var url = gurl+'/teachers/scores/'+id+'/'+sy+'/'+qtr;
	window.location=url;			
	
}	/* fxn */


function redirContact(ucid){
	var url = gurl+'/uniregister/student/'+ucid;	
	window.location = url;		
}



</script>


<script type="text/javascript" src='<?php echo URL."views/js/filters_general.js"; ?>' ></script>

