<h3>
	<?php echo ucfirst($table); ?> Editor Record Set (<?php echo $count; ?> | GET: limit, cond, order, fields | full) | <?php $this->shovel('homelinks'); ?>
	<?php $d['dbtable']=$dbtable;$d['id']=isset($id)? $id:false; ?>	
	<?php $this->shovel('links_records',$d); ?>	
	<?php $url=$_SERVER['QUERY_STRING'];$url=trim($url,"url");$url=trim($url,"=");$url.="&edit"; ?>
	| <a href='<?php echo URL.$url; ?>' >Edit</a>
	| <span class="u" onclick="traceshd();" >Show*Fields</span>
	
	
	
	
</h3>

<div class="screen shd" style="width:80%;word-wrap:break-word;" ><?php echo $all_field_str; ?><br /><br /></div>


<?php 
	// pr($data);
	
	
?>


<form method="POST" >
<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>ID</th>
	<?php for($j=0;$j<$num_columns;$j++): ?>
		<th><?php $key=$columns[$j]; echo $key; ?>
			<br /><input class="vc50" type="text" id="i<?php echo $key; ?>" placeholder="All" />
			<button onclick="populateColumn('<?php echo $key; ?>');return false;">All</button>							
		</th>
	<?php endfor; ?>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php $id=$rows[$i]['id']; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $id; ?></td>
	<?php for($j=0;$j<$num_columns;$j++): ?>
		<?php $key=$columns[$j]; ?>
		<td><input name="posts[<?php echo $i; ?>][<?php echo $key; ?>]" class="<?php echo $key; ?>" 
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
	shd();
	
})

</script>
