<h3>
	Test Add Payment - update orbooklets | <?php $this->shovel('homelinks'); ?>
	
	
	
</h3>

<?php 

pr($_SESSION['q']);

?>


<form action="<?php echo URL.'ajax/xorno.php'; ?>" method="POST" >


<div >
	<input name="task" value="addPayment" >
	<input name="orno" value="1232111" >
	<input name="amount" value="600.55" >
	<input name="feetype_id" value="2" >
	<input name="scid" value="2233" >
	<input name="ecid" value="1" >
	<input name="date" value="2020-06-15" >
	<input type="submit" name="submit" value="Submit" >
</div>

</form>
