<h3>
	Ajax Poster from PHP | <?php $this->shovel('homelinks'); ?>
	
	
	
</h3>

<?php 

pr($_SESSION['q']);

?>


<form action="<?php echo URL.'ajax/xphp.php'; ?>" method="POST" >


<div >
<input name="task" value="testPoster" readonly >
<input name="orno" value="1232111" >
<input name="poster" value="php-ajax" readonly >
<input type="submit" name="submit" value="Submit" >


</div>

</form>
