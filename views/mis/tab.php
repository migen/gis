
<!------------------------------------------------------------------------------------------>

<?php 

pr($students);

?>

<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" ><th>#</th><th>crid</th><th>student</th><th>Summary</th></tr>

<?php for($i=0;$i<$num_students;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $students[$i]['crid']; ?></td>
	<td><?php echo $students[$i]['name']; ?></td>
	<td>
		<?php $sy = $students[$i]['sy']; ?>
		<?php if($sy): ?>
			<?php echo $sy; ?>
		<?php else: ?>
			<button><a class="no-underline txt-black" href="syncToSummaries/<?php echo $students[$i]['scid'].DS.$ssy; ?>" >Sync</button>
		<?php endif; ?>
	</td>
</tr>
<?php endfor; ?>
</table>







