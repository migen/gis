
<h3>
	Edit Book | <?php $this->shovel('homelinks'); ?>
	<?php include('linksBooklists.php'); ?>
	
</h3>

<?php 
extract($row);


?>

<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>Pkid</th><td><?php echo $pkid; ?></td></tr>

<tr><th>Semester</th><td><input name="post[semester]" value="<?php echo $semester; ?>" ></td></tr>
<tr>
<th>Subject</th>
<td>
	<select name="post[subject_id]" class="vc300" >
		<?php foreach($subjects AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$subject_id)? 'selected':NULL; ?> >
				<?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select>
</td>
</tr>

<tr><th>Code</th><td><input name="post[code]" value="<?php echo $code; ?>" ></td></tr>
<tr><th>Name</th><td><input name="post[name]" value="<?php echo $name; ?>" ></td></tr>
<tr><th>Company</th><td><input name="post[company]" value="<?php echo $company; ?>" ></td></tr>
<tr><th>Amount</th><td><input name="post[amount]" value="<?php echo number_format($amount,2); ?>" ></td></tr>

<tr><th>Level</th>
<td>
	<select name="level_id" >
		<option value="" >Add Level</option>
		<?php foreach($levels AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select>
</td></tr>

<tr><td colspan=2><input type="submit" name="submit" value="Save" ></td></tr>

</table>
</form>

<br >

<table class="gis-table-bordered" >
<tr>
	<th>ID</th>
	<th>Level</th>
	<th>Num</th>
	<th></th>
</tr>
<?php foreach($levelBooks AS $row): ?>
<tr>
	<td><?php echo $row['level_book_id']; ?></td>
	<td><?php echo $row['level']; ?></td>
	<td><?php echo $row['num']; ?></td>
	<td>
		<a href="<?php echo URL.'booklists/editLevelBook/'.$row['level_book_id']; ?>" >Edit</a>		
		| <a onclick="return confirm('Sure?');" 
			href="<?php echo URL.'booklists/deleteLevelBook/'.$row['level_book_id']; ?>" >Delete</a>	
	</td>
</tr>
<?php endforeach; ?>
</table>

<br />





<script>


(function(){

	nextViaNeter();
	selectFocused();

})();



</script>




