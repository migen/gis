<?php 

$dbcontacts=PDBO.".`00_contacts`";

?>

<h5>
	Add College Course | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'uniflowcharts/batch'; ?>" >Flowchart</a>
	
	
</h5>

<!-- 
subject_id
crid
semester

-->

<div style="float:left;width:35%" >
<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr class="headrow" ><th colspan=2>*Required</th></tr>

<tr><th>*Subject</th><td class="vc200" >
<select class="full" name="post[subject_id]" >
<option value=0 >Select One</option>
<?php foreach($unisubjects AS $sel): ?>
	<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name'].' #'.$sel['id']; ?></option>
<?php endforeach; ?>
</select>
</td></tr>

<tr><th>*Classroom</th><td class="vc200" >
<select class="full" name="post[crid]" >
<option value=0 >Select One</option>
<?php foreach($uniclassrooms AS $sel): ?>
	<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$crid)? 'selected':NULL; ?>  >
		<?php echo $sel['name'].' #'.$sel['id']; ?></option>
<?php endforeach; ?>
</select>
</td></tr>

<tr><th>*Units</th><td><input type="number" class="vc50" name="post[units]" value="<?php echo 3; ?>" ></td></tr>
<tr><th>Level</th><td><input class="vc50" name="post[level_id]" type="number" value=1 ></td></tr>
<tr><th>Semester</th><td><input class="vc50" name="post[semester]" type="number" value=1 min=1 max=3 ></td></tr>
<tr class="headrow" ><th colspan=2>Optional</th></tr>

<tr><th><span class="b" >Teacher</span> 
	<input id="id" class="pdl05 vc60" readonly name="post[tcid]"  ></th>
<th><input class="pdl05" id="part"  /> </th></tr>
<tr><th></th><td colspan= ><input type="submit" class="vc150" value="Teachers" onclick="xgetDataByTable('<?php echo $dbcontacts; ?>');return false;" /></td></tr>
<tr><th>Room</th><td><input class="vc80" name="post[room]" ></td></tr>
<tr><th>Schedule</th><td><input class="vc200" name="post[schedule]" ></td></tr>

<tr><td colspan=2 ><input type="submit" name="submit" value="Add"  /></td></tr>

</table>
</form>
<div class="hd" id="names" >names</div>
</div>

<div style="float:left;width:40%" >

<h5>Notes</h5>

Recommended steps<br />
1) Flowchart - create<br />
2) Flowchart - sync<br />

</div>



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


