<h5>
	Cls Loads Crlist
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	
</h5>


<?php

// pr($_SESSION['classrooms']);

$rows =& $_SESSION['classrooms'];
$count=count($rows);
// pr($rows[0]);

?>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Classroom</th>
	<th>Loads</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['name']; ?></td>
	<td><a href="<?php echo URL.'loads/cls/'.$rows[$i]['id']; ?>" >Loads</a></td>
</tr>
<?php endfor; ?>


</table>


