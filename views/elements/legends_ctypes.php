<?php

$ctype=$data['ctype'];
$dept=$data['dept'];
$ratings=$data['ratings'];


$ctypes = array(
	'1'=>'Academics',
	'2'=>'Traits',
	'5'=>'Conducts',
	'7'=>'Elective',
); 

$depts = array(
	'1'=>'PS',
	'2'=>'GS',
	'3'=>'HS',
); 


?>

<table class="gis-table-bordered" >
<tr>
<td>Legends:</td>
<td>
<?php // pr($ratings); 
	$str = "100 - ";
	foreach($ratings AS $row){
		$str .= $row['grade'].' ('.$row['rating'].') | ';
	}
	$str = rtrim($str," | ");
	echo $str;

?>

</td>
</tr>

</table>	