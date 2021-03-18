<?php 

	// pr($data);
	// pr($level);
	
?>

<!------------------------------------------------------------------------------------------------------------------------>

<h5>
	Edit Level | 
	<a href="<?php echo URL; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>					
	| <a href="<?php echo URL.'levels/view/'.$level_id; ?>">View</a>
	| <a href="<?php echo URL.'subjects'; ?>">Subjects</a>
	
	
</h5>

<!------------------------------------------------------------------------------------------------------------------------>

<form method="POST" >
<table class="gis-table-bordered table-fx" >

<tr><th class="headrow white">Is K12</th><td><?php echo ($level['is_k12'])? 'Yes':'Not K12'; ?></td></tr>
<tr><th class="headrow white">Code</th><td><?php echo $level['code']; ?></td></tr>
<tr><th class="headrow white">Level</th><td><?php echo $level['name']; ?></td></tr>

<tr><th class="headrow white">Name</th><td><input class="vc200 pdl05" type="text" name="level[name]" value="<?php echo $level['name']; ?>" /></td></tr>

<tr><th class="headrow white">With Conduct DG</th><td>	
	<select class="vc200" name="level[with_conduct_dg]"  >
		<option value="1" <?php echo ($level['with_conduct_dg']==1)? 'selected':null; ?> >Yes</option>
		<option value="0" <?php echo ($level['with_conduct_dg']!=1)? 'selected':null; ?> >No</option>		
	</select>	
</td></tr>

<tr><th class="headrow white">Is K12</th><td>	
	<select class="vc200" name="level[is_k12]"  >
		<option value="1" <?php echo ($level['is_k12']==1)? 'selected':null; ?> >Yes</option>
		<option value="0" <?php echo ($level['is_k12']!=1)? 'selected':null; ?> >No</option>		
	</select>	
</td></tr>

<tr><th class="headrow white">Is Equiv</th><td>	
	<select class="vc200" name="level[is_equiv]"  >
		<option value="1" <?php echo ($level['is_equiv']==1)? 'selected':null; ?> >Yes</option>
		<option value="0" <?php echo ($level['is_equiv']!=1)? 'selected':null; ?> >No</option>		
	</select>	
</td></tr>

<tr><th class="headrow white">Is Sem</th><td>	
	<select class="vc200" name="level[is_sem]"  >
		<option value="1" <?php echo ($level['is_sem']==1)? 'selected':null; ?> >Yes</option>
		<option value="0" <?php echo ($level['is_sem']!=1)? 'selected':null; ?> >No</option>		
	</select>	
</td></tr>

<tr><th class="headrow white">Department</th><td>	
	<select class="vc200" name="level[department_id]"  >
		<?php	foreach($departments as $sel): ?><option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$level['department_id'])? 'selected':null; ?> ><?php echo $sel['name']; ?></option><?php	endforeach; ?>				
	</select>	
</td></tr>

<tr><th class="headrow white">Is PS</th><td>	
	<select class="vc200" name="level[is_ps]"  >
		<option value="1" <?php echo ($level['is_ps']==1)? 'selected':null; ?> >Yes</option>
		<option value="0" <?php echo ($level['is_ps']!=1)? 'selected':null; ?> >No</option>		
	</select>	
</td></tr>


<tr><th class="headrow white">Is GS</th><td>	
	<select class="vc200" name="level[is_gs]"  >
		<option value="1" <?php echo ($level['is_gs']==1)? 'selected':null; ?> >Yes</option>
		<option value="0" <?php echo ($level['is_gs']!=1)? 'selected':null; ?> >No</option>		
	</select>	
</td></tr>

<tr><th class="headrow white">Is HS</th><td>	
	<select class="vc200" name="level[is_hs]"  >
		<option value="1" <?php echo ($level['is_hs']==1)? 'selected':null; ?> >Yes</option>
		<option value="0" <?php echo ($level['is_hs']!=1)? 'selected':null; ?> >No</option>		
	</select>	
</td></tr>

<tr><th class="headrow white">Is Coll</th><td>	
	<select class="vc200" name="level[is_coll]"  >
		<option value="1" <?php echo ($level['is_coll']==1)? 'selected':null; ?> >Yes</option>
		<option value="0" <?php echo ($level['is_coll']!=1)? 'selected':null; ?> >No</option>		
	</select>	
</td></tr>

<tr><th class="headrow white">Conduct Affects<br /> Ranking </th><td>	
	<select class="vc200" name="level[conduct_affects_ranking]"  >
		<option value="1" <?php echo ($level['conduct_affects_ranking']==1)? 'selected':null; ?> >Yes</option>
		<option value="0" <?php echo ($level['conduct_affects_ranking']!=1)? 'selected':null; ?> >No</option>		
	</select>	
</td></tr>

<tr><th class="headrow white">is_finalized_ranking</th><td>	
	<select class="vc200" name="level[is_finalized_ranking]"  >
		<option value="1" <?php echo ($level['is_finalized_ranking']==1)? 'selected':null; ?> >Yes</option>
		<option value="0" <?php echo ($level['is_finalized_ranking']!=1)? 'selected':null; ?> >No</option>		
	</select>	
</td></tr>


<tr><th class="headrow white">Conduct CType</th><td>	
	<select class="vc200" name="level[conduct_ctype_id]"  >
		<?php	foreach($ctypes as $sel): ?><option value="<?php echo $sel['id']; ?>" <?php echo ($sel['id']==$level['conduct_ctype_id'])? 'selected':null; ?> ><?php echo $sel['name']; ?></option><?php	endforeach; ?>				
	</select>	
</td></tr>




<tr><th colspan="2" ><input class="vc100" type="submit" name="submit" value="Go" />

<input type="hidden" name="level[id]" value="<?php echo $level['id']; ?>" />

<button><a href="<?php echo URL.'mis/levels/'.$sy; ?>" class="no-underline" >Cancel</a></button>
</th></tr>
</table>

</form>



