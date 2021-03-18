<h3>
	Test | <?php $this->shovel('homelinks'); ?>
	
	
	
</h3>

<?php 

pr($_SESSION['q']);

?>


<form action="<?php echo URL.'ajax/xorno.php'; ?>" method="POST" >


<div >
<input name="task" value="testPoster" >
<input name="orno" value="1232111" >
<input name="poster" value="abc-test" >
<input type="submit" name="submit" value="Submit" >


</div>

</form>
