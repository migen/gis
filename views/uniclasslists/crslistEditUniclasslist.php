<?php 


$dbg=PDBG;
$dbgrades="{$dbg}.10_grades";

?>

<h5>
	Courselist <?php echo $course['name']; ?>
	| <?php $this->shovel('homelinks'); ?>
	| <span onclick="traceshd();" class="b u" >ID</span>
	
	
</h5>

<?php 
// pr($course); 
// pr($rows[0]);
?>

<span class="shd" ><?php require_once(SITE.'views/college/incs/courseDetails.php'); ?></span>

<?php if(isset($_GET['edit']) && $is_current): ?>
	<p><?php $this->shovel('filter_codename'); ?>
	<span class="b" >Scid </span>
	<span><input id="id" class="vc80" readonly />&nbsp;<button onclick="xaddStudentToUnicourse();" >Register</button></span>
	</p>
	<div id="names" >names</div>
<?php endif; ?>


<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th class="shd" >Scid</th>
	<th>Student</th>
	<th></th>
</tr>
<tbody id="tbody" >
<?php for($i=0;$i<$count;$i++): ?>
<?php $gid=$rows[$i]['gid']; ?>
<tr id="trow-<?php echo $i; ?>" >
	<td><?php echo $i+1; ?><span class="shd" > gid#<?php echo $gid; ?></span></td>
	<td class="shd" ><?php $scid=$rows[$i]['scid']; echo $scid; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
<td><?php if($is_current): ?><button class="" onclick="confirmXdelrow(dbgrades,<?php echo $gid.','.$i; ?>);" >Drop</button><?php endif; ?></td>
</tr>
<?php endfor; ?>
</tbody>
</table>


<script>
var gurl = "http://<?php echo GURL; ?>";
var limits='20';
var crs="<?php echo $crs; ?>";
var sem="<?php echo $sem; ?>";
var dbgrades="<?php echo $dbgrades; ?>";

$(function(){
	
	shd();
	$('#names').hide();
	$('html').live('click',function(){ $('#names').hide(); });

	
})

function redirContact(id){
	$("#id").val(id);
}	/* fxn */

function xaddStudentToUnicourse(){
	var scid=$('#id').val();
	var vurl=gurl+"/ajax/xmanageUnigrades.php";	
	var task="xaddStudentToUnicourse";		
	
	$.ajax({
		url: vurl,dataType: "json",type: "POST",async: true,
		data: 'task='+task+'&scid='+scid+'&sem='+sem+'&crs='+crs,				
		success: function(s) { 			
			var content="<tr><th class='center' >"+s.id+"</th><th colspan=2>"+s.name+"</th></tr>";
			$("#tbody").append(content);
		}		  
    });				
	
}	/* fxn */


function confirmXdelrow(dbtbl,id,i){
	// alert(dbtbl+', id: '+id+', i: '+i);
	if(confirm("Sure?")){
		xdelrow(dbtbl,id,i);		
	}	
}	/* fxn */




</script>

<script type="text/javascript" src='<?php echo URL."views/js/lookups.js"; ?>' ></script>
