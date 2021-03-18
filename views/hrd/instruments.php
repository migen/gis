<?php 

	// pr($data);

	

?>

<!------------------------------------------------------------------------------------------------------------------------>

<h5>
	Instruments | 
	<?php 	$this->shovel('homelinks','hrds'); ?>
</h5>

<!------------------------------------------------------------------------------------------------------------------------>


<table class="table-fx gis-table-bordered">
<tr class='headrow'>
	<th>#</th>
	<th>Code</th>
	<th>Name</th>
	<th class="hd" >id</th>
</tr>
<!----------------------- data ------------------------------------------------------------>
<?php for($i=0;$i<$num_instruments;$i++): ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td class="<?php echo ($instruments[$i]['is_active'])? null:'bg-salmon'; ?>" ><?php echo $instruments[$i]['code']; ?></td>
		<td><a href="<?php echo URL.'hrds/icomponents/'.$instruments[$i]['instrid']; ?>" ><?php echo $instruments[$i]['name']; ?></a></td>		
		<td> <button id="csb<?php echo $i; ?>" onclick="xeditInstrument(<?php echo $i.','.$instruments[$i]['instrid']; ?>);return false;" > Save </button>  </td>
		<td class="hd"><?php echo $instruments[$i]['instrid']; ?></td>
		
	</tr>	
<?php endfor; ?>

</table>
<br />

<!---------------------- add --------------------------------------------------->

<form method="POST" >	
<h5> Add Instruments </h5>

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
	<td><input class="vc50" name="instruments[<?php echo $i; ?>][code]" /></td>
	<td><input class="vc300" name="instruments[<?php echo $i; ?>][name]" /></td>
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


