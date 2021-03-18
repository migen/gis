<?php 
	// debug($_SESSION['q']);
	
?>


<h5>
	Clubs Q<?php echo $qtr; ?> (<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	<?php if($_SESSION['srid']==RMIS): ?>
	| <a href="<?php echo URL.'gset/clubs'; ?>" >Gset Clubs</a>
	| <a href="<?php echo URL.'clubs/all?order=cl.name'; ?>" >Alphabetical</a>
	| <a href="<?php echo URL.'clubs/notes'; ?>" >Notes</a>
	
	<?php endif; ?>
	<?php for($q=1;$q<5;$q++): ?>
		<?php if($q!=$qtr): ?>
		| <a href="<?php echo URL.'clubs/all?qtr='.$q; ?>" ><?php echo "Q$q"; ?></a>
		<?php endif; ?>
	<?php endfor; ?>
	
	<?php if($_SESSION['srid']==RMIS): ?>
		| <a href="<?php echo URL.'clubs/updateAllGradesFromClubscores?qtr='.$qtr; ?>" >
			<?php echo "Update All Grades From Clubscores - Q$qtr"; ?></a>				
	<?php endif; ?>
	
	
</h5>

<p>
<table class="gis-table-bordered table-altrow" >
<tr><th>Club&nbsp;<input id="club" placeholder="name" /></th>
<td><button onclick="addClub();" >Add</button></td>
</tr>
</table>
</p>


<table class="gis-table-bordered table-altrow table-fx" >
<tr>
	<th>ID</th>
	<th class="" >Club</th>
	<th class="vc300" >Tcid - Teacher</th>
	<th class="" >View</th>
	<th class="" >Edit</th>
	<th class="" >Scores</th>
	<th class="" >Grades</th>
	<th class="center" >Q<?php echo $qtr; ?>
		<br />1=Lock
		<br />0=Open
	</th>
	<th></th>
</tr>

<?php if($_SESSION['user']['role_id']!=RMIS): ?>
	<?php for($i=0;$i<$count;$i++): ?>
	<tr>
		<td><?php echo $rows[$i]['club_id']; ?></td>
		<td><?php echo $rows[$i]['club']; ?></td>
		<td><?php echo $rows[$i]['tcid'].' - '.$rows[$i]['moderator']; ?></td>
		<td><a href="<?php echo URL.'clubs/members/'.$rows[$i]['club_id']; ?>" >Members</a></td>
		<td><a href="<?php echo URL.'clubs/moderator/'.$rows[$i]['club_id']; ?>" >Teacher</a></td>
		<td><a href="<?php echo URL.'clubs/scores/'.$rows[$i]['club_id']; ?>" >Scores</a></td>
		<td><a href="<?php echo URL.'clubs/grades/'.$rows[$i]['club_id']; ?>" >Grades</a></td>
			<input type="hidden" id="club-<?php echo $i; ?>" value="<?php echo $rows[$i]['club_id']; ?>" />	
		<td><input class="vc50 center <?php echo ($rows[$i]['is_finalized_q'.$qtr]!=1)? 'bg-pink':NULL; ?>" type="number" min=0 max=1 
			id="q<?php echo $i; ?>" value="<?php echo $rows[$i]['is_finalized_q'.$qtr];  ?>" /></td>
		<td><button id="btn-<?php echo $i; ?>" onclick="xeditClub(<?php echo $i; ?>);return false;" >Save</button></td>	
	</tr>
	<?php endfor; ?>
<?php else: ?>
	<?php for($i=0;$i<$count;$i++): ?>
	<?php 
		$club_id=$rows[$i]['club_id'];
	?>
	<tr>
		<td><?php echo $rows[$i]['club_id']; ?></td>
		<td><?php echo $rows[$i]['club']; ?></td>
		<td><?php echo $rows[$i]['tcid'].' - '.$rows[$i]['moderator']; ?></td>
		<td><a href="<?php echo URL.'clubs/members/'.$rows[$i]['club_id']; ?>" >Members</a></td>
		<td><a href="<?php echo URL.'clubs/moderator/'.$rows[$i]['club_id']; ?>" >Teacher</a></td>
		<td><a href="<?php echo URL.'clubs/scores/'.$rows[$i]['club_id']; ?>" >Scores</a></td>
		<td><a href="<?php echo URL.'clubs/grades/'.$rows[$i]['club_id']; ?>" >Grades</a></td>
			<input type="hidden" id="club-<?php echo $i; ?>" value="<?php echo $rows[$i]['club_id']; ?>" />	
		<td><input class="vc50 center <?php echo ($rows[$i]['is_finalized_q'.$qtr]!=1)? 'bg-pink':NULL; ?>" type="number" min=0 max=1 
			id="q<?php echo $i; ?>" value="<?php echo $rows[$i]['is_finalized_q'.$qtr];  ?>" /></td>
		<td><button id="btn-<?php echo $i; ?>" onclick="xeditClub(<?php echo $i; ?>);return false;" >Save</button></td>	
		<td><a href='<?php echo URL."clubs/checker/$club_id"; ?>' >Checker</a></td>	
	</tr>
	<?php endfor; ?>
<?php endif; ?>

</table>

<div class="ht100" ></div>


<script>

var gurl="http://<?php echo GURL; ?>"
var sy="<?php echo $sy; ?>";
var qtr="<?php echo $qtr; ?>";

$(function(){

})

function addClub(){
	var club=$("#club").val();
	var task="addClub";
	var vurl=gurl+"/ajax/xclubs.php"	
	$.ajax({
		url:vurl,type:'POST',data:'task='+task+'&name='+club,
		success:function(){ alert('Club added.'); location.reload(); }		
	});
		
}	/* fxn */


function xeditClub(i){
	$('#btn-'+i).hide();var club_id=$('#club-'+i).val();
	var qx= $('#q'+i).val();
	var vurl = gurl+'/ajax/xclubs.php';var task = "xeditClub";
	var pdata = "task="+task+"&qx="+qx+"&club_id="+club_id+"&sy="+sy+"&qtr="+qtr;	
	$.ajax({ type: 'POST',url: vurl,data: pdata,success:function(){} });				
	
}	


</script>

