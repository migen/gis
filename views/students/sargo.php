
<?php 

// pr($data);

?>


<?php




?>


<div id='hidden' class='invisible onscreen'>
<h5>Candy - Gradebook 
	<a href="<?php echo URL.$home; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>					
	| <a href='<?php echo URL."$home/submissions/$crid/$sy/$qtr"; ?>'  >Submissions</a> &nbsp; 
	
	
</h5>
</div> 	<!-- navigation-hidden -->


<!------------------------------------------------------------------------------------->


<?php

for($i=0;$i<$num_students;$i++):			// per row or student in the class
	

	$student = $students[$i];
	$grades  = $students[$i]['grades'];

	ob_start();	

?>

<div class="clear" > <!-- 1 student start -->

<div id='printable'> <!-- 2 print -->
	
<div id='creport'>	<!-- 3 @media_print #reportcard -->  <!-- 2 creport  -->



<h5>Report Card</h5>

<table class='gis-table-bordered table-fx'>
<tr><th class='vc150 headrow'>ID Number</th><td class="vc300" ><?php echo $student['student_code']; ?></td></tr>
<tr><th  class='headrow'>Student</th><td><?php echo $student['student']; ?></td></tr>
<tr><th class='headrow'>Level - Section </th><td><?php echo $classroom['level'].' - '.$classroom['section']; ?></td></tr>
<tr><th class='headrow'>SY | Quarter</th><td><?php echo $sy.' - '.($sy+1); ?> | <?php echo 'Q'.$qtr.' - '; echo ($is_locked)? 'Finalized':'Open'; ?></td></tr>
</table>
<br />

<h5 class='brown1'>Academics</h5>
<table class='gis-table-bordered table-fx'>
<tr class='headrow'>
	<th class="vc200" >Subject</th><th class="center" >Q1</th><th class="center" >Q2</th>
	<th class="center" >Q3</th><th class="center" >Q4</th><th class="center" >FG</th>
	<th>Teacher</th>
</tr>


<?php foreach($grades as $grade): ?>
<tr><td><?php echo $grade['subject']; ?></td>
	<td><?php echo ($grade['q1'] != 0)? number_format($grade['q1'],GDECI) : ' ' ; ?></td>
	<td><?php echo ($grade['q2'] != 0)? number_format($grade['q2'],GDECI) : ' ' ; ?></td>
	<td><?php echo ($grade['q3'] != 0)? number_format($grade['q3'],GDECI) : ' ' ; ?></td>
	<td><?php echo ($grade['q4'] != 0)? number_format($grade['q4'],GDECI) : ' ' ; ?></td>
	<td><?php echo ($grade['q5'] != 0)? number_format($grade['q5'],FGDECI) : ' ' ; ?></td>
	<td><?php echo $grade['teacher']; ?></td>
</tr>
<?php endforeach; ?>

</table>



</div>	<!-- 3-close @media_print #reportcard 2 close creport -->

</div> 	<!-- 2-close per student wrapper -->

<!---------------------------------------------------------------------------------------------------------------->

<p class='pagebreak'>&nbsp; </p>

<!---------------------------------------------------------------------------------------------------------------->

<?php
	
	$ob = "ob$i";
	$$ob = ob_get_clean();
	ob_flush();
?>	
	
<?php endfor; ?>		<!-- end of all students -->


<?php

 
for($j=0;$j<$num_students;$j++){
	$ob = "ob$j";
	echo $$ob;
	echo "<hr />";

}	
 

?>



<div class='clear'>&nbsp;</div>


</div>   <!--   1 close printable  -->

