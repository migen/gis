<h5>
	String Integer | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'datatypes'; ?>" >Datatypes</a>
	
</h5>

<?php 

	pr($rows[0]);


?>


<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>Student</th>
	<th>Q1</th>
	<th>Q2</th>
	<th>Ave<br />S1</th>
	<th>Q3</th>
	<th>Q4</th>
	<th>Ave<br />S2</th>	
	
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php $q1=$rows[$i]['q1']; echo $q1; ?></td>
	<td><?php $q2=$rows[$i]['q2']; echo $q2; ?></td>
	<td><?php $ave_s1=$rows[$i]['ave_s1']; echo number_format($ave_s1,2); ?></td>	
	<td><?php $q3=$rows[$i]['q3']; echo $q3; ?></td>
	<td><?php $q4=$rows[$i]['q4']; echo $q4; ?></td>	
	<td><?php $ave_s2=$rows[$i]['ave_s2']; echo $ave_s2; ?></td>	
	
</tr>
<?php endfor; ?>
</table>
