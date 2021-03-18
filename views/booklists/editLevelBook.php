<h3>
	
	Edit Level Book <?php $this->shovel('homelinks'); ?>
	<?php include('linksBooklists.php'); ?>

	

</h3>


<?php 
extract($row);


?>

<form method="POST" >
<table class="gis-table-bordered" >
	<tr><th>Level Book ID</th><td class="vc300" ><?php echo $level_book_id; ?></td></tr>
	<tr><th>Book</th><td><?php echo $book; ?></td></tr>
	<tr><th>Level</th><td><?php echo $level; ?></td></tr>
	<tr><th>Num</th><td><input type="number" min=0 max=3 name="num" value="<?php echo $num; ?>" ></td></tr>
	<tr><td colspan=2 ><input type="submit" name="submit" value="Save" ></td></tr>
</table>
</form>


<script>


(function(){

	nextViaNeter();
	selectFocused();

})();



</script>