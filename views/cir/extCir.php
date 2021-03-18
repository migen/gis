

<?php 

// $attdlink=($_SESSION['settings']['attd_qtr']==1)? 'attdQtr':'attd';
$attdlink=($_SESSION['settings']['attd_qtr']==1)? 'quarterly':'monthly';


$sch=VCFOLDER;
$ucfsch=ucfirst(VCFOLDER);
$vpath = SITE."views/customs/{$sch}/profiles/classroomProfiles{$ucfsch}.php";
$crprofiles_path=(is_readable($vpath))? "{$sch}/classroomProfiles/":"profiles/classroom/";	

?>

<h5 class="screen" >
	Ext Class Index Reports (CIR-<?php echo $count; ?>)
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	<?php $plug=(DBYR==$sy)? NULL:"/index/$sy"; ?>
	| <a href='<?php echo URL."cir{$plug}"; ?>'>CIR</a> 			
	| <a href='<?php echo URL."syncers"; ?>'>Syncers</a> 	
	| <a href='<?php echo URL."files/read/rcard"; ?>'>*Report Card Notes</a> 	
	| <a href='<?php echo URL."cir/index?all"; ?>'>All</a> 		
	| <a href='<?php echo URL."students/filter"; ?>'>Filter</a> 		
	| <a href='<?php echo URL."cir/reset"; ?>'>Cir-Reset</a> 		
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
	<li>Attd means attendance. | Q - is_finalized (Cir-Reset to refresh) </li>
	<li>Report Cards Printing Steps, Check for red boxes 1) Spiral  2) Summarizer </li>
</ul>



<table class="gis-table-bordered table-fx table-altrow table-fx-columns " >
<tr class="headrow" >
	<th>#</th>
	<th>Classlist (Size)</th>
	<th>ID</th>
	<th>Grades</th>
	<th>Prom</th>
	<th>Report</th>
	<th>Honors</th>
	<th class="center" >Ranking<br />Step 3</th>
	<th>Gradebook</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="vc150" >
		<a target="blank" href="<?php echo URL.'registrars/classroom/'.$rows[$i]['crid']; ?>" >		
			<?php echo $rows[$i]['classroom'].' ('.$rows[$i]['num_students'].')'; ?></a>
		<?php echo ($rows[$i]['level_id']>13)? '('.$rows[$i]['num'].')':NULL; ?>	
	</td>
	<td><?php echo $rows[$i]['crid']; ?></td>
<td>
	<a href='<?php echo URL."matrix/grades/".$rows[$i]['id']."/$sy/$qtr"; ?>' >Matrix</a>
	<?php if(!empty($rows[$i]['conduct_id'])): ?>
		| <a href='<?php echo URL."conducts/records/".$rows[$i]['conduct_id']."/$sy/$qtr"; ?>' >Cond</a>
	<?php else: ?>			
		| <a href='<?php echo URL."cav/traits/".$rows[$i]['trait_id']."/$sy/$qtr"; ?>' >Trts</a>	
	<?php endif; ?>			
</td>
<td><a href='<?php echo URL."promotions/k12/".$rows[$i]['id']."/$sy"; ?>' >K12</a></td>
<td><a href='<?php echo URL."promotions/report/".$rows[$i]['id']."/$sy"; ?>' >Report</a></td>
<td><a href='<?php echo URL."honors/records/".$rows[$i]['id']."/$sy/$qtr"; ?>' >Honors</a></td>
<td><a href='<?php echo URL."qcr/qcr/".$rows[$i]['id']."/$sy/$qtr"; ?>' >Rank</a></td>
<td><a href='<?php echo URL."gradebook/classroom/".$rows[$i]['id']."/$sy/$qtr"; ?>' >Gradebook</a></td>

</tr>
<?php endfor; ?>
</table>

<div class="clear ht100" >&nbsp;</div>


<script>

var gurl = "http://<?php echo GURL; ?>";
var sy   = "<?php echo $sy; ?>";

$(function(){
	// fxColumnHighlighting();	
})


</script>


