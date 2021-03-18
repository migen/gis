<?php 


debug($rows[0]);

// $rows=getSir($rows);
// debug($_SESSION['q']);
$decigenave=$_SESSION['settings']['decigenave'];
$deciranks=$_SESSION['settings']['deciranks'];
$with_genave=isset($_GET['genave'])? true:false;
$with_details=isset($_GET['details'])? true:false;
$ordinalQtr=getOrdinal($qtr);
$current=($sy==DBYR)? true:false;

$url=$_SERVER['REQUEST_URI'];


// $fields=array('is_qualified_q4');
$field_str=isset($_GET['fields'])? $_GET['fields']:false;
$fields=isset($_GET['fields'])? explode(",",$field_str):array();


?>

<h5>
	<?php echo $level['name']; ?> Ranks With Honors (Std Level Genave - <?php echo $count; ?>)
<?php if(!isset($_GET['details'])): ?>
	
	| <a href="<?php echo $url.'&details'; ?>" class="u" >Details</a>	
<?php endif; ?>	
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'lir'; ?>" >L I R</a>
	| <a href="<?php echo URL.'ranks/process/'.$lvl.DS.$sy.DS.$qtr; ?>" >Process</a>
	| &fields
	
	| <a href="<?php echo URL.'ranks/ties/'.$lvl.DS.$sy.DS.$qtr; ?>" >Ties</a>	
	| <a href="<?php echo URL.'registrars/qlra/'.$lvl.DS.$sy.DS.$qtr; ?>" >Old Ranking</a>
	

	<?php if(!$with_details && !$with_genave): ?>
		| <a href="<?php echo URL.'ranks/level/'.$lvl.DS.$sy.DS.$qtr.'?details'; ?>" >WithDetails</a>
	<?php endif; ?>	
	
	<?php if(($_SESSION['srid'])==RMIS && ($current)): ?>
		| <span class="u" onclick="zerofyLevelRanks(<?php echo $lvl.','.$qtr; ?>);">Zerofy</span>
	<?php endif; ?>
	
	| <a href="<?php echo URL.'sir/level/'.$lvl.DS.$sy.DS.$qtr; ?>" >SIR</a>	
	| <a href="<?php echo URL.'sir/level/'.$lvl.DS.$sy.DS.$qtr.'?free=0'; ?>" >Paid</a>
	| <a href="<?php echo URL.'sir/level/'.$lvl.DS.$sy.DS.$qtr.'?free=1'; ?>" >Free</a>
	| <a href="<?php echo URL.'sir/level/'.$lvl.DS.$sy.DS.$qtr.'?free=2'; ?>" >All</a>

	
	
</h5>


<p class="screen" >
	&fields - is_qualified_q<?php echo $qtr; ?>, cocurr_q<?php echo $qtr; ?>, 
	honor_rank_q<?php echo $qtr; ?>, rank_level_q<?php echo $qtr; ?>, rank_level_ave_q<?php echo $qtr; ?>
</p>


<table class="" >
<tr><th><?php echo "School Year $sy-".($sy+1)." | $ordinalQtr Quarter"; ?></th></tr>
</table><br />

<table class="gis-table-bordered table-altrow" >
<tr><th>#</th>
<?php if($with_details): ?><th>Scid</th><th>Classroom</th><th>ID No.</th><?php endif; ?>
<th>Student</th>
<?php if($with_genave): ?><th>Classroom</th><?php endif; ?>
<th class="center" >Is<br />Qlfd</th>
<th class="center" >Honor</th>
<th class="center" >Honor<br />DG</th>
<th>Genave</th>
<th class="center" >Rank</th>
<?php foreach($fields AS $field): ?>
	<td><?php echo $field; ?></td>	
<?php endforeach; ?>	

</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1;?></td>	
	<?php if($with_details): ?>
		<td><?php echo $rows[$i]['scid'];?></td>
		<td><?php echo $rows[$i]['classroom'];?></td>
		<td><?php echo $rows[$i]['studcode'];?></td>
	<?php endif; ?>		
	<td><?php echo $rows[$i]['student']; ?></td>	
	<?php if($with_genave): ?>
		<td><?php echo $rows[$i]['classroom'];?></td>
	<?php endif; ?>	
	<td class="center" ><?php echo ($rows[$i]['is_qualified_q'.$qtr]); ?></td>	
	<td class="center" ><?php echo ($rows[$i]['honor_q'.$qtr]+0); ?></td>	
	<td><?php echo $rows[$i]['honor_dg'.$qtr];?></td>
	<td><?php echo number_format($rows[$i]['genave'],$decigenave); ?></td>		
	<td class="center" ><?php echo $rows[$i]['rank']+0; ?></td>

<?php foreach($fields AS $field): ?>
	<td><?php echo $rows[$i][$field]; ?></td>	
<?php endforeach; ?>	
	

</tr>
<?php endfor; ?>
</table>

<div class="ht100" ></div>


<script>

var gurl="http://<?php echo GURL; ?>";

function zerofyLevelRanks(lvl,qtr){
	var vurl=gurl+'/ajax/xranks.php';	
	var task="zerofyLevelRanks";		
	$.ajax({
		url: vurl,type: 'POST',data:'task='+task+'&lvl='+lvl+'&qtr='+qtr,				
		success: function() { location.reload(); }		  
    });					

}



</script>
