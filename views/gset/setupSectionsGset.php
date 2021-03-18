<style>

</style>

<h5>
	Batch Sections Add
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'gset/sections'; ?>" >Sections</a>	
	| <a class="u" onclick="ilabas('clipboard');" >Smartboard</a>
	
	

</h5>

<div class="ht500" style="float:left;width:35%;" >
<table class="gis-table-bordered table-altrow" >
<tr><th>ID</th><th>Name</th></tr>
<?php for($i=0;$i<$count;$i++): ?>
	<tr><td><?php echo $rows[$i]['id']; ?></td><td class="vc400" ><?php echo $rows[$i]['name']; ?></td></tr>
<?php endfor; ?>
</table>
</div>	<!-- third left -->


<div class="third ht500" >	<!-- middle -->
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
</tr>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<tr >
	<td class="vc20" ><?php echo $i+1; ?></td>
	<td><input id="code<?php echo $i; ?>" class="full" type="text" name="posts[<?php echo $i; ?>][code]" /></td>				
	<td><input id="name<?php echo $i; ?>" class="full" type="text" name="posts[<?php echo $i; ?>][name]" /></td>				
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


<div class="clipboard" style="width:200px;float:left;"  >	<!-- right -->
<p>
<select id="classbox" >
	<option value="code" >Code</option>
	<option value="name" >Name</option>
</select>
</p>
<?php $d['width'] = '20'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>	<!-- right -->



<script>

$(function(){
	itago('clipboard');
	
	
})

</script>
