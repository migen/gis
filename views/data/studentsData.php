<h3>
	Students List (<?php echo $count; ?>) | SY<?php echo $sy; ?> | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'sessions/unsetter/students'; ?>" >Reset-Students</a>
	| <a class="u" id="btnExport" >Excel</a> 


</h3>

<?php 

debug($rows[0]);


?>


<table id="tblExport" class="gis-table-bordered table-altrow table-fx" >
<tr>
	<th>#</th>
	<th>Lvl<br />Code</th>
	<th>Actv</th>
	<th>Scid</th>
	<th>ID No.</th>
	<th>Birthdate</th>
	<th>Student</th>
	<th>Gen<br />der</th>
	<th>Classroom</th>
	<th>Crid</th>
	<th>Ucis</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['lvlcode']; ?></td>
	<td><?php echo $rows[$i]['is_active']; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['studcode']; ?></td>
	<td><?php echo $rows[$i]['birthdate']; ?></td>
	<td><?php echo $rows[$i]['studname']; ?></td>
	<td><?php echo ($rows[$i]['is_male'])? 'B':'G'; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td><?php echo $rows[$i]['crid']; ?></td>
	<td><a href="<?php echo URL.'contacts/ucis/'.$rows[$i]['scid']; ?>" >UCIS</a></td>
</tr>
<?php endfor; ?>
</table>

<div class="ht100" >&nbsp;</div>

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
