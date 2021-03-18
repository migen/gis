<?php 
	// pr($_SESSION['q']);
	// $this->shovel('border');
?>


<h5>
	Batch Clubs	(<?php echo $count; ?>)
	| <?php $this->shovel('homelinks'); ?>
	| <a href="<?php echo URL.'clubs/members/'.$club_id.DS.$sy; ?>" >Members</a>
	| <a href="<?php echo URL.'clubs/all'; ?>" >All Clubs</a>
	

</h5>


<?php if(isset($_GET['debug'])){ pr($club); } ?>



<?php include_once('incs/filter_codenameClubs.php'); ?>
<div id="names" >names</div>

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

<!------>

<form method="POST" >	<!-- form add -->

<div class="addrows" style="width:400px;float:left;"  >
<h5> 
	Add Students
	| <a class="u" onclick="ilabas('clipboard');" >Smartboard</a>
</h5>
<table class="gis-table-bordered" >
<tr class='headrow'>
	<th>#</th>	
	<th class="vc200" >ID Number</th>
</tr>

<?php $numrows = isset($_POST['numrows'])? $_POST['numrows'] : 1; ?>
<?php for($i=0;$i<$numrows;$i++): ?>

<tr >
	<td class="vc20" ><?php echo $i+1; ?></td>
	<td><input id="code<?php echo $i; ?>" class="full" type="text" name="posts[<?php echo $i; ?>]" /></td>		
		
</tr>

<?php endfor; ?>			
</table>

<p>
	<input type="submit" name="add" value="Add" /> &nbsp; 
	<button><a href="<?php echo URL.'mis'; ?>" class="no-underline" >Cancel</a></button>
</p>

</form> <!-- add -->


<p><?php $this->shovel('numrows'); ?></p>
</div>

<div class="clipboard" style="width:200px;float:left;"  >
	<p><select id="classbox" >
		<option value="code" >Code</option></select>
	</p>
	<?php $d['width'] = '20'; ?>
	<?php $this->shovel('smartboard',$d); ?>
</div>


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
