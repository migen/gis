<?php 

	$dbclassrooms="{$dbg}.05_classrooms";

	


	$fields_contacts="c.name AS fullname,c.is_male AS sex";
	
	$order=$_SESSION['settings']['classlist_order'];
	$q="SELECT {$fields_contacts},p.* 
			FROM {$dbo}.00_contacts AS c 
			INNER JOIN {$dbg}.05_summaries AS summ ON summ.scid=c.id
			INNER JOIN {$dbo}.00_profiles AS p ON p.contact_id=c.id
		WHERE summ.crid=$crid ORDER BY $order; ";
	debug($q);
	$sth=$db->querysoc($q);
	$rows=$sth->fetchAll();
	$count=$sth->rowCount();
	
	$fkeys=array_keys($rows[0]);	
	$exclude=['id','sex','contact_id'];	
	$fkeys=array_diff($fkeys,$exclude);
	




?>

<h3>
	Classroom Datasheets (<?php echo $count; ?>) | <?php $this->shovel('homelinks'); ?>
	| <a class="u" id="btnExport" >Excel</a> 

</h3>

<div>
	<span class="b" ><?php echo $cr['classroom'].' - '.$cr['adviser']; ?></span>
	<span class="" >&nbsp;</span>
	<span class="screen" >
		<select onchange="axnFilter(this.value);" >
			<option>Select One</option>
			<?php foreach($classrooms AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" <?php echo ($crid==$sel['id'])? 'selected':NULL; ?> >
					<?php echo $sel['name']; ?>
				</option>
			<?php endforeach; ?>
		</select>
	</span>

</div>

<br />

<table id="tblExport" class="gis-table-bordered" >

<tr>
	<th>#</th>
	<th>Sex</th>	
	<?php foreach($fkeys AS $fkey): ?>
		<th><?php echo ucfirst($fkey); ?></th>
	<?php endforeach; ?>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
		<td><?php echo $i+1; ?></td>
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
var gurl = "http://<?php echo GURL; ?>";


$(function(){
	excel();

})

function axnFilter(id){
	var url=gurl+"/datasheets/crid/"+id;
	window.location=url;
}



</script>

