<?php 
// pr($legendctr);



?>



<table class="no-gis-table-bordered-print table-vcenter vc200 <?php echo $legendfont; ?>" 
	style="float:left;width:<?php echo $ftw; ?>;border:1px solid #dddddd;" >
<tr class="b <?php  ?>"  ><th class="b" style="width:1.4in;" >MARKING CODE</th></tr>
	<?php $last_legendtr = $num_legendtr-1; ?>
<?php for($l=0;$l<$num_legendtr;$l++): ?>
	<tr>
		<td style="padding-left:10px;" ><?php echo $legendctr[$l]['rating'].' - '.$legendctr[$l]['description']; ?></td>
	</tr>			
<?php endfor; ?>	
</table>


