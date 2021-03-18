

<?php 

// $attdlink=($_SESSION['settings']['attd_qtr']==1)? 'attdQtr':'attd';
$attdlink=($_SESSION['settings']['attd_qtr']==1)? 'quarterly':'monthly';


$sch=VCFOLDER;
$ucfsch=ucfirst(VCFOLDER);
$vpath = SITE."views/customs/{$sch}/profiles/classroomProfiles{$ucfsch}.php";
$crprofiles_path=(is_readable($vpath))? "{$sch}/classroomProfiles/":"profiles/classroom/";	


$is_dual=$_SESSION['settings']['is_dual'];
$prevsy=($sy-1);
$prevsy_code=substr($prevsy,2,2);


?>

<h5 class="screen pagelinks" >
	Std Class Index Reports (CIR-<?php echo $count; ?>) 
	| (&tmp (unset-cirlist/_all) | &all)
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
	| <a href='<?php echo URL."syncers"; ?>'>Syncers</a> 	
	| <a href='<?php echo URL."files/read/rcard"; ?>'>*Notes</a> 	
	| <a href='<?php echo URL."cir/index?all"; ?>'>All</a> 		
	| <a href='<?php echo URL."students/filter"; ?>'>Filter</a> 		
	| <a href='<?php echo URL."sessions/unsetter/cirlist"; ?>'>Unset</a> 		
	<?php $plug=(DBYR==$sy)? NULL:"/index/$sy"; ?>
	| <a href='<?php echo URL."cir{$plug}?ext"; ?>'>Ext</a> 		
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



<table class="table table-bordered table-fx table-altrow table-fx-columns " >
<tr class="headrow" >
	<th>#</th>
	<th>Classlist (Size)</th>
	<th>Q</th>
	<th>Attd<br />Qtr</th>
	<th>Grades</th>
	<th>Crs | Loads</th>
	<th>Submissions</th>
	<th class="center" >Spiral<br />Step 1</th>
	<th class="center" >Summarizer<br />Step 2</th>
	<th class="center" >Report<br />(Size)</th>
	<th>ID</th>	
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="vc200" >	
		<a target="blank" href="<?php echo URL.'classlists/classroom/'.$rows[$i]['crid'].DS.$sy; ?>" >		
			<?php echo $rows[$i]['classroom'].' ('.$rows[$i]['num_students'].')'; ?></a>
		<?php echo ($rows[$i]['level_id']>13)? '('.$rows[$i]['num'].')':NULL; ?>	
		| <a target="blank" href="<?php echo URL.'classlists/classroom/'.$rows[$i]['crid'].DS.$prevsy; ?>" >		
			<?php echo $prevsy; ?></a>			
	</td>
	<td><?php echo ($rows[$i]['is_locked']==1)? 'Y':'-'; ?></td>
<td>
	<?php if($is_dual): ?>
		<a href='<?php echo URL."attendance/{$attdlink}/".$rows[$i]['id']."/$prevsy/4"; ?>' ><?php echo $prevsy; ?></a> | 
	<?php endif; ?>		

	<a href='<?php echo URL."attendance/{$attdlink}/".$rows[$i]['id']."/$sy/$qtr"; ?>' >Attd</a>
</td>
<td>
	<?php if($is_dual): ?>
		<a href='<?php echo URL."matrix/grades/".$rows[$i]['id']."/$prevsy/4"; ?>' ><?php echo $prevsy; ?></a> | 
	<?php endif; ?>		
	<a href='<?php echo URL."matrix/grades/".$rows[$i]['id']."/$sy/4"; ?>' >Matrix</a>
	<?php if(!empty($rows[$i]['conduct_id'])): ?>
	<?php if($is_dual): ?>
		| <a href='<?php echo URL."conducts/records/".$rows[$i]['conduct_id']."/$prevsy/4"; ?>' ><?php echo $prevsy_code; ?></a> | 
	<?php endif; ?>			
		<a href='<?php echo URL."conducts/records/".$rows[$i]['conduct_id']."/$sy/$qtr"; ?>' >Cond</a>
	<?php else: ?>			
	<?php if($is_dual): ?>
		| <a href='<?php echo URL."cav/traits/".$rows[$i]['trait_id']."/$prevsy/4"; ?>' ><?php echo $prevsy_code; ?></a> | 
	<?php endif; ?>				
		<a href='<?php echo URL."cav/traits/".$rows[$i]['trait_id']."/$sy/$qtr"; ?>' >Trts</a>	
	<?php endif; ?>			
</td>
<td>
	<?php if($is_dual): ?>
		<a href='<?php echo URL."classrooms/courses/".$rows[$i]['id']; ?>' >Crs</a> | 
	<?php endif; ?>		
	<a href='<?php echo URL."loads/cls/".$rows[$i]['id']; ?>' >Loads</a>

</td>
<td>
	<?php if($is_dual): ?>
		<a href='<?php echo URL."submissions/view/".$rows[$i]['id']."/$sy/4"; ?>' ><?php echo $prevsy_code; ?></a> | 
	<?php endif; ?>		
	<a href='<?php echo URL."submissions/view/".$rows[$i]['id']."/$sy/$qtr"; ?>' >Submxn</a>
</td>
<td>
	<?php if($is_dual): ?>
		<a href='<?php echo URL."spiral/crid/".$rows[$i]['id']."/$sy/4"; ?>' ><?php echo $prevsy_code; ?></a> | 
	<?php endif; ?>		
	<a href='<?php echo URL."spiral/crid/".$rows[$i]['id']."/$sy/$qtr"; ?>' >Sprl</a>
</td>
<td>
	<?php if($is_dual): ?>
		<a href='<?php echo URL."summarizers/genave/".$rows[$i]['id']."/$sy/4"; ?>' ><?php echo $prevsy_code; ?></a> | 
	<?php endif; ?>		
	<a href='<?php echo URL."summarizers/genave/".$rows[$i]['id']."/$sy/$qtr"; ?>' >Smzr</a>
</td>

<td>
<?php if($rows[$i]['level_id']<14): ?>
<?php if($is_dual): ?>
	<a href='<?php echo URL."rcards/crid/".$rows[$i]['id']."/$prevsy/4?tpl=".$rows[$i]['department_id']; ?>' ><?php echo $prevsy; ?></a> | 
<?php endif; ?>		

	<a href='<?php echo URL."rcards/crid/".$rows[$i]['id']."/$sy/$qtr?tpl=".$rows[$i]['department_id']; ?>' >	
		Card </a><?php echo "(".$rows[$i]['num_students'].")"; ?>
<?php else: ?>
	<?php 
		$half=($qtr<3)?1:2;
	?>
<?php if($is_dual): ?>
	<a href='<?php echo URL."srcards/crid/".$rows[$i]['id']."/$prevsy/4/2"; ?>' ><?php echo $prevsy; ?></a>	| 
<?php endif; ?>			
	<a href='<?php echo URL."srcards/crid/".$rows[$i]['id']."/$sy/$qtr/$half"; ?>' >	
		Cards </a><?php echo "(".$rows[$i]['num_students'].")"; ?>
<?php endif; ?>
</td>


<td><?php echo $rows[$i]['crid']; ?></td>
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


