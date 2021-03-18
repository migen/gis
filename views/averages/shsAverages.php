<h5>
	SHS Averages
	| <?php $this->shovel('homelinks'); ?>
	
	
</h5>

<?php 

// pr($data);

$decicard=$_SESSION['settings']['decicard'];
$deciave=$_SESSION['settings']['deciave'];


?>

<h4>*For SHS Levels (id#14 to id#15) </h4>

<form method="POST" >
<table class="gis-table-bordered table-altrow" >
<tr><th>Decimal for Subjects: </th>
<th><input type="number" class="vc50 center" name="decicard" value="<?php echo $decicard; ?>" ></th></tr>
<tr><th>Decimal for Averages (Q5): </th>
<th><input type="number" class="vc50 center" name="deciave" value="<?php echo $deciave; ?>" ></th></tr>
<tr><th colspan=2 ><input type="submit" name="submit" value="Process!" ></th></tr>

</table>
</form>
