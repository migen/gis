<?php 

// echo "admin: $is_admin <br />";

// pr($attendance[0]);
// exit;

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
	Home	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>	
	| <a class="u" id="btnExport" >Excel</a> 	
	
</h5>

<!------ tracelogin--------------------------------------->
<?php $this->shovel('hdpdiv'); ?>

<?php 	if(empty($students)){ exit; }  ?>



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
	<th></th>
	<th>Q1</th>
	<th>Q2</th>
	<th>Q3</th>
	<th>Q4</th>
	<th class="vcenter" > DB Total <br />  <?php echo $attendance_months['year_days_total']; ?> </th>
	<th class="vcenter" > Running Total <br />  <?php echo $attendance_months['year_days_total']; ?> </th>
	
</tr>
<!------>

<?php for($i=0;$i<$count;$i++): ?>
<?php 
	$tdpre = sumpreQtr($rows[$i]);
	$tdtar = sumtarQtr($rows[$i]);
?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['student_code']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td>Present</td>
	<td><?php echo $rows[$i]['q1_days_present']; ?></td>
	<td><?php echo $rows[$i]['q2_days_present']; ?></td>
	<td><?php echo $rows[$i]['q3_days_present']; ?></td>
	<td><?php echo $rows[$i]['q4_days_present']; ?></td>

	<td> <?php echo number_format($rows[$i]['total_days_present'],$deciatt); ?> </td>	
	<td><?php echo number_format($tdpre,$deciatt); ?></td>	
	
</tr>

<tr>
	<td></td><td></td><td></td><td></td>
	<td>Tardy</td>
	<td><?php echo $rows[$i]['q1_days_tardy']; ?></td>
	<td><?php echo $rows[$i]['q2_days_tardy']; ?></td>
	<td><?php echo $rows[$i]['q3_days_tardy']; ?></td>
	<td><?php echo $rows[$i]['q4_days_tardy']; ?></td>
	<td> <?php echo number_format($rows[$i]['total_days_tardy'],$deciatt); ?> </td>	
	<td><?php echo number_format($tdtar,$deciatt); ?></td>
	
</tr>

<?php endfor; ?>

</table>



</form>		
</div>

