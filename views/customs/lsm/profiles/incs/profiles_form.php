<form method='post' > <!-- for batch edit/delete -->

<!------------------- data ------------------------------------------------------->

<?php for($i=0;$i<$num_profiles;$i++): ?>

<tr rel="<?php echo $profiles[$i]['scid']; ?>" class="<?php echo (even($i))? 'even':'odd'?>" >
	<td><?php echo $i+1; ?></td>	
	<td><?php echo $profiles[$i]['pcid']; ?></td>	
	<td>
		<a href="<?php echo URL.'contacts/ucis/'.$profiles[$i]['scid']; ?>"><?php echo $profiles[$i]['student_code']; ?></a> 
	</td>	

<?php if($_SESSION['settings']['editable_code']==1): ?>	
	<td><input class="vc100 pdl05" id="code<?php echo $i; ?>" type="text" name="profiles[<?php echo $i; ?>][code]" 
		tabindex="10" value="<?php echo $profiles[$i]['student_code']; ?>" ></td>	
<?php else: ?>
	<input id="code<?php echo $i; ?>" type="hidden" name="profiles[<?php echo $i; ?>][code]" tabindex="10" 
		value="<?php echo $profiles[$i]['student_code']; ?>" >
<?php endif; ?>
	
	<td><input class="vc300 pdl05" id="fullname<?php echo $i; ?>" type="text" name="profiles[<?php echo $i; ?>][fullname]" 
		tabindex="20" value="<?php echo $profiles[$i]['fullname']; ?>" ></td>


	<input id="cname<?php echo $i; ?>" type="hidden" name="profiles[<?php echo $i; ?>][cname]" 
		tabindex="40" value="<?php echo $profiles[$i]['cname']; ?>" >			
	<td><input class="vc120 pdr05" id="lrn<?php echo $i; ?>" type="text" name="profiles[<?php echo $i; ?>][lrn]" 
		tabindex="50" value="<?php echo $profiles[$i]['lrn']; ?>" ></td>		
	<td><input id="birthdate<?php echo $i; ?>" class="right pdr05 vc100" tabindex="60" 
		name="profiles[<?php echo $i; ?>][birthdate]" value="<?php echo $profiles[$i]['birthdate']; ?>"  ></td>	
<td><button id="csb<?php echo $i; ?>" onclick="xeditProfiling(<?php echo $i.','.$profiles[$i]['scid']; ?>);return false;" >Save</button></td>	
	<td><input id="address<?php echo $i; ?>" class="left pdl05 vc500" maxlength="100" tabindex="70" 
		name="profiles[<?php echo $i; ?>][address]" value="<?php echo $profiles[$i]['address']; ?>"  ></td>
	<td>
		<select id="is_male<?php echo $i; ?>" class="right pdr05 vc50 male" name="profiles[<?php echo $i; ?>][is_male]" 
			tabindex="90"  >
			<option value="1" <?php echo ($profiles[$i]['is_male'])? 'selected':NULL; ?>  >Y</option>
			<option value="0" <?php echo (!$profiles[$i]['is_male'])? 'selected':NULL; ?>  >N</option>
		</select>	
	</td>	
	<td><input id="father<?php echo $i; ?>" class="left pdl05 vc200" maxlength="100" tabindex="72" 
		name="profiles[<?php echo $i; ?>][father]" value="<?php echo $profiles[$i]['father']; ?>"  ></td>
	<td><input id="mother<?php echo $i; ?>" class="left pdl05 vc200" maxlength="100" tabindex="74" 
		name="profiles[<?php echo $i; ?>][mother]" value="<?php echo $profiles[$i]['mother']; ?>"  ></td>		
	
	<td>
		<input id="remarks<?php echo $i; ?>" class="left pdl05 full rmks" maxlength="100" 
			name="profiles[<?php echo $i; ?>][remarks]" tabindex="100" 
			value="<?php echo $profiles[$i]['remarks']; ?>"  /></td>
	<td>
		<input id="grp<?php echo $i; ?>" class="left pdl05 full grp" 
			name="profiles[<?php echo $i; ?>][grp]" tabindex="105" 
			value="<?php echo $profiles[$i]['grp']; ?>"  /></td>			
	<td>
		<input id="posi<?php echo $i; ?>" class="left pdl05 vc50 pos" 
			name="profiles[<?php echo $i; ?>][position]"  tabIndex="110" 
			value="<?php echo $profiles[$i]['position']; ?>" /></td>	
					
	<input type="hidden" id="cid<?php echo $i; ?>" class="right pdr05 vc70" name="profiles[<?php echo $i; ?>][cid]" 
		value="<?php echo $profiles[$i]['scid']; ?>"  >
</tr>

<?php endfor; ?>
</table>


<p>
<input type="submit" name="save" value="Save All" onclick="return confirm('Sure?');" />
</p>

</form> <!-- for batch -->