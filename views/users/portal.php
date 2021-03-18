<script>



</script>

<style>

a.portal-icon,.btn{
    display: inline-block;
	margin-right: 20px;
    position: relative;
    border-radius: 5px;
	padding: 100px 0 0 0;
	min-width: 200px; 
	min-height: 150px; 
	color:red;
	font-size : 32px;
	text-align: center;
	valign: center;

}

/*
.button{
font: bold 11px Arial;text-decoration: none;background-color: #EEEEEE;color: #333333;padding: 2px 6px 2px 6px;border-top: 1px solid #CCCCCC;
border-right: 1px solid #333333;border-bottom: 1px solid #333333;border-left: 1px solid #CCCCCC;}
*/

</style>


<h5>
	<?php echo $this->shovel('breadlinks'); ?>
	<br />Portal
</h5>

<?php 

	// pr($_SESSION['portal']);
	$numrows = count($_SESSION['user']['portals']);
	
?>

<form method='post'>

    
<?php 
    $i = 0;
    foreach($_SESSION['user']['portals'] AS $k => $v):  
?>
	<a class='portal-icon bg-color<?php echo $i; ?>' ><input type='radio' onclick='this.form.submit();' name='module' value="<?php echo $v; ?>" > <?php echo $v.'<br />'; ?> </a>	
<?php 
    $i++;
    endforeach; 
?>


</form>

