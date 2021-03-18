<?php 
$logo_src = URL."public/images/weblogo_".VCFOLDER.".png";



?>

<h5 class="screen" >
	Honors Report - <?php echo $cr['name']; ?> (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'lir'; ?>" >L I R</a>	
	| <span class="u" onclick="pclass('hd');" >ID Number</span>
	| <a href="<?php echo URL.'honors/level/'.$cr['level_id'].'?num=1'; ?>" >Level</a>
	| <a href="<?php echo URL.'honors/process/'.$crid; ?>" >Process</a>
	

</h5>
<style>
	.header {
		margin:auto;
		display: flex;
		text-align: center;
	}
	.school_logo {
		margin-top:10px;
		margin-left: 80px;
	}
	.school{
		margin-left: 30px;
		text-align:center;
	}
	.school_name {
		font-size: 23px;
		font-weight: bold;
	}
	.school_address {
		font-size: 17px;
	}
	.head_desc {
		text-transform: uppercase;
		font-size: 18px;
	}
	.reports-honors{
		margin: auto;
		text-align: center;
		width: 600px;
	}
	thead th {
		padding: 10px;
		border-bottom: 1px solid;
	}
	.tr-data td {
		padding: 3px;
	}
</style>
<div class="reports-honors">
	<div class="header">
		<div class="school_logo">
			<img class="school-img-logo" src="<?php echo $logo_src; ?>" alt="logo" height="100" width="100">
		</div>
		<div class="school">
			<p>
				<span class="school_name"><?php echo $_SESSION['settings']['school_name']; ?></span><br>
				<span class="school_address"><?php echo $_SESSION['settings']['school_address']; ?></span><br>
				<span class="yrsec"><span class="" ><?php echo $cr['level'].' - '.$cr['section']; ?></span>	</span><br>
				<span>Honor List</span><br>
				<span><?php echo 'SY' . $sy.'-'.($sy+1) . ' Q'. $qtr; ?></span>
			</p>
		</div>
	</div>
	<hr>
	<table>
		<thead>
			<tr>
				<th class="center" width="300">Student</th>
				<th class="center" width="200">General Average</th>
				<th class="center" width="50">Honor</th>
			</tr>
		</thead>
		<tbody>
			<?php for($i=0;$i<$count;$i++): ?>
			<tr class="tr-data">
				<td><?php echo $rows[$i]['student']; ?></td>
				<td class="center"><?php echo $rows[$i]['genave']; ?></td>
				<td class="center"><?php echo ($rows[$i]['honor']+0); ?></td>
			</tr>
			<?php endfor; ?>
		</tbody>
	</table>
</div>

<!-- <table class="gis-table-bordered table-altrow" >
<tr>
<th>#</th>
<th class="hd" >Scid</th>
<th class="hd" >ID No.</th>
<th>Student</th>
<th>Genave</th>
<th>Honor</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="hd" ><?php echo $rows[$i]['scid']; ?></td>
	<td class="hd" ><?php echo $rows[$i]['studcode']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td><?php echo $rows[$i]['genave']; ?></td>
	<td class="center" ><?php echo ($rows[$i]['honor']+0); ?></td>
</tr>
<?php endfor; ?>
</table> -->




