<?php 

// $attdlink=($_SESSION['settings']['attd_qtr']==1)? 'attdQtr':'attd';
$attdlink=($_SESSION['settings']['attd_qtr']==1)? 'quarterly':'monthly';
// pr($attdlink);
// pr($classrooms[62]);


?>

<h5 class="screen" >
	Class Index Reports (CIR-<?php echo $count; ?>)
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href='<?php echo URL."syncers"; ?>'>Syncers</a> 	
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
<tr><td>Qtr: <input id="qtr" type="number" class="vc50 center" value="<?php echo 4; ?>" /></td>
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
	<th>Crid</th>
	<th>Class</th>
	<th>Attd<br />Qtr</th>
	<th>Grades</th>
	<th>Crs | Loads</th>
	<th>Prom</th>
	<th>Report</th>
	<th>Honors</th>
	<th>Submissions</th>
	<th class="center" >Spiral<br />Step 1</th>
	<th class="center" >Summarizer<br />Step 2</th>
	<th class="center" >Ranking<br />Step 3</th>
	<th class="center" >Report</th>
	<th>ID</th>	
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="vc150" >
		<a target="blank" href="<?php echo URL.'registrars/classroom/'.$classrooms[$i]['crid']; ?>" >		
			<?php echo $classrooms[$i]['classroom']; ?></a>
		<?php echo ($classrooms[$i]['level_id']>13)? '('.$classrooms[$i]['num'].')':NULL; ?>	
	</td>
	<td><?php echo $classrooms[$i]['crid']; ?></td>
<td><a href='<?php echo URL."classlists/classroom/".$classrooms[$i]['id']."/$sy"; ?>' >List</a></td>
<td><a href='<?php echo URL."attendance/{$attdlink}/".$classrooms[$i]['id']."/$sy/$qtr"; ?>' >Q<?php echo $qtr; ?></a></td>
<td>
	<a href='<?php echo URL."matrix/grades/".$classrooms[$i]['id']."/$sy/$qtr"; ?>' >Matrix</a>
	<?php if(!empty($classrooms[$i]['conduct_id'])): ?>
		| <a href='<?php echo URL."conducts/records/".$classrooms[$i]['conduct_id']."/$sy/$qtr"; ?>' >Cond</a>
	<?php else: ?>			
		| <a href='<?php echo URL."cav/traits/".$classrooms[$i]['trait_id']."/$sy/$qtr"; ?>' >Trts</a>	
	<?php endif; ?>			
</td>
<td>
	<a href='<?php echo URL."classrooms/courses/".$classrooms[$i]['id']; ?>' >Crs</a>
	| <a href='<?php echo URL."loads/cls/".$classrooms[$i]['id']; ?>' >Loads</a>

</td>
<td><a href='<?php echo URL."promotions/k12/".$classrooms[$i]['id']."/$sy"; ?>' >K12</a></td>
<td><a href='<?php echo URL."promotions/report/".$classrooms[$i]['id']."/$sy"; ?>' >Report</a></td>
<td><a href='<?php echo URL."honors/records/".$classrooms[$i]['id']."/$sy/$qtr"; ?>' >Honors</a></td>
<td><a href='<?php echo URL."submissions/view/".$classrooms[$i]['id']."/$sy/$qtr"; ?>' >Submissions</a></td>
<td><a href='<?php echo URL."spiral/crid/".$classrooms[$i]['id']."/$sy/$qtr"; ?>' >Spiral</a></td>
<td><a href='<?php echo URL."summarizers/genave/".$classrooms[$i]['id']."/$sy/$qtr"; ?>' >Summarizer</a></td>
<td><a href='<?php echo URL."qcr/qcr/".$classrooms[$i]['id']."/$sy/$qtr"; ?>' >Rank</a></td>
<td><a href='<?php echo URL."rcards/crid/".$classrooms[$i]['id']."/$sy/$qtr?tpl=".$classrooms[$i]['department_id']; ?>' >
	Card</a></td>
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


