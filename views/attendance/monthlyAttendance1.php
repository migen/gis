<?php 

// echo "admin: $is_admin <br />";
// $this->shovel('border');
pr($attendance[0]);
// pr($data);
// pr($attendance_months);


?>




<!------------------ GController ------------------------------------------------------------>



<div style="width:100%;float:left;"  >	<!-- left -->


<?php 

	// pr($_SESSION['q']);
	// pr($data); 	
	
	
	$cr 			= $classroom;
	$months 		= $months_quarters;
	$attmonths 		= $attendance_months;
	$num_months		= 12;	
	$not_updated	= 0;
	


	
// $readonly = ($qtr>4)? 'readonly':NULL;

$readonly=(($is_locked) || ($qtr>4))? true:false;


$this->shovel('attendance_tally');


$deciatt = $_SESSION['settings']['deciatt'];
	
	
?>



<form method='POST' >

<h5 class="screen clear" >
	<span class="u" onclick="traceshd();" >Tally</span>
		(<?php echo (isset($_GET['sort']) && $_GET['sort']=='c.position')? 'Position':'Alphabetical'; ?>)   
	| <a href="<?php echo URL.$home; ?>" />Home</a>  
	| <a href='<?php echo URL."advisers/printAttd/$crid/$sy/$qtr"; ?>' >Printable</a> 	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>					
	| <a href='<?php echo URL."submissions/view/".$data['classroom']['id']."/$sy/$qtr"; ?>' />Submissions</a> 
	| <a href="<?php echo URL.'attendance/monthly/'.$data['classroom']['id'].DS.$sy.'/5'; ?>" />Annual</a> 
<?php if(isset($_GET['sort'])): ?>	
	| <a href='<?php echo URL."attendance/monthly/$crid/$sy/$qtr"; ?>' >Alphabetical</a> 		
<?php else: ?>
	| <a href='<?php echo URL."attendance/monthly/$crid/$sy/$qtr?sort=c.position"; ?>' >Position</a> 			
<?php endif; ?>

	| <a href='<?php echo URL."attendance/quarterly/$crid/$sy/$qtr"; ?>' >Quarterly</a> 					

<?php if($is_admin): ?>
	| <?php if($is_locked): ?>
		<a href='<?php echo URL."finalizers/openAttendance/".$cr['crid']."/$sy/$qtr"; ?>' > Unlock </a>
	<?php else: ?>
		<a href='<?php echo URL."finalizers/closeAttendance/".$cr['crid']."/$sy/$qtr"; ?>' > Lock </a>
	<?php endif; ?>	
<?php endif; ?>	
	
	
	| <span class="blue u" onclick="ilabas('smartboard');" >Smartboard</span>
	
	<?php if($qtr=='5'): ?>
		| <a href="<?php echo URL.'attendance/monthly/'.$data['classroom']['id'].DS.$sy.'/1'; ?>" />Q1</a> 
		| <a href="<?php echo URL.'attendance/monthly/'.$data['classroom']['id'].DS.$sy.'/2'; ?>" />Q2</a> 
		| <a href="<?php echo URL.'attendance/monthly/'.$data['classroom']['id'].DS.$sy.'/3'; ?>" />Q3</a> 
		| <a href="<?php echo URL.'attendance/monthly/'.$data['classroom']['id'].DS.$sy.'/4'; ?>" />Q4</a> 
	<?php endif;?>
	
</h5>

<?php $this->shovel('hdpdiv'); ?>

<!-- page info -->

<table class='gis-table-bordered table-fx'>

<?php if($qtr<5): ?>
	<tr class="hd" >
		<th class="white headrow" >Locking</th><td>
		<?php if($is_locked): ?>
			<a href='<?php echo URL."finalizers/openAttendance/".$cr['crid']."/$sy/$qtr"; ?>' > Unlock </a>
		<?php else: ?>
			<a href='<?php echo URL."finalizers/closeAttendance/".$cr['crid']."/$sy/$qtr"; ?>' > Lock </a>
		<?php endif; ?>
	</td></tr>
