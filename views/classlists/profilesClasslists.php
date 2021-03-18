<?php 

	
?>

<h5>
	Profiles Classlist - Birthdates (<?php echo $count; ?>) 
	| <?php $this->shovel('homelinks'); ?>
	| <span class="u" onclick="pclass('hd');" >Details</span>
	| <a class="u" id="btnExport" >Excel</a> 		
	
</h5>

<?php  $this->shovel('classroom_details',$cr);  ?>


<table id="tblExport" class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>Scid</th>
	<th>ID No</th>
	<th>Birthdate</th>
	<th>Name</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['birthdate']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
</tr>
<?php endfor; ?>
</table>

<div class="clear ht50" ></div>

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>


<script>

var gurl     = "http://<?php echo GURL; ?>";

$(function(){
	excel();


})






</script>
