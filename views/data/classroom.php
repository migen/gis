<h5>
 
	<span ondblclick="tracehd();" >  Classroom Courses </span>
<span class="screen" >	
	| <a href="<?php echo URL.'info'; ?>">Info</a>
	| <a href="<?php echo URL; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
</span>
</h5>

<p class="printNoScreen f10" >Printed on: <?php echo date('M d, Y'); ?></p>

<?php $hidden = ($classroom['section_code']=='TMP')? true:false; ?>
<h4 class="<?php echo ($hidden)? 'hd':NULL; ?>" > <?php echo $classroom['name'];  ?> </h4>
<table class="gis-table-bordered table-fx table-altrow <?php echo ($hidden)? 'hd':NULL; ?>" >
	<tr class="headrow"  >
		<th class="vc30" >#</th>
		<th class="vc30" >ID</th>
		<th class="vc100" >Type</th>
		<th class="vc200" >Subject</th>
		<th class="vc200" >Label</th>
		<th class="vc200" > Teacher </th>
	</tr>
	<?php $i=1; ?>
	<?php foreach($courses AS $row): ?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $row['course_id']; ?></td>
			<td><?php echo $row['crstype']; ?></td>
			<td><?php echo $row['subject']; ?></td>
			<td><?php echo $row['label']; ?></td>
			<td><?php echo $row['teacher']; ?></td>
		</tr>
	<?php $i++; ?>
	<?php endforeach; ?>
</table>

<!------------------------------------------------------------>

<script>

$(function(){
	hd();
	
})

</script>