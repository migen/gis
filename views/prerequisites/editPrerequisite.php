<?php 

$dbg=PDBG;
$dbtable="{$dbg}.01_prerequisites";
$dbunisubjects="{$dbo}.`05_subjects`";

debug($_SESSION['q']);


?>

<h5>
	Edit Prerequisite 
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'prerequisites'; ?>" >Prerequisites</a>


</h5>

<h5><?php echo $subject['code'].' - '.$subject['name'].' #'.$subject['id']; ?></h5>

<div class="third">

<form method="POST" >
	<span class="b" >ID </span><input name="psub" class="center vc60" id="id" />
	<input type="submit" name="submit" value="Add" />
</form><br />


<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Prerequisites</th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php $id=$rows[$i]['id']; ?>
<tr id="trow-<?php echo $i; ?>" >
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['prerequisite']; ?></td>
	<td><span class="u" onclick="confirmXdelrow('<?php echo $dbtable; ?>',<?php echo $id.','.$i; ?>);" >Delete</span></td>
</tr>
<?php endfor; ?>
</table>
</div>	<!-- third -->

<div class="third" >	<!-- 2nd -->

<table class="gis-table-bordered table-altrow" >
<tr><th>ID Finder</th></tr>
<tr><th><input class="pdl05" id="part" value=""  /> </th></tr>
<tr><td><input type="submit" class="vc150" value="Subjects" onclick="xgetDataByTable('<?php echo $dbunisubjects; ?>');return false;" /></td></tr>
</table>

<div id="names" >names</div>

</div>	<!-- 2nd -->


<script>

var gurl="http://<?php echo GURL; ?>";
var dbtable="<?php echo $dbtable; ?>";
var limits=20;

$(function(){
	$("#names").hide();
	$('html').live(click(function(){ $("#names").hide(); }))
	
	
})

function confirmXdelrow(dbtbl,id,i){
	if(confirm('Sure?')){ xdelrow(dbtbl,id,i); }
} 


function axnFilter(id){
	$('#id').val(id);
	
	
}	/* fxn */


</script>

<script type="text/javascript" src='<?php echo URL."views/js/filters_general.js"; ?>' ></script>
