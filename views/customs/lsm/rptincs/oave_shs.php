

<table class="nogis-table-bordered full" >
<tr>
<th style="width:<?php echo $subw; ?>;<?php echo ($child)? 'padding-left:20px;':NULL; ?>;text-align:left;" >
	Overall Average	
</th>	
<th></th>
<th></th>
<th class="" style="" >
<?php 
	if($qtr>3){
		$oave= (($student['ave_q5']+$student['ave_q6'])/2); echo number_format($oave,2); 		
	}
?>
</th>
</tr>
</table>	
