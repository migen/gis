<?php 


?>

<h5 class="screen" >
	Class Index Reports (CIR-<?php echo $count; ?>)
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href='<?php echo URL."mis/syncer"; ?>'>Syncer</a> 	
	| <a href='<?php echo URL."files/read/rcard"; ?>'>*Report Card Notes</a> 	
	| <a href='<?php echo URL."cir/index?all"; ?>'>All</a> 		
	
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
	<th>Trs</th>
	<th>ID</th>	
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="vc150" >
		<a target="blank" href="<?php echo URL.'registrars/classroom/'.$classrooms[$i]['crid']; ?>" >		
			<?php echo $classrooms[$i]['classroom']; ?></a>
	</td>
<td><a href='<?php echo URL."classlists/classroom/".$classrooms[$i]['id']."/$sy/$qtr"; ?>' >List</a></td>
<td><a href='<?php echo URL."trs/trsMatrix/".$classrooms[$i]['id']; ?>' >View</a></td>
<td><?php echo $classrooms[$i]['crid']; ?></td>
</tr>
<?php endfor; ?>
</table>

<div class="clear ht100" >&nbsp;</div>


<script>

var gurl = "http://<?php echo GURL; ?>";

$(function(){
	

})


</script>


