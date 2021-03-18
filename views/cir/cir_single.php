<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="vc200" >	
		<a target="blank" href="<?php echo URL.'classlists/classroom/'.$rows[$i]['crid'].DS.$sy; ?>" >		
			<?php echo $rows[$i]['classroom'].' ('.$rows[$i]['num_students'].')'; ?></a>
		<?php echo ($rows[$i]['level_id']>13)? '('.$rows[$i]['num'].')':NULL; ?>	
		| <a target="blank" href="<?php echo URL.'classlists/classroom/'.$rows[$i]['crid'].DS.$prevsy; ?>" >		
			<?php echo $prevsy; ?></a>			
		<?php echo ($rows[$i]['num']>1)? 'N'.$rows[$i]['num']:NULL; ?>
	</td>
	<td><?php echo ($rows[$i]['is_locked']==1)? 'Y':'-'; ?></td>
<td>
	<a href='<?php echo URL."attendance/{$attdlink}/".$rows[$i]['id']."/$sy/$qtr"; ?>' >Attd</a>
</td>
<td>
	<a href='<?php echo URL."matrix/grades/".$rows[$i]['id']."/$sy/$qtr"; ?>' >Matrix</a>
	<?php if(!empty($rows[$i]['conduct_id'])): ?>
	<a href='<?php echo URL."conducts/records/".$rows[$i]['conduct_id']."/$sy/$qtr"; ?>' >Cond</a>
	<?php else: ?>			
		<a href='<?php echo URL."cav/traits/".$rows[$i]['trait_id']."/$sy/$qtr"; ?>' >Trts</a>	
	<?php endif; ?>			
</td>
<td>
	<a href='<?php echo URL."classrooms/courses/".$rows[$i]['id']; ?>' >Crs</a> | 
	<a href='<?php echo URL."loads/cls/".$rows[$i]['id']; ?>' >Loads</a>
</td>
<td>
	<a href='<?php echo URL."submissions/view/".$rows[$i]['id']."/$sy/$qtr"; ?>' >Submxn</a>
</td>
<td>
	<a href='<?php echo URL."spiral/crid/".$rows[$i]['id']."/$sy/$qtr"; ?>' >Sprl</a>
</td>
<td>
	<a href='<?php echo URL."summarizers/genave/".$rows[$i]['id']."/$sy/$qtr"; ?>' >Smzr</a>
</td>

<td>
<?php if($rows[$i]['level_id']<14): ?>
	<a href='<?php echo URL."rcards/crid/".$rows[$i]['id']."/$sy/$qtr?tpl=".$rows[$i]['department_id']; ?>' >	
		Card </a><?php echo "(".$rows[$i]['num_students'].")"; ?>
<?php else: ?>
	<?php 
		$half=($qtr<3)?1:2;
	?>
	<a href='<?php echo URL."srcards/crid/".$rows[$i]['id']."/$sy/$qtr/$half"; ?>' >	
		Cards </a><?php echo "(".$rows[$i]['num_students'].")"; ?>
<?php endif; ?>
</td>


<td><?php echo $rows[$i]['crid']; ?></td>
</tr>
<?php endfor; ?>