<?php

pr($data);

?>


<script>

var row,viewRow,editRow,newRow,i,cid,code,s,l,sec,active,rmk; 
var gurl = 'http://<?php echo GURL; ?>';


</script>

<h5>
	Dropouts |
	<a href="<?php echo URL; ?>registrars">Home</a> | 
	<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Back</a> | 	
	<a href="<?php echo URL; ?>registrars/dashboard">Dashboard</a> | 
	<a href="javascript:history.go(0)">Refresh</a>	
</h5>

<!-- -->

<form method="POST">

<p>
	<input class="pdl05 vc200" type="text" name="data[student_code]" placeholder="Student ID Number" />
	<input type="submit" name="submit" value="Search" />
</p>

</form>

<!-- -found student/s -->


<?php if(isset($data)): ?> 	<!-- if search data is posted -->
<table class="gis-table-bordered table-fx" >

<tr class="bg-blue2">
	<td>#</td>
	<td>ID Number</td>
	<td>Student</td>
	<td>Level</td>
	<td>Section</td>
	<td>1-Active<br />0-Inactive</td>
	<td>Remarks</td>
	<td>Action</td>
</tr>

<?php $i=1; ?>
<?php foreach($data['students'] AS $row): ?>
<tr id="row<?php echo $i; ?>" >
	<td><?php echo $i; ?></td>
	<td class="vc100" id="sc<?php echo $i; ?>" ><?php echo $row['student_code']; ?></td>
	<td class="vc150" id="s<?php echo $i; ?>" ><?php echo $row['student']; ?></td>
	<td id="l<?php echo $i; ?>" ><?php echo $row['level']; ?></td>
	<td class="vc100" id="sec<?php echo $i; ?>" >
		<a href="<?php echo URL.'sectioning/crid/'.$_SESSION['sy'].DS.$row['crid']; ?>" ><?php echo $row['section']; ?></a></td>
	<td id="active<?php echo $i; ?>" class="vc50 pdl05" ><?php echo $row['status']; ?></td>
	<td id="rmks<?php echo $i; ?>"  class="vc300 pdl05" ><?php echo ' '.$row['remarks']; ?></td>
	<td>
		<input type="submit" name="update" value="Update"  />
	
	</td>
	<input type="hidden" id="cid<?php echo $i; ?>" value="<?php echo $row['scid']; ?>" />
	
</tr>
<?php $i++; ?>
<?php endforeach; ?>
</table>
<?php endif; ?>	<!-- if search data is posted -->
