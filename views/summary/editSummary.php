<h5>
	Edit Student Summary
	| <a href="<?php echo URL.$_SESSION['home']; ?>">Home</a> 
	<?php echo isset($_SERVER['HTTP_REFERER'])? '| <a href="'.$_SERVER['HTTP_REFERER'].'" >Back</a>' : ''; ?>		

<?php 
	$d['sy']=$sy;$d['repage']="summary/edit/$scid";
	$this->shovel('sy_selector',$d); 
?>	
	
	
</h5>

<p><?php require_once(SITE.'/views/elements/filter_codename.php'); ?></p>


<div class="twenty" id="names" >names</div>


<?php if($scid): ?>
<form method="POST" >
<table class="gis-table-bordered" >
<tr><th>SCID</th><td><?php echo $contact['id']; ?></td></tr>
<tr><th>ID Number</th><td><?php echo $contact['code']; ?></td></tr>
<tr><th>Student</th><td><?php echo $contact['name']; ?></td></tr>
<tr><th>Classroom #<?php echo $summary['crid']; ?></th><td><?php echo $contact['classroom']; ?></td></tr>

<tr><th>Ave Q1 | DG1</th><td>
<input name="summ[ave_q1]" value="<?php echo $summary['ave_q1']; ?>" class="vc50 right"  />
<input name="summ[ave_dg1]" value="<?php echo $summary['ave_dg1']; ?>" class="vc50 right"  />	
</td></tr>

<tr><th>Ave Q2 | DG2</th><td>
<input name="summ[ave_q2]" value="<?php echo $summary['ave_q2']; ?>" class="vc50 right"  />
<input name="summ[ave_dg2]" value="<?php echo $summary['ave_dg2']; ?>" class="vc50 right"  />	
</td></tr>

<tr><th>Ave Q3 | DG3</th><td>
<input name="summ[ave_q3]" value="<?php echo $summary['ave_q3']; ?>" class="vc50 right"  />
<input name="summ[ave_dg3]" value="<?php echo $summary['ave_dg3']; ?>" class="vc50 right"  />	
</td></tr>

<tr><th>Ave Q4 | DG4</th><td>
<input name="summ[ave_q4]" value="<?php echo $summary['ave_q4']; ?>" class="vc50 right"  />
<input name="summ[ave_dg4]" value="<?php echo $summary['ave_dg4']; ?>" class="vc50 right"  />	
</td></tr>

<tr><th>Ave Q5 | DG5</th><td>
<input name="summ[ave_q5]" value="<?php echo $summary['ave_q5']; ?>" class="vc50 right"  />
<input name="summ[ave_dg5]" value="<?php echo $summary['ave_dg5']; ?>" class="vc50 right"  />	
</td></tr>

<tr><th>Ave Q6 | DG6</th><td>
<input name="summ[ave_q6]" value="<?php echo $summary['ave_q6']; ?>" class="vc50 right"  />
<input name="summ[ave_dg6]" value="<?php echo $summary['ave_dg6']; ?>" class="vc50 right"  />	
</td></tr>


<tr><th>Conduct Q1 | DG1</th><td>
<input name="summ[conduct_q1]" value="<?php echo $summary['conduct_q1']; ?>" class="vc50 right"  />
<input name="summ[conduct_dg1]" value="<?php echo $summary['conduct_dg1']; ?>" class="vc50 right"  />	
</td></tr>

<tr><th>Conduct Q2 | DG2</th><td>
<input name="summ[conduct_q2]" value="<?php echo $summary['conduct_q2']; ?>" class="vc50 right"  />
<input name="summ[conduct_dg2]" value="<?php echo $summary['conduct_dg2']; ?>" class="vc50 right"  />	
</td></tr>
<tr><th>Conduct Q3 | DG3</th><td>
<input name="summ[conduct_q3]" value="<?php echo $summary['conduct_q3']; ?>" class="vc50 right"  />
<input name="summ[conduct_dg3]" value="<?php echo $summary['conduct_dg3']; ?>" class="vc50 right"  />	
</td></tr>
<tr><th>Conduct Q4 | DG4</th><td>
<input name="summ[conduct_q4]" value="<?php echo $summary['conduct_q4']; ?>" class="vc50 right"  />
<input name="summ[conduct_dg4]" value="<?php echo $summary['conduct_dg4']; ?>" class="vc50 right"  />	
</td></tr>
<tr><th>Conduct Q5 | DG5</th><td>
<input name="summ[conduct_q5]" value="<?php echo $summary['conduct_q5']; ?>" class="vc50 right"  />
<input name="summ[conduct_dg5]" value="<?php echo $summary['conduct_dg5']; ?>" class="vc50 right"  />	
</td></tr>


