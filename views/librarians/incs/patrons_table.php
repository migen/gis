<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>
<script>

var gurl     = "http://<?php echo GURL; ?>";

$(function(){
	excel();

})


</script>




<table id="tblExport" class="gis-table-bordered table-fx" >
<tr>
	<th>#</th>
	<th>Date</th>
	<th>Classroom</th>
	<th>ID No.</th>
	<th>Name</th>
	<th>Time Ins</th>
	<th>Times</th>
	<th>Lib</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['date']; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['contact']; ?></td>
	<td><?php echo $rows[$i]['logtimes']; ?></td>
	<td><?php echo $rows[$i]['numlogs']; ?></td>
	<td class="<?php if($rows[$i]['dif']==2){ echo ""; green; } 
		elseif($rows[$i]['dif']==3){ echo "blue"; } ?>" ><?php echo $rows[$i]['dcf']; ?></td>
</tr>
<?php endfor; ?>
</table>