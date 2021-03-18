<h5>

	<?php echo $level['name']; ?> Subjects
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a>
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>				
	| <a href="<?php echo URL.'mis/subjects'; ?>">Subjects</a>
	| <a href="<?php echo URL.'mis/subjectLevels'; ?>" >Subj-Levels</a>
	| <a href='<?php echo URL."gset/courses/$lvlid"; ?>' ><?php echo $level['name']; ?> Subjects</a>

</h5>

<p>
	<?php foreach($levels AS $row): ?>
		<a href='<?php echo URL."mis/lvlsub/".$row['id']; ?>' ><?php echo $row['code']; ?></a> &nbsp;&nbsp;   
	<?php endforeach; ?>
</p>

<form method="POST" >
<table class="gis-table-bordered table-fx" >
<tr class="headrow" >
	<th>Sub#</th>
	<th>Code</th>
	<th>Subject</th>
	<th>Sup<br />Sub</th>	
	<th>
		With<br />Scores
		<br /><input id="iws" class="center " type="number" min=0 max=1 value=0 />
		<br /> <input type="button" value="All" onclick="populateColumn('ws');" />		
		
	</th>
	<th>
		Is<br />3-Tier
		<br /><input id="ikpup" class="center " type="number" min=0 max=1 value=0 />
		<br /> <input type="button" value="All" onclick="populateColumn('kpup');" />				
	</th>	
	
	<th>Wt</th>

	<th>
		In<br />Genave
		<br /><input id="igenave" class="center " type="number" min=0 max=1 value=0 />
		<br /> <input type="button" value="All" onclick="populateColumn('genave');" />		
		
	</th>
	<th>
		Affects<br />Rank
		<br /><input id="iar" class="center " type="number" min=0 max=1 value=0 />
		<br /> <input type="button" value="All" onclick="populateColumn('ar');" />				
	</th>	
	<th>Pos</th>
	<th>
		Is<br />Aggre
		<br /><input id="iaggre" class="center " type="number" min=0 max=1 value=0 />
		<br /> <input type="button" value="All" onclick="populateColumn('aggre');" />		
		
	</th>
	<th>
		Is<br />Trns
		<br /><input id="itrns" class="center " type="number" min=0 max=1 value=0 />
		<br /> <input type="button" value="All" onclick="populateColumn('trns');" />				
	</th>		
	<th>Indent</th>
	<th>Sem
		<br /><input id="isem" class="center " type="number" min=0 max=2 value=0 />
		<br /> <input type="button" value="All" onclick="populateColumn('sem');" />			
	</th>
	<th>Type</th>
	<th>#</th>
	
	
	
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $sub[$i]['subject_id']; ?></td>
<td><input class="pdl05 vc60" maxlength="6" name="crs[<?php echo $i; ?>][code]" value="<?php echo $sub[$i]['code']; ?>" /></td>		
<td><input class="pdl05 full" name="crs[<?php echo $i; ?>][label]" value="<?php echo $sub[$i]['label']; ?>" /></td>		

	<td><input class="vc50 center" name="crs[<?php echo $i; ?>][supsubject_id]" 
		type="number" value="<?php echo $sub[$i]['supsubject_id']; ?>" /></td>		
	
	<td><input class="vc50 center ws" name="crs[<?php echo $i; ?>][with_scores]" 
		type="number" min=0 max=1 value="<?php echo $sub[$i]['with_scores']; ?>" /></td>	
	<td><input class="vc50 center kpup" name="crs[<?php echo $i; ?>][is_kpup]" 
		type="number" min=0 max=1 value="<?php echo $sub[$i]['is_kpup']; ?>" /></td>			
		
<td><input class="vc50 center" name="crs[<?php echo $i; ?>][course_weight]" value="<?php echo $sub[$i]['course_weight']; ?>" /></td>		
	
	<td><input class="vc50 center genave" name="crs[<?php echo $i; ?>][in_genave]" 
		type="number" min=0 max=1 value="<?php echo $sub[$i]['in_genave']; ?>" /></td>	
	<td><input class="vc50 center ar" name="crs[<?php echo $i; ?>][affects_ranking]" 
		type="number" min=0 max=1 value="<?php echo $sub[$i]['affects_ranking']; ?>" /></td>			
	
<td><input class="vc50 center" type="number" name="crs[<?php echo $i; ?>][position]" value="<?php echo $sub[$i]['position']; ?>" /></td>		

	<td><input class="vc50 center aggre" name="crs[<?php echo $i; ?>][is_aggregate]" 
		type="number" min=0 max=1 value="<?php echo $sub[$i]['is_aggregate']; ?>" /></td>	
	<td><input class="vc50 center trns" name="crs[<?php echo $i; ?>][is_transmuted]" 
		type="number" min=0 max=1 value="<?php echo $sub[$i]['is_transmuted']; ?>" /></td>			

<td><input class="vc50 center" type="number" name="crs[<?php echo $i; ?>][indent]" value="<?php echo $sub[$i]['indent']; ?>" /></td>		
<td><input class="vc50 center sem" name="crs[<?php echo $i; ?>][semester]" 
	type="number" min=0 max=2 value="<?php echo $sub[$i]['semester']; ?>" /></td>		
<td><input class="vc50 center" name="crs[<?php echo $i; ?>][crstype_id]" 
	type="number" min=0 max=5 value="<?php echo $sub[$i]['crstype_id']; ?>" /></td>		

<td><?php echo $i+1; ?></td>

<input type="hidden" class="vc50" name="crs[<?php echo $i; ?>][subject_id]" value="<?php echo $sub[$i]['subject_id']; ?>" />	
</tr>
<?php endfor; ?>
</table>

<p class="hd"><input onclick="return confirm('Dangerous! Proceed?');" type="submit" name="propagate" value="Propagate" /></p>


</form>


<!------ tracelogin ------------------------------------------------------->
<p><button onclick="tracepass();" >Password</button></p>
<p> <?php $this->shovel('hdpdiv'); ?> </p>
<div class="ht100" >&nbsp;</div>



<!------------------------------------------------------------------------->


<script>

var hdpass 	= '<?php echo HDPASS; ?>';
var gurl = 'http://<?php echo GURL; ?>';


$(function(){
	$('#hdpdiv').hide();
	hd();

})	



</script>