<?php

$sch=VCFOLDER;
$incfile=SITE."views/customs/{$sch}/incs/enrollmentFxn_{$sch}.php";
include_once($incfile); 

$arp=adjustPayablesSjam($student);
$periodic_adjusted=$arp['periodic_adjusted'];
$periodic_initial=$arp['periodic_initial'];
$student['resfee_paid']=$resfee_paid=getResfee($payments);

$has_resfee=($resfee_paid>0)? true:false;
$payarr=parseDiscounts($payables);
$discounts=$payarr['discounts'];
$nondiscounts=$payarr['nondiscounts'];
// pr("discounts");
// pr($discounts);
// pr("nondiscounts");
// pr($nondiscounts);
// exit;
// pr($payables);
// exit;

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
</head>
<body>
	
	<style type="text/css" media="screen">
		.assessement-form {
			margin: auto;
			width: 900px;
		}
		.colon {
			padding-right: 20px; 
		}
		.stud-info table {
			margin: auto;
		}
		.stud-info {
			padding: 10px;
			border-bottom: 3px solid #111;
			border-top: 3px solid #111;
		}
		.stud-info th,
		.payment-summary th {
			text-align: left;
		}
		.details {
			margin: 0px;
			padding-right: 30px;
			padding-left: 30px;
			display: grid;
  			grid-template-columns: repeat(2, 1fr);
  			grid-template-rows: auto;
  			grid-gap: 50px;
		}
		.payment-summary table {
			border: 1px solid;
			padding: 10px;
		}
		.payment-summary .amount {
			text-align: right;
		}
		.payment-schedule table {
			text-align: center;
			padding: 5px;
			border: 1px solid;
		}
		.payment-schedule table tr {
			border: 1px solid;	
		}
		.staff-signature {
			padding-top: 30px;
			display: grid;
  			grid-template-columns: repeat(2, 1fr);
  			grid-template-rows: auto;
  			grid-gap: 50px;
		}
		.staff-name {
			border-bottom: 1px solid;
			padding-bottom: 3px;
			padding-left: 30px;
			padding-right: 30px;
			text-transform: uppercase;
		}
		.staff-title {
			font-weight: bold;
		}
	</style>

	<div class="assessement-form">
		<div class="sch">
			<center>
				<p>
					<span style="font-size: 25px;">ST. JAMES ACADEMY</span><br>
					<small>City Of Malabon</small><br>
					<small>Tel Nos.: 283-3696 to 98 local 106</small><br>
					<small>Emaill: sjaregistrar@yhoo.com</small><br>
					<span><b>PAASCU ACCREDITED LEVEL II</b></span><br>
					<span><b>REGISTRATION FORM</b></span>
				</p>
			</center>
		</div>
		<div class="stud-info">
			<table>
				<tr>
					<th width="150">Student No.</th>
					<td><span class="colon">:</span><?php echo $student['studcode']; ?></td>
					<td width="100"></td>
					<th width="150">Date</th>
					<td><span class="colon">:</span><?php echo $_SESSION['today']; ?></td>
				</tr>
				<tr>
					<th width="150">Student Name.</th>
					<td><span class="colon">:</span><?php echo $student['studname']; ?></td>
					<td width="100"></td>
					<th width="150">Level / Section</th>
					<td><span class="colon">:</span> <?php echo $student['classroom']; ?></td>
				</tr>
				<tr>
					<th width="150">School Year</th>
					<td><span class="colon">:</span>2020 - 2021</td>
					<td width="100"></td>
					<th width="150">Mode of Payment</th>
					<td><span class="colon">:</span> <?php echo ucfirst($student['paymode']); ?></td>
				</tr>
				<tr>
					<th width="150">Scholarship Discount</th>
					<td><span class="colon">:</span>Multiple Scholar</td>
				</tr>
			</table>
		</div>
		<div class="details">
			<div class="payment-summary">
				<p><b>Payment Summary</b></p>
				<table>
				<?php 
					
					$total_tfeedetails=0;
				
				?>
				<?php for($i=0;$i<$tfeedetails_count;$i++): ?>
				<?php 
					$amount=$tfeedetails[$i]['amount']; 
					$total_tfeedetails+=$amount;
					
				
				?>
					<tr>
						<th width="250"><?php echo $tfeedetails[$i]['feetype']; ?></th>
						<td width="10">:</td>
						<td width="50"></td>
						<td width="100" class="amount"><?php echo number_format($amount,2); ?></td>
					</tr>				
				<?php endfor; ?>	<!-- -tfeedetails -->
				<?php if($has_resfee): ?>
				<?php 
					$total_tfeedetails-=$resfee_paid;
				?>
					<tr>
						<th width="250"><?php echo "Reservation | Less -- "; ?></th>
						<td width="10"></td>
						<td width="50"></td>
						<td width="100" class="amount"><?php echo number_format($resfee_paid,2); ?></td>
					</tr>				
				<?php endif; ?>
					
					<tr>
						<th width="250"><?php echo "Total"; ?></th>
						<td width="10"></td>
						<td width="50"></td>
						<th width="100" class="amount"><?php echo number_format($total_tfeedetails,2); ?></th>
					</tr>				
				
				
				</table>

				<p><b>Scholarship & Discount Summary</b></p>
				<table>
				<?php $total_discounts=0; ?>
				<?php foreach($discounts AS $row):  ?>				
				<?php $amount=$row['amount']; ?>				
				<?php 
					$total_discounts+=$amount; 				
				?>				
					<tr>
						<th width="250"><?php echo ($row['is_discount']==1)? 'Less':NULL; echo $row['feetype']; ?></th>
						<td width="10">:</td>
						<td width="50"></td>
						<td width="100" class="amount"><?php echo number_format($amount,2); ?></td>
					</tr>
					<?php endforeach; ?>
				<?php 
					$total_amount=$total_tfeedetails-=$total_discounts; 

				?>	
					<tr>
						<th width=""><?php echo 'Total Discounts'; ?></th>
						<td width="10">:</td>
						<td width="50"></td>
						<th width="100" class="amount"><?php echo number_format($total_discounts,2); ?></th>
					</tr>					
					<tr>
						<th><?php echo 'Total Amount'; ?></th>
						<td>:</td>
						<td></td>
						<th class="amount"><?php echo number_format($total_amount,2); ?></th>
					</tr>					
					
				</table>
			</div>
			<div class="payment-schedule">
				<p><b>Payment Schedule</b></p>
				<table>
					<tr>
						<th width="150">Fees Description</th>
						<th width="100">Amount</th>
						<th width="100">Due Date</th>
					</tr>				
					<tr>
						<td>Upon enrollment</td>
						<?php 
							$payable_first=$periodic_adjusted-$resfee_paid;
						?>
						<td class="" ><?php echo number_format($payable_first,2); ?></td>
						<td><?php echo $paydates[0]; ?></td>
					<tr>

					<?php for($i=1;$i<$paydates_count;$i++): ?>
					<tr>
						<td><?php echo getOrdinalEnrollment($i+1).' Payment'; ?></td>
						<td><?php echo number_format($periodic_adjusted,2); ?></td>
						<td><?php echo $paydates[$i]; ?></td>
					</tr>
					<?php endfor; ?>				
				</table>
			</div>
		</div>
		<div class="staff-signature">
			<div class="encoder">
				<center>
					<p>
						<span class="staff-name">Florevel C. Ricoperto</span><br><br>
						<span class="staff-title">Encoder</span>
					</p>
				</center>
			</div>	
			<div class="registrar">
				<center>
					<p>
						<span class="staff-name">Ms. Amalis S. Lucas</span><br><br>
						<span class="staff-title">Registrar</span>
					</p>
				</center>
			</div>
		</div>
		<div class="sch-note">
			<p>This is not an Official Receipt. Always get an Official Receipt from the CASHIER for every payment you made. Refer to your STUDENT HANDBOOK regarding the school policy. Assessment of Fees are partly based on the information you provided. St. James Academy reserves the right to reassess the account of Student whose records contain false or incorrect information. </p>
		</div>
	</div>
</body>
</html>