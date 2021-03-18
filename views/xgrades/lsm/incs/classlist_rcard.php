
<?php 
// pr($data);

$dept_id=$cr['department_id'];
$lvl=$cr['level_id'];


// $preurl=
// $sufurl=

if($lvl>13){
	$pref="srcards/scid/";
	$suff="/$sy/4/2?both=1";	
} elseif($lvl>9){
	$pref="rcards/scid/";
	$suff="/$sy/4&tpl=3";		
} elseif($lvl>3){
	$pref="rcards/scid/";
	$suff="/$sy/4&tpl=2";		
} else{
	$pref="rcards/scid/";
	$suff="/$sy/4&tpl=1";		

}


	
	
	

?>



<table id="tblExport" class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Code</th>
	<th class="vc300" >Student</th>
	<th class="vc50" >Report</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<?php $scid=$rows[$i]['scid']; ?>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['code']; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>	
	<td><a href='<?php echo URL.$pref.$scid.$suff; ?>' >Card</a></td>
</tr>
<?php endfor; ?>
</table>
