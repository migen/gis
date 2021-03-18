<h5>Patrons Library Statistics
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				


<?php 


?>


| Months - 
<?php for($i=1;$i<13;$i++): ?>
<?php $ipad=str_pad($i,2,'0',STR_PAD_LEFT)?>
	<?php if($moidno!=$i): ?>
		<a href='<?php echo URL."lib/stats/$i"; ?>' ><?php echo $ipad; ?></a> &nbsp;&nbsp;
	<?php endif; ?>
<?php endfor; ?>

</h5>



<h5><?php echo $rmonth['name'].' SY'.$_SESSION['sy'].' - '.($_SESSION['sy']+1); ?></h5>
<table class="gis-table-bordered table-fx table-altrow" >
<tr>
	<th>Level</th>
	<?php foreach($days AS $row): ?>
		<th><?php echo $row['day']; ?>
			<?php $dayno=str_pad($row['day'],2,'0',STR_PAD_LEFT); ?>
			<span class="screen" ><a href="<?php echo URL.'lib/updatePatronStatsDaily/'.$year.'-'.$moid.'-'.$dayno; ?>" >UD</a></span>
		</th>
	<?php endforeach; ?>
	<th>Total</th>
	<td><a href="<?php echo URL.'lib/updateLvlPatronStatsLoopLevels/'.$moid; ?>" >All Students</a></td>
</tr>

<?php $j=0; ?>
<?php foreach($rows AS $row): ?>
<tr>
	<td><?php echo $row['level']; ?></td>
	<?php for($i=1;$i<=$numdays;$i++): ?>
		<td><?php echo $row[$i]; ?></td>
	<?php endfor; ?>
	<td><?php echo $row['total']; ?></td>
	<td>
	<?php if($j==0): ?>
		<a href="<?php echo URL.'lib/updateLvlPatronStatsEmployees/'.$row['lvl'].DS.$moid; ?>" >Employees</a>	
	<?php else: ?>
		<a href="<?php echo URL.'lib/updateLvlPatronStats/'.$row['lvl'].DS.$moid; ?>" >Update</a>	
	<?php endif; ?>
	</td>	
</tr>
<?php $j++; ?>
<?php endforeach; ?>




</table>
