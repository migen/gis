	<span class="u screen" ondblclick="tracepass();" >Assessment Next SY</span>
	<span class="screen" >
		<span class="shd" >SHD</span>
		| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
		<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		
		| <a href='<?php echo URL."profiles/student/$scid"; ?>' >Profile</a>		
		| <a href="<?php echo URL.'students/sectioner/'.$scid; ?>">Sectioner</a> 
		| <a href="<?php echo URL.'assessment/assess'; ?>">Assessment</a>		
		| <a class="u txt-blue" onclick="window.print();" >PRINT</a>		
	</span>
