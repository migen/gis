<style>

.tbp th, .tbp td  { padding:1px 2px;}


</style>

<?php 
// pr($sq1);

?>


<table class="tbl-print tbp table-center table-vcenter <?php echo $subfont.' '.$tblwidth; ?> " 
	style="border-top:4px solid black;" >

<tr class="<?php echo $headrowfont; ?>" ><th style="width:300px;" SUBJECTS</th>
<th><?php echo $intsq1; ?></th>
<th><?php echo $intsq2; ?></th>
<th class="" ><?php echo $semOrdinal; ?><br />Semester<br />Final Rating</th>
</tr>


<?php $failedsub = ""; ?>
<?php for($g=0;$g<$numacad;$g++): ?>

<?php $child 	= ($grades[$g]['supsubject_id']>0)? true:false; ?>
<tr class="" >

<td style="width:<?php echo $subw; ?>;padding-left:<?php echo ($child)? '20px;':'6px;'; ?>;text-align:left;" >
	<?php echo $grades[$g]['subject']; ?>	
</td>



	<td><?php $g1 = ($grades[$g][$sq1] != 0)? number_format($grades[$g][$sq1],$decicard) : ''; echo $g1; ?></td>
	<td><?php $g2 = ($grades[$g][$sq2] != 0)? number_format($grades[$g][$sq2],$decicard) : ''; echo ($qtr>1 )? $g2:NULL; ?></td>
	<td>
		
		<?php if(!$qodd){ $fg=number_format($grades[$g][$fqtr],$deciave_shs); echo $fg; } ?>
		<?php 
		
		?>
	
	</td>
	
</tr>

<?php endfor; ?>

<tr class="<?php echo $blankfont; ?>" > <td>&nbsp;</td><td></td><td></td><td></td></tr>

<tr class="<?php echo $blankfont; ?>" > <th class="left" >Gen. Ave.</th>
	<th><?php echo number_format($students[$i]['summary']['ave_'.$sq1],$decigenave); ?></th>
	<th><?php if(!$qodd): ?>
		<?php echo number_format($students[$i]['summary']['ave_'.$sq2],$decigenave); ?>	
	<?php endif; ?></th>
	<td></td>
</tr>





<?php if(!$qodd): ?>
<tr><th class="left" colspan="3">General Average for 1st Semester</th>
<?php $s1genave=round($students[$i]['summary']['ave_q5'],$decifgenave);?>
<th><?php echo number_format($s1genave,$decifgenave); ?></th></tr>

<?php if($qtr>2): ?>	<!-- sem2 -->
<tr><th class="left" colspan="3">General Average for 2nd Semester</th>
<?php $s2genave=round($students[$i]['summary']['ave_q6'],$decifgenave);?>
<th><?php echo number_format($s2genave,$decifgenave); ?></th></tr>

<tr>
<th class="left" colspan="3">General Average for the Academic Year</th>
<?php 
$sygenave=(round($students[$i]['summary']['ave_q5'],$decifgenave)+round($students[$i]['summary']['ave_q6'],$decifgenave))/2;
?>
<th><?php echo number_format($sygenave,$decifgenave); ?></th>
</tr>	
	
<?php endif; ?>	<!-- sem2 -->


<?php endif; ?>


</table>

<table class="no-gis-table-bordered table-center table-vcenter <?php echo $footfont.' '.$tblwidth; ?>" >
	<tr class="left" ><td class="left" colspan="2" >GRADING SYSTEM: AVERAGING</td></tr>
</table>

