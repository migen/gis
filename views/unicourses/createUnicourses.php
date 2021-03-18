<?php 

$dbcontacts=PDBO.".`00_contacts`";

?>

<h5>
	Create College Courses | <?php $this->shovel('homelinks'); ?>
	
	
</h5>

<!-- 
subject_id
crid
semester

-->


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

<tr><th>*Major</th><td class="vc200" >
<select class="full" name="post[major_id]" >
<option value=0 >Select One</option>
<?php foreach($majors AS $sel): ?>
	<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$major_id)? 'selected':NULL; ?>  >
		<?php echo $sel['name'].' #'.$sel['id']; ?></option>
<?php endforeach; ?>
</select>
</td></tr>

<tr><th>*Units</th><td><input type="number" class="vc50" name="post[units]" value="<?php echo 3; ?>" ></td></tr>


<tr><td colspan=2 ><input type="submit" name="submit" value="Add"  /></td></tr>

</table>
</form>



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





</script>


<script type="text/javascript" src='<?php echo URL."views/js/filters_general.js"; ?>' ></script>


