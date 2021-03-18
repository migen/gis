
<?php 
// pr($summary); pr($student); 
?>

<div class="" style="border:1px solid #dddddd" >
	<table class="nogis-table-bordered tf12" style="width:<?php echo $ftw; ?>;"  >
		<tr><td colspan="2" class="b center tf11" >CERTIFICATE OF ELIGIBILITY
			<?php 
				// pr($student['summary']); 
				// pr($student['summary']['is_promoted']); 
			
			?>
		</td></tr>
		
		
		<tr><td colspan="2" class="tf12" >The bearer
		<input value="<?php echo $student['name']; ?>" class="vc300" 
			style="border:none;border-bottom:1px solid black;" readonly /></td></tr>
		<tr><td colspan="2" class="tf12" >
		<?php if($student['summary']['is_promoted']==1): ?>
			is eligible for transfer and admission to 
		<?php else: ?>
			is retained to 
		<?php endif; ?>		
		<input value="<?php echo $student['summary']['promlevel']; ?>" class="u" style="border:none;" readonly /></td></tr>
		
		<tr><td colspan="2" class="tf12" >
		with  
		<input value="<?php echo $student['summary']['incunits']; ?>" class="vc30" 
			style="border:none;border-bottom:1px solid black;" readonly /> unit(s) of deficiency in  
			<input value="<?php echo $student['summary']['incsubj']; ?>" class="vc120" readonly 
			style="border:none;border-bottom:1px solid black;" /></td></tr>		
		
		<tr><td colspan="2" class="tf12" >Date Issued  
		<?php if($qtr>3): ?>
		<input value="<?php $x=$student['summary']['eligdate'];echo date('F d, Y',strtotime($x)); ?>" 
			class="" style="border:none;border-bottom:1px solid black;" readonly />
		<?php endif; ?>
		</td></tr>		
		
		<tr>
			<td class="center" >______________________</td>
			<td class="center" >
			<input class="center" value="<?php echo $classroom['adviser']; ?>" 
			style="width:220px;font-size:1.0em;border:none;border-bottom:1px solid black;" readonly />
			</td>
		</tr>
		<tr><td class="center"  >Parent's Signature</td>		
		<td class="center tf12" >Adviser's Signature</td></tr>
		
		
	</table>
	
</div>