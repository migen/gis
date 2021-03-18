<?php 

// pr($student);
// exit;

// $summary=$student['summary'];
// $currLvl=$student['level_id'];
// $promLvl=$student['level_id']+1;
// $is_promoted=$summary['is_promoted'];
// $currLevel=$student['level'];
// $promLevel=$promLvl-3;

$is_promoted=$student['summary']['is_promoted'];
$lvl=$student['level_id'];$promlvl=$lvl-2;
$issued = $_SESSION['settings']['rcard_issued'];
$currLevel=$student['level'];
$promLevel="Grade ".$promlvl;
if($promlvl>12){ $promLevel="College"; }


// echo "currLevel: $currLevel <br /> ";
// echo "promLevel: $promLevel <br /> ";


?>

<div id="cutout" class="center" >

<?php if($qtr<4): ?>	<!-- if qtr<4 -->
<div class="clear <?php echo $tblwidth; ?> clear" > <hr class="broken" /> </div>
<table  class="no-table-bordered table-center table-vcenter <?php echo $docfont.' '.$tblwidth; ?>" >

<tr class="f12" ><td colspan="2" >I hereby acknowledge that I have received and read 
the QUARTERLY REPORT CARD of my son / daughter.
</td></tr>

<tr><th colspan="2" >&nbsp;</th></tr>

<tr class="center" >
	<td>__________________________ <span class="vc30"> &nbsp; </span> </td>
	<td>__________________________ </td>
</tr>

<tr class="center" >
	<td>Signature over printed name<span class="vc10"> &nbsp; </span> </td>
	<td>Date</td>
</tr>

</table>

<?php else: ?>	<!-- if qtr<4 -->
<table class="no-table-bordered table-center table-vcenter <?php echo $docfont.' '.$tblwidth; ?>" >

<tr class="left tf12" ><td class="left" colspan="2" >Lacks units in: <?php echo rtrim($failedsub,', '); ?> </td></tr>
<?php 
	
?>

<tr><td colspan="2" >
<?php if(empty($failedsub)): ?>	<!-- promotion failedsub -->
	<?php if($is_promoted): ?>
		Eligible for admission to <span class="u" ><?php echo $promLevel; ?></span>
	<?php else: ?>
		Retained to <span class="u" ><?php echo $currLevel; ?></span>	
	<?php endif; ?>

	
<?php else: ?>	<!-- promotion failedsub -->
	Retained in <span class="u" ><?php echo $levelnow; ?></span> 
<?php endif; ?>	<!-- promotion failedsub -->
<?php $issued = $_SESSION['settings']['rcard_issued']; ?>
&nbsp;&nbsp;
Date Issued: <span class="<?php echo ($issued)? "u":null; ?>" >
	<?php echo ($issued)? date('F d, Y',strtotime($issued)):"____________________"; ?></span>
</td></tr>
<tr><th colspan="2" >&nbsp;</th></tr>
<tr><td>________________________________</td><td>________________________________</td></tr>
<tr class="center" ><td><?php print($classroom['adviser']); ?></td><td><?php echo $_SESSION['settings']['school_principal']; ?></td></tr>

<tr class="center" >
	<td>Class Adviser <span class="vc30"> &nbsp; </span> </td>
	<td>Principal</td>
</tr>

<tr><td colspan="2" >&nbsp;</td></tr>
<tr><td colspan="2" ><hr /></td></tr>

<tr class="" ><td colspan="2" >CANCELLATION OF ELIGIBILITY TO TRANSFER</td></tr>
<tr class="" ><td colspan="2" >Has been admitted to: ____________________________________</td></tr>

<tr><th colspan="2" >&nbsp;</th></tr>

<tr class="center" >
	<td>__________________________ <span class="vc30"> &nbsp; </span> </td>
	<td>__________________________ </td>
</tr>

<tr class="center" >
	<td>Director/Principal <span class="vc10"> &nbsp; </span> </td>
	<td>Date Received</td>
</tr>

</table>
<?php endif; ?>	<!-- if qtr<4 -->
</div>	<!-- cutout -->
