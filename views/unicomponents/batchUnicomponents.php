<?php 
	
	$dbg=PDBG;
	$dbunisubjects="{$dbo}.`05_subjects`";
	
?>

<h5>
	Batch Components (MIS)
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'unicomponents'; ?>" >Components</a>
	| <a href="<?php echo URL.'components/filter'; ?>" >Filter</a>
	

</h5>

<div class="third" >
<p>
<table class="gis-table-bordered" >
<tr><th>Subject</th><td>
<select class="full" >
<?php foreach($unisubjects AS $sel): ?>
	<option><?php echo '#'.$sel['id'].' - '.$sel['name']; ?></option>
<?php endforeach; ?>
</select>
</td></tr>
<tr><th>Criteria</th><td>
<select class="full" >
<?php foreach($unicriteria AS $sel): ?>
	<option><?php echo '#'.$sel['id'].' - '.$sel['name']; ?></option>
<?php endforeach; ?>
</select>
</td></tr>

</table>
</p>


<h4>Batch Setup (CSV ID Strings)</h4>
<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr><th>Subjects</th><td><input name="post[subjects]"  /></td></tr>
<tr><th>Criteria</th><td><input name="post[criterias]"  /></td></tr>
<tr><th>Weights</th><td><input name="post[weights]"  /></td></tr>
</table>

<p><input type="submit" name="submit" value="Batch" /></p>
</form>
</div>	<!-- left -->


<div class="third" > <!-- right -->



<table class="gis-table-bordered table-altrow" >
<tr><th><span class="b" >ID</span> <input id="id" class="red pdl05 vc60" readonly ><br /></th></tr>
<tr><th><input class="pdl05" id="part" value=""  /> </th></tr>
<tr><td><input type="submit" class="vc150" value="Subjects" onclick="xgetDataByTable('<?php echo $dbunisubjects; ?>');return false;" /></td></tr>
</table>

<div class="hd" id="names" >names</div>

</div>	<!-- right -->


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

