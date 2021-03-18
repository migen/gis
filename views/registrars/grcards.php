<div class="reports" >


<?php for($i=0;$i<$num_reports;$i++): ?>

<h5> Report Card </h5>

<table class="gis-table-bordered table-fx" >
<tr><th class="vc100" >Student</th><td class="vc300" ><?php echo $reports[$i]['student']; ?></td></tr>
<tr><th>Level</th><td><?php echo $reports[$i]['level']; ?></td></tr>
<tr><th>Section</th><td><?php echo $reports[$i]['section']; ?></td></tr>
</table>

<p></p>

<table class="gis-table-bordered table-fx td-blue" >
<tr><th>Subject</th><th>Q1</th><th>Q2</th><th>Q3</th><th>Q4</th></tr>
<tr><td><?php echo $reports[$i]['crs1']; ?></td><td><?php echo $reports[$i]['crs1q1']; ?></td><td><?php echo $reports[$i]['crs1q2']; ?></td><td><?php echo $reports[$i]['crs1q3']; ?></td><td><?php echo $reports[$i]['crs1q4']; ?></td></tr>



</table>

<p class='pagebreak'>&nbsp; </p>

<?php endfor; ?>	<!-- num-reports -->


</div>

<link type='text/css' rel='stylesheet' href="<?php echo URL; ?>public/css/reports.css" />
