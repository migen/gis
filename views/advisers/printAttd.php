<?php 

// echo "admin: $is_admin <br />";

// pr($attendance[0]);

?>


<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>

<script>

	var gurl = 'http://<?php echo GURL; ?>';	
	var hdpass 	= '<?php echo HDPASS; ?>';
	var home 	= 'advisers';
	var crid	= '<?php echo $crid; ?>';
	
	var sy   = '<?php echo $sy; ?>';
	var qtr 	= '<?php echo $qtr; ?>';


	$(function(){	
		hd();
		shd();
		hdTally();
		excel();
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
	
	function redirAtt(month,scid){
		var rurl 	= gurl + '/'+home+'/attendanceLogs/'+sy+'/'+month+'/'+scid;		// redirect url	
		window.location = rurl;		
	}

	function redirClsAtt(crid){
		var rurl 	= gurl + '/'+home+'/attendance/'+crid+'/'+sy+'/'+qtr;			
		window.location = rurl;		
	}
	
	
	function redirClsAttLogs(){
		var crid = $("#crid").val();
		var cad  = $('#clsAttDate').val();
		var rurl 	= gurl + '/'+home+'/classAttendanceLogs/'+crid+'/'+cad;		// redirect url	
		// alert(rurl);
		window.location = rurl;		
	}


	function finalizeAttendance(){			
		var cnfm = confirm('Are u sure?');
		if(cnfm){
			var vurl 	= gurl + '/'+home+'/finalizeAttendance';		/* redirect url @ GController */			
			$.ajax({
				url: vurl,
				type: 'POST',
				data: 'crid='+crid+'&qtr='+qtr,				
				success: function() { location.reload(); }		  
			});			
		}					
	}
	
</script>	




<!------------------ GController ------------------------------------------------------------>



<div>


<?php 

	// pr($_SESSION['q']);
	// pr($data); 	
	
	
	$cr 			= $classroom;
	$months 		= $months_quarters;
	$attmonths 		= $attendance_months;
	$num_months		= 12;	
	$not_updated	= 0;


$readonly = ($qtr>4)? 'readonly':NULL;

$this->shovel('attendance_tally');


$deciatt = $_SESSION['settings']['deciatt'];
	
	
?>


<form method='POST' >

<h5 class="screen" >
	<span class="u" onclick="traceshd();" >Tally</span>  
	| <a href="<?php echo URL.$home; ?>" />Home</a>  
	| <a class="u" id="btnExport" >Excel</a> 	
	| <span class="u txt-blue" onclick="pclass('code');" >ID No</span> 	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>					
	| <a href='<?php echo URL."submissions/view/".$data['classroom']['id']."/$sy/$qtr"; ?>' />Submissions</a> 
	| <a href="<?php echo URL.'attendance/monthly/'.$data['classroom']['id'].DS.$sy.'/5'; ?>" />Attendance</a> 
	
	<?php if($qtr=='5'): ?>
		| <a href="<?php echo URL.'attendance/monthly/'.$data['classroom']['id'].DS.$sy.'/1'; ?>" />Q1</a> 
		| <a href="<?php echo URL.'attendance/monthly/'.$data['classroom']['id'].DS.$sy.'/2'; ?>" />Q2</a> 
		| <a href="<?php echo URL.'attendance/monthly/'.$data['classroom']['id'].DS.$sy.'/3'; ?>" />Q3</a> 
		| <a href="<?php echo URL.'attendance/monthly/'.$data['classroom']['id'].DS.$sy.'/4'; ?>" />Q4</a> 
	<?php endif;?>
	
</h5>

<!------ tracelogin ----------------------------------------------------------------------------------------------------------->
	<?php $this->shovel('hdpdiv'); ?>

<!-- page info -->

<!------------------------------------------------------------------------------->


<?php 	if(empty($students)){ exit; }  ?>


<!------------------------------------------------------------------------------->

<?php if(($_SESSION['qtr'] == 1) && ($classroom['is_init_grades']==0)): ?>
	<h4> Please ask MIS to setup Sync Grades. </h4>
<?php exit; endif; ?>

<!------------------------------------------------------------------------------->

<p>
	<?php echo $classroom['level'].' - '.$classroom['section']; ?>
	| <?php echo 'SY'.$sy.' - Q'.$qtr; ?>
	| <?php echo 'Printed: '.date('M-d, Y D',strtotime($_SESSION['today'])); ?>
</p>


<table id="tblExport" class='gis-table-bordered table-fx'>
<tr class='bg-blue2'>
	<th>#</th>
	<th class="code" >ID Number</th>
	<th>Student</th>
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
				<?php if($current && !$is_locked): ?>
					<span class="shd" ><button><a onclick="return confirm('Warning: will replace all column values.');" class="no-underline"
						href="<?php echo URL.$home.'/tal/'.$cr['crid'].DS.$sy.DS.$qtr.DS.$month['id']; ?>" >Tally</a></button></span><br />
				<?php endif; ?>
				<?php endif; ?>
			<?php endif; ?>											
		</th>
	<?php endforeach; ?>
	<?php if($qtr ==5): ?>
		<th class="vcenter" > DB Total <br />  <?php echo $attendance_months['year_days_total']; ?> </th>
		<th class="vcenter" > Running Total <br />  <?php echo $attendance_months['year_days_total']; ?> </th>
	<?php endif; ?>
	
</tr>

<!------------------------------------------------------------------------------->
<?php $is = 0; ?>
<?php foreach($attendance AS $row): ?> 	<!-- loop thru num_students-->
<?php 
	$tdpre = sumpre($row);
	$tdtar = sumtar($row);
	
	if(($row['total_days_present'] != $tdpre) || ($row['total_days_tardy'] != $tdtar)){	$not_updated ++; }
	
?>

<?php if(!empty($row)): ?>

<tr>
	<td><?php echo $is+1; ?></td>
	<!-- $is = student; 0 = first course;  -->
	<td class="code" >
		<?php $studcode = $row['student_code']; ?>
		<?php $scid = $row['scid']; ?>
		<a href='<?php echo URL."attendance/student/$scid/$sy"; ?>' ><?php echo $studcode; ?></a>
	</td>
	<td id="<?php echo 'AID: '.$row['id'].' | SCID:'.$row['scid']; ?>" ondblclick="alert(this.id);" ><?php echo $row['student']; ?></td>

<?php if($_SESSION['settings']['has_rfid']==1): ?>	
	<td class="" ></td>	
<?php endif; ?>
	
	<td class="center vcenter" ><?php echo 'Present'; ?></td>
	<?php foreach($months AS $month): ?> 	<!-- loop thru months -->
		<?php $mc = $month['code']; ?>
		<td class="center colshading" style='vertical-align:middle;'><?php echo number_format($row[$mc.'_days_present'],$deciatt); ?></td>	
	<?php endforeach; ?>								<!-- endloop columns num_courses -->		
	
	<?php if($qtr ==5): ?>
		<td class="center vcenter" > <?php echo number_format($row['total_days_present'],$deciatt); ?> </td>	
		<td class="vcenter" ><?php echo number_format($tdpre,$deciatt); ?></td>
	<?php endif; ?>
	
</tr>
<!-- =======================  tardy =============================  -->
<tr>
	<td>&nbsp;</td><td class="code" >&nbsp;</td><td>&nbsp;</td>
<?php if($_SESSION['settings']['has_rfid']==1): ?>
	<td class="" > &nbsp; </td>
<?php endif; ?>	
	<td class="center vcenter" >Tardy</td>
	<?php foreach($months AS $month): ?> 	<!-- loop thru months -->
		<?php $mc = $month['code']; ?>
		<td class="center colshading" style='vertical-align:middle;'><?php echo number_format($row[$mc.'_days_tardy'],$deciatt); ?></td>	
	<?php endforeach; ?>
	
	<?php if($qtr ==5): ?>
		<td class="center vcenter" > <?php echo number_format($row['total_days_tardy'],$deciatt); ?> </td>	
		<td class="vcenter" ><?php echo number_format($tdtar,$deciatt); ?></td>
	<?php endif; ?>
	
</tr>

<?php else: ?>
<tr>
	<td colspan="7" > Please update records of 
		<a href='<?php echo URL."advisers/addStudentAttendance/".$cr['crid'].DS.$students[$is]['scid']."/$sy/$qtr"; ?>'  >
			<?php echo $students[$is]['student'];  ?>
		</a>
	</td>
</tr>
<?php endif; ?>	<!-- attendance not empty -->


<?php $is++; ?>
<?php endforeach; ?>								<!-- endloop row num_students -->
</table>


<!-------------------------------------------------------------------->

<br />
	


</form>		
</div>

