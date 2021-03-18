
<?php 





$logo_src=URL."views/honors/img/sjam-logo.png";
$frame_src=URL."views/honors/img/border-img.png";

$cr=&$data['cr'];
$count=&$data['count'];
$rows=&$data['count'];
$sy=&$data['sy'];
$qtr=&$data['qtr'];
$date=&$data['date'];


// pr($data);
// pr($data['rows']);

function convertNumtoRank($num){
	switch($num){
		case 1: return "WITH HIGHEST";break;
		case 2: return "WITH HIGH";break;
		case 3: return "WITH";break;
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
	<link rel="stylesheet" type="text/css" href="<?php echo URL.'views/customs/sjam/honors/cert_sjam.css'; ?>">	
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

	// pr($data['rows'][$i]);
?>

<div class="certificate-wrapper">
	<div class="certificate-image">
		<figure class="image">
			<img src="<?php echo $frame_src; ?>" alt="certImage">
		</figure>
	</div>
	<div class="certificate-details">
		<div class="header">
			<figure class="school-logo">
				<img src="<?php echo $logo_src; ?>" alt="school-logo">
			</figure>
			<div class="school-info">
				<div class="name"><?php echo $school_name; ?></div>
				<div class="address"><?php echo $school_city; ?></div>
				<div class="credit">(PAASCU LEVEL II ACCREDITED)</div>
				<div class="basicEd">Basic Education Department</div>
				<div class="level">Junior High School Level</div>
				<div class="sy">School Year <?php echo $sy.' - '.($sy+1); ?></div>
			</div>
		</div>
		<div class="content">
			<div class="this">This <?php echo $qtr_word; ?> Quarter</div>
			<div class="acadAwards">Conduct Award</div>
			<div class="givenTo">IS PROUDLY GIVEN TO</div>
			<div class="student-name"><u><?php echo $student; ?></u></div>
			<div class="lvlSection"><?php echo $cr['level'].' - '.$cr['section']; ?></div>
			<div class="rank">&nbsp;</div>
		</div>
		<div class="footer">
			<div class="data-item">
				<div class="school-head">
					<u>Mr. Alfredo S. Rosete, Jr.</u><br>
					<small>High School Prefect of Students</small>
				</div>
				<!-- <div class="qtr"><?php echo $qtr_word; ?> QUARTER</div> -->
			</div>
			<div class="data-item">
				<div class="school-head">
					<u><?php echo $principal_bed; ?></u><br>
					<small>Basic Education Principal</small>
				</div>
				<!-- <div class="date"><?php echo date("F d, Y", strtotime($date)); ?></div> -->
			</div>
		</div>
	</div>
</div>
<!-- <div class="pagebreak" ></div> -->
<?php endfor; ?>	<!-- per student -->
	
</body>
</html>