

<div class="clear" > <hr class="broken" /> </div>

<div style="width:570px;padding:5px;" class="bordered center" >
<?php if($qtr<4): ?>
<table class="vc700 tf16 " >
	<tr><th class="center" colspan=2>School's Copy</th></tr>
	<tr><td class="left" >Name :<span class="u" ><?php echo $student['student']; ?></span></td>
	<td class="left" >Student No. <span class="u" ><?php echo $student['student_code']; ?></span></td></tr>
	<tr><td colspan=2 class="left" >Address :<span class="u" ><?php echo $student['address']; ?></span></td></tr>
	<tr>
		<td colspan=2 class="left" >Grade & Section:<span class="u" ><?php echo $student['level'].'-'.$student['section']; ?></span></td>
	</tr>
	<tr><td>School Year <span class="u" ><?php echo $sy.'-'.($sy+1); ?></span>	</td>
	<td>Quarter <span class="u" >_<?php echo $txtqtr; ?>_</span></td></tr>
	
	<tr><td class="left" ><br /><div class="vc300 left" >______________________________</div>
	Parent's / Guardian's Signature:</td><td class="left" ><br />
	</td></tr>	
</table>
<?php else: ?>	<!-- if qtr<4 -->
<table class="no-gis-table-bordered table-center table-vcenter <?php echo $docfont.' '.$tblwidth; ?>" >
	<tr>
		<th colspan=2>CERTIFICATE OF TRANSFER</th>
	</tr>
	<tr>
		<td class="left" >Eligible for transfer and admission to</td>
		<td class="u" >
			<?php print($student['summary']['promlevel']); ?>
		</td>
	</tr>
	<tr><td colspan="2"><br></td></tr>
	<!-- <tr>
		<td class="left" >Has advanced credits in: 
		<?php if($level_id == 15): ?>
			<u><?php echo (empty($student['incsubj']))? 'None':$student['incsubj'] ; ?></u>
		<?php endif; ?>
			
	</tr>
	<tr>
		<td class="left" >Lacks credits in: 
			<?php if($level_id == 15): ?>
				<u><?php echo (empty($student['incsubj']))? 'None':$student['incsubj'] ; ?></u>
			<?php endif; ?>
		</td>
	</tr> -->
	<tr>
<?php if($signature_rcard): ?>	
	<td class="left" ><br /><br /><br /><br /><br />
		Date printed &nbsp; __<span class="u" ><?php echo date("F d, Y",strtotime($_SESSION['today'])); ?></span>__</td>
	<td class="" >
		<span class="u" >
		<?php if($is_free): ?>
			<?php if($qtr<4): ?>
				<!-- <img src='<?php echo $src_signature_principal; ?>' alt="logo" height="80" width="220"><br /> -->
				<?php echo $_SESSION['settings']['principal_ec']; ?>
			<?php else: ?>
				<!-- <img src='<?php echo $src_signature_principal; ?>' alt="logo" height="80" width="220"><br /> -->
				<?php echo $_SESSION['settings']['school_director']; ?>
			<?php endif; ?>	
		<?php else: ?>
			<?php if($qtr<4): ?>
				<!-- <img src='<?php echo $src_signature_principal; ?>' alt="logo" height="80" width="220"><br /> -->
				<?php echo $_SESSION['settings']['school_principal']; ?>
			<?php else: ?>
				<!-- <img src='<?php echo $src_signature_principal; ?>' alt="logo" height="80" width="220"><br /> -->
				<?php echo $_SESSION['settings']['school_principal']; ?>
			<?php endif; ?>		
		<?php endif; ?>
		</span>
	</td>	
<?php else: ?>
	<td class="left" >
	Date printed: &nbsp; <span class="u" ><?php echo date("F d, Y",strtotime($_SESSION['today'])); ?></span></td>
	<td class="" >
		<span class="u" >
		<?php if($is_free): ?>
			<?php if($qtr<4): ?>
				<!-- <img src='<?php echo $src_signature_principal; ?>' alt="logo" height="80" width="220"><br /> -->
				<?php echo $_SESSION['settings']['principal_ec']; ?>
			<?php else: ?>
				<!-- <img src='<?php echo $src_signature_principal; ?>' alt="logo" height="80" width="220"><br /> -->
				<!-- <?php echo $_SESSION['settings']['school_director']; ?> -->
				<?php echo $_SESSION['settings']['principal_ec']; ?>
			<?php endif; ?>	
		<?php else: ?>
			<?php if($qtr<4): ?>
				<!-- <img src='<?php echo $src_signature_principal; ?>' alt="logo" height="80" width="220"><br /> -->
				<?php echo $_SESSION['settings']['school_principal']; ?>
			<?php else: ?>
				<!-- <img src='<?php echo $src_signature_principal; ?>' alt="logo" height="80" width="220"><br /> -->
				<!-- <?php echo $_SESSION['settings']['school_director']; ?> -->
				<?php echo $_SESSION['settings']['school_principal']; ?>
			<?php endif; ?>		
		<?php endif; ?>
		</span>
	</td>	
<?php endif; ?>
	</tr>
	<tr><td></td><td>School Principal <?php echo ($is_free)? "":NULL; ?></td></tr>
</table>
<?php endif; ?>
</div>