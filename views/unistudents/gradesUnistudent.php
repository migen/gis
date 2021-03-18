<?php 

$dbo=PDBO;
$dbcontacts="{$dbo}.`00_contacts`";

// pr($data);

?>

<h5>
	Student Grades | <?php $this->shovel('homelinks'); ?>
	| <span class="u" onclick="traceshd();"  >ID</span>



</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
<th><?php echo $student['code']; ?></th>
<th><?php echo $student['name']; ?></th>
<th><?php echo $student['classroom']; ?></th>
</tr>
</table>
<br />

<div style="float:left;width:40%" >
<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Crs</th>
	<th>Course</th>
	<th>Teacher</th>
	<th>FG</th>
</tr>
<tbody id="crsbody" >
<?php for($i=0;$i<$count;$i++): ?>
<tr id="trow-<?php echo $i; ?>" >
	<?php $gid=$rows[$i]['gid']; ?>
	<td><?php echo $i+1; ?><span class="shd" ><?php echo ' #'.$gid; ?></span></td>
	<td class="center" ><?php $crs=$rows[$i]['crs']; echo $crs; ?></td>
	<td><?php echo $rows[$i]['course']; ?></td>
	<td><?php echo $rows[$i]['teacher']; ?></td>
	<td class="center" ><?php $fg=(int)$rows[$i]['grade']+(int)$rows[$i]['bonus']; echo $fg; ?></td>
</tr>
<?php endfor; ?>
</tbody>
</table>
</div>	<!-- main -->


<div class="third" >
	<table class="gis-table-bordered table-altrow" >
	<tr><th class="headrow" >Find Student</th></tr>
	<tr><th><span class="b" >ID</span> <input id="id" class="pdl05 vc60" readonly >
		<button class="" onclick="jsredirect('unistudents/grades/'+$('#id').val());" >Go</button>
	</th></tr>
 	<tr><th><input class="pdl05" id="part" value=""  /> </th></tr>
	<tr><td><input type="submit" class="vc150" value="Filter" onclick="xgetDataByTable('<?php echo $dbcontacts; ?>');return false;" /></td></tr>
	</table>
	<div class="hd" id="names" >names</div>
</div>

<script>

var gurl="http://<?php echo GURL; ?>";
var limits=30;
var scid="<?php echo $scid; ?>";
var sem="<?php echo $sem; ?>";

$(function(){
	
	// alert(scid+', sem: '+sem);
	shd();
	$("#names").hide();	
	$('html').live('click',function(){ $('#names').hide(); });

	
})


function axnFilter(id){
	$("#id").val(id);
	
}	/* fxn */

function xaddCourseGrade(){
	var crs=$('#id').val();
	var vurl=gurl + '/ajax/xaddUnigrades.php';	
	var task="xaddUnigrade";		
	
	$.ajax({
		url: vurl,dataType: "json",type: "POST",async: true,
		data: 'task='+task+'&scid='+scid+'&sem='+sem+'&crs='+crs,				
		success: function(s) { 			
			var content="<tr><th></th><th class='center' >"+s.id+"</th><th colspan=2>"+s.name+"</th></tr>";
			$('#crsbody').append(content);

		}		  
    });				
	
	
	
}	/* fxn */

function confirmXdelrow(dbtbl,id,i){
	if(confirm("Sure?")){
		xdelrow(dbtbl,id,i);		
	}	
}	/* fxn */



function redirContact(ucid){
	var url = gurl+'/uniregister/student/'+ucid;	
	window.location = url;		
}



</script>


<script type="text/javascript" src='<?php echo URL."views/js/filters_general.js"; ?>' ></script>

