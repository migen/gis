

<?php 
// echo "<hr />";
// pr($data);

$num_columns=&$data['num_columns'];
$columns=&$data['columns'];
$rows=&$data['rows'];
$count=&$data['count'];



?>


	<table class="gis-table-bordered" >
	<tr>
		<th>#</th>
		<?php for($j=0;$j<$num_columns;$j++): ?>
			<th><?php echo $columns[$j]; ?></th>
		<?php endfor; ?>
	</tr>
	<?php for($i=0;$i<$count;$i++): ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<?php for($j=0;$j<$num_columns;$j++): ?>
			<?php $key=$columns[$j]; // $val=$rows[$i][$key]; ?>
			<td><?php echo $rows[$i][$key]; ?></td>
		<?php endfor; ?>
	</tr>
	<?php endfor; ?>
	</table>
