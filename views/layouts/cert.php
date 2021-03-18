<style>

html, body {
	margin: 0;
	padding: 0;
	height: 100%;
	width: inherit;
/*	font-family:Arial,Helmet,Freesans,sans-serif;*/
	background:ffffff;
	color:00000f;
}
.certificate {
	background-image: url('images/border-img.png');
	background-size: cover;
	padding-left: 100px;
	padding-right: 100px;
	padding-bottom: 70px;
	padding-top: 70px;
	text-align: center;
}
.school {
	margin-left: -300px;
}
.school-name {
	font-size: 25px;
}
.bed {
	font-size: 18px;
}
.adjPadding {
	margin-top: -8px;
}
.acadAward {
	margin-top: 10px;
	letter-spacing: 30px;
	font-size: 35px;
}	
.stud-name,
.teacher-name {
	text-decoration: underline;
}
.section {
	margin-top: -20px;
}

</style>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<title>Certificate</title>
</head>




<body>
<div id="content">

<?php 
	$tpl = SITE.'views/'.$template.'.php';
	// if(is_readable($tpl)){
	pr($template);
	include_once(SITE.'views/'.$template.'.php');			
	// } else {
		// include_once(SITE.'views/Default.php');				
	// }
	
?>


</div> <!-- #content -->


</body>
</html>
