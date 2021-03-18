<h5>
	Log Actions | 
	<a href="<?php echo URL.$_SESSION['home']; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>					

</h5>

<!------------------------------------------------------------------------------------------------->

<?php 

// pr($data);

?>


<table class='table-fx gis-table-bordered'>
<tr class='headrow'><th>#</th><th class="vc100" >Module</th><th class="vc200" >Action</th></tr>
<?php for($i=0;$i<$num_actions;$i++): ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td><?php echo $actions[$i]['module_code']; ?></td>
		<td><?php echo $actions[$i]['name']; ?></td>
	</tr>	
<?php endfor; ?>

</table>
<br />

<hr />
<br />

<!------------------------------------------------------------------------->

<form method="POST" >	<!-- form add subjects -->
<!------------------------------------------------------------------>
<h5> Add Actions </h5>

<table class="gis-table-bordered" >
<tr class='headrow'>
	<th>#</th>	
	<th class="vc100" >Module</th>
	<th class="vc200" >Action</th>
</tr>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<tr>
	<td><?php echo $i+1; ?></td>
	<td>
		<select class="full" name="actions[<?php echo $i; ?>][module_id]"  >
			<?php	foreach($modules as $sel): ?><option value="<?php echo $sel['id']; ?>"><?php echo $sel['code']; ?></option><?php	endforeach; ?>				
		</select>
	</td>
	<td><input class="full" type="text" name="actions[<?php echo $i; ?>][name]" /></td>
		
</tr>

<?php endfor; ?>			
</table>

<p>
	<input type="submit" name="add" value="Add" /> &nbsp; 
	<button><a href="<?php echo URL.'mis'; ?>" class="no-underline" >Cancel</a></button>
</p>

</form> <!-- add -->



</table>

<!------------------------------------------------------------------------->

<p><?php $this->shovel('numrows'); ?></p>


