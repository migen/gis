<table style="" >
	<tr>
		<td>
			<div style="float:left;padding-right:20px;" >
				<img src='<?php echo $logo_src; ?>' alt="logo" height="88" width="76">
			</div>
			<div style="float:left;" class="center" >
				<span class="b" style="font-size:1.4em;"  ><?php echo $_SESSION['settings']['school_name']; ?></span><br />
				<span class="b" style="font-size:1.1em;" ><?php echo $classroom['department'].' Department'; ?><br /></span>
				<?php echo $paascu; ?><br />
				<span class="b" style="font-size:1.2em;" >PROGRESS REPORT CARD</span><br />
				<?php echo "SCHOOL YEAR $sy - ".($sy+1); ?>
			</div>
			<div style="float:left;padding-left:20px;" >
				<img src="<?php echo URL."public/images/weblogo_sf.png"; ?>" 
					alt="logo" height="88" width="76">										
			</div>			
		</td>
	</tr>
</table>