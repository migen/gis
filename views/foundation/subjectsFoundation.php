
<?php 


// pr($_SESSION['q']);

?>


<h5>
	Subjects
	| <?php $this->shovel('homelinks'); ?>
	<?php if($sy!=DBYR): ?>	
		| <a href="<?php echo URL.'foundation/subjects?all'; ?>" >Current</a>
	<?php else: ?>
		| <a href="<?php echo URL.'foundation/subjects/'.(DBYR-1).'?all'; ?>" ><?php echo (DBYR-1); ?></a>	
	<?php endif; ?>

</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>ID</th>
	<th>Code</th>
	<th>Sub</th>
	<th>Name</th>
	<th>Is<br />Fdn</th>
	<th>Fdntype<br />ID</th>
	<th>&nbsp;</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php $sub=$rows[$i]['sub']; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo '#'.$rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $sub; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><input class="vc50" type="number" min=0 max=1 id="isFdn-<?php echo $i; ?>" value="<?php echo $rows[$i]['is_foundation']; ?>" /></td>
	<td><input class="vc50" id="fdnType-<?php echo $i; ?>" value="<?php echo $rows[$i]['fdntype_id']; ?>" /></td>		
	<td><button><a id="btn-<?php echo $i; ?>" onclick="xeditFdn(<?php echo $i.','.$rows[$i]['id']; ?>);return false;" >Save</a></button></td>
	
</tr>
<?php endfor; ?>
</table>



<script>

var gurl="http://<?php echo GURL; ?>";
var sy="<?php echo $sy; ?>";

$(function(){

})

function toggleFoundation(i,sub,val){
	var vurl=gurl + '/ajax/xfoundation.php';	
	var task="toggleFoundation";		
	$.ajax({
		url: vurl,type: 'POST',data:'task='+task+'&sub='+sub+'&val='+val+'&sy='+sy,				
		success: function() { $('#btn-'+i).hide(); }		  
    });					

}	/* fxn */



function xeditFdn(i,id){
	$('#btn-'+i).hide();	
	var vurl=gurl+'/ajax/xsubjects.php';	
	var task="xeditFdn";
	var isFdn=$('#isFdn-'+i).val();
	var fdnType= $('#fdnType-'+i).val();	
	var pdata = 'task='+task+'&isFdn='+isFdn+'&fdnType='+fdnType+'&id='+id+'&sy='+sy;	
	$.ajax({ type: 'POST',url: vurl,data: pdata,success:function(){}  });				

}	/* fxn */


	

</script>


