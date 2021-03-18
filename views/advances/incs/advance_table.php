<?php $srid=$_SESSION['srid']; ?>

<table class="gis-table-bordered" >
<tr><th>ID No</th><td><?php echo $student['studcode']; ?></td></tr>
<tr><th>Student</th><td><?php echo $student['student']; ?></td></tr>
<tr><th>Classroom</th><td><?php echo $student['classroom']; ?></td></tr>
</table>

<br />
<table class="gis-table-bordered table-fx" >
<tr><th>#</th><th>Date</th><th>Fee</th><th>Print<br />Or No</th><th>Amount</th><th></th></tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['date']; ?></td>
	<td><?php echo ($rows[$i]['pointer']==0)? 'Reservation':'Tuition'; ?></td>	
	<td><span class="u" onclick="copyOrnoValue(<?php echo $rows[$i]['orno']; ?>);return false;" >
		<?php echo $rows[$i]['orno']; ?></span></td>	
	
	<td class="right" ><?php echo number_format($rows[$i]['amount'],2); ?></td>
	<td>
		<?php if(($srid==RAXIS) || ($srid==RMIS)): ?>
			<a href="<?php echo URL.'advances/edit/'.$rows[$i]['id']; ?>" >Edit</a>
		<?php endif; ?>		
	</td>
</tr>
<?php endfor; ?>
</table>


<script type='text/javascript' src="<?php echo URL; ?>views/js/orno.js"></script>
