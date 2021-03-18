
<table class="gis-table-bordered-print table-vcenter vc200 <?php echo $legendfont; ?>" 
	style="float:left;width:4.2in;" >
<tr class="b <?php  ?>"  ><th class="b">Marking Code</th><th class="vc100" >Scale</th></tr>
	<?php $last_legendtr = $num_legendtr-1; ?>
<?php for($l=0;$l<$num_legendtr;$l++): ?>
	<tr>
		<td ><?php echo $legendctr[$l]['rating']; ?></td>
		<td><?php echo round($legendctr[$l]['grade_floor']).' - '.floor($legendctr[$l]['grade_ceiling']).'%'; ?>
	</tr>			
<?php endfor; ?>	
</table>


