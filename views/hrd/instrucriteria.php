<?php 

	// pr($data);
	// pr($_SESSION['q']);

?>

<!------------------------------------------------------------------------------------------------------------------------>

<h5>
	Instrument Criteria | 
	<?php 	$this->shovel('homelinks','hrds'); ?>
</h5>

<!------------------------------------------------------------------------------------------------------------------------>


<table class="table-fx gis-table-bordered">
<tr class='headrow'>
	<th>#</th>
	<th>Type</th>
	<th>Name</th>
	<th> Active</th>
</tr>
<!----------------------- data ------------------------------------------------------------>
<?php for($i=0;$i<$num_instrucriteria;$i++): ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td><?php echo $instrucriteria[$i]['itype']; ?></td>
		<td class="<?php echo ($instrucriteria[$i]['is_active'])? null:'bg-salmon'; ?>" ><a href="<?php echo URL.'mis/subcourses/'.$instrucriteria[$i]['id']; ?>"><?php echo $instrucriteria[$i]['name']; ?></a></td>
		<td><?php echo ($instrucriteria[$i]['is_active'])? 'Y':'N'; ?></td>
				
	</tr>	
<?php endfor; ?>

</table>
<br />

<!------------------------------------------------------------------------->

<form method="POST" >	<!-- form add subjects -->
<!------------------------------------------------------------------>
<h5> Add </h5>

<table class="gis-table-bordered" >
<tr class='headrow'>
	<th>#</th>	
	<th>Type</th>	
	<th>Name</th>
</tr>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td>
		<select name="instrucriteria[<?php echo $i; ?>][instrutype_id]"  >
			<?php	foreach($instrutypes as $sel): ?><option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option><?php	endforeach; ?>				
		</select>
	</td>	
	<td><input class="vc500" type="text" name="instrucriteria[<?php echo $i; ?>][name]" /></td>
</tr>

<?php endfor; ?>			
</table>

<p>
	<input type="submit" name="add" value="Add" /> &nbsp; 
	<button><a href="<?php echo URL.'mis'; ?>" class="no-underline" >Cancel</a></button>
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