<?php endif; ?>

	<tr><th class='white headrow'>Classroom | Adviser</th><td><?php echo $cr['level'].' - '.$cr['section'].' | '.$cr['adviser']; ?></td></tr>
	<?php if($qtr < 5): ?> <tr><th class='white headrow'>Status</th><td><?php echo 'Q'.$data['qtr'].' - '; echo ($is_locked  == 1)? 'Closed' : 'Open' ; ?></td></tr> <?php endif; ?>	


	<?php if($_SESSION['srid']!=RTEAC): ?>
		<tr class="screen" ><th class='white headrow'>Goto</th><td>
			<select class="vc200" onchange="jsredirect('attendance/monthly/'+this.value+'/'+sy+'/'+qtr+getview);" >
				<option value="0">Classroom Attendance</option>
				<?php foreach($classrooms AS $sel): ?>
					<option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option>
				<?php endforeach; ?>
			</select> 
		
		</td></tr>
	<?php endif; ?>
	
	
	<?php if(($_SESSION['settings']['has_rfid']==1) && ($current)): ?>
		<tr class="screen" ><th class='white headrow'>YYYY-MM-DD </th>
			<td><input id="clsAttDate" class="pdl05 " type="text" value="<?php echo $today; ?>" > 
				<span onclick="redirClsAttLogs();" class="button"  >Go</span>
				<input type="hidden" value="<?php echo $crid; ?>" id="crid" />
			</td>
		</tr>
	<?php endif; ?>
</table>



<?php 	if(empty($students)){ exit; }  ?>


<!------------------------------------------------------------------------------->

<?php if(($_SESSION['qtr'] == 1) && ($classroom['is_init_grades']==0)): ?>
	<h4> Please ask MIS to setup Sync Grades. </h4>
<?php exit; endif; ?>

<!------------------------------------------------------------------------------->


<br />

<div style="float:left;width:75%;" >	<!-- left -->
<table id="tblExport" class='gis-table-bordered table-fx'>
<tr class='bg-blue2'>
	<th>#</th>
	<th>Scid</th>
	<th>ID Number</th>
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
				<?php // if($_SESSION['settings']['has_rfid']==1): ?>
				<?php if($current && !$is_locked): ?>
					<span class="shd" >
						<button><a onclick="return confirm('Warning: will replace all column values.');" class="no-underline"
							href="<?php echo URL.'attd/tal/'.$cr['crid'].DS.$sy.DS.$qtr.DS.$month['id']; ?>" >Tally</a></button></span><br />
				<?php endif; ?>

				<?php // endif; ?>

			<?php endif; ?>
				<input class="vc50 center" id="i<?php echo $mc; ?>" type="text"  />
				<br /><input type="button" value="All" onclick="populateColumn('<?php echo $mc; ?>');" >							
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
	
	// counter: not_updated,it greater than 0 means true,then will display update or submit total button
	if(($row['total_days_present'] != $tdpre) || ($row['total_days_tardy'] != $tdtar)){	$not_updated ++; }
	
?>

<?php if(!empty($row)): ?>

<tr>
	<td><?php echo $is+1; ?></td>
	<!-- $is = student; 0 = first course;  -->
	<td><?php echo $row['scid']; ?></td>
	<td>
		<?php $studcode = $row['student_code']; ?>
		<?php $scid = $row['scid']; ?>
		<a href='<?php echo URL."attendance/student/$scid/$sy"; ?>' ><?php echo $studcode; ?></a>
	</td>
	<td id="<?php echo 'AID: '.$row['id'].' | SCID:'.$row['scid']; ?>" ondblclick="alert(this.id);" ><?php echo $row['student']; ?></td>

