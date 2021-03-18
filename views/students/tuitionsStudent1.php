<style>

.indented{ text-indent:20px; }

		.tfee-wrapper {
			margin: auto;
		}
		p {
			text-align: center;
			border-bottom: 1px solid;
			padding-bottom: 10px;
		}
		.tfee-wrapper table {
			margin: auto;
		}
		.tfee-wrapper table td,
		.tfee-wrapper table th {
			padding-left: 5px;
			padding-right: 5px;
		}
		.amount,
		.subtotal_amount {
			text-align: right;
		}
		.stotal-row td {
			border-top: 1px solid;
			border-bottom: 1px solid;
			padding: 3px;
		}
		.tmf-total td {
			border-bottom: 2px solid; 
			padding: 3px
		}
		.total-txt {
			letter-spacing: .35em;
			padding-left: 15px;
		}
		.payment-breakdown td {
			border-top: 1px solid;
			border-bottom: 1px solid;
			padding: 3px;
		}
		.notes	{
			width: 650px;
			margin: auto;
			padding: 10px;
			border: 1px solid;

		}

</style>


<?php 


// pr($rows[0]);

?>
<div class="tfee-wrapper">
	<table>
		<tr>
			<th colspan="2">
				<p class="header">
					<span style="font-size: 20px">ST JAMES ACADEMY</span><br>
					<span style="font-size: 20px">MALABON CITY</span><br>
					<small>TUITION AND OTHER FEES AND TERMS OF PAYMENT</small><br>
					<small>SCHOOL YEAR 2020-2021</small><br>
					<span style="font-size: 25px"><?php echo $level['name']; ?></span>
				</p>
			</th>
		</tr>
	</table>


<?php 
// pr($level); 
?>





<table class="table-bordered" >
<tr>
	<th class="vc200" ></th>
	<th class="right" ></th>
</tr>
<?php $total=0; ?>
<?php for($i=0;$i<$count;$i++): ?>
<?php $total+=($rows[$i]['in_total'])? $rows[$i]['amount']:0; ?>
<?php $is_child=($rows[$i]['parent_id']>0)? true:false; ?>
<tr>
	<td class="<?php echo ($is_child)? 'indented':'b'; ?>" ><?php echo $rows[$i]['feetype']; ?></td>
	<td class="right" ><?php echo number_format($rows[$i]['amount'],2); ?></td>
</tr>
<?php endfor; ?>
<tr>
	<th colspan=>Total</th>
	<th class="right" ><?php echo number_format($total,2); ?></th>
</tr>
</table>

<!---------- note ------------->
		<br>
		<div class="notes">
			<span style="font-size: 20px;"><b>NOTE:</b></span><br><br>
			<span>*Discount given for SY 2020-2021 <b>6.9%.</b></span><br><br>
			<span>*Schoology (LMS) will be given for free to primary pupils this School Year 2020-2021</span><br><br>
			<span>*Above fees quoted on “Annual Payment”. However, in compliance with the Rules and Regulations of DECS Series of 1979, Implementing PD, 451, we are allowing payments on installment Basis, subject to Interest of 1% per month on Gross Assessment. Delayed Installment shall be further subject to Penalty of 3% per month on the outstanding balance.</span>
		</div>
</div>	<!-- tfee-wrapper -->



<div class="ht50" ><div>
