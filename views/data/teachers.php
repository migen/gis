<h5>

	Teachers
<span class="screen" >			
	| <a href="<?php echo URL.'info'; ?>">Info</a>
	| <a href="<?php echo URL.'info'; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
</span>
</h5>

<p class="printNoScreen f10" >Printed on: <?php echo date('M d, Y'); ?></p>

<table class="gis-table-bordered table-fx table-altrow" >
<tr class="headrow" >
<th>#</th>
<th class="vc150" >ID Number</th>
<th class="vc300" >Teacher</th>
<th class="screen" >&nbsp;</th>
</tr>
<?php for($i=0;$i<$numrows;$i++): ?>
	<tr>
		<td><?php echo $i+1; ?></td>
		<td><?php echo $teachers[$i]['code']; ?></td>
		<td><?php echo $teachers[$i]['teacher']; ?></td>	
		<td class="screen" ><a href="<?php echo URL.'loads/teacher/'.$teachers[$i]['tcid'].DS.$sy; ?>">Loads</td>	
	</tr>
<?php endfor; ?>
</table>