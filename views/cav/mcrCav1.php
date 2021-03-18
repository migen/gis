<?php 
	$size=isset($_GET['size'])? $_GET['size']:1; 
	$sqtr=$_SESSION['qtr'];$current=($sqtr==$qtr)? true:false;
	$traits_value_dg=isset($_GET['value'])? $_GET['value']:$_SESSION['settings']['traits_value_dg'];
	
		


?>


<style>
	.cricol {width:60px;font-size:0.8em; word-wrap:break-word;}
	.tblFont{ font-size:<?php echo $size; ?>em; }

</style>



<h5 class="screen" >
	STD CAV MCR (<?php echo $count; ?>)	
	| <?php $this->shovel('homelinks'); ?>
	| <span class="u" onclick="traceshd();" >SHD</span>
	| Status <?php echo ($is_locked)? '(Closed)':'(Open)'; ?>
	| <a class="u" id="btnExport" >Excel</a> 

	<?php if($_SESSION['srid']==RMIS): ?> | 
		<?php if($is_locked): ?>
			<a href="<?php echo URL.'finalizers/openCourse/'.$crid.DS.$crs.DS.$sy.DS.$qtr; ?>" >Unlock</a>
		<?php else: ?>
			<a href="<?php echo URL.'finalizers/closeCourse/'.$crid.DS.$crs.DS.$sy.DS.$qtr; ?>" >Lock</a>			
		<?php endif; ?>	
	<?php endif; ?>	
	
	| <a href='<?php echo URL."cav/traits/$crs/$sy/$sqtr"; ?>' >Traits</a>								
	| <a href='<?php echo URL."cav/mcr/$crid/$sy/$sqtr"; ?>' >Current</a>							
	<?php if($value<2): ?>
		<?php if($value==1): ?>
		| <a href='<?php echo URL."cav/mcr/$crid/$sy/$qtr"; ?>' >Num</a>		
		<?php else: ?>
		| <a href='<?php echo URL."cav/mcr/$crid/$sy/$qtr?value=1&size=$size"; ?>' >DG</a>				
		<?php endif; ?>
		| <a href='<?php echo URL."cav/mcr/$crid/$sy/$qtr?value=2"; ?>' >N/DG</a>						
	<?php else: ?>
		| <a href='<?php echo URL."cav/mcr/$crid/$sy/$qtr"; ?>' >Num</a>
		| <a href='<?php echo URL."cav/mcr/$crid/$sy/$qtr?value=1&size=$size"; ?>' >DG</a>	
	<?php endif; ?>
	
	<?php if(isset($critype_id)): ?>
		| <a href='<?php echo URL."cav/mcr/$crid/$sy/$qtr?value={$traits_value_dg}"; ?>' >CavMatrix</a>	
	<?php endif; ?>
<form method="GET" style="display:inline;" action="&value=<?php echo $value; ?>" >	
	| Size <input class="center vc50" id="size" name="size" value="<?php echo (isset($_GET['size']))? $_GET['size']:1; ?>"  />
		<input type="submit" name="submit" value="Go" >	
</form>	
		
</h5>

<?php 
	$lvl=$course['level_id'];
	$qtrsem=($qtr>2)? "2nd Semester":"1st Semester";
	
	if($lvl==1){ $semqtr="SY$sy - $qtrsem"; } else {
		$semqtr="SY$sy-Q$qtr";
	}

?>
<?php $d['page']="Traits Summary - $semqtr "; ?>
<div class="center clear"  ><?php $this->shovel('letterhead_logo_datetime',$d); ?></div>


<table id="tblExport" class="gis-table-bordered tblFont" >
<tr>
<th colspan=3><?php echo '#'.$course['name'].'- #'.$course['tcid'].'-'.$course['teacher']; ?></th>
<?php foreach($critypes AS $row): ?>	
	<?php $numtrs=$row['num']; ?>
	<?php $critype_id=$row['critype_id']; ?>
	<th class="center" colspan="<?php echo $row['num']; ?>" ><?php echo $row['critype']; ?>
		<a href='<?php echo URL."cav/mcrByCritype/$crid/$critype_id/$sy/$qtr&value={$traits_value_dg}"; ?>' ><?php echo "({$numtrs})"; ?></a>
	</th>	
	
<?php endforeach; ?>
<th class="shd" ></th>
</tr>

<tr><td colspan=3></td><?php for($k=0;$k<$num_criteria;$k++): ?><td class="center" ><?php echo $k+1; ?></td><?php endfor; ?>

</tr>

<tr>
	<th>#</th>
	<th><div class="vc250" >Student</div></th>
	<th>Qtr</th>
<?php if($current && !$is_locked): ?>
	<?php for($j=0;$j<$num_criteria;$j++): ?>
	<td><div class="cricol" ><?php echo $criteria[$j]['criteria']; ?><br />
		<?php if($value!=1): ?>
			<a href="<?php echo URL.'cav/editColumn/'.$crs.DS.$criteria[$j]['criteria_id'].DS.$sy.DS.$qtr; ?>" >Edit</a>		
		<?php else: ?>
			<a href="<?php echo URL.'cav/editColumnDG/'.$crs.DS.$criteria[$j]['criteria_id'].DS.$sy.DS.$qtr; ?>" >Edit</a>		
		<?php endif; ?>
	</div></td>
	<?php endfor; ?>
<?php else: ?>
	<?php for($j=0;$j<$num_criteria;$j++): ?>
	<td><div class="cricol" ><?php echo $criteria[$j]['criteria']; ?></div></td>
	<?php endfor; ?>
<?php endif; ?>

<th class="shd" >Scid</th>
</tr>


<?php for($i=0;$i<$count;$i++): ?>	<!-- numstud -->
	<?php for($iq=1;$iq<=$numqtr;$iq++): ?>	<!-- numqtr -->
		<tr>
			<td><?php echo ($iq==1)? ($i+1):NULL; ?></td>
			<td><?php echo ($iq==1)? ($rows[$i]['student']):NULL; ?></td>
			<td><?php echo $iq; ?></td>		
			<?php for($j=0;$j<$num_criteria;$j++): ?>
				<td class="center" ><?php echo ($cavs[$i][$j]['q'.$iq]+0).'<br />'.$cavs[$i][$j]['dg'.$iq]; ?></td>
			<?php endfor; ?>			
			<td class="shd" ><?php echo $rows[$i]['scid']; ?></td>			
		</tr>
	<?php endfor; ?> <!-- numqtr -->
<?php endfor; ?> <!-- numstud -->
	
	
</table>


<?php 
$principal=$_SESSION['settings']['school_principal'];
$vice_principal=$_SESSION['settings']['school_principal_ps'];
?>
<br />
<div class="ht100" >


<style>
.table-signatories{ table-layout:fixed; }


</style>



</div>


<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>
<script>
var gurl="http://<?php echo GURL; ?>";
$(function(){
	shd();
	excel();

})

</script>


