
// old
	<br />
	<table class="nogis-table-bordered-print center <?php echo $headfont.' '.$tblwidth; ?>" >
		<tr>
			<td class="vc100 right" ><img src='<?php echo $logo_src; ?>' alt="logo" height="80" width="80"></td>
			<td>
				<span class="b f20" style="font-family:Old English Text MT;font-size:1.8em;" >St. Anthony School</span><br />			
				<span class="" >Singalong, Manila</span><br />
				<span class="" >PAASCU</span> <span class="i" >Accredited</span><br />
				<span class="" ><?php echo "Junior High School"; ?><br /></span>				
				<span class="f20 b" >PROGRESS REPORT CARD</span>				
			</td>
			<td class="vc100 left" ><span class="f10" ><?php // echo "Form 138"; ?></span></td>
		</tr>
	</table>

// ref
<table class="no-gis-table-bordered-print center <?php echo $headfont.' '.$tblwidth; ?>" >
		<tr><td>
			<div class="rcard-head">
				<img class="sch-logo" src='<?php echo $logo_src; ?>' alt="logo" height="80" width="80">
				<div class="sch-info">
					<span class="b" style="font-family:Old English Text MT;font-size:1.8em;" >St. Anthony School</span><br />
					<span class="" >Singalong, Manila</span><br />
					<span class="" >PAASCU</span> <span class="i" >Accredited</span><br />
					<span class="" ><?php echo $classroom['department']; ?><br /></span>				
					<span  >PROGRESS REPORT CARD</span><br>
					<span>SY <?php echo $sy.' - '.$nsy; ?></span>
				</div>	
			</div>							
		</td></tr>
	</table>
	
	
// new
<table class="no-gis-table-bordered-print center <?php echo $headfont.' '.$tblwidth; ?>" >
		<tr><td>
			<div class="rcard-head">
				<img class="sch-logo" src='<?php echo $logo_src; ?>' alt="logo" height="80" width="80">
				<div class="sch-info">
					<span class="b" style="font-family:Old English Text MT;font-size:1.8em;" >St. Anthony School</span><br />
					<span class="" >Singalong, Manila</span><br />
					<span class="" >PAASCU</span> <span class="i" >Accredited</span><br />
					<span class="" ><?php echo pr($classroom); ?><br /></span>				
					<span  >PROGRESS REPORT CARD</span><br>
					<span>SY <?php echo $sy.' - '.$nsy; ?></span>
				</div>	
			</div>							
		</td></tr>
	</table>	