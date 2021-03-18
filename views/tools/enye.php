<h5>

Enye

</h5>

<form method="POST" >	<!-- form add -->
<table class="gis-table-bordered" >
<tr class='headrow'>
	<th>#</th>	
	<th class="vc200" >ID Number</th>
	<th class="vc200" >X <input name="x" value="name" > </th>
</tr>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<tr >
	<td class="vc20" ><?php echo $i+1; ?></td>
	<td><input id="code<?php echo $i; ?>" class="full" type="text" name="posts[<?php echo $i; ?>][code]" /></td>		
	<td><input id="x<?php echo $i; ?>" class="full" type="text" name="posts[<?php echo $i; ?>][x]" /></td>		
		
</tr>

<?php endfor; ?>			
</table>

<p>
	<input type="submit" name="update" value="Update" /> &nbsp; 
	<button><a href="<?php echo URL.'mis'; ?>" class="no-underline" >Cancel</a></button>
</p>

</form> <!-- add -->





<p><?php $this->shovel('numrows'); ?></p>
</div>



<!------------------------------------------------------------------------>

<div style="width:50px;float:left;height:100px;" ></div>
<div class="clipboard" style="width:200px;float:left;"  >
<p>
<select id="classbox" >
	<option value="code" >Code</option>
	<option value="x" >X</option>
</select>
</p>
<?php $d['width'] = '20'; ?>
<?php $this->shovel('smartboard',$d); ?>
</div>



<div class="clear ht100" >&nbsp;</div>

