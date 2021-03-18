<h3>
	<?php echo ucfirst($table); ?> Setup Payables (Last ID: <?php echo $last_id; ?>) | 
	<?php $this->shovel('homelinks'); ?>
	<?php $d['dbtable']=$dbtable;$d['id']=isset($id)? $id:false; ?>	
	| <span class="txt-blue u" onclick="pclass('smartbox');" >Smartboard</span>
	
	
</h3>

<p>Composite: sy-scid-feetype_id </p>


<?php 
	// pr($data);
	
	
?>

<div class="half" >
<form method="POST" >
<input type="submit" name="submit" value="Batch Add" >
	<br />
<br />

<table class="gis-table-bordered" >

<tr>
	<th>#</th>
	<?php for($j=0;$j<$num_columns;$j++): ?>
		<?php $key=$columns[$j]; ?>
		<th><?php echo ucfirst($key); ?>
			<br /><input class="vc50" type="text" id="i<?php echo $key; ?>" placeholder="All" />
			<button onclick="populateColumn('<?php echo $key; ?>');return false;">All</button>					
		
		
		</th>
	<?php endfor; ?>
</tr>
<?php $numrows=isset($_POST['numrows'])? $_POST['numrows']:3; ?>
<?php for($i=0;$i<$numrows;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<?php for($j=0;$j<$num_columns;$j++): ?>
		<?php $key=$columns[$j]; ?>
		<td><input class="<?php echo $key; ?>" id="<?php echo $key.$i; ?>" name="posts[<?php echo $i; ?>][<?php echo $key; ?>]" tabIndex="<?php echo $j; ?>" ></td>
	<?php endfor; ?>
</tr>
<?php endfor; ?>
<tr>
	<th>#</th>
	<?php for($j=0;$j<$num_columns;$j++): ?>
		<?php $key=$columns[$j]; ?>
		<th><?php echo ucfirst($key); ?>
			<br /><input class="vc50" type="text" id="i<?php echo $key; ?>" placeholder="All" />
			<button onclick="populateColumn('<?php echo $key; ?>');return false;">All</button>					
		
		
		</th>
	<?php endfor; ?>
</tr>
</table>

<br /><p><input type="submit" name="submit" value="Batch Add" ></p>
</form>
<br />

<?php $this->shovel('numrows'); ?>

</div>	<!-- half -->



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
