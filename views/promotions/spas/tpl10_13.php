<h5 class="screen" >
Num Subjects: <?php echo $numsub; ?> <br />
Num Limits: <?php echo $numsub; ?> <br />
</h5>	<!-- screen -->


<?php 
	// pr($students[0]);

/* CUSTOM */
	$limits = $numsub;


/* ETC */	
	$ftable = 'tf12';
	$fhead  = 'tf14';
	$ftxt  	= 16;
	$fstat 	= 'f10';
	$fsub	= "f10";
	$numgr = count($grades);
	$passgrade   = $_SESSION['settings']['passing_grade'];
	$decigrades  = $_SESSION['settings']['decigrades'];
	$decifgenave = $_SESSION['settings']['decifgenave'];
	// pr($_SESSION['settings']['passing_grade']);
	
	
	// pr($grades[0][0]);
	// pr($grades);

?>

<link type='text/css' rel='stylesheet' href="prep_style.css" />

<style>

@media print{@page {size: landscape;}}

#pcont{ 
	width:1600px; border:1px solid blue; 

}




#phead {color:red; width:100%;}

.crs{
    width: 70px;
    white-space: normal;
	word-wrap:break-word;	
    overflow: hidden;
	
}

@media print{ .screen{display:none;} }


</style>

<!--


    white-space: nowrap;
	
	font-size:9px;
    width: 80px;
    overflow: hidden;
    display: inline-block;
    white-space: normal;
	word-wrap:break-word	
-->




<!------------------------------------------------------------------------------------------------->


<div id="pcont" >
<div id="phead" >
	<h2>Year 1 to Year 4 Template</h2>

</div>	<!-- phead -->

<div id="pbody" >
<table class="gis-table-bordered-print table-fx <?php echo $ftable; ?>" >
<thead>
<tr class="headrow <?php echo $fhead; ?>" >
	<th rowspan="2" class="vc100" >Student</th>
	<th rowspan="2" class="vc200" >Address</th>
	<th rowspan="2" class="vc30" >Yrs<br />in<br />Sch</th>
	<th rowspan="2" class="vc30" >Age</th>
	<th rowspan="2" class="vc40" >Total<br />Days</th>
	<?php for($s=0;$s<$limits;$s++): ?>
		<th colspan="2" class="crs <?php echo $fsub; ?>" ><?php echo $subjects[$s]['label']; ?></th>
	<?php endfor; ?>
	<th colspan="2" class="vc60" >Conduct</th>	
	<th rowspan="2" class="vc30" >Gen<br />Ave</th>	
	<th rowspan="2" class="vc30" >Status</th>	
</tr>

<tr class="headrow" >
	<?php for($s=0;$s<$limits;$s++): ?>
		<th>G</th>
		<th class="tf12" >Action<br />Taken</th>
	<?php endfor; ?>
	<th>&nbsp;</th>
	<th>&nbsp;</th>
</tr>
</thead>
<tbody>
<?php for($t=0;$t<$numstud;$t++): ?>
<tr>
	<td class="vc150 <?php echo $ftxt; ?>" ><?php echo $students[$t]['student']; ?></td>
	<td class="vc200 <?php echo $ftxt; ?>" ><?php echo $students[$t]['address']; ?></td>
	<td><?php echo $students[$t]['years_in_school']; ?></td>
	<td><?php echo $students[$t]['age']; ?></td>
	<td><?php echo $students[$t]['num_days_present']; ?></td>
	<?php for($u=0;$u<$limits;$u++): ?>
		<?php $fg = ($grades[$t][$u]['q5']!=0)? $grades[$t][$u]['q5']:$grades[$t][$u]['q6']; ?>
		<td><?php echo number_format($fg,$decigrades); ?></td>
		<td class="<?php echo $fstat; ?>" ><?php echo ($fg>=$passgrade)? "Passed":"Failed"; ?></td>
	<?php endfor; ?>
	<td><?php $fconduct = $students[$t]['conduct_q5']; echo number_format($fconduct,$decigrades); ?></td>	
	<td class="<?php echo $fstat; ?>" ><?php echo ($fconduct>=$passgrade)? "Passed":"Failed"; ?></td>			
	<td><?php $fgenave  = $students[$t]['ave_q5']; echo number_format($fgenave,$decifgenave); ?></td>	
	<td><?php echo ($fgenave>=$passgrade)? "PROM":"RET"; ?></td>	

		
</tr>
<?php endfor; ?>
</tbody>


</table>
</div>	<!-- phead -->


</div>	<!-- pcont -->

