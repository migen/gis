



<form method="GET" >


<table>
<tr>
<th>Filter</th>
<td><select name="ctype" >
	<option value="0" >Choose Type</option>
	<?php foreach($ctypes AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" <?php echo (isset($_GET['ctype']) && ($_GET['ctype']==$sel['id']))? 'selected':NULL; ?>
			><?php echo $sel['name']; ?></option>	
	<?php endforeach; ?>
</select></td>

<td><select name="level_id" >
	<option value="0" >Choose Level</option>
	<?php foreach($levels AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" <?php echo (isset($_GET['level_id']) && ($_GET['level_id']==$sel['id']))? 'selected':NULL; ?>
			><?php echo $sel['name'].' #'.$sel['id']; ?></option>	
	<?php endforeach; ?>
</select></td>

<td><select name="subject_id" class="vc200" >
	<option value="0" >Choose Subject</option>
	<?php foreach($subjects AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" <?php echo (isset($_GET['subject_id']) && ($_GET['subject_id']==$sel['id']))? 'selected':NULL; ?>
			><?php echo $sel['name'].' #'.$sel['id']; ?></option>	
	<?php endforeach; ?>
</select></td>


<td><select name="criteria_id" class="vc300" >
	<option value="0" >Choose Criteria</option>
	<?php foreach($criteria AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" <?php echo (isset($_GET['criteria_id']) && ($_GET['criteria_id']==$sel['id']))? 'selected':NULL; ?>
			><?php echo $sel['name'].' #'.$sel['id']; ?></option>	
	<?php endforeach; ?>
</select></td>

<td><button name="filter" value="1" type="submit" >Filter</button></td>
</tr>
</table>

<!--------------------------------------------------------------------------------------------------->

<br />

<?php $sorts = array(
	array('key'=>'com.level_id','value'=>'Level'),
	array('key'=>'subject','value'=>'Subject'),
	array('key'=>'criteria','value'=>'Criteria'),			
); ?>


<table>
<tr>
<th>Sort | Order</th>
<td>	
	<select name="sort" >
		<?php $sort_key = (isset($_POST['sort']))? $_POST['sort']:'com.level_id'; ?>
		<?php foreach($sorts AS $sel): ?>
			<option value="<?php echo $sel['key']; ?>" <?php echo ($sel['key']==$sort_key)? 'selected':NULL; ?> >
				<?php echo $sel['value']; ?></option>
		<?php endforeach; ?>

	</select>

	<select name="order" >
		<option value="ASC">ASC</option>
		<option value="DESC" <?php echo (isset($_POST['order']) && $_POST['order']=='DESC')? 'selected':NULL; ?>  >DESC</option>
	</select>			
</select></td>


</table>




</form>
