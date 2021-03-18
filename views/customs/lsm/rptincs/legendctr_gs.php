
<div class="" style="border:1px solid #dddddd" >

	<table class="full nogis-table-bordered tf10" style="width:<?php echo $ftw; ?>;border-bottom:none;"  >
		<tr><td colspan="2" class="b center tf11" >GRADING CODE</td></tr>
	</table>

	<table class="no-gis-table-bordered tf10" style="width:<?php echo $ftw; ?>;"  >
		
	<?php $last_legendctr = $num_legendctr-1; ?>
<?php for($l=0;$l<$num_legendctr;$l++): ?>
	<tr>
	<td  ><?php echo $legendctr[$l]['rating'].' - '.$legendctr[$l]['description']; ?></td>
	<td  ><?php echo round($legendctr[$l]['grade_floor'],1).' - '.number_format($legendctr[$l]['grade_ceiling'],1); ?>
	</tr>			
<?php endfor; ?>					
		
	</table>
	
</div>