<?php


?>

	<br />
	<table class=" center <?php echo $headfont.' '.$tblwidth; ?>" >
		<tr>
			<td class="vc100 right" >
				<?php if($show): ?><img src='<?php echo $logo_src; ?>' alt="logo" height="80" width="80">				
				<?php else: ?><div style="height:80px;" ></div><?php endif; ?>
			</td>

			<td>
				<?php if($show): ?>
					<span class="b f20" >ST. JAMES ACADEMY</span><br />
					<span class="" >Rizal Ave. Ext., Malabon</span><br />				
				<?php endif; ?><span style="font-size:1em;color:red;" >BASIC EDUCATION DEPARTMENT</span><br />
				<span class="" >PAASCU LEVEL II</span> <span class="i" >ACCREDITED</span><br />
				<span class="" >SENIOR <?php echo strtoupper($classroom['department']); ?> LEVEL<br /></span>				
				<span class="f20 " ><?php echo ($qtr<3)? "FIRST":"SECOND"; echo " SEMESTER"; ?> REPORT CARD</span>				
			</td>
			<td class="vc100 left" ><span class="f10" ></span></td>
		</tr>
	</table>
