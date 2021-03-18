

<h5>
	Turnover Attendance Qtr (<?php echo $count; ?>)
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a class="u" id="btnExport" >Excel</a> 
		
</h5>


<table id="tblExport" class="gis-table-bordered table-fx" >

<tr>
	<th>#</th>
	<th>Classroom</th>
	<th>Student</th>
	<th>Days</th>
	<th>Q1</th>
	<th>Q2</th>
	<th>Q3</th>
	<th>Q4</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['classroom']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td>Present</td>
	<td><?php echo $rows[$i]['q1_days_present']; ?></td>
	<td><?php echo $rows[$i]['q2_days_present']; ?></td>
	<td><?php echo $rows[$i]['q3_days_present']; ?></td>
	<td><?php echo $rows[$i]['q4_days_present']; ?></td>
</tr>

<tr>
	<td></td>
	<td></td>
	<td></td>
	<td>Tardy</td>
	<td><?php echo $rows[$i]['q1_days_tardy']; ?></td>
	<td><?php echo $rows[$i]['q2_days_tardy']; ?></td>
	<td><?php echo $rows[$i]['q3_days_tardy']; ?></td>
	<td><?php echo $rows[$i]['q4_days_tardy']; ?></td>
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
