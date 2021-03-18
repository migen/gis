<table class="gis-table-bordered table-fx" >
<tr>
	<td>
		<select id="lvl" >
			<option value="0" >Choose</option>
			<?php foreach($levels AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>
	
	<td>
		<select id="crid" >
			<option value="0" >Choose</option>
			<?php foreach($classrooms AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" ><?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>
	</td>
	
	<td>
	
<?php 
$sorts = array(
	array('key'=>'l.id','value'=>'Lvl'),
	array('key'=>'l.name','value'=>'Level'),			
	array('key'=>'cr.id','value'=>'Crid'),			
	array('key'=>'cr.name','value'=>'Classroom'),
	array('key'=>'sub.id','value'=>'Sub'),			
	array('key'=>'sub.name','value'=>'Subject'),				
);			
		?>

<select class="vc100" id="sort" >
	<?php foreach($sorts AS $sel): ?>
		<option value="<?php echo $sel['key']; ?>" <?php echo ($sel['key']==$sort)? 'selected':NULL; ?> >
			<?php echo $sel['value']; ?></option>
	<?php endforeach; ?>
</select>

<select id="order" >
	<option value="DESC" <?php echo ($order=='DESC')? 'selected':NULL; ?> >DESC</option>
	<option value="ASC" <?php echo ($order=='ASC')? 'selected':NULL; ?> >ASC</option>
</select>			
	</td>
	
	
	<td><input type="submit" onclick="redirUrl();"  /></td>
	
</tr>


</table>

<script>

function redirUrl(){
	var lvl=$('#lvl').val();
	var crid=$('#crid').val();
	var sort=$('#sort').val();
	var order=$('#order').val();
	alert(sort+order);
	var url=gurl+'/courses/teachers?lvl='+lvl+'&crid='+crid+'&sort='+sort+'&order='+order;
	window.location=url;
	
}


</script>
