<h3>
	<?php echo ucfirst($table); ?> Record Set <?php echo $count; ?> 
	<span class="screen" >
		(GET: limit, cond, order, fields | full) | <?php $this->shovel('homelinks'); ?>
		<?php $d['dbtable']=$dbtable;$d['id']=isset($id)? $id:false; ?>	
		<?php $this->shovel('links_records',$d); ?>	
		<?php $url=$_SERVER['QUERY_STRING'];$url=trim($url,"url");$url=trim($url,"=");$url.="&edit"; ?>
		| <a href='<?php echo URL.$url; ?>' >Edit</a>
	</span>	
	| <span class="u" onclick="traceshd();" >Fields</span>
	
</h3>

<div class="screen shd" style="width:80%;word-wrap:break-word;" ><?php echo $all_field_str; ?><br /><br /></div>

<?php 
	// pr($data);
	
	
?>

<form method="POST" >
<table id="tblExport" class="gis-table-bordered" >
<tr>
	<th></th>
	<th>#</th>
	<th>ID</th>
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
	<td><?php echo $rows[$i]['id']; ?></td>
	<?php for($j=0;$j<$num_columns;$j++): ?>
		<?php $key=$columns[$j]; ?>
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

<?php 

echo $pagenav;

?>

<div class="ht50 clear" >&nbsp;</div>


<script>

$(function(){
	shd();
	
})

</script>
