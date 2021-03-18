<h5>
	<?php echo $classroom['classroom']; ?>
	Classroom Photos
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
	

</h5>


<table class="gis-table-bordered table-fx" >
<tr class="headrow" >
	<th>#</th>
	<th>U|P</th>
	<th>Photo</th>
	<th>Student</th>
	<th>Manager</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>	
	<td><?php echo $i+1; ?></td>
	<td>
		<?php echo $students[$i]['ucid']; ?>
		<?php if($students[$i]['ucid']!=$students[$i]['pcid']){ echo "<br />".$students[$i]['pcid']; } ?>		
	</td>
	<td>
		<img src="data:image/jpeg;base64,<?= base64_encode($students[$i]['photo']); ?>" width="120" border="0" />
		
	</td>
	<td><?php echo $students[$i]['student']; ?></td>
	<td>
		<a href='<?php echo URL."photos/one/".$students[$i]['pcid']; ?>' >Upload</a>
		<!-- 		| <a href='<?php echo URL."img/getpic/".$students[$i]['pcid']; ?>'>GET</a>
		-->

	</td>


</tr>
<?php endfor; ?>
</table>