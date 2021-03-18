<h5>Clean Up Attendance (Holidays & Weekends) 
	| <a href="<?php echo URL; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>					

</h5>
<?php 
$date = date('Y-m-d');

?>
<!---------------------------------------------------------------------------->



<form method="POST" >	
<!------------------------------------------------------------------>

<table class="gis-table-bordered" >
<tr class='headrow'>
	<th>#</th>	
	<th>Date : mm/dd/yyyy </th>
</tr>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td><input class="pdl10" type="date" name="da[<?php echo $i; ?>][date]" value="<?php echo $date; ?>" /></td>
</tr>

<?php endfor; ?>			
</table>

<p>
	<input type="submit" name="submit" value="Clean Up" /> &nbsp; 
	<button><a href="<?php echo URL.'mis'; ?>" class="no-underline" >Cancel</a></button>
</p>

</form> 

<!------------------------------------------------------------------------->


<!---------------------------------------------------------------------------->

<script>

$(function(){

	nextViaEnter();

})


</script>
