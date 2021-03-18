<?php

// echo "sjam";



$dbo=PDBO;
$dbcontacts="{$dbo}.00_contacts";

// prx($data);



if($scid){
	
	$incs=SITE."views/customs/sjam/assessmentIncs_sjam.php";
	require_once($incs);
		
	
}	/* scid */




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

.gis-table-bordered { border: 1px solid #ddd;  } .gis-table-bordered th {color:#181818; }
.gis-table-bordered th, .gis-table-bordered td { border: 1px solid #ddd; padding:3px 10px; }
.gis-table-bordered thead th,.gis-table-bordered thead td { border-bottom-width: 2px; }
	
.bordered {border:1px solid #000;} .unbordered{border:none;}	
	
	
		.assessement-form {
			margin: auto;
			width: 1100px;
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
  			grid-gap: 10px;
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
		.sch table {
			margin-left: 250px;
		}
		.sch-logo,
		.sch-detail {
			text-align: center;
		}
		.sch-logo {
			margin-top: 10px;
			padding: 10px;
		}
		td.left{ text-align:left; }
		
		
	</style>

<?php if($scid): ?>

	<div class="assessement-form">
		<div class="sch">
			<table>
				<tr>
					<td>
						<div class="sch-logo" id="logo" ><img src="<?php echo $logo_src; ?>" width="100" height="100" ></div>
					</td>
					<td>
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
					</td>
				</tr>
			</table>
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
					<td><span class="colon">:</span></td>
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
				<?php if($has_previous_balance): ?>
				<?php $total_tfeedetails+=$previous_balance; ?>				
					<tr>
						<th width="250"><?php echo 'Previous balance'; ?></th>
						<td width="10">:</td>
						<td width="50"></td>
						<td width="100" class="amount"><?php echo number_format($previous_balance,2); ?></td>
					</tr>				

				<?php $total_tfeedetails+=$total_nondiscount; ?>
					<tr>
						<th width="250"><?php echo 'Other payables'; ?></th>
						<td width="10">:</td>
						<td width="50"></td>
						<td width="100" class="amount"><?php echo number_format($total_nondiscount,2); ?></td>
					</tr>									
				
				<?php endif; ?>
				
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

				<p><b>Scholarship & Discount Summary</b>
				
								<?php 
//									pr($tfee_grace_period_arr);
								?>
				
				</p>
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
						<th class="amount"><?php echo number_format($total_payable,2); ?></th>
					</tr>					

					
				</table>
			</div>
			<div class="payment-schedule bordered">
				<p><b>Payment Schedule</b></p>
				<table class="gis-table-bordered" >
					<tr>
						<th width="150">Fees Description</th>
						<th width="100">Amount</th>
						<th width="100">Balance</th>
						<th width="180">Due Date</th>
						<th width="180">Grace Period</th>
					</tr>				
					<?php if($has_previous_balance):  ?>
					<?php 
					
						$payable=array(
							'amount'=>$student['previous_balance'],
							'ptr'=>1,
							'feetype_id'=>3,
						);	
						$pbr=updatePayableBalance($db,$payable,$payments); 	
					
					?>
					
					
						<tr>
							<td>Previous Balance</td>
							<td class="" ><?php echo number_format($previous_balance,2); ?></td>
							<td class="" ><?php echo number_format($pbr['balance'],2); ?></td>
							<td><?php echo ($pbr['balance']>0)? 'Immediately':NULL; ?></td>
						<tr>
					<?php endif; ?>
					<?php if($has_other_payables):  ?>

						<?php foreach($payables AS $row): ?>
							<?php 	
								/* previous_balance */
								if($row['feetype_id']==3){ continue; }  
								if($row['is_discount']==1){ continue; }  
								$payable=$row;
								/* payableBalanceRow */	
								$pbr=updatePayableBalance($db,$payable,$payments); 							
								$row_is_discounted=($row['is_discount']==1)? true:false;
								$row['amount']=($row['is_discount'])? $row['amount']*-1:$row['amount']; 
							?>
							<tr>
								<td><?php echo ($row['feetype_id']!=1)? $row['feetype']:NULL; 														
									if($row['feetype_id']==1){
										$ptr=$row['ptr'];
										$row['due_on']=$tfee_duedates_arr[$ptr-1];
										echo ($ptr==1)? "Upon Enrollment":getOrdinalEnrollment($ptr).' Payment';
									}																
								?></td>
								<td class="" ><?php echo number_format($row['amount'],2); ?></td>
								<td class="" ><?php echo number_format($pbr['balance'],2); ?></td>
								<td><?php echo ($pbr['balance']>0)? $row['due_on']:NULL; ?></td>
								<td>
									<?php 
										echo ($pbr['balance']>0)? $tfee_grace_period_arr[$ptr-1]:NULL; 
									?>
								</td>
							<tr>
							
						<?php endforeach; ?>	<!-- payables -->						
					<?php endif; ?>
						
					
					<tr>
						<th><?php // echo 'Total Amount'; ?></th>
						<th><?php // echo number_format($total_payable,2); ?></th>
						<th><?php // echo number_format($total_balance,2); ?></th>
						<td><?php  ?></td>
					</tr>					
					
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
						<span class="staff-name">Mrs. Evelyn N. Santos</span><br><br>
						<span class="staff-title">Registrar</span>
					</p>
				</center>
			</div>
		</div>
		<div class="sch-note">
			<p>This is not an Official Receipt. Always get an Official Receipt from the CASHIER for every payment you made. Refer to your STUDENT HANDBOOK regarding the school policy. Assessment of Fees are partly based on the information you provided. St. James Academy reserves the right to reassess the account of Student whose records contain false or incorrect information. </p>
		</div>
	</div>
	
	<?php else: ?>		<!-- scid -->
		<p><table id="tbl-1" class="gis-table-bordered " >
			<tr>
				<th>ID</th>
				<td>
				<input class="pdl05" id="part" autofocus placeholder="id / name" />
				<input type="submit" name="auto" value="Filter" onclick='getDataByTable(dbcontacts,5);return false;' />				
			</td></tr>			
		</table></p>	
		<div id="names" ><div>
	<?php endif; ?>		<!-- scid -->
	

<script>
var gurl = "http://<?php echo GURL; ?>";
var sy = "<?php echo $sy; ?>";
var dbcontacts = "<?php echo $dbcontacts; ?>";
var limit=20;
			
$(function(){
	$('html').live('click',function(){ $('#names').hide(); });
	$('#names').hide();
	
})




function axnFilter(id){
	var url=gurl+"/students/assessment/"+id+"/"+sy;
	window.location=url;
}



</script>



<script type="text/javascript" src='<?php echo URL."views/js/axjs.js"; ?>' ></script>
	
</body>
</html>