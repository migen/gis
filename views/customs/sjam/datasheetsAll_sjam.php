<?php 

	$dbclassrooms="{$dbg}.05_classrooms";
	
	
	$limit=isset($_GET['limit'])? $_GET['limit']:10000;
	$page=isset($_GET['page'])? $_GET['page']:1;
	$offset = ($page-1)*$limit;
	
	$fields_contacts="summ.scid,cr.name AS classroom,c.name AS fullname,c.is_male AS sex";
	$order=isset($_GET['order'])? $_GET['order']:"cr.level_id,cr.num,sxn.name,c.is_male DESC,c.name";
	$q="SELECT {$fields_contacts},p.* 
			FROM {$dbo}.00_contacts AS c 
			INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
			INNER JOIN {$dbg}.05_classrooms AS cr ON summ.crid=cr.id
			INNER JOIN {$dbo}.05_sections AS sxn ON cr.section_id=sxn.id
			INNER JOIN {$dbo}.00_profiles AS p ON p.contact_id=c.id
		WHERE cr.section_id>2 ORDER BY $order LIMIT $limit OFFSET $offset; ";
	// pr($q);
	debug($q);
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$count=$sth->rowCount();
	
	$fkeys=array_keys($rows[0]);	
	$exclude=['id','sex','contact_id','classroom'];	
	$fkeys=array_diff($fkeys,$exclude);
	

	




?>

<h3 class="screen">
	SJAM All Datasheets (<?php echo $count; ?>) | <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'datasheets/crid'; ?>" >Select</a>
	| &limit&page

</h3>



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


<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>



<script>
var gurl="http://<?php echo GURL; ?>";
$(function(){
	excel();

})


function axnFilter(id){
	var url=gurl+"/datasheets/crid/"+id;
	window.location=url;
}



</script>
