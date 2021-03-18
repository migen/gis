<?php 

	// pr($data);

	

?>

<!------------------------------------------------------------------------------------------------------------------------>

<h5>
	Instrument Types | 
	<?php 	$this->shovel('homelinks','hrds'); ?>
</h5>

<!------------------------------------------------------------------------------------------------------------------------>


<table class="table-fx gis-table-bordered">
<tr class='headrow'>
	<th>#</th>
	<th>Code</th>
	<th>Name</th>
	<th class="hd" >Instyid</th>
</tr>
<!----------------------- data ------------------------------------------------------------>
<?php for($i=0;$i<$num_instrutypes;$i++): ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td><?php echo $instrutypes[$i]['code']; ?></td>
		<td><?php echo $instrutypes[$i]['name']; ?></td>
		
		<td> <button id="csb<?php echo $i; ?>" onclick="xeditInstrutype(<?php echo $i.','.$instrutypes[$i]['instyid']; ?>);return false;" > Save </button>  </td>
		<td class="hd"><?php echo $instrutypes[$i]['instyid']; ?></td>
		
	</tr>	
<?php endfor; ?>

</table>
<br />

<!---------------------- add --------------------------------------------------->

<form method="POST" >	
<h5> Add Instrument Types </h5>

<table class="gis-table-bordered" >
<tr class='headrow'>
	<th>#</th>	
	<th>Code</th>
	<th>Name</th>
</tr>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td><input class="vc50" name="instrutypes[<?php echo $i; ?>][code]" /></td>
	<td><input class="vc300" name="instrutypes[<?php echo $i; ?>][name]" /></td>
</tr>

<?php endfor; ?>			
</table>

<p>
	<input type="submit" name="add" value="Add" /> &nbsp; 
	<button><a href="<?php echo URL.'hrds'; ?>" class="no-underline" >Cancel</a></button>
</p>

</form> <!-- add -->



</table>

<!------------------------------------------------------------------------->

<p><?php $this->shovel('numrows'); ?></p>


<!------------------------------------------------------------------------->


<script>

var gurl = 'http://<?php echo GURL; ?>';
$(function(){

// hd();

		
})




</script>


