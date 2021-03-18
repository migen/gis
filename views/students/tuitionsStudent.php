<?php 


$sch=VCFOLDER;
$incfile=SITE."views/customs/{$sch}/incs/enrollmentFxn_{$sch}.php";
if(is_readable($incfile)){ include_once($incfile); $getPayplans="getPayplansSjam"; } else { $getPayplans="getPayplans"; }


// pr($getPayplans);
// pr("lvl: $lvl ");
$payplans=$getPayplans($total,$lvl);
// pr($payplans);

// pr($data);
extract($level);
// pr($level);

?>

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
					<span style="font-size: 20px">GIS</span><br>
					<span style="font-size: 20px">MALABON CITY</span><br>
					<small>TUITION AND OTHER FEES AND TERMS OF PAYMENT</small><br>
					<small>SCHOOL YEAR 2020-2021</small><br>
					<span style="font-size: 25px"><?php echo $level['name']; ?></span>
					<?php if($level_id>13): ?>
						<br /><span style="font-size: 25px"><?php echo $level['major']; ?></span>					
					<?php endif; ?>
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
	<td class="right" ><?php echo ($rows[$i]['amount_hidden']==1)? null:number_format($rows[$i]['amount'],2); ?></td>
</tr>
<?php endfor; ?>
<tr>
	<th colspan=>Total</th>
	<th class="right" ><?php echo number_format($total,2); ?></th>
</tr>

<tr>
	<th colspan=>&nbsp;</th>
	<th class="right" ><?php  ?></th>
</tr>
<?php if($lvl>2): ?>
	<?php foreach($payplans AS $k=>$v): ?>
		<tr>
			<th colspan=><?php echo ucfirst($k).' Payment'; echo ($k!='yearly')? 's':NULL; ?></th>
			<th class="right" ><?php echo number_format($v,2); ?></th>
		</tr>
	<?php endforeach; ?>
<?php else: ?>	
	<?php foreach($payplans AS $k=>$v): ?>
	<?php if($k=='semestral' OR $k=='quarterly') continue; ?>	
		<tr>
			<th colspan=><?php echo ucfirst($k).' Payment'; echo ($k!='yearly')? 's':NULL; ?></th>
			<th class="right" ><?php echo number_format($v,2); ?></th>
		</tr>
	<?php endforeach; ?>
<?php endif; ?>		<!-- ps -->
	

</table>

<!---------- note ------------->
		<br>
		<div class="notes">
			<span style="font-size: 20px;"><b>NOTE:</b></span>
			<?php echo $notes; ?>
		</div>
</div>	<!-- tfee-wrapper -->



<div class="ht50" ><div>
