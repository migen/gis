<?php 
$loops=array(
	array('copy'=>'Parent\'s copy'),
	array('copy'=>'LSM copy'),
);



?>

<?php for($i=0;$i<2;$i++): ?>

<h5 class="center" >ACKNOWLEDGEMENT OF RESERVATION</h5>

<div style="float:left; " >
<table class="gis-table-bordered" >
<tr><th>Student ID</th><td class="vc200" ><?php echo $student['studcode']; ?></td></tr>
<tr><th>Student</th><td><?php echo $student['studname']; ?></td></tr>
<tr><th>Grade Level</th><td><?php echo $student['level']; ?></td></tr>
</table>
</div>

<div style="float:left;width:20%;min-height:10px; " ></div>

<div style="float:left; " >
<table class="gis-table-bordered" >
<tr><td class="" ><?php echo $loops[$i]['copy']; ?></td></tr>
</table>
</div>

<div class="clear" ></div>

<p class="" >
Greetings of peace and all good! 
<br />
This is to confirm your reservation of 
<input style="border:none;width:60px;" value="5,000.00" > for enrollment of your son 
<span class="u" ><?php echo $student['studname']; ?></span> at Lourdes School of Mandaluyong. 
<br />
Please understand that this reservation fee is non-refundable and non-transferable but is deductible 
from the total fees upon enrolment.
<br />
Failure to enroll on or before the deadline shall mean forfeiture of your reserved slot for SY 
<?php echo ($_SESSION['sy']+1).' - '.($_SESSION['sy']+2); ?>
<p class="bordered" style="padding:3px 6px; " >
A student is considered officially enrolled only after payment of tuition fees in accordance with the chosen 
payment scheme and submission of all required documents.
</p>
<br />
I have read and fully understood the policies on reservation fees.
<br />
<br />

<table class="no-gis-table-bordered" >
<tr><td>_________________________________________</td>
<td style="width:200px;" ></td>
<td><?php echo $_SESSION['today']; ?></td>
</tr>

<tr><td>Parent's/Guardian's Signature Over Printed Name</td>
<td></td>
<td>Date</td>
</tr>

</table>

</p>

<?php if($i==0): ?><hr style="border-top: dotted 1px;" /><?php endif; ?>

<?php endfor; ?>








