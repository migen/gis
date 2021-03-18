<?php 


?>

<h5>
	Promotions Report
	
	
</h5>



<table class="gis-table-bordered" >
<tr class="headrow" >
	<th>#</th>
	<th>Student</th>
	<th>Address</th>
	<?php foreach($courses AS $row): ?>
		<?php $subject = $row['label']; ?>
		<th style="text-align:center;vertical-align:bottom;">
			<img src='<?php echo URL."views/promotions/gdstringup.php?text=$subject"; ?>'  >
		</th>
	<?php endforeach; ?>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<?php $records = $grades[$i]; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="vc120" ><?php echo $students[$i]['student']; ?></td>
	<td class="vc200" ><?php echo $students[$i]['address']; ?></td>
		<?php foreach($records AS $row): ?>
		<td><?php echo $row['q5']; ?></td>
	<?php endforeach; ?>
</tr>
<?php endfor; ?>
</table>