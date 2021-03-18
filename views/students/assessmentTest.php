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
					<td><span class="colon">:</span>2011-01012</td>
					<td width="100"></td>
					<th width="150">Date</th>
					<td><span class="colon">:</span> June 12, 2020</td>
				</tr>
				<tr>
					<th width="150">Student Name.</th>
					<td><span class="colon">:</span>John Doe</td>
					<td width="100"></td>
					<th width="150">Level / Section</th>
					<td><span class="colon">:</span> Grade 8 - St. Mark</td>
				</tr>
				<tr>
					<th width="150">School Year</th>
					<td><span class="colon">:</span>2020 - 2021</td>
					<td width="100"></td>
					<th width="150">Mode of Payment</th>
					<td><span class="colon">:</span> Quaterly</td>
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
					<tr>
						<th width="250">Tuition Fees</th>
						<td width="10">:</td>
						<td width="50"></td>
						<td width="100" class="amount">34029.30</td>
					</tr>
					<tr>
						<th>Miscellaneous Fees</th>
						<td>:</td>
						<td></td>
						<td class="amount">6162.30</td>
					</tr>
					<tr>
						<th>Other Fees</th>
						<td>:</td>
						<td></td>
						<td class="amount">10156.30</td>
					</tr>
					<tr>
						<th>Physical Plant Fees</th>
						<td>:</td>
						<td></td>
						<td class="amount">6595.30</td>
					</tr>
					<tr>
						<th>Supply Reading Material</th>
						<td>:</td>
						<td></td>
						<td class="amount">34029.30</td>
					</tr>
					<tr>
						<th>Reservation</th>
						<td>:</td>
						<td>Less --</td>
						<td class="amount">500.00</td>
					</tr>
					<tr>
						<th>Total</th>
						<td>:</td>
						<td></td>
						<td class="amount">57521.00</td>
					</tr>
				</table>

				<p><b>Scholarship & Discount Summary</b></p>
				<table>
					<tr>
						<th width="250">Less ESC</th>
						<td width="10">:</td>
						<td width="50"></td>
						<td width="100" class="amount">13000.00</td>
					</tr>
					<tr>
						<th>Less ESC Credit SY 2017-2018</th>
						<td>:</td>
						<td></td>
						<td class="amount">11000.00</td>
					</tr>
					<tr>
						<th>Total Discount</th>
						<td>:</td>
						<td>Less --</td>
						<td class="amount">24000.00</td>
					</tr>
					<tr>
						<th>Total Total Amount</th>
						<td>:</td>
						<td></td>
						<td class="amount">33551.00</td>
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
						<td>Upon Enrollment</td>
						<td>8112.92</td>
						<td>06-12-2020</td>
					</tr>
					<tr>
						<td>2nd Payment</td>
						<td>8112.92</td>
						<td>06-12-2020</td>
					</tr>
					<tr>
						<td>3rd Payment</td>
						<td>8112.92</td>
						<td>06-12-2020</td>
					</tr>
					<tr>
						<td>4th Payment</td>
						<td>8112.92</td>
						<td>06-12-2020</td>
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