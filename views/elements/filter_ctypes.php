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
<td><select id="ctype" class="vc100" >
<?php foreach($ctypes AS $k=>$v): ?>
	<option value="<?php echo $k; ?>" <?php echo ($k==$ctype)?'selected':NULL; ?> ><?php echo $v; ?></option>
	<?php endforeach; ?>
</select></td>
<td><select id="dept" class="vc60" >
<?php foreach($depts AS $k=>$v): ?>
	<option value="<?php echo $k; ?>" <?php echo ($k==$dept)?'selected':NULL; ?> ><?php echo $v; ?></option>
	<?php endforeach; ?>
</select></td>
<td><button><a onclick="redirCtype();return false;" >Ratings</a></button></td>
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