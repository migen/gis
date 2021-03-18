<?php 
$deci=$_SESSION['settings']['decicard'];
$is_locked=($club['is_finalized_q'.$qtr]==1)? 1:0;

// pr($rows[0]);
// exit;

?>


<h5>
	Club Grades (<?php echo $count; ?>) 
	| Status - <?php echo ($is_locked)? 'Finalized':'Open';  ?>
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'clubs/notes'; ?>" >Notes</a>
	| <span class="u txt-black" onclick="traceshd();" >SHD</span>	
	| <span class="u" onclick="pclass('hd');" >Details</span>
	| <a href="<?php echo URL.'clubs/members/'.$club_id.DS.$sy.DS.$qtr; ?>" >Members</a>	
	| <a href="<?php echo URL.'clubs/scores/'.$club_id.DS.$sy.DS.$qtr; ?>" >Scores</a>	
	<?php if($_SESSION['user']['role_id']==RMIS): ?>
		| <a href="<?php echo URL.'clubs/syncClubGrades/'.$club_id; ?>" >Sync</a>	
	<?php endif; ?>
	| <a href="<?php echo URL.'clubs/updateClubGrades/'.$club_id; ?>" >Update</a>
	| <a href="<?php echo URL.'clubs/checker/'.$club_id; ?>" >Checker</a>
	


<?php if(isset($_GET['dg'])): ?>
	| <a href="<?php echo URL.'clubs/grades/'.$club_id.DS.$sy.DS.$qtr; ?>" >Numeric</a>
<?php else: ?>	
	| <a href="<?php echo URL.'clubs/grades/'.$club_id.DS.$sy.DS.$qtr.'?dg'; ?>" >DG</a>
<?php endif; ?>	

<?php if(isset($_GET['edit'])): ?>
	| <a href="<?php echo URL.'clubs/grades/'.$club_id.DS.$sy.DS.$qtr; ?>" >View</a>
<?php else: ?>
	| <a href="<?php echo URL.'clubs/grades/'.$club_id.DS.$sy.DS.$qtr.'&edit'; ?>" >Edit</a>
<?php endif; ?>

	
	
	
</h5>


<?php include_once('incs/clubDetails.php'); ?>

<form method="POST" >
<table class="gis-table-bordered table-altrow table-fx" >
<tr>
<th>ID</th>
<th class="shd gid" >GID</th>
<th class="shd clcrs" >ClCrs</th>
<th class="" >M</th>
<th class="shd" >Scid</th>
<th>Classroom</th>
<th>Sex</th>
<th>ID No.</th>
<th>Student</th>
<th class="center" ><?php echo strtoupper($colvar); echo $qtr; ?></th>
<?php for($q=1;$q<5;$q++): ?>
<?php if($q!=$qtr){ echo "<th><a href='".URL."clubs/grades/".$club_id.DS.$sy.DS.$q."' >".strtoupper($colvar).$q."</a></th>"; } ?>	
<?php endfor; ?>

</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td class="shd gid" ><?php echo $rows[$i]['gid']; ?></td>
	<td class="shd clcrs" ><?php echo $rows[$i]['clubcrs']; ?></td>
	<td class="" ><?php echo ($rows[$i]['is_male']==1)? 'M':'-'; ?></td>
	<td class="shd" ><?php echo $rows[$i]['scid']; ?></td>
	<td class="" ><?php echo $rows[$i]['classroom']; ?></td>
	<td class="" ><?php echo ($rows[$i]['is_male']==1)? 'B':'G'; ?></td>
	<td class="" ><?php echo $rows[$i]['code']; ?></td>
	<td><a href="<?php echo URL.'clubs/student/'.$rows[$i]['scid']; ?>" ><?php echo $rows[$i]['student']; ?></a></td>
	<td>
		<?php $grade=($is_dg)? $rows[$i]['grade']:number_format($rows[$i]['grade'],$deci); ?>		
		<input class="vc60 center" name="posts[<?php echo $i; ?>][grade]" 
			value="<?php echo $grade; ?>" tabIndex=1 >
		<input type="hidden" name="posts[<?php echo $i; ?>][gid]" value="<?php echo $rows[$i]['gid']; ?>" >	
	</td>
	
<?php for($q=1;$q<5;$q++): ?>
<?php $grade=($is_dg)? $rows[$i][$colvar.$q]:number_format($rows[$i][$colvar.$q],$deci); ?>
<?php if($q!=$qtr){ echo "<td>".$grade."</td>"; } ?>	
<?php endfor; ?>
	

</tr>
<?php endfor; ?>
</table>

<div class="ht50 clear" >&nbsp;</div>

<p>
<?php if(isset($_GET['edit'])): ?>
	<input type="submit" name="submit" value="Submit"  />
<?php endif; ?>
<?php if(!$is_locked): ?>
	<input type="submit" name="finalize" value="Finalize"  />
<?php endif; ?>
</p>

</form>


<script>

$(function(){
	shd();
	nextViaEnter();
})


</script>
