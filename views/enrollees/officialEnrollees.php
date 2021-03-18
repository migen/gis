<?php 


?>

<h5>
	<?php echo $sy; ?> Official Enrollees (<?php echo $count; ?>)
	<?php $this->shovel('homelinks'); ?>
	| <span class="u" onclick="pclass('hd');" >Details</span>
	| <a href="<?php echo URL.'enrollees/current'; ?>" >New <?php echo DBYR; ?></a>	

	| <a class="u" id="btnExport" >Excel</a> 

</h5>

<table id="tblExport" class="gis-table-bordered table-altrow table-fx" >
<tr>
	<th>#</th>
	<th class="hd" >SCID</th>
	<th class="hd" >CRID</th>
	<th class="" >Classroom</th>
	<th class="" >ID No.</th>
	<th class="" >Birthdate</th>
	<th class="" >Student</th>
	<th class="" >Amount</th>
	<th class="" >Ledger</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="hd" ><?php echo $rows[$i]['scid']; ?></td>
	<td class="hd" ><?php echo $rows[$i]['crid']; ?></td>
	<td class="" ><?php echo $rows[$i]['classroom']; ?></td>
	<td><?php echo $rows[$i]['studcode']; ?></td>
	<td><?php echo $rows[$i]['birthdate']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['amount'],2); ?></td>
	<td><a href="<?php echo URL.'enrollment/ledger/'.$rows[$i]['scid'].DS.$sy; ?>" >Ledger</a></td>

</tr>
<?php endfor; ?>
</table>


<script>

var gurl = "http://<?php echo GURL; ?>";


$(function(){
	// hd();
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
 

