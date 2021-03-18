<h5>
	Edit Classroom | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'uniclassrooms'; ?>" >Classrooms</a>
	<?php if(!isset($_GET['get'])): ?>
		| <a href="<?php echo URL.'uniclassrooms/edit/'.$crid.'&get'; ?>" >GET</a>
	<?php endif; ?>

</h5>

<?php 
	$getcode=$row['mcode'].'-'.$row['sxncode'];
	$getname=$row['mcode'].'-'.$row['section'];
	
	debug($row);
	
?>

<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr><th>ID</th><td><?php echo $row['id']; ?></td></tr>
<tr><th>Code</th><td><input name="post[code]" value="<?php echo (!isset($_GET['get']))? $row['code']:$getcode; ?>" ></td></tr>
<tr><th>Name</th><td><input name="post[name]" value="<?php echo (!isset($_GET['get']))? $row['name']:$getname; ?>" ></td></tr>
<tr><th>Major ID</th><td>
<select name="post[major_id]" class="vc200" >
<?php foreach($majors AS $sel): ?>
<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$row['major_id'])? 'selected':NULL; ?> >
	<?php echo $sel['name'].' #'.$sel['id']; ?>
</option>
<?php endforeach; ?>
</select>
</td></tr>
<tr><th>Section ID</th><td>
<select name="post[section_id]" class="vc200" >
<?php foreach($unisections AS $sel): ?>
<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$row['section_id'])? 'selected':NULL; ?> >
	<?php echo $sel['name'].' #'.$sel['id']; ?>
</option>
<?php endforeach; ?>
</select>
</td></tr>

<tr><th colspan=2><input type="submit" name="submit" value="Save" /></th></tr>
</table>
</form>


