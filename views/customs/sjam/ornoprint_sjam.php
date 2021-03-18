<?php 
extract($or);

// pr($or);

$logo_src = URL."public/images/weblogo_".VCFOLDER.".png";


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
	<style>
		table {
			padding: 10px 48px;
			width: 100%;
			font-size: 12px;
		}
		.t-center {
			text-align: center;
		}
		.t-right {
			text-align: right;
		}
		.or-printing {
			width: 576px;
			height: 615px;
			margin:auto;
		}
		.particulars-area {
			height: 160px;
		}

		.or-num,
		.or-date,
		.total-amt {
			margin-left: 330px; 
		}
		.or-num {
			margin-top: 40px;
		}
		.or-date {
			margin-top: 15px;
		}
		.stud-info-details,
		.msg,
		.change {
			margin-left: 50px;
		}
		.total-amt {
			margin-top: -10px;
		}
		.amt-text {
			margin-top: 5px;
			margin-left: 30px;
		}
		.amt-recieve {
			margin-top: 30px;
			margin-left: 80px;
		}
		.ref {
			margin-top: 30px;
			margin-left: 20px;	
		}
		.change,
		.emplname {
			margin-top: 20px;
		}
	</style>
	<div class="wrap">
		<div class="or-printing">
			<div class="or&date-wrapper">
				<table>
					<tr>
						<td>
							<div class="or-num"><?php echo str_pad($orno,5,'0',STR_PAD_LEFT); ?></div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="or-date"><?php echo $date; ?></div>
						</td>
					</tr>
				</table>
			</div>
			<div class="head-studinfo">
				<table style="margin-top: -5px">
					<tr>
						<td colspan="3">
							<div class="stud-info-details"><?php echo ($payer_is_student)? $studcode:null; ?></div>
						</td>
						<td colspan="3">
							<div class="stud-info-details">2020 - 2021</div>
						</td>
					</tr>
					<tr>
						<td colspan="6">
							<div class="stud-info-details"><?php echo (empty($payer))? $studname: $payer; ?></div>
						</td>
						<!-- <td colspan="3" width="250">
							<div class="stud-info-details"><?php echo $address; ?></div>
						</td> -->
					</tr>	
					<tr>
						<td colspan="6">
							<div class="stud-info-details"><?php echo ($payer_is_student)? $classroom:NULL; ?></div>
						</td>
					</tr>
				</table>
			</div>
			<div class="particulars-area">
				<table style="margin-top: 23px;">
					<?php for($i=0;$i<$count;$i++): ?>
						<?php extract($rows[$i]); ?>
						<tr>
							<td>
								<div style="margin-left: 70px;"><?php echo $feetype; ?></div>
							</td>
							<td>
								<div  style="margin-right: 45px;"><?php echo number_format($amount,2); ?></div>
							</td>			
						</tr>
					<?php endfor; ?>
				</table>
			</div>
			<div class="payment-msg">
				<table>
					<tr>
						<td>
							<div class="msg"><b>*Thank you for your payment</b></div>
						</td>
					</tr>
				</table>
			</div>
			<div>
				<table>
					<tr>
						<td>
							<div class="total-amt"><?php echo number_format($total,2); ?></div>
						</td>
					</tr>
				</table>
			</div>
			<div class="pay-details">
				<table>	
					<tr>
						<td colspan="3">
							<div class="amt-text"><?php $spellout=amountInWords($total); echo strtoupper($spellout); ?></div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="amt-recieve"><u><?php echo number_format($total_received,2); ?></u></div>
						</td>
						<td width="190">
							<div class="ref"><u><?php echo $reference; ?></u></div>
						</td>
						<td width="50">
							<div class="payment-datails"><u><?php echo $bank; ?></u></div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="change"><b><?php echo number_format($total_change,2); ?></b></div>
						</td>
						<td colspan="2">
							<div class="t-center emplname"><b><?php echo $emplname; ?></b></div>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</body>
</html>
