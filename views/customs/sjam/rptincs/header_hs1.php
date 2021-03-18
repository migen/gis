<?php



?>

	<br />
	<table class="nogis-table-bordered-print center <?php echo $headfont.' '.$tblwidth; ?>" >
		<tr><td colspan=3><div style="height:50px;" >&nbsp;</div></td></tr>
		<tr>
			<td class="vc100 right" >
				<?php if($show): ?><img src='<?php echo $logo_src; ?>' alt="logo" height="80" width="80">				
				<?php else: ?><div style="height:80px;" ></div><?php endif; ?>
			</td>
	
			<td>
				<?php if($show): ?>
					<span class="b f20" >ST. JAMES ACADEMY - hs-head</span><br />
					<span class="" >Rizal Ave. Ext., Malabon</span><br />				
				<?php endif; ?>			
				<span class="" >BASIC EDUCATION DEPARTMENT</span><br />
				<span class="" >PAASCU LEVEL II</span> <span class="i" >ACCREDITED</span><br />
				<span class="" ><?php echo strtoupper($classroom['department']); ?> LEVEL<br /></span>				
				<span class="f20 " ><?php echo strtoupper($ordinalQtr); echo ($qtr<4)? " QUARTER":NULL; ?> REPORT CARD</span>				
			</td>
			<td class="vc100 left" ><span class="f10" ></span></td>
		</tr>
	</table>
