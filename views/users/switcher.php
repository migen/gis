<script>



</script>

<style>

a.portal-icon,a.switcher-icon,.btn{	    display: inline-block;
	margin-right: 20px;	    position: relative;
    border-radius: 5px;		padding: 100px 0 0 0;
	min-width: 200px;		min-height: 150px; 
	color:red;				font-size : 32px;
	text-align: center;		valign: center;
}

</style>


<h5>
	<?php echo $this->shovel('breadlinks'); ?>
	<br />Switcher
</h5>

<?php 

	// pr($_SESSION['portal']);
	$numrows = count($_SESSION['switcher']);
	
?>

<form method='post'>

<?php 
	for($i=0;$i<$numrows;$i++): 
	$row = $_SESSION['switcher'][$i];
		
	
?>

	<a class='switcher-icon bg-color<?php echo $i; ?>' ><input type='radio' onclick='this.form.submit();' name='account' value="<?php echo $i; ?>" > <?php echo $row['title']; ?> </a>
	
<?php endfor; ?>


</form>

