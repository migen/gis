<?php 

debug($_SESSION['q']);
$decigenave=$_SESSION['settings']['decigenave'];
$deciranks=$_SESSION['settings']['deciranks'];
$with_genave=isset($_GET['genave'])? true:false;
$with_details=isset($_GET['details'])? true:false;
$ordinalQtr=getOrdinal($qtr);
$current=($sy==DBYR)? true:false;

$url=$_SERVER['REQUEST_URI'];

?>

<h5>
	<?php echo $level['name']; ?> Ranks (<?php echo $count; ?>)
<?php if(!isset($_GET['details'])): ?>
	
	| <a href="<?php echo $url.'&details'; ?>" class="u" >Details</a>
	
	
<?php endif; ?>	
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'lir'; ?>" >L I R</a>
	| <a href="<?php echo URL.'ranks/process/'.$lvl.DS.$sy.DS.$qtr; ?>" >Process</a>
	| <a href="<?php echo URL.'registrars/qlra/'.$lvl.DS.$sy.DS.$qtr; ?>" >Ranking</a>
	
	<?php if($with_genave): ?>
		| <a href="<?php echo URL.'ranks/level/'.$lvl.DS.$sy.DS.$qtr; ?>" >RanksOnly</a>
	<?php else: ?>
		| <a href="<?php echo URL.'ranks/level/'.$lvl.DS.$sy.DS.$qtr.'&genave'; ?>" >WithGenave</a>	
	<?php endif; ?>

	<?php if(!$with_details && !$with_genave): ?>
		| <a href="<?php echo URL.'ranks/level/'.$lvl.DS.$sy.DS.$qtr.'?details'; ?>" >WithDetails</a>
	<?php endif; ?>	
	
	<?php if(($_SESSION['srid'])==RMIS && ($current)): ?>
		| <span class="u" onclick="zerofyLevelRanks(<?php echo $lvl.','.$qtr; ?>);">Zerofy</span>
		| <a href="<?php echo URL.'ranks/update/'.$lvl.DS.$sy.DS.$qtr; ?>" >Update</a>		
		| <a href="<?php echo URL.'ranks/ties/'.$lvl.DS.$sy.DS.$qtr; ?>" >Ties</a>		
	<?php endif; ?>
	

	<?php if($free==0): ?>
		| <a href="<?php echo URL.'ranks/level/'.$lvl.DS.$sy.DS.$qtr.'?free=1'; ?>" >Free</a>
		| <a href="<?php echo URL.'ranks/level/'.$lvl.DS.$sy.DS.$qtr.'?free=2'; ?>" >All</a>
	<?php elseif($free=1): ?>
		| <a href="<?php echo URL.'ranks/level/'.$lvl.DS.$sy.DS.$qtr; ?>" >Paid</a>
		| <a href="<?php echo URL.'ranks/level/'.$lvl.DS.$sy.DS.$qtr.'?free=2'; ?>" >All</a>	
	<?php elseif($free=2): ?>
		| <a href="<?php echo URL.'ranks/level/'.$lvl.DS.$sy.DS.$qtr; ?>" >Paid</a>
		| <a href="<?php echo URL.'ranks/level/'.$lvl.DS.$sy.DS.$qtr.'?free=1'; ?>" >Free</a>	
	<?php endif; ?>
	
</h5>



<table class="" >
<tr><th><?php echo "School Year $sy-".($sy+1)." | $ordinalQtr Quarter"; ?></th></tr>
</table><br />

<table class="gis-table-bordered table-altrow" >
<tr><th>#</th>
<?php if($with_details): ?><th>Scid</th><th>Classroom</th><th>ID No.</th><?php endif; ?>
<th>Student</th>
<?php if($with_genave): ?><th>Classroom</th><th>GenAve</th><?php endif; ?>
<th class="center" >Rank</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1;?></td>	
	<?php if($with_details): ?>
		<td><?php echo $rows[$i]['scid'];?></td>
		<td><?php echo $rows[$i]['classroom'];?></td>
		<td><?php echo $rows[$i]['studcode'];?></td>
	<?php endif; ?>		
	<td><?php echo $rows[$i]['student'];?></td>	
	<?php if($with_genave): ?>
		<td><?php echo $rows[$i]['classroom'];?></td>
		<td><?php echo number_format($rows[$i]['genave'],$decigenave);?></td>
	<?php endif; ?>	
	<td class="center" ><?php echo ($rows[$i]['rank']+0);?></td>
</tr>
<?php endfor; ?>
</table>


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
