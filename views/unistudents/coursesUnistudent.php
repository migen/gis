<?php 

$dbg=PDBG;
$dbcourses="{$dbg}.01_courses";
$dbgrades="{$dbg}.10_grades";

debug($student);
if(!empty($rows)){ debug($rows[0]);  }

?>

<h5>
	Student Courses | <?php $this->shovel('homelinks'); ?>
	| <span class="u" onclick="traceshd();"  >ID</span>

<?php if(!isset($_GET['all'])): ?>
	| <a href="<?php echo URL.'unistudents/courses/'.$scid.'&all'; ?>" >All</a>
<?php else: ?>
	<?php if($sem==1): ?>
		| <a href="<?php echo URL.'unistudents/courses/'.$scid.DS.$sy.DS.'2'; ?>" >Sem2</a>	
	<?php else: ?>
		| <a href="<?php echo URL.'unistudents/courses/'.$scid.DS.$sy.DS.'1'; ?>" >Sem1</a>	
	<?php endif; ?>
<?php endif; ?>


</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
<th class="shd" ><?php echo $student['scid']; ?></th>
<th><?php echo $student['code']; ?></th>
<th><?php echo $student['name']; ?></th>
<th><?php echo $student['classroom']; ?></th>
<th><?php echo 'Year '.$student['level_id']; ?></th>
</tr>
</table>
<br />

<div class="third" >
<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th class="shd" >Crs</th>
	<th>Sem</th>
	<th>Course</th>
	<th>Drop</th>
</tr>
<tbody id="crsbody" >
<?php for($i=0;$i<$count;$i++): ?>
<tr id="trow-<?php echo $i; ?>" >
	<?php $gid=$rows[$i]['gid']; ?>
	<td><?php echo $i+1; ?><span class="shd" ><?php echo ' G#'.$gid; ?></span></td>
	<td class="shd center" ><?php $crs=$rows[$i]['crs']; echo $crs; ?></td>
	<td class="center" ><?php $sem=$rows[$i]['semester']; echo $sem; ?></td>
	<td><?php echo $rows[$i]['course']; ?></td>
	<td><button class="" onclick="confirmXdelrow(dbgrades,<?php echo $gid.','.$i; ?>);" >Drop</button></td>
</tr>
<?php endfor; ?>
</tbody>
</table>
</div>	<!-- main -->


<?php if($is_current): ?>
<div class="third" >
	<table class="gis-table-bordered table-altrow" >
	<tr><th><span class="b" >ID</span> <input id="id" class="pdl05 vc60" readonly >
		<button class="" onclick="xaddCourseGrade();" >Add</button>
	</th></tr>
	<tr><th><input class="pdl05" id="part" value=""  /> </th></tr>
	<tr><td><input type="submit" class="vc150" value="Find Course" onclick="xgetDataByTable('<?php echo $dbcourses; ?>');return false;" /></td></tr>
	</table>
	<div class="hd" id="names" >names</div>
</div>
<?php endif; ?>	<!-- current -->

<script>

var gurl="http://<?php echo GURL; ?>";
var limits=30;
var scid="<?php echo $scid; ?>";
var sem="<?php echo $sem; ?>";
var dbgrades="<?php echo $dbgrades; ?>";

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
	var vurl=gurl + '/ajax/xmanageUnigrades.php';	
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

