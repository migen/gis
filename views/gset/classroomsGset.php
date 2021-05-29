<?php 

debug($rows[0]);
// pr($rows[15]);

$sy_enrollment=$_SESSION['settings']['sy_enrollment'];

?>

<h5>
	All Classrooms SY<?php echo $sy; ?> (<?php echo $count; ?>)
	<?php if($sy_enrollment>$sy): ?>
		| <a href="<?php echo URL.'gset/classrooms/'.$sy_enrollment.'?all'; ?>" ><?php echo "SY{$sy_enrollment}"; ?></a>	
	<?php endif; ?>
	
	<?php if(DBYR<$sy): ?>
		| <a href="<?php echo URL.'gset/classrooms/'.DBYR.'?all'; ?>" ><?php echo "SY".DBYR; ?></a>	
	<?php endif; ?>

	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'gset'; ?>" >Gset</a>	
	| <a href="<?php echo URL.'gset/sections'; ?>" >Sections</a>	
	| <a href="<?php echo URL.'classrooms/add'; ?>" >Add Sxn/Classroom</a>	
	| <a href="<?php echo URL.'classrooms/level/4'; ?>" >Manage</a>	
	| <a href="<?php echo URL.'cr'; ?>" >List</a>	
	| <a href="<?php echo URL.'gset/renameClassrooms/'.DBYR; ?>" >RenameClassrooms<?php echo DBYR; ?></a>		
</h5>

<p>
	&brid | &sxn | &all
</p>

<table class="gis-table-bordered table-altrow table-fx" >
<tr>
<th>#</th>
<th>Actv</th>
<th>BRID</th>
<th>CRID</th>
<th>Major</th>
<th>Num</th>
<th>Lvl-Level</th>
<th>Sxn-Section</th>
<th>Classroom</th>
<th>Num<br>Stud</th>
<th>Adviser</th>
<th></th>
<th>MIS<br>Class</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo ($rows[$i]['is_active']==1)? 'Y':'-'; ?></td>
	<td><?php echo $rows[$i]['brid']; ?></td>
	<td><?php echo $rows[$i]['crid']; ?></td>
	<td><?php echo $rows[$i]['major_id']; ?></td>
	<td><?php echo $rows[$i]['num']; ?></td>
	<td><?php echo $rows[$i]['level_id'].' - '.$rows[$i]['lvlcode']; ?></td>
	<td><?php echo $rows[$i]['section_id'].' - '.$rows[$i]['sxncode']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><?php echo $rows[$i]['num_students']; ?></td>
	<td><?php echo '#'.$rows[$i]['acid'].' - '.$rows[$i]['adviser']; ?></td>
	<td><a href="<?php echo URL.'classrooms/edit/'.$rows[$i]['crid']; ?>" >Edit</a></td>
	<td><a href="<?php echo URL.'misdata/classlist/'.$rows[$i]['crid'].DS.$sy; ?>" >List</a></td>
</tr>
<?php endfor; ?>

</table>


<div class="clear ht100" ></div>
