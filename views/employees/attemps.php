


<?php 
	
	// pr($data); 	

	$attmonths = $attendance_months;
	// pr($attendance[1]);
	$deciatt = $_SESSION['settings']['deciatt'];
	
	
	
	
// ======================= function ===================================
$this->shovel('attendance_tally');

	
?>


<form method='POST' >

<h5 class="screen"  >
	<a href="<?php echo URL.$_SESSION['home']; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>					
	| <a href="<?php echo URL.'mis/attendanceEmployees/'.$role_id; ?>"  >Excel</a> &nbsp; 
	
</h5>

<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
	<?php // $this->shovel('hdpdiv'); ?>

		

<!-- page info -->
<table class='gis-table-bordered table-fx'>
	<tr><th class='white headrow'>SY</th><td><?php echo $sy.' - '.($sy+1); ?></td></tr>
	<tr><th class='white headrow'>Quarter</th><td><?php echo ($qtr<5)? $qtr : 'All'; ?></td></tr>
	<?php if($_SESSION['settings']['has_rfid']==1): ?>
		<tr><th class='white headrow'>Date</th>
			<td><input id="dailyAttemps" class="pdl05 " type="text" value="<?php echo $today; ?>" > 
				<span onclick="redirDailyAttemps(<?php echo $role_id; ?>);" class="button"  >Go</span>
			</td>
		</tr>
		<tr>
			<th class='white headrow' >Filter</th>
			<td >
				<select class="full" onchange="redirAttemps(this.value);" >
					<option>Choose Role</option>
					<option value="0" >All</option>
					<?php foreach($roles AS $row): ?>
						<option value="<?php echo $row['id']; ?>" ><?php echo $row['name']; ?></option>
					<?php endforeach; ?>
				</select>
			</td>
		</tr>
		
	<?php endif; ?>
</table>


<?php 	if(empty($emps)){ exit; }  ?>
	

<br />
<table class='gis-table-bordered table-fx'>
<tr class='bg-blue2'>
	<th>#</th>
	<th>CID</th>
	<th>ID Number</th>
	<th>Employee</th>
	<?php if($_SESSION['settings']['has_rfid']==1): ?>
		<th class="" >Logs</th>
	<?php endif; ?>
	<th>Month<br />Total</th>
	<?php foreach($months AS $month): ?>	
		<th class='center'> 
			<?php $mc = $month['code']; echo strtoupper($mc); ?> <br />
			<?php echo $attmonths[$mc.'_days_total']; ?> <br />
			<?php if($qtr < 5): ?>
			
				<?php if($_SESSION['settings']['has_rfid']==1): ?>
					<span class="" ><button><a onclick="return confirm('Warning: will replace all column values.');" class="no-underline"
						href="<?php echo URL.'mis/talAttemps/'.$sy.DS.$qtr.DS.$month['id'].DS.$role_id; ?>"  >Tally </a></button></span>
				<?php else: ?>
					<input class="vc50 center" id="i<?php echo $mc; ?>" type="text"  />
					<br /><input type="button" value="All" onclick="populateColumn('<?php echo $mc; ?>');" >				
				<?php endif; ?>
			<?php endif; ?>
		</th>
	<?php endforeach; ?>
	
</tr>

<!------------------------------------------------------------------------------->

<?php $is = 0; ?>
<!-- loop thru num_students-->
<?php foreach($attendance AS $row): ?> 	

<?php if(!empty($row)): ?>

<tr>
	<td><?php echo $is+1; ?></td>
	<td><?php echo $row['ecid']; ?></td>
	<td><?php echo $row['employee_code']; ?></td>
	<td><?php echo $row['employee']; ?></td>

<?php if($_SESSION['settings']['has_rfid']==1): ?>	
	<td class="" >
		<select id="<?php echo $row['ecid']; ?>" onchange="redirAtt(this.value,this.id);"  >
			<option>Month</option>
			<?php foreach($months AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>"  ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>	
	</td>	
<?php endif; ?>
	
	<td class="center vcenter" ><?php echo 'Present'; ?></td>
	<?php foreach($months AS $month): ?> 
		<?php $mc = $month['code']; ?>
		<td class="center colshading" style='vertical-align:middle;'>
			<input class="vc50 center <?php echo $mc; ?>" type="text" name="data[Attendance][<?php echo $is; ?>][<?php echo $mc; ?>_days_present]" value="<?php echo number_format($row[$mc.'_days_present'],$deciatt); ?>" <?php echo ($qtr > 4)? "readonly" : null; ?>  />
			<input type="hidden" name="data[Attendance][<?php echo $is; ?>][id]" value="<?php echo $row['id']; ?>" />		
		</td>	
	<?php endforeach; ?>								
	
	
</tr>

<tr>
	<td>&nbsp;</td><td class="" >&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
<?php if($_SESSION['settings']['has_rfid']==1): ?>
	<td class="" > Days </td>
<?php endif; ?>	
	<td class="center vcenter" >Tardy</td>
	<?php foreach($months AS $month): ?> 	<!-- loop thru months -->
		<?php $mc = $month['code']; ?>
		<td class="center colshading" style='vertical-align:middle;'>		
			<input class="vc50 center" type="text" name="data[Attendance][<?php echo $is; ?>][<?php echo $mc; ?>_days_tardy]" value="<?php echo number_format($row[$mc.'_days_tardy'],$deciatt); ?>"  <?php echo ($qtr > 4)? "readonly" : null; ?> />
			<input type="hidden" name="data[Attendance][<?php echo $is; ?>][id]" value="<?php echo $row['id']; ?>" />				
		</td>	
	<?php endforeach; ?>
	
	
</tr>

<?php if($_SESSION['settings']['has_rfid']==1): ?>

<tr>
	<td>&nbsp;</td><td class="" >&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
	<td class="" > Minutes </td>
	<td class="center vcenter" >Tardy</td>
	<?php foreach($months AS $month): ?> 	<!-- loop thru months -->
		<?php $mc = $month['code']; ?>
		<td class="center colshading" style='vertical-align:middle;'>		
			<input class="vc50 center" type="text" name="data[Attendance][<?php echo $is; ?>][<?php echo $mc; ?>_minutes_tardy]" value="<?php echo number_format($row[$mc.'_minutes_tardy'],$deciatt); ?>"  <?php echo ($qtr > 4)? "readonly" : null; ?> />
		</td>	
	<?php endforeach; ?>
	
	
</tr>
<?php endif; ?>

<?php endif; ?>	<!-- attendance not empty -->

	<input type="hidden" name="data[Attendance][<?php echo $is; ?>][id]" value="<?php echo $row['id']; ?>" />				

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
		// alert(55);
		hd();
		hdTally();
		$('#hdpdiv').hide();
		$(".juice").datepicker({
			dateFormat:"yy-mm-dd"
		});
		
		nextViaEnter();		
		selectFocused();
	});

	
	
	function hdTally(){
		$('.tally').hide();
	}
	
	function redirAtt(month,ecid){
		var rurl 	= gurl + '/'+home+'/attendanceLogs/'+sy+'/'+month+'/'+ecid+'/1';		
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