<?php if($_SESSION['settings']['has_rfid']==1): ?>	
	<td class="" >
		<select id="<?php echo $row['scid']; ?>" onchange="redirAtt(this.value,this.id);"  >
			<option>Month</option>
			<?php foreach($months_quarters AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>"  ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>	
	</td>	
<?php endif; ?>
	
	<td class="center vcenter" ><?php echo 'Present'; ?></td>
	<?php $im=0; ?>
	<?php foreach($months AS $month): ?> 	<!-- loop thru months -->		
		<?php $im++; ?>
		<?php $mc = $month['code']; ?>
		<?php $mcdays = $attendance_months[$mc.'_days_total']; ?>
		<?php $tab = (1000*$im)+$is; ?>		
		<td class="center colshading" style='vertical-align:middle;'> 
			<input id="<?php echo $mc.'pre'.$is; ?>" class="vc50 center <?php echo $mc; ?>" 
				type="text" tabindex="<?php echo $tab; ?>"		
				name="data[Attendance][<?php echo $is; ?>][<?php echo $mc; ?>_days_present]" 
				onchange="compareDays(this.value,'<?php echo $mcdays; ?>');"
				value="<?php echo number_format($row[$mc.'_days_present'],$deciatt); ?>" 
				<?php echo ($readonly)? 'readonly':NULL; ?>  />
			<input type="hidden" name="data[Attendance][<?php echo $is; ?>][id]" value="<?php echo $row['id']; ?>" />		
			
		</td>	
	<?php endforeach; ?>								<!-- endloop columns num_courses -->		
	
	<?php if($qtr ==5): ?>
		<td class="center vcenter" > <?php echo number_format($row['total_days_present'],$deciatt); ?> </td>	
		<td class="vcenter" > 
			<input class="vc50 center vcenter" type="text" name="total[<?php echo $is; ?>][tdpre]" value="<?php echo number_format($tdpre,$deciatt); ?>"  readonly />			
		</td>
	<?php endif; ?>
	
</tr>
<!-- =======================  tardy =============================  -->

<tr>
	<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
<?php if($_SESSION['settings']['has_rfid']==1): ?>
	<td class="" > &nbsp; </td>
<?php endif; ?>	
	<td class="center vcenter" >Tardy</td>
	<?php $im=0; ?>
	<?php foreach($months AS $month): ?> 	<!-- loop thru months -->
		<?php $im++; ?>
		<?php $mc = $month['code']; ?>
		<?php $tab = (1000*$im)+$is; ?>
	
		<td class="center colshading" style='vertical-align:middle;'>		
			<input id="<?php echo $mc.'tar'.$is; ?>" class="vc50 center" type="text" tabindex="<?php echo $tab; ?>"
				name="data[Attendance][<?php echo $is; ?>][<?php echo $mc; ?>_days_tardy]" 
				value="<?php echo number_format($row[$mc.'_days_tardy'],$deciatt); ?>"  
				<?php echo ($readonly)? 'readonly':NULL; ?>  />
			<input type="hidden" name="data[Attendance][<?php echo $is; ?>][id]" value="<?php echo $row['id']; ?>" />				
		</td>	
	<?php endforeach; ?>
	
	<?php if($qtr ==5): ?>
		<td class="center vcenter" > <?php echo number_format($row['total_days_tardy'],$deciatt); ?> </td>	
		<td class="vcenter" > 		
			<input class="vc50 center vcenter" type="text" name="total[<?php echo $is; ?>][tdtar]" 
				value="<?php echo number_format($tdtar,$deciatt); ?>" readonly />	
			<input type="hidden" name="total[<?php echo $is; ?>][id]" value="<?php echo $row['id']; ?>" />							
		</td>
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

<input type="hidden" name="total[<?php echo $is; ?>][scid]" value="<?php echo $students[$is]['scid']; ?>" />							

<?php $is++; ?>
<?php endforeach; ?>								<!-- endloop row num_students -->
</table>
<br />

<?php if(!isset($_GET['view'])): ?>
	<?php if($qtr < 5 && !$is_locked): ?>		
		<input onclick="return confirm('Update! Are you sure?');" type='submit' name='submit' value='Update' />			
		<button><a onclick="return confirm('You sure?');" 
			href='<?php echo URL."finalizers/closeAttendance/$crid/$sy/$qtr"; ?>' class="no-underline txt-black" >Finalize</a></button>			
			
	<?php elseif($qtr == 5): ?>				
		<?php if(($not_updated) || ($cr['attendance_q4']==0)): ?>
			<a href='<?php echo URL."attendance/totalCridMonthly/$crid/$sy"; ?>' 
				onclick="return confirm('Total: Are you sure?');" >Total</a>		
		<?php endif; ?>
	<?php endif; ?>
		
	<?php if(($is_locked) && ($_SESSION['srid']==RMIS)): ?>		
		<input type="submit" name="submit" value="Update On" onclick="return confirm('Sure?');" />
	<?php endif; ?>	
<?php endif; ?>	<!-- not view -->

</form>		

</div>	<!-- left -->

<div style="float:left;width:20%;min-height:50px;" >	<!-- right -->
<p class="smartboard" >
<select id="classbox" >
	<?php foreach($months AS $row): ?>
		<option value="<?php echo $row['code'].'pre'; ?>" ><?php echo ucfirst($row['name']); ?> Present</option>
		<option value="<?php echo $row['code'].'tar'; ?>" ><?php echo ucfirst($row['name']); ?> Tardy</option>
	<?php endforeach; ?>
</select>
</p>

<?php $d['width'] = '20'; ?>
<?php $this->shovel('smartboard',$d); ?>

</div> 	<!-- right -->


<div class="ht100 clear" ></div>



<script>

	var gurl = 'http://<?php echo GURL; ?>';	
	var hdpass 	= '<?php echo HDPASS; ?>';
	var home 	= 'advisers';
	var crid	= '<?php echo $crid; ?>';
	
	var sy   = '<?php echo $sy; ?>';
	var qtr 	= '<?php echo $qtr; ?>';
	
	var getview = "<?php echo isset($_GET['view'])? '&view':NULL; ?>";


	$(function(){	
		hd();
		shd();
		hdTally();
		itago('smartboard');
		$('#hdpdiv').hide();
		$(".juice").datepicker({
			dateFormat:"yy-mm-dd"
		});
		
		nextViaEnter();
		selectFocused();
		
	});

	function compareDays(val,mcdays){
		if(val>mcdays){
			alert('Invalid: exceeds total days.');
		}
	}	/* fxn */

	
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

	


