<?php

// pr($nationalities);

?>

<form method="GET" >
<div class="third" >	<!--  left -->
<table class="gis-table-bordered table-fx" >

<tr><th>Code</th><td><input name="code" /></td></tr>
<tr><th>Name</th><td><input name="name" /></td></tr>
<tr><th>SY</th><td><input name="sy" value="" /></td></tr>



<tr>
<th>Level</th>
<td>
	<select class="vc200" name="lvl" >
		<option value="0" >Choose</option>
		<?php foreach($levels AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select>
</td>
</tr>


<tr>
<th>Classroom</th>
<td>
	<select class="vc200" name="crid" >
		<option value="0" >Choose</option>
		<?php foreach($classrooms AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
		<?php endforeach; ?>
	</select>
</td>
</tr>


<tr>
<th>Nationality</th><td><input name="natl" ></td></tr>



</table>
</div>

<!-------------------------------------------------->

<div class="third" >	<!--  left -->
<table class="gis-table-bordered table-fx" >
<tr>
<th>Sort</th>
<?php $sorts = array(
	array('key'=>'id','value'=>'ID'),
	array('key'=>'name','value'=>'Name'),			
); ?>	
<td><select class="vc100" name="sort" >
	<?php foreach($sorts AS $sel): ?>
		<option value="<?php echo $sel['key']; ?>" <?php echo ($sel['key']==$sort)? 'selected':NULL; ?> >
			<?php echo $sel['value']; ?></option>
	<?php endforeach; ?>
</select></td>
</tr>

<tr>
<th>Order</th>
<td>
	<select name="order" >
		<option value="DESC">DESC</option>
		<option value="ASC" >ASC</option>
	</select>		
</td>
</tr>

<tr><th>Page</th><th><input class="" name="page" value="<?php echo $page; ?>"  /></th></tr>	
<tr><th>Count</th><th><input class="" name="limits" value="<?php echo 100; ?>"  /></th></tr>		




</table>
</div>

<div class="clear" ></div>


<p><input type="submit" name="filter" value="Filter"  /></p>

</form>