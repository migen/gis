<?php


?>


<?php if($show): ?>
	<table class="center" >
		<tr><td rowspan=7><img src='<?php echo $logo_src; ?>' alt="logo" height="80" width="80"></td></tr>
		<tr><th>ST. JAMES ACADEMY</th></tr>
		<tr><th>City of Malabon</th></tr>
		<tr><th>BASIC EDUCATION DEPARTMENT</th></tr>
		<tr><th>PAASCU LEVEL II ACCREDITED</th></tr>
		<tr><th>SENIOR HIGH SCHOOL LEVEL</th></tr>		
		<tr><th><?php echo ($sem==1)? "FIRST":"SECOND"; echo " SEMESTER"; ?> REPORT CARD</th></tr>
	</table>
<?php else: ?>
	<table class="center" >
		<tr><th>BASIC EDUCATION DEPARTMENT</th></tr>
		<tr><th>PAASCU LEVEL II ACCREDITED</th></tr>
		<tr><th>SENIOR HIGH SCHOOL LEVEL</th></tr>
		<tr><th><?php echo ($sem==1)? "FIRST":"SECOND"; echo " SEMESTER"; ?> REPORT CARD</th></tr>
	</table>
<?php endif; ?>




