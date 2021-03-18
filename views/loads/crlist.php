<h5>
	Cls Loads Crlist
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>	
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>
	
</h5>


<?php

if(isset($_GET['debug'])){ pr($q); }

// pr($_SESSION['classrooms']);
// $rows =& $_SESSION['classrooms'];
$count=count($rows);
// pr($rows[0]);

?>

<table class="gis-table-bordered table-altrow" >
<tr>
	<th>#</th>
	<th>Classroom</th>
	<th>Adviser</th>
	<th>Loads</th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo '#'.$rows[$i]['crid'].' - '.$rows[$i]['classroom']; ?></td>
	<td><?php echo '#'.$rows[$i]['acid'].' - '.$rows[$i]['adviser']; ?></td>
	<td><a href="<?php echo URL.'loads/cls/'.$rows[$i]['crid']; ?>" >Loads</a></td>
</tr>
<?php endfor; ?>


</table>


