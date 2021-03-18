<?php 
	$sqtr=$_SESSION['qtr'];
?>

<h5>

	Annual Quarterly Attendance
	| <?php $this->shovel('homelinks'); ?>
	| <a class="u" id="btnExport" >Excel</a> 
	| <a href='<?php echo URL."attendance/quarterly/$crid/$sy/$sqtr"; ?>' >Q<?php echo $sqtr; ?></a>
	| <span class="u" onclick="traceshd();" >SHD</span>
	| <a href='<?php echo URL."conducts/annual/$crid/$sy"; ?>' >Conducts</a>
	
</h5>


<table class="" >

</table>


<?php 

// pr($data);
// pr($cr);
?>

<h4><?php echo $cr['name'].' - '.$cr['adviser']; ?></h4>

<table id="tblExport" class="gis-table-bordered table-altrow" >
<tr>
	<th></th>
	<th colspan=2 class="shd" ></th>
	<th></th>
	<th></th>
	<th>Q1</th>
	<th>Q2</th>
	<th>Q3</th>
	<th>Q4</th>
	<th>Total</th>
	
</tr>
<tr>
	<th>#</th>
	<th class="left shd" >Scid</th>
	<th class="left shd" >ID No</th>
	<th class="left" >Student</th>
	<th class="left" >Max</th>
	<th><?php echo ($attmos['q1_days_total']+0); ?></th>
	<th><?php echo ($attmos['q2_days_total']+0); ?></th>
	<th><?php echo ($attmos['q3_days_total']+0); ?></th>
	<th><?php echo ($attmos['q4_days_total']+0); ?></th>
	<th><?php echo ($attmos['q5_days_total']+0); ?></th>

</tr>


<?php for($i=0;$i<$count;$i++): ?>
<tr class="center" >
	<td><?php echo $i+1; ?></td>
	<td class="left shd vc50" ><?php echo $rows[$i]['scid']; ?></td>
	<td class="left shd vc100" ><?php echo $rows[$i]['code']; ?></td>
	<td class="left" style="text-align:left;" ><?php echo $rows[$i]['student']; ?></td>
	<td class="left" >Present<br />Tardy</td>
	<td><?php echo ($rows[$i]['q1_days_present']+0).'<br />'.($rows[$i]['q1_days_tardy']+0); ?></td>
	<td><?php echo ($rows[$i]['q2_days_present']+0).'<br />'.($rows[$i]['q2_days_tardy']+0); ?></td>
	<td><?php echo ($rows[$i]['q3_days_present']+0).'<br />'.($rows[$i]['q3_days_tardy']+0); ?></td>
	<td><?php echo ($rows[$i]['q4_days_present']+0).'<br />'.($rows[$i]['q4_days_tardy']+0); ?></td>
	<td><?php echo ($rows[$i]['q5_days_present']+0).'<br />'.($rows[$i]['q5_days_tardy']+0); ?></td>

</tr>
<?php endfor; ?>
</table>


<div class="ht50" >&nbsp;</div>

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>

<script>
var gurl="http://<?php echo GURL; ?>";
$(function(){
	excel();
	shd();

})

</script>

