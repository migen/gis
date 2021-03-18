<?php ?>

<h5>
	Add Product Categories
	| <a href="<?php echo URL.$_SESSION['home']; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>					


</h5>


<div class="half" >
<form method="POST" >
<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th class="vc30" >ID</th>
	<th class="vc80" >Code</th>
	<th class="vc300" >Name</th>
</tr>

<?php $numrows = (isset($_POST['numrows']))? $_POST['numrows']:1;  ?>

<?php for($i=0;$i<$numrows;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><input id="code<?php echo $i; ?>" class="pdl05 full" maxlength="8" name="posts[<?php echo $i; ?>][code]"  /></td>
	<td><input id="name<?php echo $i; ?>" class="pdl05 full" name="posts[<?php echo $i; ?>][name]"   /></td>

</tr>
<?php endfor; ?>

</table>

<p>	
	<input onclick="return confirm('Sure?');" type="submit" name="submit" value="Save"  />
	<button><a href="<?php echo URL.'products/categories'; ?>" class="no-underline" >Cancel</a></button>
</p>

</form>


<?php $this->shovel('numrows'); ?>
</div> 	<!-- half left -->


<!--------------------------------------------------------------------------------------------->

<p>
<select id="classbox" >
	<option value="name" >Name</option>
	<option value="code" >Code</option>
</select>
</p>


<?php $this->shovel('smartboard'); ?>


