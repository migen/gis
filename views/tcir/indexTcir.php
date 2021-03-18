<?php 

// $attdlink=($_SESSION['settings']['attd_qtr']==1)? 'attdQtr':'attd';
$attdlink=($_SESSION['settings']['attd_qtr']==1)? 'quarterly':'monthly';
// pr($attdlink);
// pr($classrooms[62]);


?>

<h5 class="screen" >
	THead CIR (CIR-<?php echo $count; ?>)
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





<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th>Classroom</th>
	<th>Crid</th>
	<th>Roster</th>
	<th>Loads</th>
	<th>Grades</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="vc150" ><?php echo $classrooms[$i]['classroom']; ?>
		<?php echo ($classrooms[$i]['level_id']>13)? '('.$classrooms[$i]['num'].')':NULL; ?>	
	</td>
	<td><?php echo $classrooms[$i]['crid']; ?></td>
<td><a href='<?php echo URL."thead/roster/".$classrooms[$i]['id']."/$sy"; ?>' >Roster</a></td>
<td><a href='<?php echo URL."loads/cls/".$classrooms[$i]['id']; ?>' >Loads</a></td>
<td><a href='<?php echo URL."matrix/grades/".$classrooms[$i]['id']."/$sy/$qtr"; ?>' >Matrix</a></td>

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


