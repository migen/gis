<?php 

	// pr($data);
	// pr($level);
	
?>

<!------------------------------------------------------------------------------------------------------------------------>

<h5>
	Edit Level | 
	<a href="<?php echo URL; ?>" />Home</a>  
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>					
	| <a href="<?php echo URL.'subjects'; ?>">Subjects</a>
	| <a href="<?php echo URL.'levels/edit/'.$level_id; ?>">Edit</a>
	| <a href="<?php echo URL.'levels'; ?>">Levels</a>
	
	
</h5>

<!------------------------------------------------------------------------------------------------------------------------>

<form method="POST" >
<table class="gis-table-bordered table-fx" >

<tr><th class="headrow white">Is K12</th><td><?php echo ($level['is_k12'])? 'Yes':'Not K12'; ?></td></tr>
<tr><th class="headrow white">Code</th><td><?php echo $level['code']; ?></td></tr>
<tr><th class="headrow white">Name</th><td><?php echo $level['name']; ?></td></tr>
<tr><th class="headrow white">W/ Conduct DG</th><td><?php echo $level['with_conduct_dg']; ?></td></tr>
<tr><th class="headrow white">Is K12</th><td><?php echo $level['is_k12']; ?></td></tr>
<tr><th class="headrow white">Is Equiv</th><td><?php echo $level['is_equiv']; ?></td></tr>
<tr><th class="headrow white">Is Sem</th><td><?php echo $level['is_sem']; ?></td></tr>
<tr><th class="headrow white">Is PS</th><td><?php echo $level['is_ps']; ?></td></tr>
<tr><th class="headrow white">Is GS</th><td><?php echo $level['is_gs']; ?></td></tr>
<tr><th class="headrow white">Is HS</th><td><?php echo $level['is_hs']; ?></td></tr>
<tr><th class="headrow white">Is Coll</th><td><?php echo $level['is_coll']; ?></td></tr>
<tr><th class="headrow white">Subdept</th><td><?php echo $level['subdepartment_id']; ?></td></tr>
<tr><th class="headrow white">Dept</th><td><?php echo $level['department_id']; ?></td></tr>
<tr><th class="headrow white">Cdt Affects Ranking</th><td><?php echo $level['conduct_affects_ranking']; ?></td></tr>
<tr><th class="headrow white">Is Finalized Ranking</th><td><?php echo $level['is_finalized_ranking']; ?></td></tr>
<tr><th class="headrow white">Cdt Ctype</th><td><?php echo $level['conduct_ctype_id']; ?></td></tr>
<tr><th class="headrow white">Cdt Ctype</th><td><?php echo $level['conduct_ctype_id']; ?></td></tr>

<tr><th colspan="2" ><input class="vc100" type="submit" name="submit" value="Go" />

<input type="hidden" name="level[id]" value="<?php echo $level['id']; ?>" />

<button><a href="<?php echo URL.'mis/levels/'.$sy; ?>" class="no-underline" >Cancel</a></button>
</th></tr>
</table>

</form>



