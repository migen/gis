
<?php 


?>


<h5>
	Turnover Attendance SY<?php echo $sy; ?> (<?php echo $count; ?>)
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a class="u" id="btnExport" >Excel</a> 
	| <a href="<?php echo URL.'turnover/attd?sy='.$prevsy; ?>" ><?php echo $prevsy; ?></a>
		
</h5>


<table id="tblExport" class="gis-table-bordered table-fx" >

<tr>
	<th>#</th>
	<th>Classroom</th>
	<th>Student SY<?php echo $sy; ?> </th>
	<th>Days</th>
	<th>Jan</th>
	<th>Feb</th>
	<th>Mar</th>
	<th>Apr</th>
	<th>May</th>
	<th>Jun</th>
	<th>Jul</th>
	<th>Aug</th>
	<th>Sep</th>
	<th>Oct</th>
	<th>Nov</th>
	<th>Dec</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td>Present</td>
	<td><?php echo $rows[$i]['jan_days_present']; ?></td>
	<td><?php echo $rows[$i]['feb_days_present']; ?></td>
	<td><?php echo $rows[$i]['mar_days_present']; ?></td>
	<td><?php echo $rows[$i]['apr_days_present']; ?></td>
	<td><?php echo $rows[$i]['may_days_present']; ?></td>
	<td><?php echo $rows[$i]['jun_days_present']; ?></td>
	<td><?php echo $rows[$i]['jul_days_present']; ?></td>
	<td><?php echo $rows[$i]['aug_days_present']; ?></td>
	<td><?php echo $rows[$i]['sep_days_present']; ?></td>
	<td><?php echo $rows[$i]['oct_days_present']; ?></td>
	<td><?php echo $rows[$i]['nov_days_present']; ?></td>
	<td><?php echo $rows[$i]['dec_days_present']; ?></td>
</tr>

<tr>
	<td></td>
	<td></td>
	<td></td>
	<td>Tardy</td>
	<td><?php echo $rows[$i]['jan_days_tardy']; ?></td>
	<td><?php echo $rows[$i]['feb_days_tardy']; ?></td>
	<td><?php echo $rows[$i]['mar_days_tardy']; ?></td>
	<td><?php echo $rows[$i]['apr_days_tardy']; ?></td>
	<td><?php echo $rows[$i]['may_days_tardy']; ?></td>
	<td><?php echo $rows[$i]['jun_days_tardy']; ?></td>
	<td><?php echo $rows[$i]['jul_days_tardy']; ?></td>
	<td><?php echo $rows[$i]['aug_days_tardy']; ?></td>
	<td><?php echo $rows[$i]['sep_days_tardy']; ?></td>
	<td><?php echo $rows[$i]['oct_days_tardy']; ?></td>
	<td><?php echo $rows[$i]['nov_days_tardy']; ?></td>
	<td><?php echo $rows[$i]['dec_days_tardy']; ?></td>
</tr>
<?php endfor; ?>

</table>



<!------------------------------------------------------->

<script type='text/javascript' src="<?php echo URL; ?>views/js/excel01.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel02.js"></script>
<script type='text/javascript' src="<?php echo URL; ?>views/js/excel03.js"></script>

<script type='text/javascript' src="<?php echo URL; ?>views/js/reports.js"></script>


<script>

var gurl     = "http://<?php echo GURL; ?>";

$(function(){
	excel();


})







</script>
