	<tr class="" ><th class="vc150" >SY</th><td class="vc300" >
		<input onchange='jsredirect("ledgers/student/<?php echo $scid; ?>/"+this.value);' 
			min="<?php echo $_SESSION['settings']['year_start']; ?>" max="<?php echo $_SESSION['sy']; ?>"
			type="number" class="pdl05" value="<?php echo $sy; ?>" />
		</td>
	</tr>
	<tr><th>Status</th><td class="vc300" >
		Actv <input type="checkbox" class="pdr05 right" id="actv0" name="is_active" 
			<?php echo ($tsum['is_active']==1)? 'checked':NULL; ?> />
		Clrd <input type="checkbox" class="pdr05 right" id="clrd0" name="is_cleared" 
			<?php echo ($tsum['is_cleared']==1)? 'checked':NULL; ?> />						
	</td></tr>

	<tr><th>ID Number</th><td class="vc300" ><?php echo $tsum['student_code']; ?></td></tr>
	<tr><th>Student <span class="screen" >| <a href="<?php echo URL.'contacts/ucis/'.$scid; ?>" >Edit</a></span>
		</th><td><?php echo $tsum['student']; ?></td></tr>
	<tr><th>Classroom</th><td><?php echo $tsum['level'].' - '.$tsum['section']; ?></td></tr>		
	
	<tr><th>Modes</th><td>
		<select id="pmid0" class="" name="paymode_id" >
			<?php foreach($paymodes AS $sel): ?>
				<option value="<?php echo $sel['id']; ?>" 
					<?php echo ($sel['id']==$tsum['paymode_id'])? 'selected':NULL; ?> >
					<?php echo $sel['name']; ?></option>
			<?php endforeach; ?>
		</select>				
		<input type="hidden" id="scid0" value="<?php echo $tsum['scid']; ?>"/>
		<span class="screen" ><button onclick="scidPaymode(0);" >OK</button></span>		
	</td></tr>

	