<h5>
	<?php echo $level['name']; ?> Honors Q<?php echo $qtr; ?> (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <a class="u" id="btnExport" >Excel</a> 
	| <a href="<?php echo URL.'lir'; ?>" >L I R</a>	
	| <a href="<?php echo URL.'honors/level/'.$lvl.DS.$sy.DS.$qtr.'?num=2'; ?>" >BySections</a>
	<?php if($free==0): ?>
		| <a href="<?php echo URL.'honors/level/'.$lvl.DS.$sy.DS.$qtr.'?free=1'; ?>" >Free</a>
		| <a href="<?php echo URL.'honors/level/'.$lvl.DS.$sy.DS.$qtr.'?free=2'; ?>" >All</a>
	<?php elseif($free=1): ?>
		| <a href="<?php echo URL.'honors/level/'.$lvl.DS.$sy.DS.$qtr; ?>" >Paid</a>
		| <a href="<?php echo URL.'honors/level/'.$lvl.DS.$sy.DS.$qtr.'?free=2'; ?>" >All</a>	
	<?php elseif($free=2): ?>
		| <a href="<?php echo URL.'honors/level/'.$lvl.DS.$sy.DS.$qtr; ?>" >Paid</a>
		| <a href="<?php echo URL.'honors/level/'.$lvl.DS.$sy.DS.$qtr.'?free=1'; ?>" >Free</a>	
	<?php endif; ?>
	| <a href="<?php echo URL.'honors/levelReport/'.$lvl.DS.$sy.DS.$qtr; ?>" >Report</a>


<?php if($lvl>13): ?>
	<?php if($qtr<5): ?>
		| <a href="<?php echo URL.'honors/level/'.$lvl.DS.$sy.DS.'5'; ?>" >Sem1</a>
		| <a href="<?php echo URL.'honors/level/'.$lvl.DS.$sy.DS.'6'; ?>" >Sem2</a>	
	<?php else: ?>
		| <a href="<?php echo URL.'honors/level/'.$lvl.DS.$sy.DS.$_SESSION['qtr']; ?>" >Current</a>
	<?php endif; ?>	
<?php else: ?>
	<?php if($qtr<5): ?>
		| <a href="<?php echo URL.'honors/level/'.$lvl.DS.$sy.DS.'5'; ?>" >Final</a>
	<?php else: ?>
		| <a href="<?php echo URL.'honors/level/'.$lvl.DS.$sy.DS.$_SESSION['qtr']; ?>" >Current</a>
	<?php endif; ?>
<?php endif; ?>


<?php 
	$sqtr=$_SESSION['qtr'];
	$get=sages($_GET);

?>

	
  | <?php for($q=1;$q<=$sqtr;$q++): ?>	
	<?php if($q!=$qtr): ?>
		<a href="<?php echo URL.'honors/level/'.$lvl.DS.$sy.DS.$q.$get; ?>" >Q<?php echo $q; ?></a> | 
	<?php endif; ?>  
  <?php endfor; ?>			
	
	
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
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['studcode']; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td class="right" ><?php echo $rows[$i]['genave']; ?></td>
	<td class="center" ><?php echo ($rows[$i]['honor']+0); ?></td>
</tr>
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

