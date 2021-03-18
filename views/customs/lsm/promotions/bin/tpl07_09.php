<a target='blank' href='<?php echo URL."promotions/report/".$crid."?tpl=1&default"; ?>' >Template One</a>
<a target='blank' href='<?php echo URL."promotions/report/".$crid."?tpl=2&default"; ?>' >Template Two</a>
| <a target='blank' href='<?php echo URL."promotions/report/".$crid."?tpl=3&default"; ?>' >Template Three</a>
| <a class="u" id="btnExport" >Excel</a> 
xxxxxx
<script>
	$(function(){ 
		hd(); 
		excel();
	})
	
	
	
</script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>


<h5 class="screen hd" >
Num Subjects: <?php echo $numsub; ?> <br />
Num Limits: <?php echo $numsub; ?> <br />
</h5>	<!-- screen -->


<?php 

/* CUSTOM */
	$limits = $numsub;


/* ETC */	
	$tblwidth = "1000px";
	$ftable = 'tf14';
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

@media print{ .screen{display:none;} }

#pcont{ 
	width:<?php echo $tblwidth; ?>; border:1px solid white; 

}

	


#phead {color:; width:100%;}






</style>

<!--

-->




<!------------------------------------------------------------------------------------------------->


<div id="pcont" class="portrait" >
<div id="phead" class="" >

<?php include_once('phead01_06.php'); ?>
	
	
</div>	<!-- phead -->




<div id="pbody" class="pdl10" >
<table id="tblExport" class="gis-table-bordered-print table-fx tf14 <?php echo $tblwidth; ?>" >
<thead>
<tr class="<?php echo $fhead; ?>" >
	<th rowspan="2" class="vc50" >LRN</th>

	<th rowspan="2" class="pct30" >NAMES <br />
		(Surnames First, listed alphabetically)
	</th>
	<th rowspan="2" class="pct40" >HOME ADDRESS</th>
	<th rowspan="2" class="vc30" >YEARS<br />IN<br />SCHOOL</th>
	<th rowspan="2" class="vc30" >AGE</th>
	<th rowspan="2" class="vc40" >TOTAL<br />DAYS<br />IN<br />SCHOOL</th>
	<th rowspan="2" class="vc30" >FINAL<br />RATING</th>	
	<th rowspan="2" class="vc30" >ACTION<br />TAKEN</th>	
	<th rowspan="2" class="vc30" >Remarks</th>	
</tr>
</thead>

<tbody>
<?php for($t=0;$t<$numstud;$t++): ?>
<tr>
	<td class="vc60 <?php echo $ftxt; ?>" ><?php echo $students[$t]['lrn']; ?></td>
	<td class="vc150 <?php echo $ftxt; ?>" ><?php echo $students[$t]['student']; ?></td>
	<td class="vc200 <?php echo $ftxt; ?>" ><?php echo $students[$t]['address']; ?></td>
	<td><?php echo $students[$t]['years_in_school']; ?></td>
	<td><?php echo $students[$t]['age']; ?></td>
	<td><?php echo $students[$t]['num_days_present']; ?></td>
	<td><?php $fgenave  = $students[$t]['ave_q5']; echo number_format($fgenave,$decifgenave); ?></td>	
	<td><?php echo ($fgenave>=$passgrade)? "PROM":"RET"; ?></td>	
	<td><?php echo ($fgenave>=$passgrade)? "PROM":"RET"; ?></td>	

</tr>
<?php endfor; ?>
</tbody>


</table>
</div>	<!-- pbody -->


</div>	<!-- pcont -->

<p class="pagebreak" >&nbsp;</p>

<div class="landscape" >
<?php include_once('pfoot01_06.php'); ?>

</div>

<!----------------------------------------------------------------------------------->

<p class="pagebreak f20" >
<a href='<?php echo URL."promotions/reportBack/$crid/$sy"; ?>' >Back Page</a>
</p>