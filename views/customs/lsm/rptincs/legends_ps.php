<?php 

?>

<table style="font-size:1em;width:<?php echo $ftw; ?>;" class="no-gis-table-bordered center" >	
	<tr><td class="b" >EVALUATION / GRADING CODE</td></tr>
</table>

<table class="no-gis-table-bordered-print table-vcenter vc200 <?php echo $legendfont; ?>" 
	style="float:left;width:<?php echo $htw; ?>;border:1px solid #ddd;height:1.4in;" >
<tr class="b <?php  ?>"  ><th class="b" style="width:1.4in;" > 
CHRISTIAN ATTITUDE AND VALUES</th></tr>
	<?php $last_legendtr = $num_legendtr-1; ?>
<?php for($l=0;$l<$num_legendtr;$l++): ?>
	<tr>
		<td ><?php echo $legendctr[$l]['rating'].' - '.$legendctr[$l]['description']; ?></td>
	</tr>			
<?php endfor; ?>	
</table>


<div style="float:left;width:0.2in;min-height:50px;" ></div>


<table class="no-gis-table-bordered-print table-vcenter <?php echo $legendfont; ?>" 
	style="float:left;width:<?php echo $htw; ?>;border:1px solid #ddd;height:1.4in;" >
	<?php $last_legendcrs = $num_legendcrs-1; ?>
<tr><td class="b" >CLASSROOM PROGRESS</td>
<td style="width:0.6in;" >
</td></tr>	

<tr><td>HC - Highly Capable</td><td>95 and above</td></tr>
<tr><td>VC - Very Capable</td><td>88 to 94</td></tr>
<tr><td>C - Capable</td><td>80 to 87</td></tr>
<tr><td>LC - Less Capable</td><td>75 to 79</td></tr>
<tr><td>NI - Needs Improvement</td><td>74 and below</td></tr>

</table>





