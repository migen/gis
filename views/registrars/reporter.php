<h5> Reporter <?php echo ucfirst($report); ?> </h5>




<form method="POST"  >

<table class="gis-table-bordered table-fx"  >
<tr class="headrow" >
	<th>#</th>
	<th>Level</th>
	<th class="vc80" >Year</th>
</tr>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td>
		<select class="full" name="reports[<?php echo $i; ?>][level_id]"  >
			<option value="" >Choose One</option>
			<?php	foreach($levels AS $sel): ?><option value="<?php echo $sel['id']; ?>"><?php echo $sel['name']; ?></option><?php	endforeach; ?>
		</select>
	</td>
	<td>
		<select class="full" name="reports[<?php echo $i; ?>][sy]"  >
				<option value="">Year</option>		
			<?php for($i=$year;$i>1970;$i--): ?>
				<option><?php echo $i; ?></option>
			<?php endfor; ?>
		</select>
	</td>		

	<td><u class='delLink blue' rel="<?php echo $row['id']; ?>">DEL</u></td>
	
</tr>

<?php endfor; ?>			

</table>
<p>
	<input type="submit" name="filter" value="Filter" /> &nbsp;
	<input type="submit" name="submit" value="Submit" /> &nbsp;
</p>


</form>


<p><?php $this->shovel('numrows'); ?></p>



<!----------------------------------------------------------------------------------------------->


<script>


$(document).on('click','.delLink',function(){		
	delLink = $(this);
	delLink.parent().parent().remove();
	return false;					
});


</script>
