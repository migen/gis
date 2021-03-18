<?php 

// pr($qtr);
// pr($classroom);
// pr($reports[0]);

// pr($k12);

// pr($legendcrs);
// pr($legendtr);

// pr($numbc);
// pr($numbtr);

/*  php-if traits then css-> @media print{@page{size:landscape}} */	

$rcardteac    = $_SESSION['settings']['rcardteac'];
$decicard     = $_SESSION['settings']['decicard'];
$deciconducts = $_SESSION['settings']['deciconducts'];
$decifconducts = $_SESSION['settings']['decifconducts'];
$decigenave    = $_SESSION['settings']['decigenave'];
$decifgenave   = $_SESSION['settings']['decifgenave'];


?>

<style>
	<?php if($traits): ?> @media print{@page{size:landscape}} <?php endif; ?>

@media print{
	.screen, #sidebar,.invisible,#mainMenu,#creportsPager,#gui,#header,#footer{display:none;}
	body{font-size:8pt;}	
}

	
</style>


<?php 


$logo_src = URL."views/customs/".VCFOLDER."/logo.png";

// pr($logo_src);


?>




<?php for($i=0;$i<$num_reports;$i++): ?>

<div class="rcard" >

<table class="no-gis-table-bordered table-fx tf9" >
	<tr><td class="tf8" >DepEd FORM 138-E</td><td class="center vc300" >Republic of the Philippines</td></tr>
	<tr><td rowspan="4" >
		<img style="float:left;" src='<?php echo $logo_src; ?>' alt="logo" height="48" width="48">	
	</td><td class="center" >Department of Education</td></tr>
	<tr><td class="center f16 b" ><?php echo $client['school']; ?></td></tr>
	<tr><td class="center" ><?php echo $client['city']; ?></td></tr>
	<tr><td class="center" ><?php echo 'PAASCU Accredited'; ?></td></tr>
</table>


<br />

<div class="rcardhalf" >

<table class="tf10" >
<tr><th class="vc100" >Student</th><td colspan="3" class="vc300" ><?php echo $reports[$i]['student']; ?></td></tr>
<tr><th>Level</th><td><?php echo $reports[$i]['level']; ?> </td>
<th>Section </th> <td> <?php echo $reports[$i]['section']; ?></td></tr>
<tr><th>Class Adviser</th><td colspan="3" ><?php echo $reports[$i]['adviser']; ?></td></tr>
</table>


<br />
<table class="rptcard" >
<tr><th rowspan="2" class="center vc120" >LEARNING <br /> AREAS</th><th colspan="8" class="vc200 center" >GRADING PERIODS</th>
<th rowspan="2" class="center" colspan="2" >FINAL <br />RATING</th>
<tr><th class="center" colspan="2" >1</th><th class="center" colspan="2" >2</th><th class="center" colspan="2" >3</th><th class="center" colspan="2" >4</th></tr>

<?php for($c=1;$c<=$numcrs;$c++): ?>
<tr>
	<td><?php $crs = isset($reports[$i]['crs'.$c])? $reports[$i]['crs'.$c] : '&nbsp;'; echo $crs; ?></td>
	<td class="center" ><?php echo number_format($reports[$i]['crs'.$c.'q1'],$decicard); ?></td>
	<td class="center" ><?php $dg = ($k12)? $reports[$i]['crs'.$c.'dg1']:'&nbsp;'; echo $dg; ?></td>
	
	<?php if($qtr>=2): ?>
		<td class="center" ><?php echo number_format($reports[$i]['crs'.$c.'q2'],$decicard); ?></td>
		<td class="center" ><?php $dg = ($k12)? $reports[$i]['crs'.$c.'dg2']:'&nbsp;'; echo $dg; ?></td>
	<?php else: ?>
		<td>&nbsp;</td><td>&nbsp;</td>
	<?php endif; ?>
	
	<?php if($qtr>=3): ?>
		<td class="center" ><?php echo number_format($reports[$i]['crs'.$c.'q3'],$decicard); ?></td>
		<td class="center" ><?php $dg = ($k12)? $reports[$i]['crs'.$c.'dg3']:'&nbsp;'; echo $dg; ?></td>
	<?php else: ?>
		<td>&nbsp;</td><td>&nbsp;</td>
	<?php endif; ?>
	
	<?php if($qtr>=4): ?>
		<td class="center" ><?php echo number_format($reports[$i]['crs'.$c.'q4'],$decicard); ?></td>
		<td class="center" ><?php $dg = ($k12)? $reports[$i]['crs'.$c.'dg4']:'&nbsp;'; echo $dg; ?></td>
	<?php else: ?>
		<td>&nbsp;</td><td>&nbsp;</td>
	<?php endif; ?>
	
	<?php if($qtr>=4): ?>
		<td class="center" ><?php echo $reports[$i]['crs'.$c.'fg']; ?></td>
		<td class="center" ><?php $dg = ($k12)? $reports[$i]['crs'.$c.'dgf']:'&nbsp;'; echo $dg; ?></td>
	<?php else: ?>
		<td>&nbsp;</td><td>&nbsp;</td>
	<?php endif; ?>
	

