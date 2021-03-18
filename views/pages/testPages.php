<h5>
	Pages | <?php $this->shovel('homelinks'); ?>
	
	
</h5>

<?php

$conn=mysqli_connect("localhost","root",""); 
// $conn=mysqli_connect("localhost","root",""); 

mysqli_select_db($conn,PDBO);

pr(PDBO);

$q="SELECT id,name FROM contacts WHERE role_id=1 ORDER BY name LIMIT 10; ";
pr($q);
$result=mysqli_query($conn,$q);
$numrows=mysqli_num_rows($result);



// $sth=mysqli_query($conn,$q);
// $rows=mysqli_num_rows($sth);


// pr($rows);

