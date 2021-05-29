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
	<style type="text/css" >
		body {

		}
		.nav	{
			margin: 0 auto;
			width: 700px;
			text-align:center;
		}		
		.or-wrapper	{
			padding-top: 30px;
			margin: 0 auto;
			width: 700px;
		}
		.or-detail {
			text-align: right;
		}
		.or-num {
			color: red;
			font-size: 25px;
		}
		.sch-logo {
			margin-top: 10px;
			text-align: right;
			padding: 10px;
		}
		.border {
			border: 1px solid;
			padding: 10px;
		}
		.sch table,
		.stud-info table,
		.particulars table,
		.sum-of table,
		.pay-detail table,
		.change-detail table {
			margin: auto;
			width: 600px;
		}
		.stud-info table,
		.particulars table,
		.sum-of table,
		.pay-detail table {
			border: 1px solid;
			margin-top: 10px;
		}
		.particulars table th {
			border-bottom: 1px solid;
		}
		.particular-details {
			text-align: center;
		}
		.particular-amount {
			text-align: right;
			padding-right: 70px;
		}
		.ttl-td {
			text-align: center;
			font-weight: bolder;
			border-bottom: 1px solid;
			border-top: 1px solid;
			padding: 10px;
		}

        @media print{ 
            .screen{ display:none; }
        }

		
		
		
 	</style>

	<div class="nav screen" >
		<a href='<?php echo URL."ornos/view/$orno/$sy?print"; ?>' >Official Printing</a>
	</div>

	<div class="or-wrapper">
	
		<div class="sch">
			<table>
				<tr>
					<td>
						<div class="sch-logo" id="logo" ><img src="<?php echo $logo_src; ?>" width="100" height="100" ></div>
					</td>
					<td>
						<center>
							<p class="sch-detail">
								<span class="" style="font-size: 25px;">ST. JAMES ACADEMY</span><br>
								<small>Rixal Ave. Ext. Gen Luna St.,</small><br>
								<small>San Agustin, Malabon, Metro Manila 1470</small><br>
								<small>Emaill: <u>finance@sja.edu.ph</u></small><br>
								<span><b>NON-VAT REG. TIN 001-392-164-000</b></span><br>
								<span><b>PAASCU ACCREDITED SCHOOL</b></span>
							</p>
						</center>
					</td>
				
				
					
					<td colspan="2" class="or-detail">
						<span >							
							<b>No.</b><span class="or-num"><?php echo str_pad($orno,5,'0',STR_PAD_LEFT); ?></span>
						</span>
					</td>
				</tr>
				<tr>
					<td><b>OFFICIAL RECEIPT<br><small>(EXEMPT)</small></b></td>
					<td colspan="2" style="text-align: right;"><b class="border">DATE</b><span class="border"><?php echo $date; ?></span></td>
				</tr>
			</table>
		</div>
		<div class="stud-info">
			<table>
				<tr>
					<td><b><small>SN NUMBER:</small></b></td>
					<td><?php echo ($payer_is_student)? $studcode:NULL; ?></td>
					<td colspan="2"><b><small>SY:</small></b></td>
					<td colspan="2">
						<?php echo $sy.' - '.($sy+1); ?>
					</td>
				</tr>
				<tr>
					<td><b><small>NAME:</small></b></td>
					<td>
						<?php echo (empty($payer))? $studname: $payer; ?>																
					</td>
					<td colspan="2"><b><small>ADDRESS:</small></b></td>
					<td colspan="2"><?php echo $address; ?></td>
				</tr>
				<tr>
					<td><b><small>GR/YR/SECTION:</small></b></td>
					<td><?php echo ($payer_is_student)? $crname:NULL; ?></td>
					<td><b><small>TIN:</small></b></td>
					<td></td>
					<td><b><small>BUS.NAME/STYLE:</small></b></td>
					<td></td>
				</tr>
			</table>
		</div>
		<div class="particulars">
			<table>			
				<tr>
					<th>PARTICULARS</th>
					<th width="200">AMOUNT</th>
				</tr>
				<?php for($i=0;$i<$count;$i++): ?>
					<?php extract($rows[$i]); ?>
					<tr>
						<td class="particular-details"><?php echo $feetype; ?></td>
						<td class="particular-amount"> <?php echo number_format($amount,2); ?></td>
					</tr>				
				<?php endfor; ?>
				
				<tr>
					<td class="ttl-td">TOTAL</td>
					<td class="ttl-td"> <?php echo number_format($total,2); ?></td>
				</tr>
			</table>
		</div>
		<div class="sum-of">
			<table>			
				<tr>
					<td><b><small>THE SUM OF</small></b></td>
				</tr>
				<td><center>
					<?php $spellout=amountInWords($total); echo strtoupper($spellout); ?>
				</center></td>
			</table>
		</div>
		<div class="pay-detail">
			<table>			
				<tr>
					<td><b>AMOUNT RECEIVED:</b> &nbsp;<span><u><?php echo number_format($total_received,2); ?></u></span></td>
					<td><b>CHECK #:</b> <span><u><?php echo $reference; ?></u></span></td>
					<td><b>BANK</b> <span><u><?php echo $bank; ?></u></span></td>
				</tr>
			</table>
		</div>
		<div class="change-detail">
			<table>			
				<tr>
					<td class="border" width="250"><center><b>CHANGE</b> &nbsp;<span><?php echo number_format($total_change,2); ?></span></center></td>
					<td>
						<p><center>
							<span style="border-bottom: 1px solid; padding-bottom: 2px;font-size: 17px;">
								<b><?php echo $emplname; ?></b>
							</span><br>
							<span><b><small>CASHIER</small></b></span><br>
							<span><small>Not valid without cashier's signature</small></span>
						</center></p>
					</td>
				</tr>
				<tr>
					<!-- <td>
						<small style="font-size: 11px;">
							5 BOXES 4000 SETS/BOXS2 PLY 90001-110000 BIR OCN 4AU00021388183<<br>
							DATE 
						</small>
					</td> -->
					<td colspan="2">
						<center>
							<br>
							THIS OFFICIAL RECEIPT SHALL BE VALID FOR FIVE(5) YEARS FROM THE DATE OF ATP<br>
							<small><b>"THIS DOCUMENT IS NOT VALID FOR CLAIM OF INPUT TAXES."</b></small>
						</center>
					</td>
				</tr>
			</table>
		</div>
	</div>
	</div>
</body>
</html>
