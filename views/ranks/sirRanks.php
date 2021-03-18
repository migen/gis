
<?php 

$rows=getSir($rows);




?>

<h5>
	Split Iterative Ranking / SIR (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <span onclick="traceshd();" >SHD</span>
	| <a class="u" id="btnExport" >Export</a> 		
	| <a href="<?php echo URL.'sir/level/'.$lvl.DS.$sy.DS.$qtr; ?>" >Paid</a>
	| <a href="<?php echo URL.'sir/level/'.$lvl.DS.$sy.DS.$qtr.'?free=1'; ?>" >Free</a>	
	| <a href="<?php echo URL.'sir/level/'.$lvl.DS.$sy.DS.$qtr.'?free=2'; ?>" >All</a>	
</h5>


<table id="tblExport" class="gis-table-bordered table-altrow table-fx" >
<tr class="headrow" >
<th>#</th>
<th class="shd" >ID</th>
<th class="" >Code</th>
<th class="vc250 left" >Name</th>
<th>Gen<br />Ave</th>
<th>SIR</th>

</tr>
<?php $r1=1; ?>
<?php for($i=0;$i<$count;$i++): ?>


<tr>	
	<td><?php echo $rows[$i]['ct']; ?></td>
	<td class="shd" ><?php echo $rows[$i]['scid']; ?></td>
	<td class="left" ><?php echo $rows[$i]['studcode']; ?></td>
	<td class="left" ><?php echo ucfirst($rows[$i]['name']); ?></td>
	<td class="rigth" ><?php echo number_format($rows[$i]['genave'],2); ?></td>
	<td><?php echo $rows[$i]['rank']; ?></td>
</tr>
<?php endfor; ?>
</table>


<div class="ht100" ></div>

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>

<script>
var gurl="http://<?php echo GURL; ?>";

$(function(){
	shd();
	excel();
	
})

</script>
