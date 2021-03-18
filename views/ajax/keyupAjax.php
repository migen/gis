<h3>

	Ajax Keyup | <?php shovel('homelinks'); ?>


</h3>

<form method="POST" >
<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>Name</th>
	<th>ID</th>
</tr>
<?php $numrows=isset($_POST['numrows'])? $_POST['numrows']:5; ?>
<?php for($i=0;$i<$numrows;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td>
		<input class="vc300 pdl05" id="part<?php echo $i; ?>" onkeyup="keyupDataByRow(<?php echo $i; ?>);return false;" />		
		<input type="submit" name="auto" value="Filter" onclick="xgetContactsByPartRow(<?php echo $i; ?>);return false;" />	
	</td>
	<td><input id="ucid<?php echo $i; ?>" class="pdl05 vc50" name="posts[<?php echo $i; ?>][ucid]" /></td>
</tr>
<?php endfor; ?>
</table>
</form>


<?php shovel('numrows'); ?>

<div class="hd" id="names" > </div>


<script>
var gurl = 'http://<?php echo GURL; ?>';

		
$(function(){
	hd();
	$('html').live('click',function(){ $('#names').hide(); });
	// selectFocused();
	
	
})


function keyupDataByRow(i){
	var part=$('#part'+i).val();
	var len=part.length;
	if(len>3){
		part=$('#part'+i).val();		
		xgetContactsByPartRow(i);
	}
	
}


function rowVal(i,tcid){
	$('input[name="posts['+i+'][ucid]"]').val(tcid);	
}	/* fxn */


function redirContact(pcid,rid){	
	$('input[name="posts['+rid+'][ucid]"]').val(pcid);		
}	/* fxn */




</script>
<script type="text/javascript" src='<?php echo URL."views/js/filters.js"; ?>' ></script>

