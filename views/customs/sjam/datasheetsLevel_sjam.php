<?php 

	$dbclassrooms="{$dbg}.05_classrooms";

	
if($lvl){
	$fields_contacts="l.name AS level,cr.name AS classroom,c.name AS fullname,c.is_male AS sex";
	$order="cr.num,sxn.name,c.is_male DESC,c.name";
	$q="SELECT {$fields_contacts},p.* 
			FROM {$dbo}.00_contacts AS c 
			INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
			INNER JOIN {$dbo}.05_sections AS sxn ON cr.section_id=sxn.id
			INNER JOIN {$dbo}.05_levels AS l ON cr.level_id=l.id
			INNER JOIN {$dbo}.00_profiles AS p ON p.contact_id=c.id
		WHERE cr.level_id=$lvl AND cr.section_id>2 ORDER BY $order; ";
	debug($q);
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$count=$sth->rowCount();
	
	$fkeys=array_keys($rows[0]);	
	$exclude=['id','sex','contact_id','level','classroom'];	
	$fkeys=array_diff($fkeys,$exclude);
	
}	/* crid */

	




?>

<h3>
	SJAM Level Datasheets (<?php echo ($lvl)? $count:NULL; ?>) | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'datasheets/crid'; ?>" >Classroom</a>
	| <a href="<?php echo URL.'datasheets/all'; ?>" >All</a>	
	| <a class="u" id="btnExport" >Excel</a> 

</h3>

<?php if(!$lvl): ?>
	<div>
		<span class="screen" >
			<select onchange="axnFilter(this.value);" >
				<option>Select One</option>
				<?php foreach($levels AS $sel): ?>
					<option value="<?php echo $sel['id']; ?>" <?php echo ($lvl==$sel['id'])? 'selected':NULL; ?> >
						<?php echo $sel['name']; ?>
					</option>
				<?php endforeach; ?>
			</select>
		</span>
	</div>


<?php else: ?>
<div><span class="b" ><?php echo $level['level']; ?></span></div><br />

<table id="tblExport" class="gis-table-bordered" >

<tr>
	<th>#</th>
	<th>Classroom</th>	
	<th>Sex</th>	
	<?php foreach($fkeys AS $fkey): ?>
		<th><?php echo ucfirst($fkey); ?></th>
	<?php endforeach; ?>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
		<td><?php echo $i+1; ?></td>
		<td><?php echo $rows[$i]['classroom']; ?></td>
		<td><?php echo ($rows[$i]['sex']==1)? 'Boy':'Girl'; ?></td>
	<?php foreach($fkeys AS $fkey): ?>
		<td><?php echo $rows[$i][$fkey]; ?></td>
	<?php endforeach; ?>
</tr>
<?php endfor; ?>
</table>

<div class="ht100" ></div>

<?php endif; ?>

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>



<script>
var gurl="http://<?php echo GURL; ?>";
$(function(){
	excel();

})


function axnFilter(id){
	var url=gurl+"/datasheets/level/"+id;
	window.location=url;
}



</script>
