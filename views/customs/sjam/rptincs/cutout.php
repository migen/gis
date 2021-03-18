<div id="cutout" class="center" >

<?php if($qtr<4): ?>	<!-- if qtr<4 -->
<div class="clear <?php echo $tblwidth; ?> clear" > <hr class="broken" /> </div>
<table  class="no-gis-table-bordered table-center table-vcenter <?php echo $docfont.' '.$tblwidth; ?>" >

<tr class="left f12" ><td colspan="2" >I hereby acknowledge that I have received and read 
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
<table class="no-gis-table-bordered table-center table-vcenter <?php echo $docfont.' '.$tblwidth; ?>" >

<tr class="left tf12" ><td class="left" colspan="2" >Lacks units in: <?php echo rtrim($failedsub,', '); ?> </td></tr>
<?php 
	
?>

<tr><td colspan="2" >
<?php if(empty($failedsub)): ?>	<!-- promotion failedsub -->
	Eligible for transfer and admission to <span class="u" ><?php echo $levelnxt; ?></span>
<?php else: ?>	<!-- promotion failedsub -->
	Retained in <span class="u" ><?php echo $levelnow; ?></span> 
<?php endif; ?>	<!-- promotion failedsub -->
Date Issued: <span class="u" ><?php $issued = $_SESSION['settings']['rcard_issued']; 
	echo date('F d, Y',strtotime($issued)); ?></span></td></tr>
<tr><th colspan="2" >&nbsp;</th></tr>
<tr><td>________________________________</td><td>________________________________</td></tr>
<tr class="center" ><td><?php print($classroom['adviser']); ?></td><td>Susan S. Canlas</td></tr>

<tr class="center" >
	<td>Class Adviser <span class="vc30"> &nbsp; </span> </td>
	<td>Principal</td>
</tr>

<tr><td colspan="2" >&nbsp;</td></tr>
<tr><td colspan="2" ><hr /></td></tr>

<tr class="left" ><td colspan="2" >CANCELLATION OF ELIGIBILITY TO TRANSFER</td></tr>
<tr class="left" ><td colspan="2" >Has been admitted to: ____________________________________</td></tr>

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
