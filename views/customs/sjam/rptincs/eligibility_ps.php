

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
	<td><?php echo $semtext; ?></td></tr>
	
	<tr><td class="left" ><br /><div class="vc300 left" >______________________________</div>
	Parent's / Guardian's Signature:</td><td class="left" ><br />
	</td></tr>	
</table>
<?php else: ?>	<!-- if qtr<4 -->
<table class="no-gis-table-bordered table-center table-vcenter <?php echo $docfont.' '.$tblwidth; ?>" >
	<tr><th colspan=2>CERTIFICATE OF TRANSFER</th></tr>
	<tr><td class="left" >Eligible for transfer and admission to</td><td class="u" >
		__<?php print($student['summary']['promlevel']); ?>__</td></tr>
	<tr><td class="left" >Has advanced credits in</td><td class="u" ></td></tr>
	<tr><td class="left" >Lacks credits in </td><td class="u" ></td></tr>
	<tr>
<td class="left" >Date printed &nbsp; __<span class="u" ><?php echo date("F d, Y",strtotime($_SESSION['today'])); ?></span>__</td>
<td class="" >
	__<span class="u" >
		<!-- <?php echo $_SESSION['settings']['school_principal']; ?>	 -->	
		<?php echo $_SESSION['settings']['school_director']; ?>
	</span>__
</td>	
	</tr>
	<tr><td></td><td>Principal / Director</td></tr>	
</table>
<?php endif; ?>
</div>