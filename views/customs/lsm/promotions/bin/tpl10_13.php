<a target='blank' href='<?php echo URL."promotions/report/".$crid."?tpl=1"; ?>' >Template One</a>
| <a target='blank' href='<?php echo URL."promotions/report/".$crid."?tpl=2"; ?>' >Template Two</a>
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
	$decicard=$_SESSION['settings']['deciave_hs'];
	$decifgenave = $_SESSION['settings']['decifgenave'];
	// pr($_SESSION['settings']['passing_grade']);
	

?>

<link type='text/css' rel='stylesheet' href="prep_style.css" />

<style>

@media print{@page {size: landscape;}}

#pcont{ 
	width:1600px; border:1px solid WHITE; 

}




#phead {width:100%;}

.crs{
    width: 70px;
    white-space: normal;
	word-wrap:break-word;	
    overflow: hidden;
	
}

@media print{ .screen{display:none;} }


</style>




<div id="pcont" >
<div id="phead" >

<?php 
	$h2 = "tf16 ";
	$h1 = "tf18 ";
	$phead_align = "center";

?>
	<?php include_once('phead10_13.php'); ?>
	
	
</div>	<!-- phead -->

<div id="pbody" >
<table id="tblExport" class="gis-table-bordered-print table-fx <?php echo $ftable; ?>" >
<thead>
<tr class="headrow <?php echo $fhead; ?>" >
	<th rowspan="2" class="vc50" >LRN</th>
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
	<td class="vc60 <?php echo $ftxt; ?>" ><?php echo $students[$t]['lrn']; ?></td>
	<td class="vc150 <?php echo $ftxt; ?>" ><?php echo $students[$t]['student']; ?></td>
	<td class="vc200 <?php echo $ftxt; ?>" ><?php echo $students[$t]['address']; ?></td>
	<td><?php echo $students[$t]['years_in_school']; ?></td>
	<td><?php echo $students[$t]['age']; ?></td>
	<td><?php echo $students[$t]['num_days_present']; ?></td>
	<?php for($u=0;$u<$limits;$u++): ?>
		<?php $fg = ($grades[$t][$u]['q5']!=0)? $grades[$t][$u]['q5']:$grades[$t][$u]['q6']; ?>
		<td><?php echo number_format($fg,$decicard); ?></td>
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
</div>	<!-- pbody -->

<?php include_once('pfoot10_13.php'); ?>


</div>	<!-- pcont -->

