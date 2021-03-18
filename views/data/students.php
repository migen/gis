<h5>



	<?php echo $level['name']; ?> Students
<span class="screen" >		
	| <a href="<?php echo URL.'info'; ?>">Info</a>
	| <a href="<?php echo URL; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
</span>
</h5>

<p class="printNoScreen f10" >Printed on: <?php echo date('M d, Y'); ?></p>

<?php for($c=0;$c<$numrows;$c++): ?>
	<h4><?php echo $classrooms[$c]['name']; ?></h4>
	<table class="gis-table-bordered table-fx table-altrow" >
		<tr class="headrow"  >
			<th class="vc30" >#</th>
			<th class="vc100" >ID Number</th>
			<th class="vc400" >Student</th>
			<th>Gender</th>
		</tr>
		<?php $i=1; ?>
		<?php foreach($students[$c] AS $row): ?>
			<tr>
				<td><?php echo $i; ?></td>
				<td><?php echo $row['student_code']; ?></td>
				<td><?php echo $row['student']; ?></td>
				<td><?php echo ($row['is_male'])? 'M' : "F"; ?></td>
			</tr>
		<?php $i++; ?>
		<?php endforeach; ?>
	</table>
	<br />
<?php endfor; ?>
