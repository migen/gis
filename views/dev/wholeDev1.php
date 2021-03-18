<style>
	
div.divleft div {float:left; }
#divLogo{ width: 120px; }


</style>

<?php 

$logo_src=URL.'public/images/logo_sample.png';

if(isset($_GET['data'])){ pr($data); }
if(isset($_GET['student'])){ pr($data[0]['student']); }

?>

<h5 class="screen" >
	Dev Whole
	
	
</h5>

<?php 

// $student=$data[1]['student'];
// pr($student);

// $attendance=$data[0]['attendance'];



?>

<?php for($s=0;$s<$num_students;$s++): ?>
<?php 
	$student=$data[$s]['student'];
	$grades=$data[$s]['grades'];
	$attendance=$data[$s]['attendance'];

?>
<div class="divleft" >	<!-- rcheader -->
<div id="divLogo" ><img src='<?php echo $logo_src; ?>' alt="logo" height="88" width="76"></div>
<div class="center" >ABC SCHOOL<br />ABC Address<br />Paascu Acccredited</div>

</div>	<!-- rcheader -->

<div class="clear" ></div>
	<table class="gis-table-bordered" >
	<tr><th><?php echo $student['name']; ?></th></tr>

	</table>


	<br />

	<!-- grades -->
	<table class="gis-table-bordered" >
	<tr>
		<th>Subject</th>
		<th>Q1</th>
		<th>Q2</th>
		<th>Q3</th>
		<th>Q4</th>
		<th>Final</th>
	</tr>
	<?php foreach($grades AS $grade): ?>
	<tr>
		<td><?php echo $grade['subject']; ?></td>
		<td><?php echo $grade['q1']; ?></td>
		<td><?php echo $grade['q2']; ?></td>
		<td><?php echo $grade['q3']; ?></td>
		<td><?php echo $grade['q4']; ?></td>
		<td><?php echo $grade['q5']; ?></td>
	</tr>
	<?php endforeach; ?>
	</table><br />
		
	<!-- attendance -->
	<table class="gis-table-bordered" >
		<tr><th></th>
			<?php foreach($months AS $month): ?>
				<th><?php echo ucfirst($month); ?></th>
			<?php endforeach; ?>
		</tr>
		<tr>
			<th>Days Present</th>
			<?php foreach($months AS $month): ?>
				<td><?php echo $attendance[$month.'_days_present']; ?></td>
			<?php endforeach; ?>			
		</tr>
		<tr>
			<th>Days Tardy</th>
			<?php foreach($months AS $month): ?>
				<td><?php echo $attendance[$month.'_days_tardy']; ?></td>
			<?php endforeach; ?>			
		</tr>



	</table>
	

	<p class="pagebreak" ></p>
<?php endfor; ?>




