<?php 
	// pr($grades);

?>

<a target='blank' href='<?php echo URL."promotions/report/".$crid."?tpl=1"; ?>' >Template One</a>
| <a target='blank' href='<?php echo URL."promotions/report/".$crid."?tpl=3"; ?>' >Template Three</a>
| <a class="u" id="btnExport" >Excel</a> 


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
@media print{ .screen{display:none;} }

#pcont{ 
	width:1600px; border:1px solid white; 

}

	


#phead {color:; width:100%;}






</style>

<!--

-->




<!------------------------------------------------------------------------------------------------->


<div id="pcont" >
<div id="phead" >

<?php 
	$h2 = "tf16 ";
	$h1 = "tf18 ";
	$phead_align = "center";
	$levels = "(Grades IV - VI)";

?>
	<?php include_once('phead07_09.php'); ?>
	
	
</div>	<!-- phead -->

<div id="pbody" >
<table id="tblExport" class="gis-table-bordered-print table-fx <?php echo $ftable; ?>" >
<thead>
<tr class="<?php echo $fhead; ?>" >
	<th rowspan="2" class="vc50" >LRN</th>
	<th rowspan="2" class="vc100" >Student</th>
	<th rowspan="2" class="vc200" >Address</th>
	<th rowspan="2" class="vc30" >Yrs<br />in<br />Sch</th>
	<th rowspan="2" class="vc30" >Age</th>
	<th rowspan="2" class="vc40" >Total<br />Days</th>
	<th class="center" colspan="<?php echo $limits+1; ?>" >Final Rating</th>	
	<th rowspan="2" class="vc30" >Gen<br />Ave</th>	
	<th rowspan="2" class="vc30" >Action<br />Taken</th>	
</tr>


<tr class="" >

	<?php for($s=0;$s<$limits;$s++): ?>
		<?php 
			$sub = $subjects[$s]['label'];
			$sub = textwrap($sub,6,"<br />\n");
		?>
		<th width="" height="100px" class=""><span class=""><?php echo $sub; ?></span></th>	
	<?php endfor; ?>
	<th class="vc60" >Conduct</th>
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
	<?php for($u=0;$u<$limits;$u++): ?>
		<?php 
			$fg = ($grades[$t][$u]['q5']!=0)? $grades[$t][$u]['q5']:$grades[$t][$u]['q6']; 
			// echo "student T: $t <br />"; 
			// echo "subject U: $u <br />"; 
			// pr($grades[$t][$u]);
			// pr($fg);
		?>
		<td><?php echo number_format($fg,$decigrades); ?></td>
	<?php endfor; ?>
	<td><?php $fconduct = $students[$t]['conduct_q5']; echo number_format($fconduct,$decigrades); ?></td>	

	<td><?php $fgenave  = $students[$t]['ave_q5']; echo number_format($fgenave,$decifgenave); ?></td>	
	<td><?php echo ($fgenave>=$passgrade)? "PROM":"RET"; ?></td>	

		
</tr>
<?php endfor; ?>
</tbody>


</table>
</div>	<!-- pbody -->

<?php 

?>
	<?php include_once('pfoot07_09.php'); ?>


</div>	<!-- pcont -->

