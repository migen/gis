<?php 

$attdlink=($_SESSION['settings']['attd_qtr']==1)? 'attdQtr':'attd';


// pr($classrooms[0]);
$is_dual=$_SESSION['settings']['is_dual'];
$prevsy=($sy-1);
$prevsy_code=substr($prevsy,2,2);

?>

<h5 class="screen" >
	SJAM (CIRR-<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."cir/reset"; ?>'>CirList Reset</a> 		
	| <a href='<?php echo URL."cir"; ?>'>CIR</a> 		
	| <a href='<?php echo URL."lir"; ?>'>LIR</a> 		
	| <a href='<?php echo URL."acad/links"; ?>'>Links</a> 		
	| <a href="<?php echo URL.'students'; ?>" >Portal</a>
	| <a href="<?php echo URL.'cdt'; ?>" >Cdt Tally Index</a>
	
	
	
</h5>



<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th>Classroom</th>
	<th>Class</th>
	<th>Attd</th>
	<th>Cdt</th>
	<th>Tally</th>
	<th>Cdt<br />Proc</th>
	<th>CndkTrt<br />Proc</th>
	<th>Ofns<br />Qtr</th>
	<th>Matrix</th>
	<th>Rpt Cards</th>
	<?php if($_SESSION['srid']==RMIS): ?>
		<th>Ofns<br />Sync</th>
	<?php endif; ?>
	<th>ID</th>	
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<?php 
	$crid=$classrooms[$i]['id'];
	$conduct_id=$classrooms[$i]['conduct_id'];
	$trait_id=$classrooms[$i]['trait_id'];
?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="vc150" ><?php echo $classrooms[$i]['classroom']; ?></td>
<td>
	<?php if($is_dual): ?>
		<a href='<?php echo URL."classlists/classroom/$crid/$prevsy"; ?>' ><?php echo $prevsy; ?></a> | 
	<?php endif; ?>		
	<a href='<?php echo URL."classlists/classroom/$crid/$sy"; ?>' >List</a>
</td>
<td>
	<?php if($is_dual): ?>
		<a href='<?php echo URL."attendance/annualQtr/".$classrooms[$i]['id']."/$prevsy"; ?>' ><?php echo $prevsy_code;  ?></a> | 
	<?php endif; ?>		
	<a href='<?php echo URL."attendance/annualQtr/".$classrooms[$i]['id']."/$sy"; ?>' ><?php echo 'Attd';  ?></a>
</td>	
<td>
	<?php if($is_dual): ?>
		<a href='<?php echo URL."conducts/annual/".$classrooms[$i]['id']."/$prevsy"; ?>' ><?php echo $prevsy;  ?></a> | 
	<?php endif; ?>		
	<a href='<?php echo URL."conducts/annual/".$classrooms[$i]['id']."/$sy"; ?>' ><?php echo 'Cdt';  ?></a>
</td>	
<td>
	<?php if($is_dual): ?>
		<a href='<?php echo URL."cdt/tally/".$classrooms[$i]['id']."/$prevsy"; ?>' ><?php echo $prevsy;  ?></a> | 
	<?php endif; ?>		
	<a href='<?php echo URL."cdt/tally/".$classrooms[$i]['id']."/$sy"; ?>' ><?php echo 'Tally';  ?></a>
</td>	
<td>
	<?php if($is_dual): ?>
		<a href='<?php echo URL."conducts/process/$crid/$prevsy/4"; ?>' ><?php echo $prevsy_code; ?></a> | 
	<?php endif; ?>		
	<a href='<?php echo URL."conducts/process/$crid/$sy/$qtr"; ?>' ><?php echo $conduct_id; ?></a>
</td>
<td>
	<?php if($is_dual): ?>	
		<a href='<?php echo URL."conducts/process/$crid/$prevsy/4"; ?>' ><?php echo $prevsy; ?></a> | 
	<?php endif; ?>		
	<a href='<?php echo URL."conducts/process/$crid/$sy/$qtr"; ?>' ><?php echo $trait_id; ?></a>
</td>
<td>
	<?php if($is_dual): ?>
		<a href='<?php echo URL."offenses/records/$crid/$prevsy/4"; ?>' ><?php echo $prevsy_code; ?></a> | 
	<?php endif; ?>		
	<a href='<?php echo URL."offenses/records/$crid/$sy/$qtr"; ?>' ><?php echo 'Offns'; ?></a>
</td>
<td>
	<?php if($is_dual): ?>
		<a href='<?php echo URL."matrix/view/$crid/$prevsy/4"; ?>' ><?php echo $prevsy; ?></a> | 
	<?php endif; ?>		
	<a href='<?php echo URL."matrix/view/$crid/$sy/$qtr"; ?>' ><?php echo 'Mtrx'; ?></a>
</td>
	
<td>
<?php if($classrooms[$i]['level_id']<14): ?>
<a href='<?php echo URL."rcards/crid/".$crid."/$prevsy/4?tpl=".$classrooms[$i]['department_id']; ?>' ><?php echo $prevsy; ?></a>
| <a href='<?php echo URL."rcards/crid/".$crid."/$sy/$qtr?tpl=".$classrooms[$i]['department_id']; ?>' ><?php echo 'Cards'; ?></a>
<?php else: ?>
	<?php 
		$half=($qtr<3)?1:2;
	?>
	<?php if($is_dual): ?>
		<a href='<?php echo URL."srcards/crid/".$crid."/$prevsy/4/2"; ?>' ><?php echo $prevsy; ?></a> | 
	<?php endif; ?>		
	<a href='<?php echo URL."srcards/crid/".$crid."/$sy/$qtr/$half"; ?>' ><?php echo 'Cards'; ?></a>
<?php endif; ?>
</td>
	
	
<?php if($_SESSION['srid']==RMIS): ?>
	<td><a href='<?php echo URL."syncers/syncOffensesByCrid/$crid"; ?>' ><?php echo 'Sync'; ?></a></td>
<?php endif; ?>

<td><?php echo '#'.$classrooms[$i]['crid']; ?></td>
</tr>
<?php endfor; ?>
</table>

<div class="clear ht100" >&nbsp;</div>


<script>

var gurl = "http://<?php echo GURL; ?>";
var sy   = "<?php echo $sy; ?>";

$(function(){
	

})


</script>




