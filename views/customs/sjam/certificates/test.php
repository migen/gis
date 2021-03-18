<?php


// $frame_src=URL."views/customs/sjam/honors/img/border-img.png";
// $logo_src=URL."views/certificates/img/sjam-logo.png";

// $logo_src=URL."views/certificates/img/sjam-logo.png";
// $frame_src=URL."views/certificates/img/border-img.png";

$logo_src=URL."public/images/sjam/sjam-logo.png";
$frame_src=URL."public/images/sjam/border-img.png";


pr($logo_src);
pr($frame_src);


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


<img src="<?php echo $frame_src; ?>" alt="certImage">
<img src="<?php echo $logo_src; ?>" alt="logoImage">



</body>
</html>
