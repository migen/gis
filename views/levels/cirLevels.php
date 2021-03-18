<h5>
	<?php echo $level['name']; ?> CIR
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'lir'; ?>" >L I R</a>
	

</h5>

<p><?php foreach($levels AS $sel): ?><a href="<?php echo URL.'levels/cir/'.$sel['id']; ?>" ><?php echo $sel['code']; ?></a>&nbsp;&nbsp;
	<?php endforeach; ?></p>

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
		<a target="blank" href="<?php echo URL.'registrars/classroom/'.$rows[$i]['crid']; ?>" >		
			<?php echo $rows[$i]['classroom']; ?></a>
		<?php echo ($rows[$i]['level_id']>13)? '('.$rows[$i]['num'].')':NULL; ?>	
	</td>
	<td><?php echo $rows[$i]['crid']; ?></td>
<td><a href='<?php echo URL."classlists/classroom/".$rows[$i]['id']."/$sy"; ?>' >List</a></td>
<td><a href='<?php echo URL."attendance/{$attdlink}/".$rows[$i]['id']."/$sy/$qtr"; ?>' >Q<?php echo $qtr; ?></a></td>
<td><a href='<?php echo URL."matrix/grades/".$rows[$i]['id']."/$sy/$qtr"; ?>' >Matrix</a></td>
<td>
	<a href='<?php echo URL."classrooms/courses/".$rows[$i]['id']; ?>' >Crs</a>
	| <a href='<?php echo URL."loads/cls/".$rows[$i]['id']; ?>' >Loads</a>

</td>
<td><a href='<?php echo URL."promotions/k12/".$rows[$i]['id']."/$sy"; ?>' >K12</a></td>
<td><a href='<?php echo URL."promotions/report/".$rows[$i]['id']."/$sy"; ?>' >Report</a></td>
<td>
	<a href='<?php echo URL."honors/records/".$rows[$i]['id']."/$sy/$qtr"; ?>' >Honors</a>
	| <a href='<?php echo URL."honors/clsmatrix/".$rows[$i]['id']."/$sy/$qtr"; ?>' >ClsMrx</a>
</td>
<td><a href='<?php echo URL."submissions/view/".$rows[$i]['id']."/$sy/$qtr"; ?>' >Submissions</a></td>
<td><a href='<?php echo URL."spiral/crid/".$rows[$i]['id']."/$sy/$qtr"; ?>' >Spiral</a></td>
<td><a href='<?php echo URL."summarizers/genave/".$rows[$i]['id']."/$sy/$qtr"; ?>' >Summarizer</a></td>
<td><a href='<?php echo URL."qcr/qcr/".$rows[$i]['id']."/$sy/$qtr"; ?>' >Rank</a></td>
<td><a href='<?php echo URL."rcards/crid/".$rows[$i]['id']."/$sy/$qtr?tpl=".$rows[$i]['department_id']; ?>' >
	Card</a></td>
<td><?php echo $rows[$i]['crid']; ?></td>

</tr>
<?php endfor; ?>


</table>