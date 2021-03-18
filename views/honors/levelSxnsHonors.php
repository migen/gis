<h5>
	By Section <?php echo $level['name']; ?> Honors (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <a class="u" id="btnExport" >Excel</a> 
	| <a href="<?php echo URL.'lir'; ?>" >L I R</a>
	| <a href="<?php echo URL.'honors/level/'.$lvl.DS.$sy.DS.$qtr.'?num=1'; ?>" >Mixed</a>
	
</h5>

<?php 
// pr($classrooms);
?>

<p><?php foreach($classrooms AS $sel): ?>
<a href="<?php echo URL.'honors/process/'.$sel['id']; ?>" ><?php echo $sel['code']; ?></a> | <?php endforeach; ?>
</p>



<table id="tblExport" class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Scid</th>
	<th>ID No.</th>
	<th>Classroom</th>
	<th>Student</th>
	<th class="right" >Genave</th>
	<th>Honor</th>
</tr>

<tr><th colspan=7 ><?php echo $rows[0]['classroom']; ?></th></tr>

<?php $j=0;?>
<?php for($i=0;$i<$count;$i++): ?>
<?php $j=$i+1; ?>


<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['studcode']; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td class="right" ><?php echo $rows[$i]['genave']; ?></td>
	<td class="center" ><?php echo ($rows[$i]['honor']+0); ?></td>
</tr>
<?php if(isset($rows[$j]['crid']) && ($rows[$i]['crid']!=$rows[$j]['crid'])): ?>
	<tr><th colspan=7 ><?php echo $rows[$j]['classroom']; ?></th></tr>
<?php endif; ?>

<?php endfor; ?>
</table>


<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>
<script>
var gurl="http://<?php echo GURL; ?>";
$(function(){
	excel();

})

</script>

