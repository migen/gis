<?php 
// views/customs/'.VCFOLDER.'/incs/border-img.png

$logo_src = URL."public/images/weblogo_".VCFOLDER.".png";
$frame_src = URL."views/customs/".VCFOLDER."/incs/border-img.png";
pr($logo_src);
	// background-image: url('../img/border-img.png');


?>

<style>

.certificate { 
	background-image: url('images/border-img.png');
	background-size: cover;padding-left: 100px;padding-right: 100px;padding-bottom: 70px;padding-top: 70px;text-align: center; 
}
.school { margin-left: -300px; }
.school-name { font-size: 25px; }
.bed { font-size: 18px; }
.adjPadding { margin-top: -8px; }
.acadAward { margin-top: 10px;letter-spacing: 30px;font-size: 35px;}	
.stud-name,.teacher-name { text-decoration: underline; }
.section { margin-top: -20px; }


</style>

<link rel="stylesheet" type="text/css" href="<?php echo URL.'views/customs/'.VCFOLDER.'/incs/cert.css'; ?>">


<?php 

// pr($data);
// exit;


$dept_id=$cr['department_id'];
function getDept($dept_id){	
	switch($dept_id){
		case 3: $dr['dept']="hs";$dr['department']="High School";$break;
		default: $dr['dept']="gs";$dr['department']="Grade School";break;
	}
	return $dr;
}	/* fxn */

$dr=getDept($dept_id);
$dept=$dr['dept'];
$department=$dr['department'];
$classroom=$cr['name'];

$school_name=$_SESSION['settings']['school_name'];
$school_city=$_SESSION['settings']['school_city'];
$principal_bed=$_SESSION['settings']['school_principal'];
$principal_dept=$_SESSION['settings']['school_principal_'.$dept];



?>

<?php for($i=0;$i<$count;$i++): ?>
<?php $student=$rows[$i]['name']; ?>

<div>		
		<center>
			<table class="certificate">
				
				<thead>
					<tr>
						<th>
							<img src='<?php echo $logo_src; ?>' alt="logo" height="120" width="120">						
						</th>
						<th>
							<p class="school">
								<i class="school-name"><?php echo $school_name; ?></i><br>
								<small><?php echo $school_city; ?></small><br>
								<b><small>(PAASCU LEVEL II ACCREDITED)</small></b><br>
								<b class="bed">Basic Education Department</b><br>
								<b class="bed"><i><?php echo $department; ?> Level</i></b><br>
								School Year <?php echo $sy.' - '.($sy+1); ?>
							</p>
						</th>
					</tr>
				</thead>
				<tbody>
					<center>
					<tr>
						<td colspan="2">
							<h2 class="thistext" >This</h2>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<h2 class="adjPadding">THIRD HONORS</h2>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<p class="adjPadding acadAward">ACADEMIC AWARD</p>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<h5 class="adjPadding">is given to</h5>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<h1 class="adjPadding stud-name"><?php echo $student; ?></h1>
							<p class="section"><?php echo $classroom; ?></p>
						</td>
					</tr>
					<tr>
						<td>
							<p>
								<b class="teacher-name"><?php echo $principal_dept; ?></b><br>
								<small>Assistant Principal for Academic Affairs</small><br>
								<b><p><?php echo $qtr; ?> QUARTER</p></b>
							</p>
						</td>
						<td>
							<p>
								<b class="teacher-name"><?php echo $principal_bed; ?></b><br>
								<small>Basic Education Principal</small><br>
								<b><p><?php echo $date; ?></p></b>
							</p>
						</td>
					</tr>
					</center>
				</tbody>
			</table>
		</center>
</div>

<div class="pagebreak" ></div>
<?php endfor; ?>	<!-- per student -->


