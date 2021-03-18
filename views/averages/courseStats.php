<h5>

Subject Statistics
	| <a href="<?php echo URL; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
</h5>

<table class="gis-table-bordered table-fx" >
<tr><th class="bg-blue2 white vc120" >Classroom</th><td class="vc200" ><?php echo $course['level'].' - '.$course['section']; ?></td></tr>
<tr><th class="bg-blue2 white " >Subject</th><td><?php echo $course['label']; ?></td></tr>
<tr><th class="bg-blue2 white ">Teacher</th><td><?php echo $course['teacher']; ?></td></tr>



</table>

<p></p>


<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th>DG</th>
	<th>Description</th>
	<th>Count</th>
</tr>

<?php for($i=0;$i<$num_stats;$i++): ?>
<tr>
	<td><?php echo $i+1;?></td>
	<td><?php echo $stats[$i]['rating'];?></td>
	<td><?php echo $stats[$i]['description'];?></td>
	<td><?php echo $stats[$i]['count'];?></td>
</tr>
<?php endfor; ?>
</table>
