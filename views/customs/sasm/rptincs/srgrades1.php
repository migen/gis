<style>

.tbp th, .tbp td  { padding:1px 2px;}


</style>

<?php 

$qodd = ($qtr%2);

// echo "vpo $vpo <br />";
// echo "hpo $hpo <br />";
?>


<table class="tbl-print tbp table-center table-vcenter <?php echo $subfont.' '.$tblwidth; ?> " 
	style="border-top:4px solid black;" >

<tr class="<?php echo $headrowfont; ?>" ><th class="<?php echo $subwidth; ?>" >SUBJECTS</th><th>Midterm</th><th>Finals</th>
<th class="" ><?php echo $semOrdinal; ?><br />Semester<br />Final Grade</th>
</tr>


<?php $failedsub = ""; ?>
<?php for($g=0;$g<$numacad;$g++): ?>

<?php $child 	= ($grades[$g]['supsubject_id']>0)? true:false; ?>
<tr class="" >
<td style="width:<?php echo $subw; ?>;<?php echo ($child)? 'padding-left:20px;':NULL; ?>;text-align:left;" >
	<?php echo $grades[$g]['subject']; ?>	
</td>


	<td><?php $g1 = ($grades[$g]['q1'] != 0)? number_format($grades[$g]['q1'],$decicard) : ''; echo $g1; ?></td>
	<td><?php $g2 = ($grades[$g]['q2'] != 0)? number_format($grades[$g]['q2'],$decicard) : ''; echo ($qtr>1 )? $g2:NULL; ?></td>
	<?php $fqtr = ($sem==1)? 'q5':'q6'; ?>	
	<td><?php if(!$qodd){ $fg=number_format($grades[$g][$fqtr],$deciave); echo $fg; } ?></td>
	
</tr>

<?php endfor; ?>

<tr class="<?php echo $blankfont; ?>" > <td>&nbsp;</td><td></td><td></td><td></tr>

<tr class="" >
	<th class="left" >General Average</th>
	<th><?php $s1 = number_format($students[$i]['summary']['ave_q1'],$decifgenave); echo $s1; ?></th>
	<th><?php $s2 = number_format($students[$i]['summary']['ave_q2'],$decifgenave); echo ($qtr>1 )? $s2:NULL; ?></th>
	<th></th>
</tr>



<tr class="" >
	<th class="left" colspan="3" >General Average for the Semester</th>

	<th><?php if(!$qodd){ echo number_format($students[$i]['summary']['ave_'.$fqtr],$decifgenave); } ?></th>

	
</tr>
</table>

<table class="no-gis-table-bordered table-center table-vcenter <?php echo $footfont.' '.$tblwidth; ?>" >
	<tr class="left" ><td class="left" colspan="2" >GRADING SYSTEM: AVERAGING</td></tr>
</table>

