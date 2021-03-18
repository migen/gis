<h5>
	Edit | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'unicomponents'; ?>" >Components</a>
	| <a href="<?php echo URL.'unicomponents/subject/'.$row['subject_id']; ?>" >Subject</a>

</h5>

<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr><th>ID</th><td><?php echo $row['id']; ?></td></tr>
<tr><th>Subject ID</th><td>
<select name="post[subject_id]" class="vc200" >
<?php foreach($unisubjects AS $sel): ?>
<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$row['subject_id'])? 'selected':NULL; ?> >
	<?php echo $sel['name'].' #'.$sel['id']; ?>
</option>
<?php endforeach; ?>
</select>
</td></tr>
<tr><th>Criteria ID</th><td>
<select name="post[criteria_id]" class="vc200" >
<?php foreach($unicriteria AS $sel): ?>
<option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$row['criteria_id'])? 'selected':NULL; ?> >
	<?php echo $sel['name'].' #'.$sel['id']; ?>
</option>
<?php endforeach; ?>
</select>
</td></tr>
<tr><th>Weight</th><td><input name="post[weight]" value="<?php echo $row['weight']; ?>" ></td></tr>
<tr><th colspan=2><input type="submit" name="submit" value="Save" /></th></tr>
</table>
</form>


