<h5>

<?php echo $instrument['name']; ?>
</h5>


<table class="gis-table-bordered table-fx" >
	<tr><th>#</th><th>Criteria</th></tr>
<?php for($i=0;$i<$num_icomponents;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $icomponents[$i]['icriteria']; ?></td>
</tr>

<?php endfor; ?>
</table>



<!---------------------- add --------------------------------------------------->

<form method="POST" >	
<h5> Add </h5>

<table class="gis-table-bordered" >
<tr class='headrow'>
	<th>#</th>	
	<th>Criteria</th>
	<th>Max</th>
	<th>Weight</th>
</tr>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td><select name="icomponents[<?php echo $i; ?>][instrucriteria_id]" id='<?php echo $i; ?>' class='vc300'  >
	<?php echo isset($row['stype'])? $row['stype']:'misc'; ?></option>
	<?php	foreach($data['instrucriteria'] as $sel): ?><option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option><?php endforeach; ?>
	</select></td>			
	<td><input class="vc50" name="icomponents[<?php echo $i; ?>][max_score]" /></td>
	<td><input class="vc300" name="icomponents[<?php echo $i; ?>][weight]" /></td>
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
nextViaEnter();

		
})




</script>