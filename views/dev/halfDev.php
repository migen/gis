<style>



.wrapper {
	width: 600px;
	margin: auto;
}
.header {
	padding: 10px;
	display: flex;
}
.divLogo {
	text-align: center;
}
.school-info {
	padding: 0px 100px 0px 0px;
}
.student-info {
	padding: 5px 5px 15px 5px;
}
.student-info table,
.grades table,
.signatory table {
	width: 600px;
}
.stud-name {
	text-transform: uppercase;
	font-size: 18px;
}
.grades table {
	border-top: 3px solid;
}
.tbl-student th,
.tbl-student td{
	padding: 1px 0px 1px 0px;
}
.thead th {
	text-align: center;
}
.colSubject {

}
.colGrades {
	text-align: center;
}
.attendance {
	font-size: 13px;
}
.attd-data {
	font-size: 15px;
}
.sm-text {
	padding-left: 5px;
	font-size: 10px;
}
.signatory table {
	margin-top: 20px;
}
.signatory table td {
	padding: 3px;
	text-align: center;
}
div.divleft div {float:left; }
.divLogo{ width: 200px; }
</style>

<?php 

$logo_src=URL.'public/images/logo_sample.png';

if(isset($_GET['data'])){ pr($data); }
if(isset($_GET['student'])){ pr($data[0]['student']); }

?>

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
	$averages=$data[$s]['averages'];

?>
<div class="wrapper">
		<div class="header">
			<div class="divLogo">
				<img src='<?php echo $logo_src; ?>' alt="logo" height="88" width="76">
			</div>
			<div class="school-info">
				<div class="center">
					<span class="school-name">ST. ANTHONY SCHOOL </span><br>
					<span><small>Singalong, Manila</small></span><br>
					<span>PAASCU <i>Accredited</i></span><br>
					<span>Senior High School</span><br>
					<span><b>PROGRESS REPORT CARD</b></span>
				</div>
			</div>
			<div>
				<small>SF9</small>
			</div>
		</div>	<!-- header -->
		<hr>
		<div class="student-info">
			<table class="tbl-student">
				<tr>
					<td colspan="4" class="stud-name"><center><?php echo $student['name']; ?></center></td>
				</tr>
				<tr>
					<td>LRN</td>
					<td><?php echo $student['lrn']; ?></td>
					<td>School Year</td>
					<td>2018 - 2019</td>
				</tr>
				<tr>
					<td>ID Number</td>
					<td><?php echo $student['code']; ?></td>
					<td>Gender</td>
					<td>F</td>
				</tr>
				<tr>
					<td>Birth Date</td>
					<td colspan="3">08-11-2002</td>
				</tr>
				<tr>
					<td>Grade & Section</td>
					<td colspan="3">Grade 11 - S. MAXIMILIAN KOLBE (ABM)</td>
				</tr>
			</table>
		</div>	<!-- studinfo -->
		<div class="grades">
			<table class="gis-table-bordered" >
				<tr class="thead">
					<th>Subject</th>
					<th>Q1</th>
					<th>Q2</th>
					<th>Q3</th>
					<th>Q4</th>
					<th>Final</th>
				</tr>
				<?php foreach($grades AS $grade): ?>
				<tr>
					<td class="colSubject"><?php echo $grade['subject']; ?></td>
					<td class="colGrades"><?php echo $grade['q1']; ?></td>
					<td class="colGrades"><?php echo $grade['q2']; ?></td>
					<td class="colGrades"><?php echo $grade['q3']; ?></td>
					<td class="colGrades"><?php echo $grade['q4']; ?></td>
					<td class="colGrades"><?php echo $grade['q5']; ?></td>
				</tr>
				<?php endforeach; ?>
				<tr>
					<td>&nbsp;</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td class="colSubject"><b>GENERAL AVERAGE</b></td>
					<td class="colGrades"><?php echo $averages['q1_ave']; ?></td>
					<td class="colGrades"><?php echo $averages['q2_ave']; ?></td>
					<td class="colGrades"><?php echo $averages['q3_ave']; ?></td>
					<td class="colGrades"><?php echo $averages['q4_ave']; ?></td>
					<td class="colGrades"><?php echo $averages['final_ave']; ?></td>
				</tr>
			</table>
		</div>
		<small class="sm-text">GRADING SYSTEM: AVERAGING</small>
		<div class="attendance">
			<table class="gis-table-bordered" >
				<tr>
					<th></th>
					<?php foreach($months AS $month): ?>
						<th><?php echo ucfirst($month); ?></th>
					<?php endforeach; ?>
				</tr>
				<tr>
					<th>Days Present</th>
					<?php foreach($months AS $month): ?>
						<td class="attd-data"><?php echo $attendance[$month.'_days_present']; ?></td>
					<?php endforeach; ?>			
				</tr>
				<tr>
					<th>Days Tardy</th>
					<?php foreach($months AS $month): ?>
						<td class="attd-data"><?php echo $attendance[$month.'_days_tardy']; ?></td>
					<?php endforeach; ?>			
				</tr>
			</table>
		</div>
		<div class="retained">
			<small class="sm-text">Lack units in: </small>
			<?php if($student['is_promoted'] == 1) :?>
				<center>
					<small>Eligible for admission to <u><?php echo $student['level']; ?></u> Date Issued: <u>April 04, 2019</u></small>
				</center>
			<?php else: ?>
				<center>
					<small>Retained to <u><?php echo $student['level']; ?></u> Date Issued: <u>April 04, 2019</u></small>
				</center>
			<?php endif ?>
		</div>
		<div class="signatory">
			<table>
				<tr>
					<td>
						_________________________ <br>
						<small> Eden A. Alab</small><br>
						<small>Class Adviser</small>
					</td>
					<td>
						_________________________ <br>
						<small>Susan S. Canlas</small><br>
						<small>Principal</small>
					</td>
				</tr>
			</table>
			<table>
				<tr>
					<td colspan="2">
						<small>CANCELLATION OF ELEGIBILITY TO TRANSFER <br>
						Has been admitted to: ________________________________________________</small>
					</td>
				</tr>
			</table>
			<table>
				<tr>
					<td>
						_________________________ <br>
						<small>Director/Principal</small>
					</td>
					<td>
						_________________________ <br>
						<small>Date Recieve</small>
					</td>
				</tr>
			</table>
		</div>

</div>	<!-- wrapper -->
<br><br>
<div class="clear" ></div>
<p class="pagebreak" ></p>
<?php endfor; ?>




