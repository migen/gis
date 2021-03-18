		<?php if($is_numeric): ?>	<!-- open-numeric -->
			
			<?php 	$dbbonus=$students[$s]['bonus'];$rdgrade=$rdge+$dbbonus; 
					$eqgrade=uniequiv($rdgrade,$equivs);$dbgrade=$students[$s]['grade'];   ?>						
			<td class="center c1 <?php echo ($ge<$pg)? 'bg-red':NULL; ?> " >		
				<input name="grades[<?php echo $s; ?>][raw]" class="ibox vc50 center" value="<?php echo $rdge;  ?>" readonly /><br />
				<input name="grades[<?php echo $s; ?>][bonus]" onchange="xeditData(<?php echo $s; ?>);" class="ibox vc50 center 
					<?php echo ($credit<0)? 'bg-pink':null; echo ($credit>0)? 'bg-lightgreen':null; ?>"  
					value="<?php echo $students[$s]['bonus']+0;  ?>" />
				<input name="grades[<?php echo $s; ?>][dg]" type="hidden" value=""  />			
				<input type="hidden" name="grades[<?php echo $s; ?>][gid]" value="<?php echo $students[$s]['gid']; ?>">				
			</td>
			<td class="vcenter c2 " ><input name="grades[<?php echo $s; ?>][grade]" class="vc50 center" value="<?php echo $eqgrade;  ?>" readonly /></td>						

		<?php else: ?>	<!-- open-descriptive -->
		<?php 	$dbbonus=$students[$s]['bonus'];$rdgrade=$rdge+$dbbonus;$udg=unirating($rdgrade,$ratings); ?>
		<td class="center c1" >
			<input name="grades[<?php echo $s; ?>][raw]" class="ibox vc50 center" value="<?php echo $rdge;  ?>" readonly /><br />
			<input name="grades[<?php echo $s; ?>][bonus]" onchange="xeditData(<?php echo $s; ?>);" class="ibox vc50 center" value="<?php echo $dbbonus+0; ?>" />
			<input type="hidden" name="grades[<?php echo $s; ?>][grade]"  value="<?php echo $rdge+$credit; ?>"  />			
			<input type="hidden" name="grades[<?php echo $s; ?>][gid]" value="<?php echo $students[$s]['gid']; ?>">
		</td>
		<td class="vcenter c2" ><input name="grades[<?php echo $s; ?>][dg]" class="vc50 center" value="<?php echo $udg;  ?>" readonly /></td>				
		<?php endif; ?>	<!-- open-numeric -->


