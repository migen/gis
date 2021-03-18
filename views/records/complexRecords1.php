<h3>
	Custom Record Set  | <?php $this->shovel('homelinks'); ?>
	| <span onclick="clearForm();" >Clear</span>
		<?php $d['dbtable']=null;$d['id']=isset($id)? $id:false; ?>	
	<?php $this->shovel('links_records',$d); ?>	

	
</h3>

<?php 

?>


<form method="POST" >

<table class="gis-table-bordered" >
	<tr><th>Query</th><td>
		<textarea id="q" rows=7 cols=120 name="q" ><?php echo $q; ?></textarea>
	</td>
	<td><input type="submit" name="submit" value="Query" ></td>
	</tr>
</table><br />

</form>


<!-- 2 -->
<?php // if(isset($_POST['submit'])): 
	if(!$is_empty):
?>
	<form method="POST" >
	<table class="gis-table-bordered" >
	<tr>
		<th>#</th>
		<?php for($j=0;$j<$num_columns;$j++): ?>
			<th><?php echo $columns[$j]; ?></th>
		<?php endfor; ?>
		<th></th>
	</tr>
	<?php for($i=0;$i<$count;$i++): ?>
	<tr>
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
	<?php // echo $pagenav; ?>
	<div class="ht50 clear" >&nbsp;</div>
<?php endif; ?>	<!-- query -->

<script>

$(function(){
	shd();
	
})

function clearForm(){
	$("#q").val("");
	
}


</script>