</tr>
<?php endfor; ?>


<?php for($d=0;$d<$numbc;$d++): ?>
<tr> 
	<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
	<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
</tr>
<?php endfor; ?>


<tr>
<th>Conduct</th>
<td class="center" ><?php echo $reports[$i]['sumcq1'] ?></td>
<td class="center" ><?php $dg = ($k12)? $reports[$i]['sumcdg1']:'&nbsp;'; echo $dg; ?></td>

<?php for($j=2;$j<5;$j++): ?>
	<?php if($qtr>=$j): ?>
		<td class="center" ><?php echo $reports[$i]['sumcq'.$j]; ?></td>
		<td class="center" ><?php $dg = ($k12)? $reports[$i]['sumcdg'.$j]:'&nbsp;'; echo $dg; ?></td>
	<?php else: ?>
		<td>&nbsp;</td><td>&nbsp;</td>
	<?php endif; ?>
<?php endfor; ?>

<?php if($qtr>=4): ?>
	<td class="center" ><?php echo $reports[$i]['sumcfg']; ?></td>
	<td class="center" ><?php $dg = ($k12)? $reports[$i]['sumcdgf']:'&nbsp;'; echo $dg; ?></td>
<?php else: ?>
	<td>&nbsp;</td><td>&nbsp;</td>
<?php endif; ?>

</tr>


<tr>
	<th>General Average</th>
	
	<td class="center" ><?php echo $reports[$i]['sumq1']; ?></td>
	<td class="center" ><?php $dg = ($k12)? $reports[$i]['sumdg1']:'&nbsp;'; echo $dg; ?></td>

<?php for($j=2;$j<5;$j++): ?>
	<?php if($qtr>=$j): ?>
		<td class="center" ><?php echo $reports[$i]['sumq'.$j]; ?></td>
		<td class="center" ><?php $dg = ($k12)? $reports[$i]['sumdg'.$j]:'&nbsp;'; echo $dg; ?></td>
	<?php else: ?>
		<td>&nbsp;</td><td>&nbsp;</td>
	<?php endif; ?>
<?php endfor; ?>

<?php if($qtr>=4): ?>
	<td class="center" ><?php echo $reports[$i]['sumfg']; ?></td>
	<td class="center" ><?php $dg = ($k12)? $reports[$i]['sumdgf']:'&nbsp;'; echo $dg; ?></td>
<?php else: ?>
	<td>&nbsp;</td><td>&nbsp;</td>
<?php endif; ?>
	
	
</tr>

</table>

<br />
<table class="rptcard">
	<tr><th class="vc200 b" colspan="2" > LEVEL OF PROFICIENCY </th><th class="vc120" > RANGE </th></tr>
	<?php foreach($legendcrs AS $row): ?>
		<tr>
		<td><?php echo $row['rating']; ?></td>
		<td><?php echo $row['description']; ?></td>
		<td><?php echo $row['grade_floor'].' - '.$row['grade_ceiling']; ?></td></tr>
	<?php endforeach; ?>
</table>


</div>

<!-------------------------------------------------------------------------------------------------------------------------->

<div class="forty" >


<h5 style="margin-left:120px;" > ATTENDANCE RECORD </h5>
<table class="rptcard" >
<tr>
<th> &nbsp; </th><th>
	<?php echo 'JUN'; ?></th><th><?php echo 'JUL'; ?></th><th><?php echo 'AUG'; ?></th><th><?php echo 'SEP'; ?></th>
	<th><?php echo 'OCT'; ?></th><th><?php echo 'NOV'; ?></th><th><?php echo 'DEC'; ?></th><th><?php echo 'JAN'; ?></th>
	<th><?php echo 'FEB'; ?></th><th><?php echo 'MAR'; ?></th>
	<th><?php echo 'APR'; ?></th><th><?php echo 'TOT'; ?></th>
</tr>

