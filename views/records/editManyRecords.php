<h3>
	<?php echo ucfirst($table); ?> Record Set (<?php echo $count; ?> | GET: limit, cond, order, fields) | <?php $this->shovel('homelinks'); ?>
	<?php $d['dbtable']=$dbtable;$d['id']=isset($id)? $id:false; ?>	
	<?php $this->shovel('links_records',$d); ?>	
	<?php $url=$_SERVER['QUERY_STRING'];$url=trim($url,"url");$url=trim($url,"=");$url.="&edit"; ?>
	| <a href='<?php echo URL.$url; ?>' >Edit</a>
	
	
	
	
</h3>

<?php 
	// pr($data);
	
	
?>


<form method="POST" >
<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<?php for($j=0;$j<$num_columns;$j++): ?>
		<th><?php echo $columns[$j]; ?></th>
	<?php endfor; ?>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php $id=$rows[$i]['id']; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<?php for($j=0;$j<$num_columns;$j++): ?>
		<?php $key=$columns[$j]; ?>
		<td><input name="posts[<?php echo $i; ?>][<?php echo $key; ?>]" 
			value="<?php echo $rows[$i][$key]; ?>" tabIndex="<?php echo $j; ?>" ></td>				
	<?php endfor; ?>
		<input type="hidden" name="posts[<?php echo $i; ?>][id]" value="<?php echo $rows[$i]['id']; ?>" readonly >	
</tr>
<?php endfor; ?>
</table>

<p><input type="submit" name="submit" value="Save" ></p>
</form>

<?php 



?>


<script>

$(function(){
	nextViaEnter();
	
})

</script>
