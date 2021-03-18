<h5>
	Submissions (<?php echo $count; ?>) Qtr-<?php echo $qtr; ?>
	| <a href="<?php echo URL.$home; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				


</h5>

<?php 
	$numcols='5';

?>


<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Crs</th>
	<th>Course</th>
	<th>IO</th>
	<th>Date</th>
</tr>
<tr><th colspan="<?php echo $numcols; ?>" ><?php echo @$rows[0]['teacher']; ?></th></tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['crs']; ?></td>
	<td><?php echo $rows[$i]['course']; ?></td>
	<?php $is_locked=$rows[$i]['is_locked']; ?>
	<td><?php echo $is_locked; ?></td>
	<td><?php echo ($is_locked)? $rows[$i]['finalized_date']:'-'; ?></td>
</tr>	

<?php 
	$j=$i+1;
	if($rows[$i]['tcid']!=@$rows[$j]['tcid']){
		$lblsupp=isset($rows[$j]['teacher'])? $rows[$j]['teacher'].' - #'.$rows[$j]['tcid']:'NO Teacher';
		$lsrow="<tr><th colspan='".$numcols."' >".$lblsupp."</th></tr>";
		echo $lsrow;
	} 
?>	

<?php endfor; ?>
</table>


