
<?php 
$sy_enrollment=$_SESSION['settings']['sy_enrollment'];
?>

<table class="misdata accordion gis-table-bordered table-altrow" >
	<tr><th class="accorHeadrow" onclick="accordionTable('misdata');" >MIS Data</th></tr>


	<tr><td style="width:250px;" ><a href="<?php echo URL.'cir'; ?>" ></a></td></tr>
	<tr><td><a href="<?php echo URL.'gset/classrooms/'.$sy_enrollment.'?all'; ?>" >Classrooms</a></td></tr>

</table>



