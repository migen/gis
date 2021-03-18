	<table class="no gis-table-bordered tf10" style="width:<?php echo $ftw; ?>;border-bottom:none;"  >
		<tr><td colspan="2" class="b center tf11"  >GRADING CODE</td></tr>
	</table>
<table class='no-gis-table-bordered tf10' style="width:<?php echo $ftw; ?>;border:1px solid #ddd;border-top:none;"  >		

	<?php $last_legendcrs = $num_legendcrs-1; ?>
<?php for($l=0;$l<$num_legendcrs;$l++): ?>
<tr>
	<td><?php echo $legendcrs[$l]['rating'].' - '.$legendcrs[$l]['description']; ?></td>
	<?php if($l==$last_legendcrs): ?>	
		<td><?php echo 'Below 75%'; ?></td>
	<?php else: ?>
	<td style="width:0.8in;" >
		<?php echo round($legendcrs[$l]['grade_floor'],1).' - '.round($legendcrs[$l]['grade_ceiling'],1).'%'; ?>
	</td>
	<?php endif; ?>
</tr>

<?php endfor; ?>					
		
	</table>
	
