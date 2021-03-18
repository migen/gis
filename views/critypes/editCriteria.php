<h5>
	Critypes Edit Components
	| <?php $this->shovel('homelinks'); ?>
	
</h5>

<?php 
// pr($subjects); 


?>

<form method="GET" >
<table class="gis-table-bordered" >
<tr><th>Replace X</th><td><input type="number" name="x_critype" value="" ></td></tr>
<tr><th>Replace with Y</th><td><input type="number" name="y_critype" value="" ></td></tr>
<tr><th colspan=2 ><input type="submit" name="submit" value="Submit"  /></th></tr>
</table>


</form>

<br />
<table class="gis-table-bordered" >
<tr><th>ID</th><th>Critype</th></tr>
<?php foreach($critypes AS $sel): ?>
<tr>
	<td><?php echo '#'.$sel['id']; ?></td>
	<td><?php echo $sel['name']; ?></td>
</tr>
<?php endforeach; ?>
</table>
