
<?php 

// pr($_SESSION['q']);

$dbo=PDBO;$dbg=PDBG;
$dbcontacts="{$dbo}.`00_contacts`";  

$dbunisubjects="{$dbo}.`05_subjects`";
$dbunisections="{$dbg}.01_sections";
$dbuniclassrooms="{$dbg}.01_classrooms";
$dbunicourses="{$dbg}.01_courses";


$dbsubjects="{$dbo}.`05_subjects`";
$dbsections="{$dbo}.`05_sections`";
$dbclassrooms="{$dbg}.05_classrooms";
$dbcourses="{$dbg}.05_courses";


?>

<h5>
	ID Finder 	
	<input id="id" class="red pdl05 vc60" readonly >	
	<?php $this->shovel('homelinks'); ?>
	
	
</h5>


<table class="gis-table-bordered table-altrow" >
<tr><th><span class="b" >ID</span> <input id="id" class="red pdl05 vc60" readonly ><br /></th></tr>
<tr><th><input class="pdl05" id="part" value=""  /> </th></tr>
<tr><td><input type="submit" class="vc150" value="Teachers" onclick="xgetDataByTable('<?php echo $dbcontacts; ?>');return false;" /></td></tr>
<tr><td><input type="submit" class="vc150" value="College Subjects" onclick="xgetDataByTable('<?php echo $dbunisubjects; ?>');return false;" /></td></tr>
<tr><td><input type="submit" class="vc150" value="College Classrooms" onclick="xgetDataByTable('<?php echo $dbuniclassrooms; ?>');return false;" /></td></tr>
<tr><td><input type="submit" class="vc150" value="College Sections" onclick="xgetDataByTable('<?php echo $dbunisections; ?>');return false;" /></td></tr>
<tr><td><input type="submit" class="vc150" value="College Courses" onclick="xgetDataByTable('<?php echo $dbunicourses; ?>');return false;" /></td></tr>

<tr><th>BED / K12</th></tr>
<tr><td><input type="submit" class="vc150" value="Subjects" onclick="xgetDataByTable('<?php echo $dbsubjects; ?>');return false;" /></td></tr>
<tr><td><input type="submit" class="vc150" value="Classrooms" onclick="xgetDataByTable('<?php echo $dbclassrooms; ?>');return false;" /></td></tr>
<tr><td><input type="submit" class="vc150" value="Sections" onclick="xgetDataByTable('<?php echo $dbsections; ?>');return false;" /></td></tr>
<tr><td><input type="submit" class="vc150" value="Courses" onclick="xgetDataByTable('<?php echo $dbcourses; ?>');return false;" /></td></tr>

<tr><td><select name="" id="" class="" >
<option value=0 >Select One</option>
<?php foreach($levels AS $sel): ?>
<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$row['level_id'])? 'selected':NULL; ?> >
	<?php echo $sel['name'].' ('.$sel['id'].')'; ?></option>
<?php endforeach; ?>
</select></td></tr>


</table>
<br />


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

