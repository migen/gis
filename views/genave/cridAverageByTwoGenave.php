<h3>

    Crid Average


</h3>


<table>
<tr>
    <th>#</th>
    <th>Scid</th>
    <th>ID No.</th>
    <th>Student</th>
    <th>1st</th>
    <th>2nd</th>
    <th>Ave</th>
</tr>
<?php foreach($rows AS $i => $row): ?>
<tr>
    <td><?php echo $i+1; ?></td>
    <td><?php echo $row['scid']; ?></td>
    <td><?php echo $row['studcode']; ?></td>
    <td><?php echo $row['studname']; ?></td>
    <td><?php echo $row['first']; ?></td>
    <td><?php echo $row['second']; ?></td>
    <td><?php echo $row['ave']; ?></td>
</tr>

<?php endforeach; ?>
</table>

