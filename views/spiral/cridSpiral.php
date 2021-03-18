<?php 
	// unset($data['grades']);
	// unset($data['count']);
	// unset($data['rows']);
	// pr($data);
	
?>

<style>


</style>

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>

<h5>
	Spiral Grid View (<?php echo $classroom['name'].' - '.$count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <a class="u" id="btnExport" >Excel</a> 
	| <span onclick="traceshd();" class="blue u" >ID</span>
	<?php if($_SESSION['srid']==RMIS): ?>
		| <a href="<?php echo URL.'classrooms/courses/'.$crid; ?>" >Crs</a>
	<?php endif; ?>
	| &qtr=<?php echo $qtr; ?>
	
</h5>
<p class="brown" >* Click on corresponding -X- column -AND- Re-Tally Aggregates if any 
<span class="red b">Red Grades</span> appear.
<br />** Then re-check Summarizer before printing report cards.
</p>

<?php 
	$decicard=isset($_GET['decicard'])? $_GET['decicard']:$_SESSION['settings']['decicard'];
?>

<table id="tblExport" class="gis-table-bordered table-altrow table-fx table-fx-columns" >
<tr class="center headrow" ><th>#</th><th class="shd" >Scid</th><th style="text-align:left;" >Student</th>
<?php 
	for($i=0;$i<$num_groups;$i++):
		for($j=0;$j<$numsub[$i];$j++):
?>
<th><a href="<?php echo URL.'teachers/grades/'.$groups[$i][$j]['crs'].DS.$sy.DS.$qtr; ?>"><?php echo $groups[$i][$j]['code']; ?></a>

	<br /><?php echo $groups[$i][$j]['wt'].'%'; ?></th>
<?php 	endfor; ?>	<!-- subgroups -->
	<th><a href="<?php echo URL.'aggregates/tally/'.$crid.DS.$groups[$i][$j]['crs'].DS.$groups[$i][$j]['subject_id']; ?>" >
		<?php echo $groups[$i][$j]['code']; ?></a></th>
	<th><a href="<?php echo URL.'aggregates/tally/'.$crid.DS.$groups[$i][$j]['crs'].DS.$groups[$i][$j]['subject_id']; ?>" >
		<span class="red" >-x-</span></a></th>
<?php endfor; ?>	<!-- groups -->
</tr>

<?php for($r=0;$r<$count;$r++): ?>
<tr class="center" >
	<td><?php echo $r+1; ?></td>
	<td class="shd" ><?php echo $rows[$r]['scid']; ?></td>
	<td style="text-align:left;" ><?php echo $rows[$r]['name']; ?></td>
<?php 
	for($i=0;$i<$num_groups;$i++):
		$ave=0;
		for($j=0;$j<$numsub[$i];$j++):
			$grade=number_format($grades[$i][$j][$r]['grade'],$decicard);
			$wt=$grades[$i][$j][$r]['wt'];
			$wt=($wt<100)? $wt:100/$numsub[$i]; 
			$wt=number_format($wt,2);
			$ave+=$grade*($wt/100);			
			echo "<td>{$grade}</td>";			
		endfor;
			$grade=number_format($grades[$i][$j][$r]['grade'],$decicard);		
			// echo "i: $i, j: $j, r: $r <br />";
			echo "<th>{$grade}</th>";
			$ave = number_format($ave,$decicard);								
			$val=($grade==$ave)? NULL:$ave;
			echo "<td class='red' >".$val."</td>";
	endfor;
?>
</tr>
<?php endfor; ?>
</table>


<div class="ht100" ></div>

<script>
	var gurl     = "http://<?php echo GURL; ?>";
	$(function(){
		shd();
		excel();
		fxColumnHighlighting();

	})

</script>
