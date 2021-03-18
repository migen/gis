<?php 

// pr($legendetc);


?>



<table class="no-gis-table-bordered-print table-vcenter <?php echo $legendfont; ?>" 
	style="float:left;width:<?php echo $htw; ?>;border:1px solid #ddd;height:1in;" >
<tr class="b <?php  ?>"  ><th class="b" style="width:1.4in;" >Grading Code</th></tr>
	<?php $last_legendetc = $num_legendetc-1; ?>
<?php for($l=0;$l<$num_legendetc;$l++): ?>
	<tr>
	<td  ><?php echo $legendetc[$l]['rating'].' - '.$legendetc[$l]['description']; ?></td>
	</tr>			
<?php endfor; ?>			
</table>

<div style="float:left;width:0.2in;min-height:50px;" ></div>




<table class="no-gis-table-bordered-print table-vcenter vc200 <?php echo $legendfont; ?>" 
	style="float:left;width:<?php echo $htw; ?>;border:1px solid #ddd;height:1in;" >
<tr class="b <?php  ?>"  ><th class="b" style="width:1.4in;" >Marking Code</th></tr>
	<?php $last_legendtr = $num_legendtr-1; ?>
<?php for($l=0;$l<$num_legendtr;$l++): ?>
	<tr>
		<td ><?php echo $legendctr[$l]['rating'].' - '.$legendctr[$l]['description']; ?></td>
	</tr>			
<?php endfor; ?>	
</table>


