<h5>
	Level Single Aggregate
	| <?php $this->shovel('homelinks'); ?>
	

</h5>



<table class="gis-table-bordered" >
<tr>
	<td>Mom (Params One) </td>
	<td><?php echo '#'.$mom['id'].' - '.$mom['code']; ?></td>
	<td>&nbsp;</td>
	<td>Kid (Params Two) </td>
	<td><?php echo '#'.$kid['id'].' - '.$kid['code']; ?></td>	
	<td>Level (Params Three) </td>
	<td><?php echo '#'.$level['id'].' - '.$level['name']; ?></td>		
</tr>
</table><br />


<p>
	Levels - <?php foreach($levels AS $level): ?>
		<?php $level_id=$level['id']; ?>
		<a href='<?php echo URL."fix/lsa/$ps/$cs/$level_id&qtr=$qtr"; ?>' ><?php echo $level['id']; ?></a> | 
	<?php endforeach; ?>
</p>


<form method="POST" >

<table class="gis-table-bordered" >
<tr>
	<th>#</th>
	<th>Crid</th>
	<th>Student</th>
	<th><?php echo $kid['code']; ?><br />Scid</th>
	<th><?php echo $kid['code']; ?></th>
	<th><?php echo $mom['code']; ?><br />Scid</th>
	<th><?php echo $mom['code']; ?></th>
	<th>MG</th>	
	
</tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $moms[$i]['crid']; ?></td>
	<td><?php echo $moms[$i]['student']; ?></td>
	<td><?php echo $kids[$i]['scid']; ?></td>
	<td><?php echo $kids[$i]['grade']+0; ?></td>
	<td><?php echo ($moms[$i]['scid']!=$kids[$i]['scid'])? $moms[$i]['scid']:NULL; ?></td>
	<td><?php echo $moms[$i]['grade']+0; ?></td>
	<td>		
		<?php if($moms[$i]['grade']!=$kids[$i]['grade']): ?>
			<input type="hidden" class="vc50" name="posts[<?php echo $i; ?>][gid]" value="<?php echo $moms[$i]['gid']; ?>"  >
			<input readonly class="vc50" name="posts[<?php echo $i; ?>][grade]" value="<?php echo $kids[$i]['grade']+0; ?>"  >	
		<?php endif; ?>
	</td>
</tr>
<?php endfor; ?>


</table>

<p><input type="submit" name="submit" value="Update" ></p>

</form>


<div class="ht50" >&nbsp;</div>


