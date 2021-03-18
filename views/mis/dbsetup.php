<?php 

// pr($data);




?>


<h5>
	DB Setup
	| <a href='<?php echo URL."setup/grading";  ?>' > Setup</a>		
	| <a href='<?php echo URL."$home/dbpanel/dbgis_".VCFOLDER; ?>' >DB Panel</a>
</h5>


<div class="clear" >
<form method="POST" >

<!-- 
	<p><input id="dbnew" class="pdl05" type="text" name="dbnew" placeholder="Create DB"  /> &nbsp; <input onclick="return dbnewConfirm();"  type="submit" name="dbcreate" value="Create DB" ></p>
-->

<table class="gis-table-bordered table-fx table-altrow" >
<tr><th>DB1: FROM </th><td>
<select name="dbone" >
	<option><?php echo isset($_SESSION['mis']['dbsetup']['dbone'])? $_SESSION['mis']['dbsetup']['dbone']:'Choose one'; ?></option>
	<?php foreach($databases AS $val): ?>
		<option><?php echo $val; ?></option>
	<?php endforeach; ?>
</select>
</td></tr>
<tr><th>DB2: TO </th><td>
<select name="dbtwo" >
	<option><?php echo isset($_SESSION['mis']['dbsetup']['dbtwo'])? $_SESSION['mis']['dbsetup']['dbtwo']:'Choose one'; ?></option>
	<?php foreach($databases AS $val): ?>
		<option><?php echo $val; ?></option>
	<?php endforeach; ?>
</select>
</td></tr>

<tr><td colspan="2" ><input type="submit" name="submit" value="DB Info"  /></td></tr>

</table>

</form>
</div>


<!----------------------------------------------------------------------------->

<?php if(@!$dbone || !$dbtwo) exit; ?>
<hr />

<div class="half"  >
<h4>DB1: Source - 
	<?php if(isset($dbone)): ?>
		<a href='<?php echo URL."$home/dbpanel/$dbone"; ?>' ><?php echo $dbone; ?> </a>
		&nbsp; | &nbsp; <a class="button" onclick="xdiffAll();" >Differences</a>
	<?php endif; ?>	
</h4>
<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" ><th>#</th><th>Table</th><th>Last IDs</th><th>Counts</th><th>Axn</th><th>Diff</th><th>Backup<br />HDB</th></tr>
<?php if($onetables): ?>
	<?php for($i=0;$i<$num_onetables;$i++): ?>
		<?php $tbl = $dbonetables[$i]; ?>
		<tr class="row" id="<?php echo $i; ?>" >
			<td><?php echo $i+1; ?></td>
			<td><?php echo $tbl; ?></td>
		
			<td><?php $v = isset($_SESSION['mis'][$dbone]['lasts'][$tbl])? $_SESSION['mis'][$dbone]['lasts'][$tbl]: ''; echo round($v); ?></td>
			<td id="ct1-<?php echo $i;?>" ><?php $v = isset($_SESSION['mis'][$dbone]['counts'][$tbl])? $_SESSION['mis'][$dbone]['counts'][$tbl]: ''; echo round($v);  ?></td>
			
			<td>  
				<a class="button" onclick="xdiff(<?php echo $i; ?>);return false;"  >Diff</a>
			</td>			
			<td id="diff-<?php echo $i;?>" > </td>
			
			<td>

				<a onclick="return confirm('You sure?');" href='<?php echo URL."$home/tableBackup/$dbone/$dbtwo/$tbl"; ?>'  > Backup </a>
			
			</td>
		</tr>
	<?php endfor; ?>
	
<?php endif; ?>



</table>

</div>

<div class="third"  >
<h4>DB2: Destination - 
	<a href='<?php echo URL."$home/dbpanel/$dbtwo"; ?>' ><?php echo isset($dbtwo)? $dbtwo:''; ?> </a>
</h4>
<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" ><th>#</th><th>Table</th><th>Last IDs</th><th>Counts</th></tr>
<?php if($twotables): ?>
	<?php for($i=0;$i<$num_twotables;$i++): ?>
		<?php $tbl = $twotables[$i]['table']; ?>
		<tr>
			<td><?php echo $i+1; ?></td>
			<td><?php echo $tbl; ?></td>
		
			<td><?php echo isset($_SESSION['mis'][$dbtwo]['lasts'][$tbl])? $_SESSION['mis'][$dbtwo]['lasts'][$tbl]: ''; ?></td>
			<td id="ct2-<?php echo $i;?>" ><?php echo isset($_SESSION['mis'][$dbtwo]['counts'][$tbl])? $_SESSION['mis'][$dbtwo]['counts'][$tbl]: ''; ?></td>
		</tr>
	<?php endfor; ?>
<?php endif; ?>

</table>

</div>

<!---------------------------------------------------------------------------->


<script>

$(function(){
	
});




</script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/mis.js"></script>

