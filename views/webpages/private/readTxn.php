<?php 

$suid = Session::get('user_id');


?>

<div class='read'>
<table>
<tr><td>Id</td><td class='twenty'><?php echo $txn['id']; ?></td></tr>
<tr><td>User</td><td><?php if($suid == 1): ?><a href="<?php echo URL.'users/edit/'.$txn['user_id']; ?>"><?php endif; ?><?php echo $txn['user']; ?></a></td></tr>
<tr><td>Tag</td><td><?php echo $txn['tag']; ?></td></tr>
<tr><td>Status</td><td><?php echo $txn['status']; ?></td></tr>


<tr><td>Date</td><td class='twenty'><?php echo $txn['date']; ?></td></tr>
<tr><td>Amount</td><td class='twenty'><?php echo $txn['amount']; ?></td></tr>
<tr><td>Type</td><td class='twenty'><?php echo $txn['txntype']; ?></td></tr>
<tr><td>To</td><td><?php if($suid == 1): ?><a href="<?php echo URL.'entitys/edit/'.$txn['to_id']; ?>"><?php endif; ?><?php echo $txn['tent']; ?></td></tr>
<tr><td>From</td><td><?php if($suid == 1): ?><a href="<?php echo URL.'entitys/edit/'.$txn['from_id']; ?>"><?php endif; ?><?php echo $txn['fren']; ?></td></tr>



<tr><td>Name</td><td class='twenty'><?php echo $txn['name']; ?></td></tr>
<tr><td>Share</td><td class='twenty'><?php echo $txn['share']; ?></td></tr>

</table>
</div>


<div id='tent' >
<h5 class='center'>To Entity</h5>
<?php pr($tent); ?>
</div>

<div id='fren'>
<h5 class='center'>From Entity</h5>
<?php pr($fren); ?>
</div>

