	<span class="u screen" ondblclick="tracepass();" ><?php echo $sy; ?> Assessment </span>
	<span class="screen" >
		<span class="" onclick="traceshd();" >SHD</span>
		| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
		<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
		| <a href='<?php echo URL."profiles/student/$scid/$sy"; ?>' >Profile</a>		
		| <a href="<?php echo URL.'students/sectioner/'.$scid.DS.$sy; ?>">Sectioner</a> 
		| <a href="<?php echo URL.'registration/one'; ?>">Register</a> 
		| <a href='<?php echo URL."assessment/assess/$scid?negligible=10"; ?>'>Negligible</a> 
<?php if($_SESSION['srid']!=RREG): ?>		
		| <a href="<?php echo URL.'ledgers/pay/'.$scid.DS.$sy; ?>">Ledger</a> 
<?php endif; ?>
		| <a class="u txt-blue" onclick="window.print();" >PRINT</a>		

		
SY <select onchange="redirSy();" id="sy" >
	<option value="<?php echo DBYR; ?>" <?php echo ($sy==DBYR)? 'selected':NULL; ?> ><?php echo DBYR; ?></option>
	<option value="<?php echo (DBYR+1); ?>" <?php echo ($sy==(DBYR+1))? 'selected':NULL; ?> ><?php echo (DBYR+1); ?></option>
</select>	
		
	</span>
