
<?php 


// pr($_SESSION['q']);


?>


<h5>
	Subjects
	| <?php $this->shovel('homelinks'); ?>


</h5>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Code</th>
	<th>Sub</th>
	<th>Name</th>
	<th>Is<br />Fdn</th>
	<th>&nbsp;</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php $sub=$rows[$i]['sub']; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $sub; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo ($rows[$i]['is_foundation']==1)? 'Y':'-'; ?></td>
	<td>
		<?php if($rows[$i]['is_foundation']==1): ?>
			<button id="btn-<?php echo $i; ?>" onclick="toggleFoundation(<?php echo $i.','.$sub.','.'0'; ?>);return false;" >Off</button>
		<?php else: ?>
			<button id="btn-<?php echo $i; ?>" onclick="toggleFoundation(<?php echo $i.','.$sub.','.'1'; ?>);return false;" >On</button>		
		<?php endif; ?>
	</td>
	
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
	

</script>


