<form method="" >


<div style="width:30%;float:left"  >	<!--  left -->
<table class="gis-table-bordered table-fx" >


<tr>
<th>Destination</th>
<td>
	<select class="vc200" name="gid" >
		<option value="0" >Choose</option>
		<?php foreach($staffers AS $sel): ?>
			<option value="<?php echo $sel['id']; ?>" 
			<?php echo ((isset($_POST['gid'])) && ($sel['id']==$_POST['gid']))? 'selected':NULL; ?> >						
			<?php echo $sel['name'].' #'.$sel['id']; ?></option>
		<?php endforeach; ?>
	</select>
</td>
</tr>


</table>
</div>


<div class="third" >	<!--  left -->
<table class="gis-table-bordered table-fx" >
<tr>
<th colspan="" >Sort</th>
<td><?php $sorts = array(
	array('key'=>'smv.date','value'=>'Date'),
	array('key'=>'sc.name,smv.date','value'=>'Source Employee'),			
	array('key'=>'dc.name,smv.date','value'=>'Destination Employee'),			
); ?>	
<select class="vc100" name="sort" >
	<?php foreach($sorts AS $sel): ?>
		<option value="<?php echo $sel['key']; ?>" <?php echo ($sel['key']==$sort)? 'selected':NULL; ?> >
			<?php echo $sel['value']; ?></option>
	<?php endforeach; ?>
</select>

<select name="order" >
	<option value="DESC" <?php echo ($order=='DESC')? 'selected':NULL; ?> >DESC</option>
	<option value="ASC" <?php echo ($order=='ASC')? 'selected':NULL; ?> >ASC</option>
</select>		
</td>
</tr>


<tr><th>Page | Count</th><th>
	<input class="vc40" id="page" name="page" value="<?php echo $page; ?>"  />
	<input class="vc40" id="limits" name="limits" 
		value="<?php echo (isset($_POST['limits']))? $_POST['limits']:0; ?>"  />
<button onclick="nolimits();return false;" >All</button>
</th></tr>		
<tr><th>Size | Color</th><th>
	<input class="vc40" id="size" name="size" type="number"
		value="<?php echo (isset($_POST['size']))? $_POST['size']:1; ?>"  />
	<input class="vc60" id="color" name="color" 
		value="<?php echo (isset($_POST['color']))? $_POST['color']:'black'; ?>"  />		
</th></tr>		



</table>
</div>


</form>