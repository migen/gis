
<?php 

// ================= DEFINE VARS ====================

$sy = $_SESSION['sy'];

$num_levels = count($data['levels']);

// pr($data);

?>


<h5>Levels</h5>

<form method="POST" >

<table class='gis-table-bordered table-fx' >
<tr class='bg-gray1'>
	<th>#</th>
	<th>Level</th>
	<th class="center" >Level Ranking</th>
</tr>

<?php for($i=0;$i<$num_levels;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $levels[$i]['name']; ?></td>
	<td>
	<?php for($j=1;$j<5;$j++): ?>
		<a href="<?php echo URL.'registrars/qlr/'.$levels[$i]['id'].DS.$sy.DS.$j; ?>" >Q<?php echo $j; ?> </a> &nbsp; | 
	<?php endfor; ?>
		<a href="<?php echo URL.'registrars/qlr/'.$levels[$i]['id'].DS.$sy.DS.'5'; ?>" > FG </a> &nbsp; 
	</td>
	

</tr>
	
	
 		
<?php endfor; ?>


	


</table>

<!-- =====================================================================================================  -->
