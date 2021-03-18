
<div class="screen" >
<form method="GET" >

<table class="gis-table-bordered" >

<tr>
<th>Date From</th>
<td><input class="pdl05" type="date" id="beg" name="beg"
	value="<?php echo (isset($_GET['beg']))? $_GET['beg']:$today; ?>" /></td>
</tr>

<tr>
<th>Date To</th>
<td><input class="pdl05" type="date" id="end" name="end"
	value="<?php echo (isset($_GET['end']))? $_GET['end']:$today; ?>" /></td>	
</tr>

	
<tr><th>Level From</th>
<td>
	<select name="lvlbeg" >
		<option value="0" >Choose One</option>
		<?php foreach($levels AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select>
</td>
</tr>

<tr><th>Level To</th>
<td>
	<select name="lvlend" >
		<option value="0" >Choose One</option>
		<?php foreach($levels AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select>
</td>
</tr>



<th>Sort</th>
<td><?php $sorts = array(
	array('key'=>'c.name,l.datetime DESC','value'=>'Student'),			
	array('key'=>'l.id,c.name,l.datetime DESC','value'=>'Level'),			
	array('key'=>"l.datetime DESC,l.id,c.name",'value'=>'Date'),			

); ?>	
<select class="vc100" name="sort" >
	<?php foreach($sorts AS $sel): ?>
		<option value="<?php echo $sel['key']; ?>"  ><?php echo $sel['value']; ?></option>
	<?php endforeach; ?>
</select>

</td>


</tr>


<tr><td colspan="2" ><input type="submit" name="filter" value="Filter" /></td></tr>

</table>

</form>
</div>
