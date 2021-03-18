<?php
	// pr($data);
	
	
?>

<h5>
	Edit GIS Months Quarters
	| <?php $this->shovel('homelinks','mis'); ?>

</h5>


<form method="POST">


<table class='gis-table-bordered table-fx'>
<thead>
	<tr class='headrow'>
		<th>ID</th>
		<th>Code</th>
		<th>Month</th>
		<th>Position</th>
		<th>Quarter</th>
	</tr>
</thead>

<tbody>
<?php for($i=0;$i<$numrows;$i++): ?>
<tr rel="<?php echo $i; ?>" >
	<td id="id<?php echo $rows[$i]['id']; ?>"><?php echo $rows[$i]['id']; ?></td>
	<td id="code<?php echo $rows[$i]['id']; ?>"  ><?php echo $rows[$i]['code']; ?></td>
	<td id="month<?php echo $rows[$i]['id']; ?>" ><?php echo $rows[$i]['name']; ?></td>
	<td id="pos<?php echo $rows[$i]['id']; ?>" >
		<input type='text' class='vc50 center' name="data[MQ][<?php echo $i; ?>][index]" value="<?php echo $rows[$i]['index']; ?>"  >
		<br />				
	</td>		
	<td id="qtr<?php echo $rows[$i]['id']; ?>" >
		<input type='text' class='vc50 center' name="data[MQ][<?php echo $i; ?>][qtr]" value="<?php echo $rows[$i]['quarter']; ?>"  >
		<br />				
	</td>	
	
		<input type='hidden' name="data[MQ][<?php echo $i; ?>][row_id]" value="<?php echo $rows[$i]['id']; ?>"  >				
</tr>
<?php endfor; ?>
</tbody>
</table>


<p><input onclick="return confirm('Are you sure?');" type='submit' name='submit' value='Submit' /></p>

</form>


<?php 

// pr($data);