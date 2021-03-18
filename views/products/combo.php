<h5>
	Combo


</h5>


<p class="" ><?php $this->shovel('hdpdiv'); ?></p>

<form method="POST" >
<table class="gis-table-bordered" >

<tr><th>ID</th><td><input value="<?php echo $row['id']; ?>" readonly /></td></tr>
<tr><th>Product</th><td><input name="name" value="<?php echo $row['name']; ?>" /></td></tr>
<tr><th>Combo</th><td><input name="combo" value="<?php echo $row['combo']; ?>" /></td></tr>
<tr><th>Lookup</th><td>
	<select >
		<?php foreach($products AS $sel): ?>
			<option><?php echo $sel['name'].'-ID#'.$sel['id']; ?></option>
		<?php endforeach; ?>
	</select>
</td></tr>

</table>




<p class="" >
	<input type="submit" name="submit" value="Submit" />
</p>
</form>


<?php if(!empty($rows)): ?>	<!-- has combos -->
<table class="gis-table-bordered" >
<tr><th>ID</th><td>Product</td></tr>
<?php foreach($rows AS $row): ?>
	<tr><td><?php echo $row['id']; ?></td><td><?php echo $row['name']; ?></td></tr>
<?php endforeach; ?>
</table>
<?php endif; ?>	<!-- has combos -->



<script>
var hdpass = "<?php echo HDPASS; ?>";

	$(function(){
		$('#hdpdiv').hide();
		hd();
	})


</script>


<?php 

// pr($data);

?>