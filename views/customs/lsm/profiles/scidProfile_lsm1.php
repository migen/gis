<h5>
	LSM Scid Profile | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'contacts/edit/'.$scid; ?>" >Contact</a>
	| <?php if(!isset($_GET['print'])): ?>
		<a href="<?php echo URL.'profiles/scid/'.$scid.'&print'; ?>" >Print</a>
	<?php else: ?>
		<a href="<?php echo URL.'profiles/scid/'.$scid; ?>" >Edit</a>	
	<?php endif; ?>


</h5>

<?php 

if(isset($row)){ debug($row); }

?>

<?php if($scid): ?>
<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>Scid</th><td><?php echo $scid; ?></td></tr>
<?php foreach($row AS $k=>$v): ?>
<tr><th><?php echo ucfirst($k); ?></th>
<td><input class="pdl05" name="post[<?php echo $k; ?>]" value="<?php echo $v; ?>" ></td>
</tr>
<?php endforeach; ?>
<tr><th colspan=2><input type="submit" name="submit" value="Save" /></th></tr>
</table>
</form>
<?php endif; ?>