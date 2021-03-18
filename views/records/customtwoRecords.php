<h3>
	Custom Record Set  

	
</h3>


<?php 

	
?>



<form method="POST" >

<table class="gis-table-bordered" >
	<tr><th>Query</th><td>
		<textarea rows=7 cols=120 name="qstr" ><?php echo $qstr; ?></textarea>
	</td>
	<td><input type="submit" name="query" value="Query" ></td>
	</tr>
</table><br />

</form>

<?php 
exit;

?>

<!-- 2 -->
<?php if(isset($_POST['query'])): ?>
	<form method="POST" >
	<table class="gis-table-bordered" >
	<tr>
		<th></th>
		<th>#</th>
		<?php for($j=0;$j<$num_columns;$j++): ?>
			<th><?php echo $columns[$j]; ?></th>
		<?php endfor; ?>
		<th></th>
	</tr>
	<?php for($i=0;$i<$count;$i++): ?>
	<?php $id=$rows[$i]['id']; ?>
	<tr>
		<td><input type="checkbox" id="id-<?php echo $i; ?>" name="rows[<?php echo $i; ?>]" value="<?php echo $id; ?>" ></td>
		<td><?php echo $i+1; ?></td>
		<?php for($j=0;$j<$num_columns;$j++): ?>
			<?php $key=$columns[$j]; // $val=$rows[$i][$key]; ?>
			<td><?php echo $rows[$i][$key]; ?></td>
		<?php endfor; ?>
		<td><a href='<?php echo URL."records/edit/".$dbtable."/$id"; ?>' >Edit</a></td>
	</tr>
	<?php endfor; ?>
	</table>

	<p class="screen" >
		<input type='submit' name='editor' value='Editor' >
		<?php $this->shovel('boxes'); ?>
	</p>
	</form>
	<br />
	<?php echo $pagenav; ?>
	<div class="ht50 clear" >&nbsp;</div>
<?php endif; ?>	<!-- query -->

<script>

$(function(){
	shd();
	
})

</script>
