<h3>
	Notes
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>			
 
</h3>


<?php 

$notes = array(
	array('id'=>'tasks','name'=>'Tasks'),
	array('id'=>'checklist','name'=>'Checklist - Requirements & Specifications'),
	array('id'=>'rcard','name'=>'Report Card Notes'),
	array('id'=>'photos','name'=>'Photos'),
	array('id'=>'attis','name'=>'Attendance RFID Notes')

);

// pr($notes);
$count = count($notes);

?>

<table class="table-bordered table-fx table-altrow" >
	<tr class="headrow" ><th class="vc50" >#</th><th class="vc300" >Notes</th></tr>
<?php for($i=0;$i<$count;$i++): ?>
	<?php 
		$id 	= $notes[$i]['id'];
		$name 	= $notes[$i]['name'];
	?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td><a href='<?php echo URL."files/read/$id"; ?>' ><?php echo $name; ?></a></td>		
	</tr>


<?php endfor; ?>
</table>
