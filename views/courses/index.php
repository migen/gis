<h5>
	Courses

</h5>


<table class="gis-table-bordered table-fx" >
<tr>
<th>#</th>
<th>Courses</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><a href="<?php echo URL.'courses/settings/'.$rows[$i]['id']; ?>" ><?php echo $rows[$i]['name']; ?></a></td>
</tr>
<?php endfor; ?>
</table>

