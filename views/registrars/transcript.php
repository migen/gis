<?php 

?>

<h5> Transcript Candy Report
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
</h5>

<!--------------- student ------------------------------------------------------------------->
<p>
<table class="gis-table-bordered table-fx" >
<tr><th class="bg-blue2 vc100" >ID</th><td class="vc300" ><?php echo $student['student_code']; ?></td></tr>
<tr><th class="bg-blue2 " >Student</th><td><?php echo $student['student']; ?></td></tr>
<tr><th class="bg-blue2 " >Phone</th><td><?php echo ''; ?></td></tr>
<tr><th class="bg-blue2 " >Email</th><td><?php echo ''; ?></td></tr>
<tr><th class="bg-blue2 " >Address</th><td><?php echo ''; ?></td></tr>
</table>
</p>

<!---------------------------------------------------------------------------------->

<?php for($s=0;$s<$num_sums;$s++): ?>

<h5>School Year: <?php echo $sums[$s]['sy'].' - '.($sums[$s]['sy']+1); ?> </h5>
<!--  summaries -->
<p>
<table class="gis-table-bordered table-fx">
	<tr><th class="bg-blue2 white vc100" >Level</th><td class="vc300" ><?php echo $sums[$s]['level']; ?></td></tr>
	<tr><th class="bg-blue2 white" >Section</th><td><?php echo $sums[$s]['section']; ?></td></tr>
	<tr><th class="bg-blue2 white" >Adviser</th><td><?php echo $sums[$s]['adviser']; ?></td></tr>
	<tr><th class="bg-blue2 white" >Academics</th><td><?php echo $sums[$s]['gafg']; ?></td></tr>
	<tr><th class="bg-blue2 white" >Conduct</th><td><?php echo $sums[$s]['cfg']; ?></td></tr>
	<tr><th class="bg-blue2 white" >Total Days</th><td><?php echo $sums[$s]['ydt']; ?></td></tr>
	<tr><th class="bg-blue2 white" >Present</th><td><?php echo $sums[$s]['tdp']; ?></td></tr>
</table>
</p>

<!--  course grades -->
<p>
<table class="gis-table-bordered table-fx" >
<tr class="headrow" >
	<th>#</th><th class="vc200" >Subject</th><th class="vc50" >Q1</th><th class="vc50" >Q2</th><th class="vc50" >Q3</th><th class="vc50" >Q4</th><th class="vc50" >FG</th>
</tr>
<?php $c=0; ?>
<?php foreach($grades[$s] AS $row): ?>
<tr>
	<td><?php echo $c+1; ?></td>
	<td><?php echo $row['subject']; ?></td>
	<td><?php echo $row['q1']+$row['bonus_q1']; ?></td>
	<td><?php echo $row['q2']+$row['bonus_q2']; ?></td>
	<td><?php echo $row['q3']+$row['bonus_q3']; ?></td>
	<td><?php echo $row['q4']+$row['bonus_q4']; ?></td>
	<td><?php echo $row['q5']; ?></td>
</tr>
<?php $c++; ?>
<?php endforeach; ?>
</table>
</p>


<?php endfor; ?>

	

<!---------------------------------------------------------------------------------->

<script>



</script>

