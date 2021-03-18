<?php 

// pr($club_id);
// exit;
// $this->shovel('border');


?>

<h5>
	Club Members (<?php echo $count; ?>)
	<?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'clubs/notes'; ?>" >Notes</a>
	| <a href="<?php echo URL.'clubs/tagging/'.$club_id; ?>" >Tagging</a>
	| <a href="<?php echo URL.'clubs/batch/'.$club_id; ?>" >Batch</a>
	| <a href="<?php echo URL.'clubs/scores/'.$club_id.DS.$sy.DS.$qtr; ?>" >Scores</a>
	| <a href="<?php echo URL.'clubs/grades/'.$club_id.DS.$sy.DS.$qtr; ?>" >Grades</a>
	| <a href="<?php echo URL.'clubs/membersCrs/'.$club_id.DS.$sy.DS.$qtr; ?>" >Members-Course</a>
	<?php if($_SESSION['srid']==RMIS): ?>
		| <a href="<?php echo URL.'clubs/deleteClubMembersScores/'.$club_id; ?>" >X-MembersScores</a>		
	<?php endif; ?>
	
</h5>

<?php include_once('incs/clubDetails.php'); ?>

<div class="half" >
<table class="gis-table-bordered table-altrow" >
<tr>
<th>#</th>
<th>Classroom</th>
<th>Scid</th>
<th>ID No.</th>
<th>Sex</th>
<th>Student</th>
<th></th>
</tr>

<?php for($i=0;$i<$count;$i++): ?>
<tr>
	<td><?php echo $i+1; ?></td>
	<td><a href="<?php echo URL.'classlists/classroom/'.$rows[$i]['crid']; ?>" ><?php echo $rows[$i]['classroom']; ?></a></td>
	<td><?php echo $rows[$i]['scid']; ?></td>
	<td><?php echo $rows[$i]['student_code']; ?></td>
	<td><?php echo ($rows[$i]['is_male']==1)? 'B':'G'; ?></td>
	<td><a href="<?php echo URL.'clubs/student/'.$rows[$i]['scid']; ?>" ><?php echo $rows[$i]['student']; ?></a></td>
	<td><button id="btn-<?php echo $i; ?>" 
		onclick="removeStudentFromClub(<?php echo $i.','.$rows[$i]['scid'];?>);" >Remove</button></td>	
</tr>
<?php endfor; ?>
</table>
</div>	<!-- left -->

<div class="clear ht50" >&nbsp;</div>


<script>

var gurl = "http://<?php echo GURL; ?>";
var sy	 = "<?php echo $sy; ?>";
var club_id = "<?php echo $club_id; ?>";
var home = "<?php echo 'clubs'; ?>";
var limits='20';



$(function(){
	itago('clipboard');
	$('html').live('click',function(){ $('#names').hide(); });
	
	
})



function redirContact(ucid){
	var vurl = gurl+'/ajax/xclubs.php';		
	var task = "studentToClub";		
	$.post(vurl,{task:task,ucid:ucid,club_id:club_id},function(s){		
		$("#names").hide();
		alert(s.id+' - '+s.student);
		$("#table").append("<tr><td></td><td>"+ucid+"</td><td>"+s.code+"</td><td>"+s.name+"</td><td></td></tr>");
	},'json');	

}



</script>


<script type="text/javascript" src='<?php echo URL."views/js/jclubs.js"; ?>' ></script>

