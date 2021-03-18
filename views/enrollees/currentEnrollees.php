<?php 
debug($_SESSION['q']);

?>

<h5>
	<?php echo $sy; ?> New Enrollees (<?php echo $count; ?>)
	<?php $this->shovel('homelinks'); ?>
	| <span class="u" onclick="pclass('hd');" >Details</span>
	| <a href="<?php echo URL.'enrollees/official'; ?>" >Official</a>
	
	<?php if($last_school): ?>
		| <a href="<?php echo URL.'enrollees/current'; ?>" >No Last School</a>
	<?php else: ?>
		| <a href="<?php echo URL.'enrollees/current?last_school'; ?>" >Last School</a>
	<?php endif; ?>
	| <a class="u" id="btnExport" >Excel</a> 

</h5>

<table id="tblExport" class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th class="hd" >SCID</th>
	<th class="hd" >CRID</th>
	<th class="" >Classroom</th>
	<th class="hd" >Level</th>
	<th class="hd" >Section</th>
	<th class="" >ID No.</th>
	<th class="" >Student</th>
	<?php if($last_school): ?>
		<th class="" >Last School</th>
	<?php endif; ?>
	<th class="hd" ></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="hd" ><?php echo $rows[$i]['scid']; ?></td>
	<td class="hd" ><?php echo $rows[$i]['crid']; ?></td>
	<td class="" ><?php echo $rows[$i]['classroom']; ?></td>
	<td class="hd" ><?php echo $rows[$i]['level']; ?></td>
	<td class="hd" ><?php echo $rows[$i]['section']; ?></td>
	<td><?php echo $rows[$i]['studcode']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<?php if($last_school): ?>
		<td><?php echo $rows[$i]['last_school']; ?></td>
	<?php endif; ?>	
	<td class="hd" ><button id="btn-<?php echo $i; ?>" 
		onclick="removeCurrentEnrollee(<?php echo $i.','.$rows[$i]['scid'];?>);" >Remove</button></td>	
</tr>
<?php endfor; ?>
</table>


<script>

var gurl = "http://<?php echo GURL; ?>";


$(function(){
	hd();
	excel();
})


function removeCurrentEnrollee(i,scid){
	var vurl 	= gurl + '/ajax/xenrollees.php';	
	var task	= "removeCurrentEnrollee";		
	$.ajax({
		url: vurl,type: 'POST',data: 'scid='+scid+'&task='+task,				
		success: function() { $('#btn-'+i).hide(); }		  
    });					
	
}	/* fxn */



</script>


<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>
 