<tr><th>1-Promoted/0-Retained</th><td>
<input name="summ[is_promoted]" value="<?php echo $summary['is_promoted']; ?>" class="vc50 right"  />
</td></tr>

<tr><th>Promoted to crid/level</th><td>
<select name="summ[promcrid]" class="vc100" >
	<?php foreach($classrooms AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" <?php  echo ($sel['id']==$summary['promcrid'])? 'selected':NULL; ?> ><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select>

<select name="summ[promlvl]" class="vc100" >
	<?php foreach($levels AS $sel): ?>
		<option value="<?php echo $sel['id']; ?>" <?php  echo ($sel['id']==$summary['promlvl'])? 'selected':NULL; ?> ><?php echo $sel['name']; ?></option>
	<?php endforeach; ?>
</select>
</td></tr>

<tr><th>Inc units | subjects</th><td>
<input name="summ[incunits]" value="<?php echo $summary['incunits']; ?>" class="vc50 right"  />
<input name="summ[incsubj]" value="<?php echo $summary['incsubj']; ?>" class="vc200 left pdl05"  />	
</td></tr>


<tr><th colspan=2>Summext</th></tr>
<tr><th>Q1 Rank Classroom | Level</th><td>
<input name="sx[rank_classroom_q1]" value="<?php echo $summary['rank_classroom_q1']; ?>" class="vc50 right"  />
<input name="sx[rank_level_q1]" value="<?php echo $summary['rank_level_q1']; ?>" class="vc50 right"  />
</td></tr>

<tr><th>Q2 Rank Classroom | Level</th><td>
<input name="sx[rank_classroom_q2]" value="<?php echo $summary['rank_classroom_q2']; ?>" class="vc50 right"  />
<input name="sx[rank_level_q2]" value="<?php echo $summary['rank_level_q2']; ?>" class="vc50 right"  />
</td></tr>

<tr><th>Q3 Rank Classroom | Level</th><td>
<input name="sx[rank_classroom_q3]" value="<?php echo $summary['rank_classroom_q3']; ?>" class="vc50 right"  />
<input name="sx[rank_level_q3]" value="<?php echo $summary['rank_level_q3']; ?>" class="vc50 right"  />
</td></tr>

<tr><th>Q4 Rank Classroom | Level</th><td>
<input name="sx[rank_classroom_q4]" value="<?php echo $summary['rank_classroom_q4']; ?>" class="vc50 right"  />
<input name="sx[rank_level_q4]" value="<?php echo $summary['rank_level_q4']; ?>" class="vc50 right"  />
</td></tr>

<tr><th>Q5 Rank Classroom | Level</th><td>
<input name="sx[rank_classroom_q5]" value="<?php echo $summary['rank_classroom_q5']; ?>" class="vc50 right"  />
<input name="sx[rank_level_q5]" value="<?php echo $summary['rank_level_q5']; ?>" class="vc50 right"  />
</td></tr>


	
<tr><td colspan="2" ><input type="submit" name="submit" value="Update" onclick="return confirm('Sure?');"  /></td></tr>

</table>
</form>
<?php endif; ?>

<div class="ht100" ></div>



<script>
var gurl="http://<?php echo GURL; ?>";
var sy="<?php echo $sy; ?>";
var limits='20';

$(function(){	
	$('#names').hide();
	
})


function redirContact(ucid){
	var url = gurl+'/summary/edit/'+ucid;	
	window.location = url;		
}


</script>
<script type="text/javascript" src="<?php echo URL.'views/js/lookups.js'; ?>" ></script>


