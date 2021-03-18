<?php 


?>


<h5>
	Add
	
</h5>

<form method="POST" >

<table class="gis-table-bordered table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th>
		<input class="pdl05 vc300" type="text" id="iwurl" placeholder="Wurl" /><br />	
		<input type="button" value="All" onclick="populateColumn('wurl');" >			
	</th>
	
	<th>
		<select id="ititle" class='vc120'>	
			<option> Title </option>
			<?php foreach($titles as $sel): ?>
				<option value="<?php echo $sel['id']; ?>"> <?php echo $sel['name']; ?> </option>
			<?php endforeach; ?>
		</select>				
		<br /> <input type="button" value="All" onclick="populateColumn('title');" >		
	</th>	
		
</tr>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td><input tabindex="<?php echo $i+1; ?>" class="pdl05 full wurl" type="text" name="posts[<?php echo $i; ?>][wurl]" /></td>
	<td>
		<select class="title" name="posts[<?php echo $i; ?>][title_id]"  >
			<option> Title </option>		
			<?php	foreach($titles as $sel): ?>
				<option value="<?php echo $sel['id']; ?>"  ><?php echo $sel['name']; ?></option>
			<?php	endforeach; ?>				
		</select>
	</td>	
			
</tr>

<?php endfor; ?>			


</table>

<p>
	<input onclick="return confirm('Sure');" type="submit" name="add" value="Add" /> &nbsp; 
	<button><a href="<?php echo URL.'mis'; ?>" class="no-underline" >Cancel</a></button>
</p>

</form> <!-- add -->




<!------------------------------------------------------------------------->

<p><?php $this->shovel('numrows'); ?></p>


<!------------------------------------------------------------------------>

<script>

var gurl = 'http://<?php echo GURL; ?>';
var hdpass = '<?php echo HDPASS; ?>';

$(function(){
	
	nextViaEnter();
	selectFocused();

})





</script>







