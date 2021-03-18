<?php 
	// pr($_SESSION['q']);
	// $this->shovel('border');
?>


<h5>
	Tagging Clubs	(<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'clubs/members/'.$club_id; ?>" >Members</a>
	<?php if($_SESSION['srid']==RMIS): ?>
		| <a href="<?php echo URL.'clubs/all'; ?>" >All Clubs</a>	
	<?php endif; ?>
	| <a href="<?php echo URL.'clubs/scores/'.$club_id; ?>" >Scores</a>		
	| <a href="<?php echo URL.'clubs/grades/'.$club_id; ?>" >Grades</a>		
	<?php if($_SESSION['srid']==RMIS): ?>
		| <a href="<?php echo URL.'clubs/deleteClubMembersScores/'.$club_id; ?>" >X-MembersScores</a>		
	<?php endif; ?>
		

</h5>


<?php if(isset($_GET['debug'])){ pr($club); } ?>



<?php include_once('incs/filter_codenameClubs.php'); ?>
<div class="hd" id="names" >names</div>

<div class="clear" >
	<table class="gis-table-bordered" >
	<tr><th>Club#<?php echo $club['club_id']; ?></th><th><?php echo $club['club']; ?></th></tr>
	<tr><th>Teacher</th><th><?php echo $club['moderator']; ?></th></tr>
	</table>
</div>
<br />

<div style="float:left;width:45%;" >
<table id="table" class="gis-table-bordered table-altrow" >
<tr><th>#</th><th>Scid</th><th>ID No.</th><th class="vc300" >Students</th><td></td></tr>
<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['student_code']; ?></td>
	<td><?php echo $rows[$i]['student']; ?></td>
	<td><button id="btn-<?php echo $i; ?>" 
		onclick="removeStudentFromClub(<?php echo $i.','.$rows[$i]['scid'];?>);" >Remove</button></td>
</tr>
<?php endfor; ?>
</table>
</div>



<script>

var gurl = "http://<?php echo GURL; ?>";
var club_id = "<?php echo $club_id; ?>";
var home = "<?php echo 'clubs'; ?>";
var limits='20';



$(function(){
	hd();
	itago('clipboard');
	$('html').live('click',function(){ $('#names').hide(); });
	
	
})



function redirContact(ucid){
	var vurl = gurl+'/ajax/xclubs.php';		
	var task = "studentToClub";	
	
	$.post(vurl,{task:task,ucid:ucid,club_id:club_id},function(s){		
		hd();
		$("#table").append("<tr><td></td><td>"+ucid+"</td><td>"+s.code+"</td><td>"+s.name+"</td><td></td></tr>");
	},'json');	


}




</script>

<script type="text/javascript" src='<?php echo URL."views/js/jclubs.js"; ?>' ></script>
