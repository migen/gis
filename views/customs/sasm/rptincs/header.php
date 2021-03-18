
	<br />
	<table class="nogis-table-bordered-print center " style="table-layout:auto;width:540px;" >
		<tr>
			<td style="text-align:right;" class="vc120 " ><img src='<?php echo $logo_src; ?>' alt="logo" height="80" width="80"></td>
			<td style="min-width:100px;">
				<span class="b" style="font-family:Old English Text MT;font-size:2em;" >St. Anthony School</span><br />
				<span class="">Singalong, Manila</span><br />				
				<span class="" >PAASCU</span> <span class="" >ACCREDITED</span>					
				<div style="padding-top:0.6em;" ><span class=""  >
					<?php 
						echo ($level_id>9)? "Junior ":NULL;
					
					?>
					<?php echo $classroom['department']; ?></span></div>									
				<span>
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
					PROGRESS REPORT CARD &nbsp; (SF9)</span>				
				<br /><span>SY <?php echo $sy.' - '.$nsy; ?></span>												
			</td>
			<td class="vc100 left" ><span class="f10" ></span></td>
		</tr>
	</table>









