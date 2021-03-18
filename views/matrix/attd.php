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
	

	
</script>	




<!------------------ GController ------------------------------------------------------------>



<div>


<?php 
	
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
	  <a href="<?php echo URL.$home; ?>" />Home</a>  
	| <a class="u" id="btnExport" >Excel</a> 	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>						
	
</h5>

<!------ tracelogin --->
	<?php $this->shovel('hdpdiv'); ?>

<!-- page info -->



<?php 	if(empty($students)){ exit; }  ?>


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
			
				<?php if($_SESSION['settings']['has_rfid']==1): ?>
				<?php if($current && !$is_locked): ?>
					<span class="shd" ><button><a onclick="return confirm('Warning: will replace all column values.');" class="no-underline"
						href="<?php echo URL.$home.'/tal/'.$cr['crid'].DS.$sy.DS.$qtr.DS.$month['id']; ?>" >Tally</a></button></span><br />
				<?php endif; ?>
				<?php endif; ?>
			<?php endif; ?>											
		</th>
	<?php endforeach; ?>
	<th> DB Total <br />  <?php echo $attendance_months['year_days_total']; ?> </th>
	<th> Running Total <br />  <?php echo $attendance_months['year_days_total']; ?> </th>
	
</tr>

<!------------------------------------------------------------------------------->
<?php $is = 0; ?>
<?php foreach($attendance AS $row): ?> 
<?php 
	$tdpre = sumpre($row);
	$tdtar = sumtar($row);	
	
?>

<tr>
	<td><?php echo $is+1; ?></td>
	<td><?php echo $row['scid']; ?></td>
	<?php $scid = $row['scid']; ?>	
	<td><?php echo $row['student_code']; ?></td>
	<td><?php echo $row['student']; ?></td>
	
	<td><?php echo 'Present'; ?></td>
	<?php foreach($months AS $month): ?> 
		<?php $mc = $month['code']; ?>
		<td class="center colshading" style='vertical-align:middle;'><?php echo number_format($row[$mc.'_days_present'],$deciatt); ?></td>	
	<?php endforeach; ?>			
	<td> <?php echo number_format($row['total_days_present'],$deciatt); ?> </td>	
	<td><?php echo number_format($tdpre,$deciatt); ?></td>
	
</tr>

<tr>
	<td>&nbsp;</td><td>&nbsp;</td>
	<td>&nbsp;</td><td>&nbsp;</td>
	<td>Tardy</td>
	<?php foreach($months AS $month): ?> 
		<?php $mc = $month['code']; ?>
		<td class="center colshading" style='vertical-align:middle;'><?php echo number_format($row[$mc.'_days_tardy'],$deciatt); ?></td>	
	<?php endforeach; ?>
	
	<td> <?php echo number_format($row['total_days_tardy'],$deciatt); ?> </td>	
	<td><?php echo number_format($tdtar,$deciatt); ?></td>
	
</tr>


<?php $is++; ?>
<?php endforeach; ?> 
</table>


<br />
	
</form>		
</div>