<tr>
<td>Total</td>
	<td><?php echo $reports[$i]['jun_days_total']; ?></td><td><?php echo $reports[$i]['jul_days_total']; ?></td>
	<td><?php echo $reports[$i]['aug_days_total']; ?></td><td><?php echo $reports[$i]['sep_days_total']; ?></td>
	<td><?php echo $reports[$i]['oct_days_total']; ?></td><td><?php echo $reports[$i]['nov_days_total']; ?></td>
	<td><?php echo $reports[$i]['dec_days_total']; ?></td><td><?php echo $reports[$i]['jan_days_total']; ?></td>
	<td><?php echo $reports[$i]['feb_days_total']; ?></td><td><?php echo $reports[$i]['mar_days_total']; ?></td>
	<td><?php echo $reports[$i]['apr_days_total']; ?></td><td><?php echo $reports[$i]['year_days_total']; ?></td>
</tr>

<tr>
<td>Present</td>
	<td><?php echo $reports[$i]['jun_days_present']; ?></td><td><?php echo $reports[$i]['jul_days_present']; ?></td>
	<td><?php echo $reports[$i]['aug_days_present']; ?></td><td><?php echo $reports[$i]['sep_days_present']; ?></td>
	<td><?php echo $reports[$i]['oct_days_present']; ?></td><td><?php echo $reports[$i]['nov_days_present']; ?></td>
	<td><?php echo $reports[$i]['dec_days_present']; ?></td><td><?php echo $reports[$i]['jan_days_present']; ?></td>
	<td><?php echo $reports[$i]['feb_days_present']; ?></td><td><?php echo $reports[$i]['mar_days_present']; ?></td>
	<td><?php echo $reports[$i]['apr_days_present']; ?></td><td><?php echo $reports[$i]['total_days_present']; ?></td>
</tr>

<tr>
<td>Tardy</td>
	<td><?php echo $reports[$i]['jun_days_tardy']; ?></td><td><?php echo $reports[$i]['jul_days_tardy']; ?></td>
	<td><?php echo $reports[$i]['aug_days_tardy']; ?></td><td><?php echo $reports[$i]['sep_days_tardy']; ?></td>
	<td><?php echo $reports[$i]['oct_days_tardy']; ?></td><td><?php echo $reports[$i]['nov_days_tardy']; ?></td>
	<td><?php echo $reports[$i]['dec_days_tardy']; ?></td><td><?php echo $reports[$i]['jan_days_tardy']; ?></td>
	<td><?php echo $reports[$i]['feb_days_tardy']; ?></td><td><?php echo $reports[$i]['mar_days_tardy']; ?></td>
	<td><?php echo $reports[$i]['apr_days_tardy']; ?></td><td><?php echo $reports[$i]['total_days_tardy']; ?></td>
</tr>
</table>



<?php if($traits): ?>
<br />
<table class="rptcard" >
<tr><th>Trait</th><th>Q1</th><th>Q2</th><th>Q3</th><th>Q4</th><th>FG</th></tr>

<?php for($t=1;$t<=$numtr;$t++): ?>
<tr>
	<td><?php $tr = isset($reports[$i]['tr'.$t])? $reports[$i]['tr'.$t] : '&nbsp;'; echo $tr; ?></td>	
	<td><?php echo $reports[$i]['tr'.$t.'q1']; ?></td>
	<td><?php echo ($qtr>=2)? $reports[$i]['tr'.$t.'q2']:'&nbsp'; ?></td>
	<td><?php echo ($qtr>=3)? $reports[$i]['tr'.$t.'q3']:'&nbsp'; ?></td>
	<td><?php echo ($qtr>=4)? $reports[$i]['tr'.$t.'q4']:'&nbsp'; ?></td>
	<td><?php echo ($qtr>=4)? $reports[$i]['tr'.$t.'fg']:'&nbsp'; ?></td>
</tr>

<?php endfor; ?>

<?php for($d=0;$d<$numbtr;$d++): ?>
<tr> <td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td> </tr>
<?php endfor; ?>


</table>

<br />
<table class="rptcard">
	<tr><th class="vc300 center" colspan="2" > MARKING SYSTEM </th></tr>
	<?php foreach($legendtr AS $row): ?>
	<tr><td><?php echo $row['grade_floor'].' - '.$row['grade_ceiling']; ?></td><td><?php echo $row['rating'].' : '.$row['description']; ?></td></tr>
	<?php endforeach; ?>
</table>



<?php endif; ?>	<!-- if traits -->


</div>

<div class="clear" > &nbsp; </div>

</div>

<span  class="screen"  ><hr /> </span>
<p class='pagebreak'> </p>

<?php endfor; ?>	<!-- num-reports -->



<link type='text/css' rel='stylesheet' href="<?php echo URL; ?>public/css/reports.css" />
<link type='text/css' rel='stylesheet' href="<?php echo URL; ?>public/css/style.css" />
