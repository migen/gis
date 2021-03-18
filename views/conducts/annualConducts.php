<style>

.left{ text-align:left; }

</style>

<?php 
	$sqtr=$_SESSION['qtr'];
	
	$dg=isset($_GET['dg'])? true:false;
	$crs=$conduct['crs'];
	
	// pr($cr);
	
?>

<h5>

	Annual Conducts
	| <?php $this->shovel('homelinks'); ?>
	| <a class="u" id="btnExport" >Excel</a> 
	| <a href='<?php echo URL."attendance/quarterly/$crid/$sy/$sqtr"; ?>' >Q<?php echo $sqtr; ?></a>
	| <span class="u" onclick="traceshd();" >SHD</span>
<?php if(!$dg): ?>
	| <a href='<?php echo URL."conducts/annual/$crid/$sy?dg"; ?>' >DG</a>
<?php else: ?>
	| <a href='<?php echo URL."conducts/annual/$crid/$sy"; ?>' >Numeric</a>
<?php endif; ?>
<?php if(($_SESSION['srid']==RTEAC) || ($_SESSION['srid']==RMIS)): ?>
	| <a href='<?php echo URL."conducts/records/$crs/$sy/$sqtr"; ?>' >Records</a>
<?php endif; ?>
	
	
</h5>


<table class="" >

</table>


<?php 

// pr($data);
// pr($cr);
?>

<h4><?php echo $cr['name'].' - '.$cr['adviser']; ?></h4>

<table id="tblExport" class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th class="left shd" >Scid</th>
	<th class="left shd" >ID No</th>
	<th class="left" >Student</th>
	<th>Q1</th>
	<th>Q2</th>
	<th>Q3</th>
	<th>Q4</th>
<?php if(!$dg): ?>
	<th>Final</th>
<?php endif; ?>	
	
</tr>


<?php if(!$dg): ?>
	<?php for($i=0;$i<$count;$i++): ?>
	<tr class="center" >
		<td><?php echo $i+1; ?></td>
		<td class="left shd vc50" ><?php echo $rows[$i]['scid']; ?></td>
		<td class="left shd vc100" ><?php echo $rows[$i]['code']; ?></td>
		<td class="left" style="text-align:left;" ><?php echo $rows[$i]['student']; ?></td>
		<td><?php echo ($rows[$i]['conduct_q1']+0); ?></td>
		<td><?php echo ($rows[$i]['conduct_q2']+0); ?></td>
		<td><?php echo ($rows[$i]['conduct_q3']+0); ?></td>
		<td><?php echo ($rows[$i]['conduct_q4']+0); ?></td>
		<td><?php echo ($rows[$i]['conduct_q5']+0); ?></td>
	</tr>
	<?php endfor; ?>
<?php else: ?>
	<?php for($i=0;$i<$count;$i++): ?>
	<tr class="center" >
		<td><?php echo $i+1; ?></td>
		<td class="left shd vc50" ><?php echo $rows[$i]['scid']; ?></td>
		<td class="left shd vc100" ><?php echo $rows[$i]['code']; ?></td>
		<td class="left" style="text-align:left;" ><?php echo $rows[$i]['student']; ?></td>
		<td><?php echo $rows[$i]['conduct_dg1']; ?></td>
		<td><?php echo $rows[$i]['conduct_dg2']; ?></td>
		<td><?php echo $rows[$i]['conduct_dg3']; ?></td>
		<td><?php echo $rows[$i]['conduct_dg4']; ?></td>
	</tr>
	<?php endfor; ?>
<?php endif; ?>


</table>

<div class="ht50" >&nbsp;</div>


<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>

<script>
var gurl="http://<?php echo GURL; ?>";
$(function(){
	excel();
	shd();

})

</script>

