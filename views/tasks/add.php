<h5>
	Add Tasks
	| <a href="<?php echo URL.$_SESSION['home']; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>


</h5>

<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr>
	<th>#</th>
	<th>Date</th>
	<th>Item</th>
	<th>Is<br />Done</th>
</tr>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 5; ?>
<?php for($i=0;$i<$numrows;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><input class="pdl05" name="posts[<?php echo $i; ?>][date]" tabIndex="2" 
		value="<?php echo $today; ?>" type="date" /></td>
	<td><input name="posts[<?php echo $i; ?>][item]" tabIndex="4" class="vc500" /></td>
	<td><input name="posts[<?php echo $i; ?>][is_done]" value="1" tabIndex="6" type="number" max=1 min=0 /></td>
	<input type="hidden" name="posts[<?php echo $i; ?>][ucid]" value="<?php echo $ucid; ?>" />
</tr>
<?php endfor; ?>


<tr><td colspan="4" ><input type="submit" name="submit" value="Add" /></td></tr>

</table>
</form>

<p><?php $this->shovel('numrows'); ?></p>



<script>

$(function(){
	nextViaEnter();
})

</script>