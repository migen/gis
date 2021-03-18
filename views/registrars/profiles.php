<!-- hyperlinks -->
<h5>
	Profiles |
	<a href="<?php echo URL; ?>registrars">Home</a> |
	<a href="<?php echo URL.'registrars/editProfiles/'.$crid; ?>" />Edit</a>	

	
	
</h5>

<?php



?>

<!--  =========   CR DETAILS BELOW =====================  -->

<?php $cr = $data['classroom'];  ?>
<table class='gis-table-bordered table-fx'>
	<tr><th class='white headrow'>Level</th><td><?php echo $cr['level']; ?></td></tr>
	<tr><th class='white headrow'>Section</th><td><?php echo $cr['section']; ?></td></tr>
</table>
<BR />
<!--  =========   PROFILES BELOW =====================  -->

<table class="gis-table-bordered table-fx ">
<!-- ======== row 1 ======= -->
<tr class='bg-blue2'>
	<th>#</th>
	<th class="vc100" >ID Number</th>
	<th class="vc300" >Student</th>
	<th class="vc100" >Actions</th>
</tr>

<?php $i=1; ?>
<?php foreach($data['students'] AS $row): ?>
<tr>
	<td><?php echo $i; ?></td>
	<td><?php echo $row['student_code']; ?></td>
	<td class="peek"><?php echo $row['student']; ?></td>
	<td class="hide hd<?php echo $row['scid']; ?>" ><p>Status: <?php echo ($row['is_active'] == 1)? 'Cleared' : 'Not cleared'; ?></p></td>
	<td class="hide hd<?php echo $row['scid']; ?>" ><p>First Name: <?php echo $row['first_name']; ?></p></td>
	<td class="hide hd<?php echo $row['scid']; ?>" ><p>Middle Name: <?php echo $row['middle_name']; ?></p></td>
	<td class="hide hd<?php echo $row['scid']; ?>" ><p>Last Name: <?php echo $row['last_name']; ?></p></td>
	<td class="hide hd<?php echo $row['scid']; ?>" ><p>Sms: <?php echo $row['sms']; ?></p></td>
	<td class="hide hd<?php echo $row['scid']; ?>" ><p>Email: <?php echo $row['email']; ?></p></td>
	
	<td class="hide hd<?php echo $row['scid']; ?>" ><p>Birthdate: <?php echo date('M d,Y',strtotime($row['birthdate'])); ?></p></td>
	<td class="hide hd<?php echo $row['scid']; ?>" ><p>Nationality: <?php echo $row['nationality']; ?></p></td>
	<td class="hide hd<?php echo $row['scid']; ?>" ><p>Religion: <?php echo $row['religion']; ?></p></td>
	<td class="hide hd<?php echo $row['scid']; ?>" ><p>Province: <?php echo $row['province']; ?></p></td>
	<td class="hide hd<?php echo $row['scid']; ?>" ><p>City: <?php echo $row['city']; ?></p></td>
	<td>
		<a class="blue" onclick="modalShow(<?php echo $row['scid']; ?>);return false;" ><u> View </u></a> | 
		<a href="<?php echo URL.'registrars/editProfile/'.$row['scid']; ?>" >Edit </a> |	
		<a href="<?php echo URL.'registrars/statuses/'.$row['scid']; ?>" > Statuses </a> 	
	</td>
	
</tr>

<?php $i++; ?>
<?php endforeach; ?>
</table>

<script>
	$(function(){
		hide();
	
	});
	

</script>


<div class="modal hide" id="modalDiv" >
</div>