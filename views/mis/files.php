

<!------------------------------------------------------------------------------------------------------------>

<h5>Files</h5>



<!------------------------------------------------------------------------------------------------------------>

<table class="gis-table-bordered table-fx table-altrow"  >
<tr class="headrow" >
	<th>#</th>
	<th>File</th>
</tr>

<?php for($i=0;$i<$num_files;$i++): ?>
<tr>
<td><?php echo $i+1; ?></td>
<td><a href="<?php echo URL."public/".$folder."/".$files[$i]; ?>" ><?php echo $files[$i]; ?></a></td>
</tr>

<?php endfor; ?>
</table>