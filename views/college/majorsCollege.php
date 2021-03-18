<h5>
	TMP 00 Majors
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'college'; ?>" >College</a>		
	
	
</h5>

<table class="gis-table-bordered table-altrow" >
<tr><th class="vc200" >Majors</th></tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo '#'.$rows[$i]['id'].' - '.$rows[$i]['name']; ?></td>
</tr>
<?php endfor; ?>
</table>
