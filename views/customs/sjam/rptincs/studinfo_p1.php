<style>
.vcid{ width:26%;}
</style>

<?php 
// pr($classroom);

?>


<table class="no-gis-table-bordered-print <?php echo $headerfont.' '.$tblwidth; ?>">
	<tr><td class="vcid" >Student's Name</td><td colspan="4" ><?php echo $student['student']; ?></td></tr>		
	
	<tr>
		<td class="vcid" >LRN</td><td class="" ><?php echo $student['lrn']; ?></td>
		<td class="vc30" >&nbsp;</td>		
		<td class="" >School Year</td><td class="" ><?php echo $sy.' - '.$nsy; ?></td>		
		
	</tr>

	
	<tr>
		<td class="vcid" >ID Number</td><td class="" ><?php echo $student['student_code']; ?></td>
		<td class="vc30" >&nbsp;</td>		
		<td class="" >Gender</td><td class="" ><?php echo ($student['is_male'])? 'Male':'Female'; ?></td>				
	</tr>

	<tr><td class="vcid" >Grade & Section &nbsp; </td>
		<td colspan=4><?php echo $classroom['level'].' - '.$classroom['section']; ?></td></tr>
	<tr><td>Adviser</td><td colspan="4" ><?php echo $classroom['adviser']; ?></td></tr>
</table>