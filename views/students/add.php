
<?php 
$ninjaEnt = SITE."views/entitys/private/ninjaEntity.php";
// include($ninjaEnt);
// include('../entitys/private/ninjaEntity.php'); 

?>
<div  id='jasmin'></div>


<form id='addTxnForm' method='post' action="<?php echo URL.'txns/add' ; ?>" >

<table >
<thead><tr><th></th><th>Date</th><th>Amount</th><th>Transaction</th><th>To</th><th>From</th><th>Tag</th><th>Share</th><th>Status</th></tr></thead>
<tbody id='tableTxn'>

<?php $ni = isset($_POST['ni'])? $_POST['ni'] : 1; ?>
<?php for($i=0;$i<$ni;$i++): ?>
	<?php include('forms/txn.php'); ?>
		
<?php $uid = isset($_SESSION['user_id'])? $_SESSION['user_id']:1; ?>	
<input type='hidden' name='data[Txn][<?php echo $i; ?>][user_id]' value='<?php echo (int)$uid; ?>'>	
<?php endfor; ?>

</tbody></table>


<input type='submit' name='submit' value='Submit'><input type="button" name="cancel" value="Cancel" onclick="document.location='index';" />


</form> <!-- addTxnForm -->


<?php $this->shovel('numrows'); ?>




