<h3>
	<?php echo $sy; ?> Registered Students (<?php echo $count; ?>) 
	| <?php $this->shovel('homelinks'); ?>
	| <a class="u" id="btnExport" >Excel</a> 
	| <a class="u" onclick="traceshd();" >SHD</a> 
	| <a href="<?php echo URL.'sy/level/4'; ?>" >SY Registered</a>
		
</h3>

<table id="tblExport" class="gis-table-bordered table-altrow table-fx" >
<tr>
	<th>#</th>
	<th>SY</th>
	<th>Level</th>
	<th class="shd" >Summ<br />Scid</th>
	<th>Scid</th>
	<th>ID No.</th>
	<th>Birthdate</th>
	<th>Student</th>
	<th>Leveler</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['sy']; ?></td>
	<td><?php echo $rows[$i]['lvlname']; ?></td>
	<td class="shd" ><?php echo $rows[$i]['summscid']; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['studcode']; ?></td>
	<td><?php echo $rows[$i]['birthdate']; ?></td>
	<td><?php echo $rows[$i]['studname']; ?></td>
	<td><a href="<?php echo URL.'students/leveler/'.$rows[$i]['scid'].DS.$sy; ?>" >Leveler</a></td>
</tr>
<?php endfor; ?>
</table>

<div class="ht50" ></div>


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

