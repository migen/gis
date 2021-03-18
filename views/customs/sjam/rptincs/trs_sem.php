<?php
	$conducts = $students[$i]['conducts'];

	
?>


<table class="tbl-print tbp table-center table-vcenter <?php echo $subfont.' '.$tblwidth; ?> " 
	style="border-top:4px solid black;" >
<tr class="<?php echo $headrowfont; ?>" ><th class="<?php echo $subwidth; ?>" >WORKHEALTH HABITS</th><th>1st</th><th>2nd</th></tr>


<?php for($ic=0;$ic<$numtraits;$ic++): ?>
<tr>
	<td style="width:<?php echo $subw; ?>;text-align:left;" ><?php echo $conducts[$ic]['trait']; ?></td>
	<td><?php echo $conducts[$ic]['dg5']; ?></td>
	<td><?php echo ($qtr>3)? $conducts[$ic]['dg6']:NULL; ?></td>
</tr>
<?php endfor; ?>

</table>






