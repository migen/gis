<?php 
	$dbyr=DBYR;
	$sqtr=$_SESSION['qtr'];
?>

<h5>
	Crs Copier
	| <?php $this->shovel('homelinks'); ?>
	| <a href='<?php echo URL."teachers/scores/$crs/$dbyr/$sqtr"; ?>' >Scores</a>
	| <a href='<?php echo URL."teachers/grades/$crs/$dbyr/$sqtr"; ?>' >Grades</a>
	| <a href='<?php echo URL."conducts/records/$crs/$dbyr/$sqtr"; ?>' >Conducts</a>
		
</h5>

<p class="brow" >
* Q5 is the average (Q1 to Q4), but if Semestral then Q5 is the average for Sem1 (ave of Q1 and Q2),  
while Q6 is the average for Sem2 (ave of Q3 and Q4),  
</p>


<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr>
	<th>From <input class="vc50" type="number" name="src" value="" ></th>
	<th>To <input class="vc50" type="number" name="dest" value="" ></th>
	<th><input type="submit" name="submit" value="Copy" onclick="return confirm('Sure?');"  /></th>
</tr>
</table>
</form>

<br />
<table class="gis-table-bordered table-altrow table-center" >
<tr>
<th>#</th>
<th class="left" >Scid</th>
<th class="left" >Student</th>
<th>Q1</th>
<th>Q2</th>
<th>Q3</th>
<th>Q4</th>
<th>Q5</th>
<th>Q6</th>

</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td class="left" ><?php echo $rows[$i]['student']; ?></td>
	<td><?php echo round($rows[$i]['q1']).'<br />'.$rows[$i]['dg1'];  ?></td>
	<td><?php echo round($rows[$i]['q2']).'<br />'.$rows[$i]['dg2'];  ?></td>
	<td><?php echo round($rows[$i]['q3']).'<br />'.$rows[$i]['dg3'];  ?></td>
	<td><?php echo round($rows[$i]['q4']).'<br />'.$rows[$i]['dg4'];  ?></td>
	<td><?php echo round($rows[$i]['q5']).'<br />'.$rows[$i]['dg5'];  ?></td>
	<td><?php echo round($rows[$i]['q6']).'<br />'.$rows[$i]['dg6'];  ?></td>	
</tr>
<?php endfor; ?>
</table>

<div class="clear ht50" ></div>

<script></script>
