<?php 
	// $this->shovel('border'); 
	// pr($rows[0]);
	debug($rows[0]);
	
?>

<h5>
	Criteria (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'criteria/set'; ?>" >Set</a>
	| <a href="<?php echo URL.'gset/critypes'; ?>" >Critypes</a>
	| <a href="<?php echo URL.'gset'; ?>" >Gset</a>	
	| <a href="<?php echo URL.'gset/criteria?edit'; ?>" >Edit</a>
	| <a href="<?php echo URL.'gset/criteria?ctype=1'; ?>" >Acad</a>
	| <?php $this->shovel('links_gset'); ?>
	

</h5>

<div style="width:35%;float:left;" >
<table class="gis-table-bordered" >
<tr>
	<th>ID</th><th>Pos</th><th>Code</th><th>Name</th>
	<th>CrsType</th>
	<th>CriType</th>
<th></th></tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $rows[$i]['id']; ?></td>
	<td><?php echo $rows[$i]['position']; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['crstype_id']; ?></td>
	<td><?php echo $rows[$i]['critype_id']; ?></td>
	<td><a href="<?php echo URL.'criteria/edit/'.$rows[$i]['id']; ?>" >Edit</a></td>
</tr>
<?php endfor; ?>
</table>
</div>	<!-- left -->


<?php if(isset($_GET['edit'])): ?>

<div style="width:25%;float:left;" >	<!-- middle -->
<form method="POST" >
<h5> 
	Batch
	| <a class="u" onclick="ilabas('clipboard');" >Smartboard</a>
</h5>
<table class="gis-table-bordered" >
<tr class='headrow'>
	<th>#</th>	
	<th class="vc100" >Code</th>
	<th class="vc200" >Name</th>
	<th class="vc50" >CTY</th>
</tr>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<tr >
	<td class="vc20" ><?php echo $i+1; ?></td>
	<td><input id="code<?php echo $i; ?>" class="full" type="text" name="posts[<?php echo $i; ?>][code]" /></td>				
	<td><input id="name<?php echo $i; ?>" class="full" type="text" name="posts[<?php echo $i; ?>][name]" /></td>				
	<td><input id="cty<?php echo $i; ?>" class="full" type="text" name="posts[<?php echo $i; ?>][crstype_id]" /></td>				
</tr>

<?php endfor; ?>			
</table>

<p>
	<input type="submit" name="add" value="Add" /> &nbsp; 
	<button><a href="<?php echo URL.'mis'; ?>" class="no-underline" >Cancel</a></button>
</p>

</form>
<p><?php $this->shovel('numrows'); ?></p>

</div> <!-- middle  -->


<div class="clipboard" style="width:30%;float:left;"  >	<!-- right -->
<p>
<select id="classbox" >
	<option value="code" >Code</option>
	<option value="name" >Name</option>
	<option value="cty" >CTY</option>
</select>
</p>
<?php $d['width'] = '20'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>	<!-- right -->

<?php endif; ?>		<!-- edit -->
