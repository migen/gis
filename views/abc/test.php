<h3>
	Test | <?php $this->shovel('homelinks'); ?>
</h3>

<?php 

function updatePayableBalance($db,$payable,$payments){
	$row['paid']=0;
	$row['balance']=$payable['amount'];
	foreach($payments AS $payment){
		if(($payable['feetype_id']==$payment['feetype_id']) && ($payable['ptr']==$payment['ptr'])){
			$row['paid']+=$payment['amount'];		
		}
		
	}
	$row['balance']-=$row['paid'];
	return $row;
	
}	/* fxn */





$payables=array(
	array('feetype_id'=>1,'amount'=>10000,'ptr'=>1),
	array('feetype_id'=>1,'amount'=>20000,'ptr'=>2),

);

$payments=array(
	array('feetype_id'=>11,'amount'=>2200,'ptr'=>1),
	array('feetype_id'=>12,'amount'=>2100,'ptr'=>2),
	array('feetype_id'=>11,'amount'=>2200,'ptr'=>1),
	array('feetype_id'=>12,'amount'=>2100,'ptr'=>2),
	array('feetype_id'=>12,'amount'=>2200,'ptr'=>1),
	array('feetype_id'=>13,'amount'=>2100,'ptr'=>2),
	array('feetype_id'=>1,'amount'=>1000,'ptr'=>1),
	array('feetype_id'=>1,'amount'=>2000,'ptr'=>2),	
	array('feetype_id'=>1,'amount'=>2000,'ptr'=>2),	
	array('feetype_id'=>1,'amount'=>1000,'ptr'=>1),	
);



// pr($payables);
// exit;





?>
<h3>Payables</h3>
<table class="gis-table-bordered" >
<tr>
	<th>Payable</th>
	<th>Ptr</th>
	<th>Amount</th>
	<th>Paid</th>
	<th>Balance</th>
</tr>
<?php foreach($payables AS $payable): ?>
<?php $proc=updatePayableBalance($db,$payable,$payments); ?>
<tr>
	<td><?php echo $payable['feetype_id']; ?></td>
	<td><?php echo $payable['ptr']; ?></td>
	<td class="right" ><?php echo number_format($payable['amount'],2); ?></td>
	<td class="right" ><?php echo number_format($proc['paid'],2); ?></td>
	<td class="right" ><?php echo number_format($proc['balance'],2); ?></td>
</tr>
<?php endforeach; ?>
</table>




