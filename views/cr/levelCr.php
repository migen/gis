<h5>
	CR 	
<select onchange="jsredirect('cr/level/'+this.value);" >
<?php foreach($levels AS $sel): ?>
	<option  value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$lvl)? 'selected':NULL; ?> >
		<?php echo $sel['name']; ?></option>
<?php endforeach; ?>
</select>	
		
	  <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'classrooms/level/'.$lvl; ?>" >Edit</a>
	| <a href="<?php echo URL.'cr/add'; ?>" >Add</a>

&nbsp; 
</h5>

<?php 
// pr($level);
?>

<p>

</p>


<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Section</th>
	<th>Adviser</th>
	<th>Ct</th>
	<th>Nm</th>
	<?php if($lvl>13): ?>
		<th>Major</th>	
	<?php endif; ?>
</tr>
<?php for($i=0;$i<$count;$i++):	?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo '#'.$rows[$i]['sxn'].'-'.$rows[$i]['section']; ?></td>
	<td><?php echo $rows[$i]['adviser']; ?></td>
	<td><?php echo $rows[$i]['num_students']; ?></td>
	<td><?php echo $rows[$i]['num']; ?></td>
	<?php if($lvl>13): ?>
		<td><?php echo $rows[$i]['major']; ?></td>
	<?php endif; ?>		
</tr>
<?php endfor; ?>
</table>


<script>

var gurl="http://<?php echo GURL; ?>";


</script>
