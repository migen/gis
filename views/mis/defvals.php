<h5>
	Default Values
	
	
</h5>

<form method="POST" >

<table class="gis-table-bordered table-fx table-altrow" >
<tr><th>DB</th><td>
	<select name="dbx" >
		<option value="<?php echo DBO; ?>" >DBO</option>
		<option value="<?php echo PDBG; ?>" >DBM</option>
		<option value="<?php echo PDBG; ?>" >DBG</option>
	</select>
</td></tr>

<tr><th>Table</th><td><input name="dbtable" /></td></tr>
<tr><th>Where</th><td><input name="where" /></td></tr>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<tr >
	<td><input id="col<?php echo $i; ?>" class="" name="posts[<?php echo $i; ?>][col]" /></td>		
	<td><input id="val<?php echo $i; ?>" class="" name="posts[<?php echo $i; ?>][val]" /></td>		
</tr>

<?php endfor; ?>			
</table>

<p>
	<input type="submit" name="submit" value="Submit" onclick="return confirm('Sure?');" /> &nbsp; 
	<button><a href="<?php echo URL.$_SESSION['home']; ?>" class="no-underline" >Cancel</a></button>
</p>

</form>


<p><?php $this->shovel('numrows'); ?></p>
