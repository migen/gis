<?php 
// pr($classroom);
// pr($classroom);




?>

<style>

	.utdh{ border-bottom:1px solid black; }
	.white-underline{ border-bottom:hidden; }
	

</style>


<table class="no-gis-table-bordered-print <?php echo $headerfont.' '.$tblwidth; ?>">
	<tr><td style="font-size: 20px; " class="center" colspan="5" class=''><b><?php echo $student['student']; ?></b></td></tr>
</table>

<table class="no-gis-table-bordered-print <?php echo $headerfont.' '.$tblwidth; ?>">
	<tr>
		<td class="vcid" >LRN</td>
		<td class="utdh" ><?php echo $student['lrn']; ?></td>
		<td class="vc30 utdh" >&nbsp;</td>
		<td class="vcid" >ID Number</td>
		<td class="utdh"  ><?php echo $student['student_code']; ?></td>		
	</tr>
	
	<tr>
		<td class="vcid" >Birthdate</td>
		<td class="utdh" ><?php echo date("m-d-Y",strtotime($student['birthdate'])); ?></td>
		<th class="vc30" >&nbsp;  </th>		
		<td style="border-bottom:1px solid white;" >Sex</td>
		<td class="utdh" ><?php echo ($student['is_male'])? 'M':'F'; ?></td>	
	</tr>
	<tr><td class="vcid" >Grade & Sec</td>
		<td class="utdh" colspan="4" >
			<span class="" ><?php echo $student['level'].' - '.$student['section']; ?></span>
		</td></tr>
	<tr><td class="vcid" >Adviser</td><td colspan="4" class="utdh" ><?php echo $classroom['adviser']; ?></td></tr>	
</table>
<br />