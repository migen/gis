<h3>
	Ranks | <?php $this->shovel('homelinks'); ?>

</h3>

<?php 
// pr($_SESSION['settings']);
?>


<!-- filter -->
<p>
<form method="GET" >
<table class="gis-table-bordered table-altrow table-fx" >
	<tr>
		<th>SY</th>
		<td><input type="number" name="sy" class="vc100" 
			value="<?php echo (isset($_GET['sy']))? $_GET['sy']:DBYR; ?>" ></td>
	</tr>		
	<tr>
		<th>Qtr</th>
 		<td>
			<select name="qtr" class="vc100" >		
				<?php for($i=1;$i<5;$i++): ?>
					<option value="<?php echo $i; ?>" ><?php echo $i; ?></option>
				<?php endfor; ?>
					<option value="5" >Final</option>				
					<option value="5" >Sem 1</option>				
					<option value="6" >Sem 2</option>				
					<option value="7" >Final - SHS</option>				
			</select>
	</tr>		
	<tr>
		<th>Level</th>
 		<td>
			<select name="lvl" >
				<option value="0" >Select</option>
				<?php foreach($levels AS $sel): ?>
					<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
				<?php endforeach; ?>			
			</select>
	</tr>	
	<tr>
		<th>Classroom</th>
 		<td>
			<select name="crid" >
				<option value="0" >Select</option>
				<?php foreach($classrooms AS $sel): ?>
					<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
				<?php endforeach; ?>			
			</select>
	</tr>	
		
	<tr>
		<td colspan=2><input type="submit" name="submit" value="Submit" ></td>
	</tr>
	
	
</table>
</form>
</p>



<!-- -->




