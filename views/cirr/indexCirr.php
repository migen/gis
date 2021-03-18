<?php 

$attdlink=($_SESSION['settings']['attd_qtr']==1)? 'attdQtr':'attd';
// pr($attdlink);

// pr($classrooms[2]);
// pr($classrooms[5]);
// exit;



?>

<h5 class="screen" >
	Class Index Reports Two (CIRR-<?php echo $count; ?>)
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href='<?php echo URL."mis/syncer"; ?>'>Syncer</a> 	
	| <a href='<?php echo URL."files/read/rcard"; ?>'>*Report Card Notes</a> 	
	| <a href='<?php echo URL."cir/index?all"; ?>'>All</a> 		
	| <a href='<?php echo URL."students/filter"; ?>'>Filter</a> 		
	| <a href='<?php echo URL."cir/reset"; ?>'>CirList Reset</a> 		
	<?php if($_SESSION['srid']==RMIS): ?>
		| <a href='<?php echo URL."mis/advisers"; ?>'>Advisers</a> 		
	<?php endif; ?>
	
<?php 
	$d['sy']=$sy;$d['repage']="cir/index";
	$this->shovel('sy_selector',$d); 
?>	
	
	
</h5>

<table class="gis-table-bordered" >
<tr><td>Qtr: <input id="qtr" type="number" class="vc50 center" value="<?php echo $qtr; ?>" /></td>
<td><button onclick="jsredirect('advisers/averager?qtr='+$('#qtr').val());" >Averager</button></td>
</tr>
</table>


<ul>
	<li><span class="b u" >Q</span> means Quarter Status - "Y" if classroom has been finalized by the adviser.</li>
	<li>Attd means attendance. </li>
	<li>Report Cards Printing Steps 1) Averager (1x only), 2) Per Classroom Summarizer (if has red TG box).</li>
</ul>




<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th>Classroom</th>
	<th>Class</th>
	<th>Attd</th>
	<th>Cndk<br />Proc<br />Crs</th>
	<th>CndkTrt<br />Proc<br />Crs</th>
	<th>Ofns<br />Qtr</th>
	<th>Ofns<br />Sync</th>
	<th>Matrix</th>

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
	<td class="vc150" >
		<a target="blank" href="<?php echo URL.'registrars/classroom/'.$classrooms[$i]['crid']; ?>" >		
			<?php echo $classrooms[$i]['classroom']; ?></a>
	</td>
<td><a href='<?php echo URL."classlists/classroom/$crid/$sy"; ?>' >List</a></td>
<?php ?>

<?php ?>
	<td><a href='<?php echo URL."attendance/monthly/".$classrooms[$i]['id']."/$sy/$qtr"; ?>' >Q<?php echo $qtr;  ?></a></td>
<td><a href='<?php echo URL."conducts/process/$crid/$sy/$qtr"; ?>' ><?php echo $conduct_id; ?></a></td>
<td><a href='<?php echo URL."conducts/process/$crid/$sy/$qtr"; ?>' ><?php echo $trait_id; ?></a></td>
<td><a href='<?php echo URL."offenses/records/$crid/$sy/$qtr"; ?>' ><?php echo $crid; ?></a></td>
<td><a href='<?php echo URL."syncers/syncOffensesByCrid/$crid"; ?>' ><?php echo 'Sync'; ?></a></td>
<td><a href='<?php echo URL."matrix/view/$crid/$sy/$qtr"; ?>' ><?php echo "View"; ?></a></td>


<td><?php echo $classrooms[$i]['crid']; ?></td>
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


