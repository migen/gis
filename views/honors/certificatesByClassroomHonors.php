<?php 
$logo_src=URL."views/honors/img/sjam-logo.png";
$frame_src=URL."views/honors/img/border-img.png";

$cr=&$data['cr'];
$count=&$data['count'];
$rows=&$data['count'];
$sy=&$data['sy'];
$qtr=&$data['qtr'];
$date=&$data['date'];


// pr($logo_src);
// pr($frame_src);


// pr($data);
// pr($data['rows']);

function convertNumtoRank($num){
	switch($num){
		case 1: return "First";break;
		case 2: return "Second";break;
		case 3: return "Third";break;
		default: return "NA";break;
	}
}

// $x=convertNumtoRank(2);


?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" type="text/css" href="<?php echo URL.'views/honors/css/cert.css'; ?>">	
	<title>Certificate</title>

</head>
<body>

<?php 



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
<?php 
	$student=$data['rows'][$i]['student']; 
	$genave=$data['rows'][$i]['genave']; 
	$honor=$data['rows'][$i]['honor'];
	$rank=convertNumToRank($honor);
	// pr($data['rows'][$i]);
?>

<div>		
		<center>
			<table class="certificate" >
				
				<thead>
					<tr>
						<th>
							<img src='<?php echo $logo_src; ?>' alt="logo" height="120" width="120">						
						</th>
						<th>
							<p class="school">
								<i class="school-name"><?php echo $school_name; ?></i><br>
								<small><?php echo $school_city; ?></small><br>
								<b><small>(PAASCU LEVEL II ACCREDITED)-D</small></b><br>
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
							<h2 class="adjPadding"><?php echo $rank; ?> HONORS</h2>
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


	
		

</body>
</html>