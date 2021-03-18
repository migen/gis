


<?php 
	
	// pr($data); 	

	$attmonths = $attendance_months;
	
	
	
	

	
?>


<form method='POST' >

	
<p class="screen"  >
	<a class="button" id="btnExport" style="font-size:14px;" >Excel</a> &nbsp; 
</p>
	

<!-- page info -->
<table class='gis-table-bordered table-fx'>
	<tr><th class='white headrow'>SY</th><td><?php echo $sy.' - '.($sy+1); ?></td></tr>
	<tr><th class='white headrow'>Quarter</th><td><?php echo ($qtr<5)? $qtr : 'All'; ?></td></tr>
</table>


<?php 	if(empty($emps)){ exit; }  ?>
	

<br />
<table id="tblExport"  class='gis-table-bordered table-fx'>
<tr class='bg-blue2'>
	<th>#</th>
	<th>ID Number</th>
	<th>Employee</th>
	<th>Month<br />Total</th>
	<?php foreach($months AS $month): ?>	
		<th class='center'> 
			<?php $mc = $month['code']; echo strtoupper($mc); ?> <br />
			<?php echo $attmonths[$mc.'_days_total']; ?> <br />

		</th>
	<?php endforeach; ?>
	<?php if($qtr ==5): ?>
		<th class="vcenter" > DB Total <br />  <?php echo $attmonths['year_days_total']; ?> </th>
		<th class="vcenter" > Running Total <br />  <?php echo $attmonths['year_days_total']; ?> </th>
	<?php endif; ?>
	
</tr>

<!------------------------------------------------------------------------------->

<?php $is = 0; ?>
<!-- loop thru num_students-->
<?php foreach($attendance AS $row): ?> 	

<?php if(!empty($row)): ?>

<tr>
	<td><?php echo $is+1; ?></td>
	<td><?php echo $row['employee_code']; ?></td>
	<td><?php echo $row['employee']; ?></td>

	
	<td class="center vcenter" ><?php echo 'Present'; ?></td>
	<?php foreach($months AS $month): ?> 
		<?php $mc = $month['code']; ?>
		<td class="center colshading" style='vertical-align:middle;'> <?php echo number_format($row[$mc.'_days_present'],ADECI); ?> </td>	
	<?php endforeach; ?>								
	
	<?php if($qtr ==5): ?>
		<td class="center vcenter" > <?php echo number_format($row['total_days_present'],ADECI); ?> </td>	
		<td class="vcenter" > 
			<input class="vc50 center vcenter" type="text" name="total[<?php echo $is; ?>][tdpre]" value="<?php echo number_format($tdpre,ADECI); ?>"  readonly />			
		</td>
	<?php endif; ?>
	
</tr>

<tr>
	<td>&nbsp;</td><td class="" >&nbsp;</td><td>&nbsp;</td>

	<td class="center vcenter" >Tardy</td>
	<?php foreach($months AS $month): ?> 	<!-- loop thru months -->
		<?php $mc = $month['code']; ?>
		<td class="center colshading" style='vertical-align:middle;'> <?php echo number_format($row[$mc.'_days_tardy'],ADECI); ?> </td>	
	<?php endforeach; ?>
	
	<?php if($qtr ==5): ?>
		<td class="center vcenter" > <?php echo number_format($row['total_days_tardy'],ADECI); ?> </td>	
		<td class="vcenter" > 		
			<input class="vc50 center vcenter" type="text" name="total[<?php echo $is; ?>][tdtar]" value="<?php echo number_format($tdtar,ADECI); ?>" readonly />	
			<input type="hidden" name="total[<?php echo $is; ?>][id]" value="<?php echo $row['id']; ?>" />							
		</td>
	<?php endif; ?>
	
</tr>


<?php endif; ?>	<!-- attendance not empty -->

<?php $is++; ?>
<?php endforeach; ?>								<!-- endloop row num_students -->


	
	
</table>	

<!------------------------------------------------------------------------->
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>

<!------------------------------------------------------------------------------>
<script>

	var gurl = 'http://<?php echo GURL; ?>';	var sy   = '<?php echo $sy; ?>';
	var hdpass 	= '<?php echo HDPASS; ?>';
	var home 	= '<?php echo $home; ?>';


	$(function(){	
		hd();
		hdTally();
		$('#hdpdiv').hide();
		$(".juice").datepicker({
			dateFormat:"yy-mm-dd"
		});
		
		nextViaEnter();		
		selectFocused();
		excel();
	});

	
	function excel(){
		$("#btnExport").click(function () {
			$("#tblExport").btechco_excelexport({
				containerid: "tblExport"
			   ,datatype: $datatype.Table
			});
		});

	}
	
	
	function hdTally(){
		$('.tally').hide();
	}
	
	function redirAtt(month,ecid){
		var rurl 	= gurl + '/'+home+'/attendanceLogs/'+sy+'/'+month+'/'+ecid;		// redirect url	
		// alert(rurl);
		window.location = rurl;		
	}

	
	function redirAttemps(roleid){
		var rurl 	= gurl + '/'+home+'/attemps/'+roleid;		// redirect url	
		window.location = rurl;		
	}
	
	function redirDailyAttemps(roleid){
		var day  = $('#dailyAttemps').val();
				
		var rurl 	= gurl + '/'+home+'/dailyAttemps/'+roleid+'/'+day;		// redirect url	
		// alert(rurl);
		window.location = rurl;		
	}


	
	
</script>	
