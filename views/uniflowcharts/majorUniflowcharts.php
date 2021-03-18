<style>

.col1,.col2{ float:left; width:300px;  }
.bordered{ border:1px solid white; min-height:160px; }
.tfont tr td { font-size:0.8em; }

</style>

<h5>
	Flowchart - <?php echo $major['name'].' #'.$major['id']; ?> | <?php $this->shovel('homelinks','College'); ?>
	| <a href="<?php echo URL.'uniflowcharts/batch/'.$major_id; ?>" >Create</a>
	| <a href="<?php echo URL.'uniflowcharts'; ?>" >Flowcharts</a>
	| <a href="<?php echo URL.'uniflowcharts/reset'; ?>" >Reset</a>
	| <a href="<?php echo URL.'uniflowcharts/sync/'.$major_id; ?>" >Sync</a>
	
</h5>

<p>
Sxns: <?php foreach($crids_array AS $row): ?>
	<a href="<?php echo URL.'uniclassrooms/courses/'.$row['crid']; ?>" ><?php echo $row['sxncode']; ?></a>&nbsp;
<?php endforeach; ?>
| Majors: 
<?php foreach($majors AS $row): ?>
	<a href="<?php echo URL.'uniflowcharts/major/'.$row['id']; ?>" ><?php echo $row['code']; ?></a>&nbsp;
<?php endforeach; ?>

</p>


<?php 
// pr($rows[1]); 
?>

<?php for($i=1;$i<=$years;$i++): ?>
<div class="clear" ><h5>Year <?php echo $i; ?></h5></div>

<div class="col1 bordered" >
	<?php $recs=($rows[$i][1]); ?>	
	<table class="gis-table-bordered tfont" >
		<tr><th colspan=3 >First Semester</th></tr>
		<tr><th>Code</th><th>Subject</th><th>Units</th></tr>
		<?php foreach($recs AS $rec): ?>
			<tr>
				<td><?php echo $rec['code']; ?></td>
				<td><?php echo $rec['subject']; ?></td>
				<td class="center" ><?php echo $rec['units']+0; ?></td>
			</tr>
		<?php endforeach; ?>
	</table>
	
	
</div>

<div class="col2 bordered" >
	<?php $recs=($rows[$i][2]);	?>	
	<table class="gis-table-bordered tfont" >
		<tr><th colspan=3 >Second Semester</th></tr>
		<tr><th>Code</th><th>Subject</th><th>Units</th></tr>			
		<?php foreach($recs AS $rec): ?>
			<tr>
				<td><?php echo $rec['code']; ?></td>
				<td><?php echo $rec['subject']; ?></td>
				<td class="center" ><?php echo $rec['units']+0; ?></td>
			</tr>
		<?php endforeach; ?>
	</table>
	
	
</div>

<?php endfor; ?>