<h5>
	Course Edit 
	| ID <input id="id" class="red pdl05 vc60" readonly >
	<?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'cr'; ?>" >Classrooms</a>
	| <a href="<?php echo URL.'cr/sessionizeLSM'; ?>" >Reset LSM</a>
	| <a href="<?php echo URL.'cr/ltd/'.$crid; ?>" >LTD</a>
	
	
</h5>


<?php 

debug($row);

$dbo=PDBO;$dbg=PDBG;
$dbcontacts="{$dbo}.`00_contacts`";  
$dbsubjects="{$dbo}.`05_subjects`";
$dbsections="{$dbo}.`05_sections`";
$dbclassrooms="{$dbg}.05_classrooms";
$dbcourses="{$dbg}.05_courses";



?>





<div class="half" >
<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>ID</th><td><?php echo $row['id']; ?></td></tr>
<tr><th>Teacher</th><td><?php echo $row['teacher']; ?></td></tr>
<tr><th>Classroom</th><td><?php echo $row['classroom']; ?></td></tr>
<?php foreach($columns_array AS $col): ?>
<tr>
	<th><?php echo $col; ?></th>
	<td><input name="post[<?php echo $col; ?>]" value="<?php echo $row[$col]; ?>" ></td>	
</tr>
<?php endforeach; ?>

<tr><th colspan=2><input type="submit" name="submit" value="Submit" onclick="return confirm('Sure?');" ></th></tr>

</table>
</form>

<div class="ht100" ></div>

</div>	<!-- row -->

<div class="third" >

<table class="gis-table-bordered table-altrow" >
<tr><th class="center headrow" >ID Finder</th></tr>
<tr><th><input class="pdl05" id="part" value=""  /> </th></tr>
<tr><td><input type="submit" class="vc150" value="Teachers" onclick="xgetDataByTable('<?php echo $dbcontacts; ?>');return false;" /></td></tr>
<tr><td><input type="submit" class="vc150" value="Subjects" onclick="xgetDataByTable('<?php echo $dbsubjects; ?>');return false;" /></td></tr>
<tr><td><input type="submit" class="vc150" value="Classrooms" onclick="xgetDataByTable('<?php echo $dbclassrooms; ?>');return false;" /></td></tr>
<tr><td><input type="submit" class="vc150" value="Sections" onclick="xgetDataByTable('<?php echo $dbsections; ?>');return false;" /></td></tr>
<tr><td><input type="submit" class="vc150" value="Courses" onclick="xgetDataByTable('<?php echo $dbcourses; ?>');return false;" /></td></tr>

</table>

<div id="names" >names</div>

</div><!-- finder -->


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





</script>


<script type="text/javascript" src='<?php echo URL."views/js/filters_general.js"; ?>' ></script>




