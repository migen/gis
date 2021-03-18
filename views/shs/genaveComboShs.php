<?php 

// pr($cr);
// pr($classrooms);
$header="";foreach($classrooms AS $row){ $header.='#'.$row['id'].'-'.$row['name'].' | '; } $header=rtrim($header," | ");

?>

<h5>
	<?php echo $sy; ?> SHS Genave <?php echo (isset($_GET['final']))? "Final":"Summary"; ?>
	- (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <a class="u" id="btnExport" >Excel</a> 
	
	
	
</h5>

<p><?php echo $header; ?></p>

<table id="tblExport" class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th class="idno" >Scid</th>
	<th class="idno" >ID No.</th>
	<th>Student</th>
	<?php if(!isset($_GET['final'])): ?>
		<th>Ave<br />Sem1</th>
		<th>Ave<br />Sem2</th>
	<?php endif; ?>	
	<th>Ave<br />Final</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="idno" ><?php echo $rows[$i]['scid']; ?></td>
	<td class="idno" ><?php echo $rows[$i]['studcode']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<?php if(!isset($_GET['final'])): ?>	
		<td><?php echo $rows[$i]['ave_q5']; ?></td>
		<td><?php echo $rows[$i]['ave_q6']; ?></td>
	<?php endif; ?>
	<td><?php echo $rows[$i]['ave_q7']; ?></td>
</tr>
<?php endfor; ?>
</table>


<!------------------------------------------------------->

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
