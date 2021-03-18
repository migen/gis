<h3>
	Editing <?php echo ucfirst($table); ?> Record Set (<?php echo $count; ?> | GET: limit, cond, order, fields) | <?php $this->shovel('homelinks'); ?>
	<?php $d['dbtable']=$dbtable;$d['id']=isset($id)? $id:false; ?>	
	<?php $this->shovel('links_records',$d); ?>
	| <span class="txt-blue u" onclick="pclass('smartbox');" >Smartboard</span>
	
	
</h3>

<?php 
	// pr($data);
	
	
?>

<form method="POST" >
<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<?php for($j=0;$j<$num_columns;$j++): ?>
		<th><?php $key=$columns[$j]; echo $key; ?>
			<br /><input class="vc50" type="text" id="i<?php echo $key; ?>" placeholder="All" />
			<button onclick="populateColumn('<?php echo $key; ?>');return false;">All</button>									
		</th>
	<?php endfor; ?>
	<th></th>
	<th></th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php $id=$rows[$i]['id']; ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<?php for($j=0;$j<$num_columns;$j++): ?>
		<?php $key=$columns[$j]; ?>
		<td><input name="posts[<?php echo $i; ?>][<?php echo $key; ?>]" value="<?php echo $rows[$i][$key]; ?>" 
			id="<?php echo $key.$i; ?>" class="<?php echo $key; ?>" ></td>
	<?php endfor; ?>
	<td><a href='<?php echo URL."records/edit/".$dbtable."/$id"; ?>' >Edit</a></td>
	<td><button id="btn-<?php echo $i; ?>" >Save</button></td>
		<input type="hidden" name="posts[<?php echo $i; ?>][id]" value="<?php echo $rows[$i]['id']; ?>" readonly >
</tr>
<?php endfor; ?>
</table>

<p><input type="submit" name="submit" value="Save" ></p>
</form>

<?php 

echo $pagenav;

?>

<!-- smartboard -->
<div class="smartbox"  >	<!-- smartboard -->
<p>
<select id="classbox" >
	<?php for($j=0;$j<$num_columns;$j++): ?>
		<?php $key=$columns[$j]; ?>
		<option value="<?php echo $key; ?>" ><?php echo ucfirst($key); ?></option>
	<?php endfor; ?>

	
</select>
</p>
<?php $d['width'] = '30'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>	<!-- smartboard -->

<div class="ht50" >&nbsp;</div>


<script>

$(function(){
	pclass('smartbox');
	selectFocused();
	nextViaEnter();
	
})	/* fxn */



</script>
