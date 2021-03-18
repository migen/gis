<h5 class="screen" >
Num Subjects: <?php echo $numsub; ?> <br />
Num Limits: <?php echo $numsub; ?> <br />
</h5>	<!-- screen -->


<?php 

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


?>

<link type='text/css' rel='stylesheet' href="prep_style.css" />

<style>

@media print{@page {size: landscape;}}

#pcont{ 
	width:1600px; border:1px solid blue; 

}

table, th, td {
	border: 1px solid black;
	border-collapse:collapse;
}
	
th.vertical-label{
	-webkit-transform: rotate(270deg) translateX(100%) translateY(10%);    
	-webkit-transform-origin: 100% 100%;
}
	
	
.vheader{
	
}



#phead {color:red; width:100%;}

.crs{
    width: 50px;
    white-space: normal;
	word-wrap:break-word;	
    overflow: hidden;
	
}

@media print{ .screen{display:none;} }




</style>

<!--

-->




<!------------------------------------------------------------------------------------------------->


<div id="pcont" >
<div id="phead" >
	<h2>Grade 4 to 6 Template</h2>

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
		<?php 
			$sub = $subjects[$s]['label'];
			$sub = textwrap($sub,6,"<br />\n");
		?>
		<th width="" height="200px" class=""><span class=""><?php echo $sub; ?></span></th>	
	<?php endfor; ?>
	<th class="vc60" >Conduct</th>	
	<th class="vc30" >Gen<br />Ave</th>	
	<th rowspan="2" class="vc30" >Status</th>	
</tr>

<tr class="headrow" >

	<th class="center" colspan="<?php echo $limits; ?>" >Final Rating</th>
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
	<?php endfor; ?>
	<td><?php $fconduct = $students[$t]['conduct_q5']; echo number_format($fconduct,$decigrades); ?></td>	

	<td><?php $fgenave  = $students[$t]['ave_q5']; echo number_format($fgenave,$decifgenave); ?></td>	
	<td><?php echo ($fgenave>=$passgrade)? "PROM":"RET"; ?></td>	

		
</tr>
<?php endfor; ?>
</tbody>


</table>
</div>	<!-- phead -->


</div>	<!-- pcont -->

