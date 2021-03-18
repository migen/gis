<h5>
	Works
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>


	<?php if(isset($_GET['all'])): ?>
			| <a href='<?php echo URL."works"; ?>' >Pending</a>	
	<?php else: ?>		
			| <a href='<?php echo URL."works?all"; ?>' >All</a>		
	<?php endif; ?>		
	
	| <a href='<?php echo $_SERVER['REQUEST_URI'].'&window'; ?>' >Window</a>	
	
	| <a href='<?php echo URL."events/add"; ?>' >New</a>		
	
</h5>



<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
	<th>#</th>
	<th>Actv</th>
	<th>Date</th>
	<th>Request</th>
	<th>By</th>
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo ($works[$i]['is_active'])? 'Y':'-'; ?></td>
	<td><?php echo date('M-d',strtotime($works[$i]['date'])); ?></td>
	<td class="vc400" ><?php echo $works[$i]['request']; ?></td>
	<td class="vc150" ><?php echo $works[$i]['contact']; ?></td>
	<?php if($admin): ?>
		<td>
			<a href='<?php echo URL."works/edit/".$works[$i]['id']; ?>' >Edit</a>
			| <a onclick="return confirm('Proceed?');" href='<?php echo URL."works/delete/".$works[$i]['id']; ?>' >Delete</a>

		</td>
	<?php endif; ?>
</tr>
<?php endfor; ?>
</table>

