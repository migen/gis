<?php 
// pr($rows[0]);
?>
<h5>
	Sections
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'gset'; ?>" >Gset</a>	
	| <a href="<?php echo URL.'sections/set'; ?>" >Simple</a>	
	| <a href="<?php echo URL.'gset/classrooms'; ?>" >Classrooms</a>	
	| <a href="<?php echo URL.'gset/setupSections'; ?>" >Setup Sections</a>	
	| <a class="u" onclick="ilabas('lvl');" >Setup Classrooms</a>	
	<?php if(isset($_GET['order']) && ($_GET['order']=='name')): ?>
		| <a href="<?php echo URL.'gset/sections'; ?>" >By ID</a>
	<?php else: ?>
		| <a href="<?php echo URL.'gset/sections?order=name'; ?>" >By Name</a>	
	<?php endif; ?>
	| <?php $this->shovel('links_gset'); ?>
	
</h5>

<h4 class="brown" >*Caution - once a classroom (lvl-sxn) has been created, cannot delete, coz of relational dbms data, i.e. courses and grades. <br />
2) After classrooms have been created, cannot initt sections anymore.
</h4>

<p><table class="gis-table-bordered lvl" >
<tr>
<?php foreach($levels AS $level): ?>
<td><?php echo '#'.$level['id'].' - '.$level['name']; ?></td>
<?php endforeach; ?>
</tr>
</table></p>

<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr>
<th>#</th>
<th>ID</th>
<th>Code</th>
<th class="vc300" >Name</th>
<th class="vc300" >Levels</th>
<th class="lvl" >Lvl</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td class="vc30" ><?php echo $i+1; ?></td>
	<td class="vc30" ><?php echo $rows[$i]['id']; ?></td>
	<td class="vc50" ><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td>
		<?php 
			$str="";
			foreach($records[$i] AS $rec){
				$str.=$rec['level'].", ";
			} $str=trim($str,", ");
			echo $str;
		?>
	</td>
	
	<td class="lvl" >
		<?php 
			$str="";
			foreach($records[$i] AS $rec){
				$str.=$rec['lvl'].", ";
			} $str=trim($str,", ");
		?>
		<input name="posts[<?php echo $i; ?>][lvls]" value="<?php echo $str; ?>"; />
		<input type="hidden" name="posts[<?php echo $i; ?>][section_id]" value="<?php echo $rows[$i]['id']; ?>"; />		
	</td>
</tr>
<?php endfor; ?>
</table>

<p><input class="lvl" type="submit" name="submit" value="Update" onclick="return confirm('Sure?');"  /></p>

</form>


<script>

$(function(){
	itago('lvl');
})

</script>