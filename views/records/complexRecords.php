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
<?php if(!$is_empty): ?>
<?php 
	$d['num_columns']=&$num_columns;
	$d['columns']=$columns;
	$d['rows']=&$rows;
	$d['count']=&$count;
	$this->shovel('tableset',$d);
?>
<?php endif; ?>	<!-- query -->

<script>

$(function(){
	shd();
	
})

function clearForm(){
	$("#q").val("");
	
}


</script>
