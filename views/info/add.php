<h5>
	Add Info
	| <a href="<?php echo URL.$_SESSION['home']; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>


</h5>

<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr>
	<th>#</th>
	<th>Date</th>
	<th>Amount</th>
	<th>Type</th>
	<th>Info</th>
</tr>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 5; ?>
<?php for($i=0;$i<$numrows;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><input class="pdl05" name="posts[<?php echo $i; ?>][date]" tabIndex="2" 
		value="<?php echo $today; ?>" type="date" /></td>
	<td><input name="posts[<?php echo $i; ?>][amount]" tabIndex="4" class="vc100" /></td>
	<td>
		<select name="posts[<?php echo $i; ?>][infotype_id]" tabIndex="6">
			<?php foreach($infotypes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>
	<td><input name="posts[<?php echo $i; ?>][info]" tabIndex="8" class="vc500" /></td>

	<input type="hidden" name="posts[<?php echo $i; ?>][ucid]" value="<?php echo $ucid; ?>" />
</tr>
<?php endfor; ?>


<tr><td colspan="5" ><input type="submit" name="submit" value="Add" /></td></tr>

</table>
</form>

<p><?php $this->shovel('numrows'); ?></p>



<script>

$(function(){
	nextViaEnter();
})

</script>